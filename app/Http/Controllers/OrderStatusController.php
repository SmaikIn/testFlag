<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderStatusRequest;
use App\Http\Resources\OrderStatusResource;
use App\Models\OrderStatus;

class OrderStatusController extends Controller
{
    public function index()
    {
        return OrderStatusResource::collection(OrderStatus::all());
    }

    public function store(OrderStatusRequest $request)
    {
        return new OrderStatusResource(OrderStatus::create($request->validated()));
    }

    public function show(OrderStatus $orderStatus)
    {
        return new OrderStatusResource($orderStatus);
    }

    public function update(OrderStatusRequest $request, OrderStatus $orderStatus)
    {
        $orderStatus->update($request->validated());

        return new OrderStatusResource($orderStatus);
    }

    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->delete();

        return response()->json();
    }
}
