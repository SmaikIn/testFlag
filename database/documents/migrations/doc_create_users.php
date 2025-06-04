<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');
        $client = new \Meilisearch\Client($host, $key);

        $client->createIndex('users', ['primaryKey' => 'id']);
        $client->index('users')->updateFilterableAttributes([
            'name',
            'email',
        ]);
    }

    public function down(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');

        $client = new \Meilisearch\Client($host, $key);
        $client->deleteIndex('users');
    }
};
