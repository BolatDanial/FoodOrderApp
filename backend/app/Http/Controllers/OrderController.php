<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Service\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'content' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $order = $this->service->add($request);

        return response($order, 201);
    }

    public function getById($id)
    {
        $order = Order::where('id', $id)->first();
        $positions = $order->menu;

        return response($order, 200);
    }

    public function getAllByUserId(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->get();

        return response($orders, 200);
    }

    public function update($id)
    {
        $order = Order::where('id', $id)->first();
        $order->status = "paid";
        $order->save();

        return response(["status" => "paid"], 200);
    }

    public function delete($id)
    {
        $res = Order::where('id', $id)->first()->delete();

        return response(["deletedId" => $res], 200);
    }
}
