<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $client = new Client();

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);

            if ($user->save()) {
                return $this->login($request);
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $client = new Client();

        try {
            return $client->post(config('service.passport.login_endpoint'), [
                "form_params" => [
                    "client_id" => config('passport.personal_access_client.id'),
                    "client_secret" => config('passport.personal_access_client.secret'),
                    "grant_type" => "password",
                    "username" => $request->email,
                    "password" => $request->password
                ]
            ]);
        } catch (BadResponseException $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }

    public function logout(Request $request)
    {
        try {
            $logout = auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });

            if ($logout) {
                $message = 'Logged out succesfully';

                return $this->setResponse(compact('message'));
            }
        } catch (\Exception $e) {
            $this->status = 'error';
            $this->code = 500;

            $message = $e->getMessage();
            return $this->setResponse(compact('message'));
        }
    }
}
