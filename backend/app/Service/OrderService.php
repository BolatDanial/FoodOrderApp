<?php
namespace App\Service;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderService {
    public function add(Request $request): Order
    {
        $data = $request->all();

        $order = new Order;
        $order->status =  $data['status'];
        $order->price =   $data['price'];

        $order->user_id = $request->user()->id;
        $order->save();

        $order->menu()->attach($data['content']);
        return $order;
    }

    public function update(Order $position, array $data)
    {
        foreach($data as $key => $value){
            if ($data[$key] != null && $data[$key] != '' && $data[$key] != 'null') {
                $position->$key = $value;
            }
        }
    }
}
