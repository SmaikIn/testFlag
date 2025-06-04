<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');
        $client = new \Meilisearch\Client($host, $key);

        $client->createIndex('order_payment_types', ['primaryKey' => 'id']);
        $client->index('order_payment_types')->updateFilterableAttributes([
            'name',
            'link',
        ]);
    }

    public function down(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');

        $client = new \Meilisearch\Client($host, $key);
        $client->deleteIndex('order_payment_types');
    }
};
