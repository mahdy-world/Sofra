<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ClientMainController extends Controller
{
    public function review(Request $request)
    {
        $validator = validator()->make($request->all(),[
                'comment' => 'required',
                'react' => 'required|in:1,2,3,4,5',
                'restaurant_id' => ' required|exists:restaurants,id',
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        } else {
            $review = Review::create($request->all());
            $review->client_id = $request->user()->id;
            $review->save();
        }

        return responseJson(1, 'Success', $review);
    }

    public function profileEdit(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'min:2',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            'password' => 'confirmed',
            'block_id' => 'exists:blocks,id',
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        if (request()->has('password')) {

            $request->merge(['password' => bcrypt($request->password)]);

        }

        $request->user()->update($request->all());

        return responseJson(1, 'Success', [
            'restaurant' => $request->user(),
        ]);
    }

    public function showOffers()
    {
        $offers = Offer::paginate(10);
        return responseJson(1, 'Success',$offers);
    }

    public function showItems(Request $request)
    {
        $offers = Item::where(function ($query) use($request){
            if($request->has('restaurant_id'))
            {
                $query->where('restaurant_id',$request->restaurant_id);
            }
        })->paginate(10);

        return responseJson(1, 'Success',$offers);
    }

    public function getOpenRestaurant()
    {
        $restaurant = Restaurant::where('is_active',1)->get();

        return responseJson(1, 'Success', $restaurant);
    }


    public function clientReview(Request $request)
    {
         $request->user()->reviews()->find($request->api_token);
        return responseJson(1, 'Success', [
            'review' => $request->user()->load('reviews')
        ]);
    }

    public function restaurantReviews(Request $request)
    {
        $review = Review::where(function ($query) use($request){
            if($request->has('restaurant_id'))
            {
                $query->where('restaurant_id',$request->restaurant_id);
            }
        })->paginate(10);

        return responseJson(1, 'Success', $review);
    }

    public function ClientRegisterToken(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
            'type' => 'required|in:android','ios'
        ]);
        if ($validator->fails()) {
            return responsejson(0, $validator->errors()->first(), $validator->errors());
            # code...
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responsejson(1, 'تم التسجيل بنجاح ');
    }

    public function ClientRemoveToken(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }

        Token::where('token',$request->token)->delete();

        return responseJson(1,'تم المسح بنجاح ');
    }

    public function newOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'item.*.item_id' => 'required|exists:items,id',
            'item.*.qty' => 'required',
            'address' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->state == 'close') {
            return responseJson(0, 'عزرا المطعم غير متاح فى الوقت الحالى');
        }
        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'note' => $request->note,
            'status' => 'pending',
            'address' => $request->address,
            'payment_method_id' => $request->payment_method_id
        ]);

        $cost = 0;
        $delivery_cost = $restaurant->fees;
        foreach ($request->item as $i) {
            $item = Item::find($i['item_id']);
            $readyItem = [
                $i['item_id'] => [
                    'qty' => $i['qty'],
                    'price' => $item->price,
                    'note' => (isset($i['note'])) ? $i['note'] : ''
                ]
            ];
            $order->items()->attach($readyItem);
            $cost += ($item->price * $i['qty']);
        }
        if ($cost >= $restaurant->minimum) {
            $total = $cost + $delivery_cost;
            $commission = settings()->commission * $cost;
            $net = $total - settings()->commission;
            $update = $order->update([
                'price' => $cost,
                'delivery_cost' => $delivery_cost,
                'total' => $total,
                'commission' => $commission,
                'net' => $net,
            ]);
            $notification = $restaurant->notifications()->create([
                'title' => 'لديك طلب جديد',
                'body' => 'لديك طلب جديد من العمليل ' . $request->user()->name,
                'order_id' => $order->id
            ]);
            $send = null;
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }
            $data = [
                'order' => $order->fresh()->load('items')
            ];
            return responseJson(1, 'تم الطلب بنجاح', ['data' => $data, 'send' => $send]);
        } else {
            $order->items()->delete();
            $order->delete();
            return responseJson(0, 'الطلب لابد ان لا يكون اقل من ' . $restaurant->minimum . ' $');
        }
    }

    public function orderDetails(Request $request)
    {
        $request->user()->orders()->find($request->api_token);
        return responseJson(1, 'Success', [
            'review' => $request->user()->load('orders')
        ]);
    }

    public function clientCurrentOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('status', ['pending', 'accepted'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod')]);
    }

    public function showOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'id' => 'required|exists:orders,id', //
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $order = $request->user()->orders()->find($request->id);
        if ($order) {
            return responseJson(1, 'تمت العمليه بنجاح', [
                'order' => $order->load('items', 'paymentMethod')
            ]);
        }
        return responseJson(1, 'تم الحذف بنجاح');
    }

    public function clientOldOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('status', ['rejected', 'delivered', 'declined'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', [
            'order' => $order->load('items', 'paymentMethod')
        ]);
    }

    public function deliveredOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->status == 'pending' || $order->status == 'accepted') {
            $orders = $order->update([
                'status' => 'delivered' // تسليم
            ]);

            $restaurant = $order->restaurant;
//
            $notification = $restaurant->notifications()->create([
                'title' => 'تمت الموافقه على ان الطلب تم تسليمه',
                'body' => 'تمت الموافقه على الطلب من المستخدم ' . $request->user()->name . 'على انه استلمه',
                'order_id' => $request->order_id,
            ]);
            $send = null;
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);

            }

            $data = [
                'order' => $order->fresh()->load('items')
            ];

            return responseJson(1, 'تم الارسال بنجاح', ['data' => $data, 'send' => $send]);
        }
        return responseJson(0, 'هذا الطلب لا يمكن الموافقه عليه');
    }

    public function declinedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->status == 'pending' || $order->status == 'accepted') {
            $orders = $order->update([
                'status' => 'declined' // رفض
            ]);
            $restaurant = $order->restaurant;
            $notification = $restaurant->notifications()->create([
                'title' => 'تمت رفض الطلب',
                'body' => 'تمت رفض الطلب من المستخدم ' . $request->user()->name,
                'order_id' => $request->order_id
            ]);
            //$send = null;
            $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();

//
            if (count($tokens)) {
                $title = $notification->title;
                $body = $notification->body;
                $data = [
                    'order_id' => $order->name
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
            }

            $data = [
                'order' => $order->fresh()->load('items')
            ];

            return responseJson(1, 'تم الطلب بنجاح',$data);
        }
        return responseJson(0, 'هذا الطلب لا يمكن الموافقه عليه');
    }

}

