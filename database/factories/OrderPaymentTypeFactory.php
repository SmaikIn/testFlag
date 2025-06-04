<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\OrderPaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderPaymentTypeFactory extends Factory
{
    protected $model = OrderPaymentType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'link' => $this->faker->url(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
