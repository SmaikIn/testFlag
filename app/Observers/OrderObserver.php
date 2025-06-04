<?php

declare(strict_types=1);

namespace App\Observers;

use App\Events\OrderCashEvent;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Event;
use Meilisearch\Client as Meilisearch;

class OrderObserver
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(Order $order): void
    {
        CartItem::where('user_id', $order->user_id)->delete();
        Event::dispatch(new OrderCashEvent($order->id));
        $this->meilisearch->getIndex('orders')->addDocuments($order->toArray());
    }

    public function updated(Order $order): void
    {
        $this->meilisearch->getIndex('orders')->addDocuments($order->toArray());
    }

    public function saved(Order $order): void
    {
        $this->meilisearch->getIndex('orders')->addDocuments($order->toArray());
    }

    public function deleted(Order $order): void
    {
        $this->meilisearch->getIndex('orders')->deleteDocument($order->id);
    }
}
