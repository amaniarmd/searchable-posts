<?php

namespace App\Console\Commands;

use App\Enumerations\CommonEntries;
use App\Enumerations\ElasticSearch\Entries;
use App\Models\Post;
use App\Repository\ElasticSearch\Interfaces\ElasticSearchRepositoryInterface;
use App\Repository\Post\Interfaces\PostRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;

class ReindexPosts extends Command
{
    protected $signature = 'posts:reindex';
    protected $description = 'Indexes or re-indexes all current posts in Elasticsearch';
    protected $elasticRepository;
    protected $postRepository;

    public function __construct(ElasticSearchRepositoryInterface $elasticRepository, PostRepositoryInterface $postRepository)
    {
        parent::__construct();
        $this->elasticRepository = $elasticRepository;
        $this->postRepository = $postRepository;
    }

    public function handle()
    {
        $totalPostsCount = $this->postRepository->getPostsCount();

        if ($totalPostsCount == 0) {
            $this->info('No posts found to index.');
            return 0;
        }

        Post::chunk(Entries::BULK_INDEX_PER_TRANSACTION->value, function ($posts) {
            try {
                $this->elasticRepository->bulkIndexPosts($posts->all());
                $this->info("Successfully indexed " . count($posts) . " posts.");
            } catch (\Exception $e) {
                $this->error("Failed to index posts: " . $e->getMessage());
            }
        });

        $this->info("Re-indexing complete. Total posts processed: {$totalPostsCount}");
        return 0;
    }
}
