<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');
        $client = new \Meilisearch\Client($host, $key);

        $client->createIndex('cart_items', ['primaryKey' => 'id']);
        $client->index('cart_items')->updateFilterableAttributes([
            'user_id',
            'product_id',
        ]);
    }

    public function down(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');

        $client = new \Meilisearch\Client($host, $key);
        $client->deleteIndex('cart_items');
    }
};
