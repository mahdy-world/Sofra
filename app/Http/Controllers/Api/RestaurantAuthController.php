<?php

namespace App\Http\Controllers\Api;

use App\Mail\ResetPassword;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RestaurantAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|min:2',
            'phone' => 'required|unique:restaurants',
            'email' => 'required|email|unique:restaurants',
            'password' => 'required|confirmed',
            'min' => 'required|numeric',
            'fees' => "required|numeric",
            'restaurant_phone' => 'required|numeric',
            'whatsup' => 'required|numeric',
            'block_id' => 'required|exists:blocks,id',
            'categories' => 'required|exists:categories,id'
        ]);


        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        } else {

            $request->merge(['password' => Hash::make($request->password)]);

            $restaurant = Restaurant::create($request->all());

            $restaurant->categories()->attach($request->categories);

            $restaurant->api_token = Str::random(60);

            if ($request->hasFile('image')) {
                $logo = $request->image;
                $logo_new_name = time() . $logo->getClientOriginalName();
                $logo->move('uploads/post', $logo_new_name);
                $restaurant->image = 'uploads/post/' . $logo_new_name;
                $restaurant->save();
            }

        }

        return responseJson(1, 'Success', [
            'api_token' => $restaurant->api_token,
            'restaurant' => $restaurant->load('categories'),

        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required|exists:restaurants',
            'password' => 'required',
        ]);


        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('email', $request->email)->first();

        if ($restaurant) {

            if (Hash::check($request->password, $restaurant->password)) {

                return responseJson(1, 'مرحبا بك ', [
                    'api_token' => $restaurant->api_token,
                    'restaurant' => $restaurant->load('categories'),

                ]);
            } else {
                return responseJson(0, 'لا يوجد حساب ');
            }
        }else {

            return responseJson(0, 'لا يوجد حساب ');
        }

    }

    public function resetPassword(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('phone', $request->phone)->first();
        if ($restaurant) {

            $code = rand(1111, 9999);

            $update = $restaurant->update(['pin_code'=>$code]);


            if ($update) {
                Mail::to($restaurant->email)
                    ->bcc("ahmedwaliedz123@gmail.com")
                    ->send(new ResetPassword($code));
                return responseJson(1, 'برجاء فحص هاتفك', [
                    'pin_code_for_test' => $code,
                ]);
            }

        }

    }

    public function newPassword(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'pin_code' => 'required',
            'phone' => 'required',
            'password' => 'required|confirmed'

        ]);

        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('pin_code', $request->pin_code)
            ->where('phone', $request->phone)->first();

        if ($restaurant) {
            $restaurant->password = bcrypt($request->password);
            $restaurant->pin_code = null;

            if ($restaurant->save()) {
                return responseJson(1, 'success');
            } else {
                return responseJson(0, 'failed');
            }
        }
    }
}
