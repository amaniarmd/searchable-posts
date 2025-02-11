<?php

namespace App\Repository\ElasticSearch\Interfaces;

use App\Models\Post;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Illuminate\Http\JsonResponse;

interface ElasticSearchRepositoryInterface
{
    public function indexPost(Post $post): void;
    public function bulkIndexPosts(array $posts): void;
    public function updatePost(Post $post): void;
    public function deletePost(Post $post): void;
    public function searchPosts(string $query, array $paginationArray): JsonResponse;
}
