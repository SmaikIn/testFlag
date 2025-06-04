<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\OrderPaymentType;
use Illuminate\Database\Seeder;

class OrderPaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        OrderPaymentType::factory()->count(4)->create();
    }
}
