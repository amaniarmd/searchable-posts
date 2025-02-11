<?php

namespace App\Repository\Post\Classes;

use App\Enumerations\CommonEntries;
use App\Enumerations\Post\StringEntries;
use App\Models\Post;
use App\Repository\Base\Classes\BaseRepository;
use App\Repository\Post\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getPosts(array $searchParameters): JsonResponse
    {
        $posts = Post::query();
        $this->orderQuery($posts, $searchParameters);
        $paginatedExperts = $this->addSearchParameters($posts, $searchParameters);

        return response()->json([
            CommonEntries::DATA->value => $paginatedExperts->items(),
            CommonEntries::CURRENT_PAGE->value => $paginatedExperts->currentPage(),
            CommonEntries::PER_PAGE->value => $paginatedExperts->perPage(),
            CommonEntries::TOTAL->value => $paginatedExperts->total(),
            CommonEntries::LAST_PAGE->value => $paginatedExperts->lastPage(),
        ]);
    }

    public function getPost(int $id): JsonResponse
    {
        $post = Post::find($id);

        return response()->json([
            CommonEntries::DATA->value => $post,
        ]);
    }

    public function deletePost(int $id): JsonResponse
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function createPost(array $data): JsonResponse
    {
        Post::create($data);

        return response()->json([
            CommonEntries::MESSAGE->value => StringEntries::POST_CREATED_SUCCESSFULLY->value,
        ], Response::HTTP_CREATED);
    }

    public function updatePost(int $id, array $data): JsonResponse
    {
        $post = Post::find($id);
        $post->update($data);

        return response()->json([
            CommonEntries::MESSAGE->value => StringEntries::POST_UPDATED_SUCCESSFULLY->value,
        ]);
    }

    public function getPostsCount(): int
    {
        return Post::count();
    }
}
