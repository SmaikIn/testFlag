<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\OrderPaymentType;
use Meilisearch\Client as Meilisearch;

class OrderPaymentTypeObserver
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(OrderPaymentType $orderPaymentType): void
    {
        $this->meilisearch->getIndex('order_payment_types')->addDocuments($orderPaymentType->toArray());
    }

    public function updated(OrderPaymentType $orderPaymentType): void
    {
        $this->meilisearch->getIndex('order_payment_types')->addDocuments($orderPaymentType->toArray());
    }

    public function saved(OrderPaymentType $orderPaymentType): void
    {
        $this->meilisearch->getIndex('order_payment_types')->addDocuments($orderPaymentType->toArray());
    }

    public function deleted(OrderPaymentType $orderPaymentType): void
    {
        $this->meilisearch->getIndex('order_payment_types')->deleteDocument($orderPaymentType->id);
    }
}
