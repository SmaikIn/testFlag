<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        OrderStatus::factory()->create([
            'id' => 1,
            'name' => 'На оплату',
        ]);
        OrderStatus::factory()->create([
            'id' => 2,
            'name' => 'Оплачен',
        ]);
        OrderStatus::factory()->create([
            'id' => 3,
            'name' => 'Отменен',
        ]);
    }
}
