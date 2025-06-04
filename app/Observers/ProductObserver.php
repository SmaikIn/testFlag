<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Product;
use Meilisearch\Client as Meilisearch;

class ProductObserver
{
    public function __construct(
        private Meilisearch $meilisearch
    ) {
    }
    public function created(Product $product): void
    {
        $this->meilisearch->getIndex('products')->addDocuments($product->toArray());
    }

    public function updated(Product $product): void
    {
        $this->meilisearch->getIndex('products')->addDocuments($product->toArray());
    }

    public function saved(Product $product): void
    {
        $this->meilisearch->getIndex('products')->addDocuments($product->toArray());
    }

    public function deleted(Product $product): void
    {
        $this->meilisearch->getIndex('products')->deleteDocument($product->id);
    }
}
