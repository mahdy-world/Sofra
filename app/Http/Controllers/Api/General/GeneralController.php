<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Category;
use App\Models\City;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;


class GeneralController extends Controller
{
    public function settings()
    {
        $settings = Setting::all();

        return responseJson(1,'success', $settings);
    }

    public function contactUs()
    {
        $contact = Contact::all();

        return responseJson(1,'success', $contact);
    }

    public function Categories()
    {
        $category = Category::all();

        return responseJson(1,'success', $category);
    }

    public function cities()
    {
        $city = City::paginate(10);

        return responseJson(1,'success', $city);
    }

    public function blocks(Request $request)
    {
       $block = Block::where(function ($query) use($request){
            if($request->has('city_id'))
            {
                $query->where('city_id',$request->city_id);
            }
        })->paginate(10);

        return responseJson(1,'success', $block);
    }

    public function createContactUs(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric',
            'message' => 'required',
            'type' => 'in:complain,suggest,enquiry'
        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $contact = Contact::create($request->all());
        $contact->save();

        return responseJson(1,'success', $contact);
    }

    public function restaurants(Request $request)
    {
        $restaurants = Restaurant::where(function ($query) use ($request) {
            if ($request->has('name')) {
                $query->where('name', $request->name);
            }
            if ($request->input('keyword'))  {
                $query->where(function ($restaurants) use ($request) {
                    $restaurants->where('name', 'like', '%' . $request->keyword . '%');
                });
            }
        })->latest()->paginate(10);
        //dd($posts);
        if ($restaurants->count() == 0) {
            return responseJson(0, 'Failed');
        }
        return responseJson(1, 'success', $restaurants);
    }


    public function getReviews()
    {
        $review = Review::with('restaurant')->get();
        return responseJson(1, 'Success', $review);
    }

    public function paymentMethod()
    {
        $payment = PaymentMethod::get();
        return responseJson(1, 'Success', $payment);
    }

    public function notifications()
    {
        $notification = Notification::paginate(10);
        return responseJson(1, 'Success', $notification);
    }

    public function orders()
    {
        $order = Order::paginate(10);
        return responseJson(1, 'Success', $order);
    }


}
