<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payment_types');
    }
};
