<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class OrdersController extends Controller
{
    public function addOrder(Request $req)
    {
        $orders = new Order();

        $orders->address = $req->address;
        $orders->description = $req->description;
        $orders->category = $req->category;
        $orders->price = $req->price;

        $name = time().'.'.$req->image->extension();

        $req->image->move(
        public_path('images'),
        $name
        );

        $url = url('images/'.$name);
        $orders->image = $url;

        $user = User::where('api_token', $req->header('api_token'))->first();
        $orders->user_id = $user->id;

        if(!$orders->save()) {
            return response()->json([
                "success" => false,
                "message" => "Что-то пошло не так, попробуйте снова..."
            ], 400);
        }
        return response()->json([
            "success" => true,
            "message" => "Заявка добавлена успешно!"
        ]);
    }

    public function getOrders(Request $req)
    {
        $user = User::where('api_token', $req->header('api_token'))->first();
        $orders = Order::where('user_id', $user->id)->get(['created_at','address', 'description', 'category', 'price', 'image', 'status']);
        return response()->json($orders);
    }

    public function deleteOrders(Request $req)
    {
        $user = User::where('api_token', $req->header('api_token'))->first();
        $orders = Order::where("id", $req->id)->where("user_id", $user->id)->first();

        if (!$orders) {
            return response()->json("Такой записи не существует");
        }

        $orders->delete();
        return response()->json("Заявка удалена");
    }
}

