<?php

namespace App\Observers;

use App\Models\Post;
use App\Repository\ElasticSearch\Interfaces\ElasticSearchRepositoryInterface;

class PostObserver
{
    protected $elasticSearchRepository;
    public function __construct(ElasticSearchRepositoryInterface $elasticSearchRepository)
    {
        $this->elasticSearchRepository = $elasticSearchRepository;
    }

    public function created(Post $post): void
    {
        $this->elasticSearchRepository->indexPost($post);
    }

    public function updated(Post $post): void
    {
        $this->elasticSearchRepository->updatePost($post);

    }

    public function deleted(Post $post): void
    {
        $this->elasticSearchRepository->deletePost($post);
    }
}
