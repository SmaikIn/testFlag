<?php

declare(strict_types=1);

namespace App\Domains\User\Observers;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Meilisearch\Client as Meilisearch;

class UserObserver implements ShouldQueue
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }

    public function created(User $user): void
    {
        $this->meilisearch->getIndex('users')->addDocuments($user->toArray());
    }

    public function updated(User $user): void
    {
        $this->meilisearch->getIndex('users')->addDocuments($user->toArray());
    }

    public function saved(User $user): void
    {
        $this->meilisearch->getIndex('users')->addDocuments($user->toArray());
    }

    public function deleted(User $user): void
    {
        $this->meilisearch->getIndex('users')->deleteDocument($user->id);
    }
}
