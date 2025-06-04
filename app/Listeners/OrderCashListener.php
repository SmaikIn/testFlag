<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCashEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCashListener implements ShouldQueue
{
    public int $delay = 120;

    public function __construct()
    {
    }

    public function handle(OrderCashEvent $event): void
    {
        $order = Order::find($event->getOrderId());

        if ($order->order_status_id != 2) {
            $order->order_status_id = 3;
            $order->save();
        }
    }

}
