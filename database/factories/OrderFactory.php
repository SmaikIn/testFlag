<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderPaymentType;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'data' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'order_payment_type_id' => OrderPaymentType::factory(),
            'order_status_id' => OrderStatus::factory(),
        ];
    }
}
