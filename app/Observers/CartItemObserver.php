<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\CartItem;
use Meilisearch\Client as Meilisearch;

class CartItemObserver
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(CartItem $cartItem): void
    {
        $this->meilisearch->getIndex('cart_items')->addDocuments($cartItem->toArray());
    }

    public function updated(CartItem $cartItem): void
    {
        $this->meilisearch->getIndex('cart_items')->addDocuments($cartItem->toArray());
    }

    public function saved(CartItem $cartItem): void
    {
        $this->meilisearch->getIndex('cart_items')->addDocuments($cartItem->toArray());
    }

    public function deleted(CartItem $cartItem): void
    {
        $this->meilisearch->getIndex('products')->deleteDocument($cartItem->id);
    }
}
