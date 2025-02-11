<?php

namespace App\Http\Controllers;

use App\Enumerations\CommonFields;
use App\Enumerations\Post\StringEntries;
use App\Http\Requests\Post\GetPostByIdRequest;
use App\Http\Requests\Post\GetPostsRequest;
use App\Http\Requests\Post\SearchPostsRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Repository\ElasticSearch\Interfaces\ElasticSearchRepositoryInterface;
use App\Repository\Post\Interfaces\PostRepositoryInterface;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;
    private ElasticSearchRepositoryInterface $elasticSearchRepository;

    public function __construct(PostRepositoryInterface $postRepository, ElasticSearchRepositoryInterface $elasticSearchRepository)
    {
        $this->postRepository = $postRepository;
        $this->elasticSearchRepository = $elasticSearchRepository;
    }

    public function index(GetPostsRequest $request)
    {
        return $this->postRepository->getPosts($request->validated());
    }

    public function store(StorePostRequest $request)
    {
        return $this->postRepository->createPost($request->validated());
    }

    public function show(GetPostByIdRequest $request)
    {
        return $this->postRepository->getPost($request[CommonFields::ID->value]);
    }

    public function update(StorePostRequest $request)
    {
        $data = $request->validated();
        $postId = $data[CommonFields::ID->value];
        unset($data[CommonFields::ID->value]);

        return $this->postRepository->updatePost($postId, $data);
    }

    public function destroy(GetPostByIdRequest $request)
    {
        return $this->postRepository->deletePost($request[CommonFields::ID->value]);
    }

    public function search(SearchPostsRequest $request)
    {
        $paginationArray = $request->validated();
        $query = $paginationArray[StringEntries::SEARCH_TERM->value];
        unset($paginationArray[StringEntries::SEARCH_TERM->value]);

        return $this->elasticSearchRepository->searchPosts($query, $paginationArray);
    }
}
