<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        CartItem::factory()->count(50)->create();
    }
}
