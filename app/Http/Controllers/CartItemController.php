<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function index()
    {
        return CartItemResource::collection(CartItem::all());
    }

    public function store(CartItemRequest $request)
    {
        return new CartItemResource(CartItem::create($request->validated()));
    }

    public function show(CartItem $cartItem)
    {
        return new CartItemResource($cartItem);
    }

    public function update(CartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update($request->validated());

        return new CartItemResource($cartItem);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json();
    }
}
