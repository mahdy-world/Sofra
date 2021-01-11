<?php

namespace App\Http\Controllers\Api;

use App\Mail\ResetPassword;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ClientAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required|min:2',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
             'block_id' =>  'required|exists:cities,id'
        ]);


        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());

        } else {

            $request->merge(['password' => Hash::make($request->password)]);

            $client = Client::create($request->all());

            $client->api_token = Str::random(60);


            $client->save();

        }

        return responseJson(1, 'Success', [
            'api_token' => $client->api_token,
            'client' => $client
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required|exists:clients',
            'password' => 'required',
        ]);


        if ($validator->fails()) {

            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $client = Client::where('email', $request->email)->first();

        if ($client) {

            if (Hash::check($request->password, $client->password)) {

                return responseJson(1, 'مرحبا بك ', [
                    'api_token' => $client->api_token,
                    'client' => $client
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
        $client = Client::where('phone', $request->phone)->first();
        if ($client) {

            $code = rand(1111, 9999);

            $update = $client->update(['pin_code'=>$code]);


            if ($update) {
                Mail::to($client->email)
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

        $client = Client::where('pin_code', $request->pin_code)
            ->where('phone', $request->phone)->first();

        if ($client) {
            $client->password = bcrypt($request->password);
            $client->pin_code = null;

            if ($client->save()) {
                return responseJson(1, 'success');
            } else {
                return responseJson(0, 'failed');
            }
        }
    }
}
