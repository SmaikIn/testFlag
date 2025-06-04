<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderPaymentTypeRequest;
use App\Http\Resources\OrderPaymentTypeResource;
use App\Models\OrderPaymentType;

class OrderPaymentTypeController extends Controller
{
    public function index()
    {
        return OrderPaymentTypeResource::collection(OrderPaymentType::all());
    }

    public function store(OrderPaymentTypeRequest $request)
    {
        return new OrderPaymentTypeResource(OrderPaymentType::create($request->validated()));
    }

    public function show(OrderPaymentType $orderPaymentType)
    {
        return new OrderPaymentTypeResource($orderPaymentType);
    }

    public function update(OrderPaymentTypeRequest $request, OrderPaymentType $orderPaymentType)
    {
        $orderPaymentType->update($request->validated());

        return new OrderPaymentTypeResource($orderPaymentType);
    }

    public function destroy(OrderPaymentType $orderPaymentType)
    {
        $orderPaymentType->delete();

        return response()->json();
    }
}
