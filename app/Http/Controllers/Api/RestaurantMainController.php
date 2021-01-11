<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Offer;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RestaurantMainController extends Controller
{
    public function items(Request $request)
    {
        $items = $request->user()->items()->paginate(10);
        return responseJson(1, 'قائمه الطعام ', $items);
    }


    public function offers(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'from' => ' required|date',
            'to' => ' required|date',
            'offer_price'=> 'required|numeric',
            'image' => 'required'
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        } else {
            $offer = Offer::create($request->all());
            $offer->restaurant_id = $request->user()->id;
            if ($request->hasFile('image')) {
                $logo = $request->image;
                $logo_new_name = time() . $logo->getClientOriginalName();
                $logo->move('uploads/post', $logo_new_name);
                $offer->image = 'uploads/post/' . $logo_new_name;
                $offer->save();
            }
        }

        return responseJson(1, 'Success', $offer);
    }

    public function upDateOffers(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'from' => ' required|date',
            'to' => ' required|date',
            'offer_price'=> 'required|numeric',
            'restaurant_id' => 'required|exists:restaurants,id',
            'image' => 'required',
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        }
        $offer = $request->user()->offers()->find($request->offer_id);
        if ( $request->hasFile('image')  ) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);
            $offer->image = 'uploads/post/'.$logo_new_name;
            $offer->update($request->all());
        }


        return responseJson(1, 'Success', $offer);
    }

    public function deleteOffers(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'id' => 'required|exists:offers,id'
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $offer = $request->user()->offers()->find($request->id);

        if($offer){

            $offer->delete();
        }

        return responseJson(1, 'Success');
    }


    public function profileEdit(Request $request)
    {
    $validator = validator()->make($request->all(), [
        'name' => 'min:2',
        'email' => Rule::unique('clients')->ignore($request->user()->id),
        'phone' => Rule::unique('clients')->ignore($request->user()->id),
        'password' => 'confirmed',
        'min' => 'numeric',
        'fees' => "numeric",
        'restaurant_phone' => 'numeric',
        'whatsup' => 'numeric',
        'block_id' => 'exists:blocks,id',
        'categories' => 'exists:categories,id',
        'status' => 'in:1,0'
    ]);

    if ($validator->fails()) {

        return responseJson(0, $validator->errors()->first(), $validator->errors());
    }

    if (request()->has('password')) {

        $request->merge(['password' => bcrypt($request->password)]);

    }

    $request->user()->update($request->all());
    $request->user()->categories()->sync($request->categories);

    return responseJson(1, 'Success', [
        'restaurant' => $request->user(),
        'category'=> $request->user()->load('categories')
    ]);
    }

    public function createItems(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'description'=> 'required',
            'price' => 'required',
            'time' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        }
        if($request->offer >= $request->price){
                return responseJson(0, 'الرجاء التحقق من السعر ');
        }

            $items = Item::create($request->all());
            $items->restaurant_id = $request->user()->id;
        if ($request->hasFile('image')) {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);
            $items->image = 'uploads/post/' . $logo_new_name;
            $items->save();
        }

        return responseJson(1, 'Success', $items);
    }

    public function editItems(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'description'=> 'required',
            'price' => 'required',
            'time' => 'required',
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        }
        if($request->offer >= $request->price){

            return responseJson(0, 'الرجاء التحقق من السعر ');
        }


        $item = $request->user()->items()->find($request->item_id);

        if($item){

            $item->update($request->all());
        }

        return responseJson(1, 'Success', $item);
    }

    public function deleteItems(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'id' => 'required|exists:items,id'
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $item = $request->user()->items()->find($request->id);

        if($item){

            $item->delete();
        }

        return responseJson(1, 'Success');
    }

    public function showItems(Request $request)
    {
        $items = Item::paginate(10);
        return responseJson(1, 'قائمه الطعام ', $items);
    }

    public function restaurantReview(Request $request)
    {
        $request->user()->reviews()->find($request->api_token);
        return responseJson(1, 'Success', [
            'review' => $request->user()->load('reviews')
        ]);
    }

    public function RestaurantRegisterToken(Request $request)
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

    public function RestaurantRemoveToken(Request $request)
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

    public function orderDetails(Request $request)
    {
        $request->user()->orders()->find($request->api_token);
        return responseJson(1, 'Success', [
            'review' => $request->user()->load('orders')
        ]);
    }

    public function commission(Request $request){
        $restaurant_sales = $request->user()->orders()->where('status','delivered')->sum('price') ;
        $app_commissions = $request->user()->orders()->where('status','delivered')->sum('commission') ;
        $restaurant_payments = $request->user()->payments()->pluck('amount')->first();
        $rest_of_commissions =   $app_commissions - $restaurant_payments ;
        $setting = Setting::first();
        $commission =  $setting->commission * 100 .' %';
//        $elahly_bank =  $setting->elahly_bank ;
//        $alrajhi_bank =  $setting->alrajhi_bank ;
        return responseJson(1, 'تمت العمليه بنجاح', compact('restaurant_sales', 'app_commissions', 'restaurant_payments'
            , 'rest_of_commissions', 'commission'));
    }

    public function restaurantNewOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('status', ['pending'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod','items')]);
    }

    public function restaurantCurrentOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('status', ['accepted'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod','items')]);
    }

    public function restaurantOldOrder(Request $request)
    {
        $order = $request->user()->orders()->whereIn('status', ['rejected', 'delivered', 'declined'])->get();

        return responseJson(1, 'تمت العمليه بنجاح', ['order' => $order->load('client', 'paymentMethod','items')]);
    }

    public function acceptedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->status == 'pending') {
            $orders = $order->update([
                'status' => 'accepted'
            ]);

            $client = $order->client;
            $notification = $client->notifications()->create([
                'title' => 'تمت الموافقه على الطلب',
                'body' => 'تمت الموافقه على الطلب من المطعم ' . $request->user()->name,
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
        }
        return responseJson(0, 'هذا الطلب لا يمكن رفضه');
    }

    public function rejectedOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $order = $request->user()->orders()->find($request->order_id);
        if ($order->status == 'pending') {
            $orders = $order->update(['status' => 'rejected']);

            $client = $order->client;
            $notification = $client->notifications()->create([
                'title' => 'تمت رفض الطلب',
                'body' => 'تمت رفض الطلب من المطعم ' . $request->user()->name,
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
        }
        return responseJson(0, 'هذا الطلب لا يمكن رفضه');

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

            $client = $order->client;
            $notification = $client->notifications()->create([
                'title' => 'تمت التاكيد على ان الطلب تم تسليمه',
                'body' => 'تمت التاكيد من مطعم ' . $request->user()->name . 'على ان الطلب تم تسليم للعمليل ' . $client->name,
                'order_id' => $request->order_id,
            ]);
//            $send = null;
            $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
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
}
