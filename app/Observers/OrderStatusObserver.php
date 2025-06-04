<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\OrderStatus;
use Meilisearch\Client as Meilisearch;

class OrderStatusObserver
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(OrderStatus $orderStatus): void
    {
        $this->meilisearch->getIndex('order_statuses')->addDocuments($orderStatus->toArray());
    }

    public function updated(OrderStatus $orderStatus): void
    {
        $this->meilisearch->getIndex('order_statuses')->addDocuments($orderStatus->toArray());
    }

    public function saved(OrderStatus $orderStatus): void
    {
        $this->meilisearch->getIndex('order_statuses')->addDocuments($orderStatus->toArray());
    }

    public function deleted(OrderStatus $orderStatus): void
    {
        $this->meilisearch->getIndex('order_statuses')->deleteDocument($orderStatus->id);
    }
}
