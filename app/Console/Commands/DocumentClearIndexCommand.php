<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DocumentClearIndexCommand extends Command
{
    protected $signature = 'documents:clear-index';

    protected $description = 'Command description';

    public function handle(): void
    {
        $host = config('database.connections.documents.host').":".config('database.connections.documents.port');
        $key = config('database.connections.documents.key');
        $client = new \Meilisearch\Client($host, $key);

        foreach ($client->getIndexes()->getResults() as $index) {
            $client->deleteIndex($index->getUid());
        }

        $this->info('Index cleared!');
    }
}
