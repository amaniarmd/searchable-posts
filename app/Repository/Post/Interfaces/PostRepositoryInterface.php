<?php

namespace App\Repository\Post\Interfaces;

use Illuminate\Http\JsonResponse;

interface PostRepositoryInterface
{
    public function getPosts(array $searchParameters): JsonResponse;
    public function getPost(int $id): JsonResponse;
    public function deletePost(int $id): JsonResponse;
    public function createPost(array $data): JsonResponse;
    public function updatePost(int $id, array $data): JsonResponse;
    public function getPostsCount(): int;
}
