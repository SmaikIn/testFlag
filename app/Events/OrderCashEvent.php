<?php
declare(strict_types=1);

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;

class OrderCashEvent
{
    use Dispatchable;

    public function __construct(
        public int $orderId,
    )
    {
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }
}
