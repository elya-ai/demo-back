<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), 
        [
            'name' => 'required|string',
            'login' => 'required|string|unique:users',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $arr = $req->all();
        $arr['password'] = Hash::make($req->password);

        $users = User::create($arr);
        return response()->json("Вы успешно зарегистрировались!");	
    }

    public function auth(Request $req)
    {
        $validator = Validator::make($req->all(), 
        [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($users = User::where('login', $req->login)->first()) {
            if (Hash::check($req->password, $users->password)) {
                $users->api_token = Str::random(10);
                $users->save();
                return response()->json("Вы успешно авторизованы.". $users->api_token);
            }
        }
        return response()->json("Произошла какая-то ошибка, попробуйте позже.");
    }

    public function logout(Request $req)
    {
        $users = User::where('api_token', $req->api_token)->first();

        if ($users) {
            $users->api_token = null;
            $users->save();
            return response()->json([
                "success" => true,
                "message" => "Вы успешно вышли с аккаунта!"
            ]);
        }
    }
}
