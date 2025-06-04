<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderPaymentType;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(OrderRequest $request)
    {
        $orderPaymentType = OrderPaymentType::find($request->input('order_payment_type_id'));

        $order = Order::create(
            [
                'user_id' => Auth::id(),
                'order_payment_type_id' => $orderPaymentType,
                'order_status_id' => 1,
                'data' => Auth::user()->cartItems()->get()->toJson()
            ]
        );

        $order->refresh();

        return $orderPaymentType->link.'/'.$order->id;
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function update(int $id)
    {
        Order::findOrFail($id)->update(['order_status_id' => 2]);
        return new OrderResource($order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json();
    }
}
