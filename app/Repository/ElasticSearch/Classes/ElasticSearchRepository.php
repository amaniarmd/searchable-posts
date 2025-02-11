<?php

namespace App\Repository\ElasticSearch\Classes;

use App\Enumerations\CommonEntries;
use App\Enumerations\CommonFields;
use App\Enumerations\ElasticSearch\Fields;
use App\Enumerations\Post\Fields as PostFields;
use App\Enumerations\Category\Fields as CategoryFields;
use App\Models\Post;
use App\Repository\Base\Classes\BaseRepository;
use App\Repository\ElasticSearch\Interfaces\ElasticSearchRepositoryInterface;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\JsonResponse;

class ElasticSearchRepository extends BaseRepository implements ElasticSearchRepositoryInterface
{
    protected $client;
    protected $index = Fields::POSTS_INDEX_NAME->value;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([
                env(env(Fields::ENV_KEY_HOST->value) . ':' . env(Fields::ENV_KEY_PORT->value), Fields::ENV_DEFAULT_HOST->value)
            ])
            ->setBasicAuthentication(Fields::DEFAULT_ELASTIC_USERNAME->value, env(Fields::ENV_KEY_PASSWORD->value))
            ->build();
    }

    public function indexPost(Post $post): void
    {
        $params = [
            Fields::INDEX->value => $this->index,
            CommonFields::ID->value => $post[CommonFields::ID->value],
            Fields::BODY->value => [
                PostFields::TITLE->value => $post[PostFields::TITLE->value],
                Fields::POST_CATEGORY->value => $post->category[CategoryFields::NAME->value],
                PostFields::BODY->value => $post[PostFields::BODY->value],
            ]
        ];

        $this->client->index($params);
    }

    public function bulkIndexPosts(array $posts): void
    {
        $bulkParams = [Fields::BODY->value => []];

        foreach ($posts as $post) {
            $bulkParams[Fields::BODY->value][] = [
                Fields::INDEX->value => [
                    Fields::UNDERLINE_INDEX->value => $this->index,
                    Fields::UNDERLINE_ID->value => $post[CommonFields::ID->value],
                ],
            ];

            $bulkParams[Fields::BODY->value][] = [
                PostFields::TITLE->value => $post[PostFields::TITLE->value],
                Fields::POST_CATEGORY->value => $post->category[CategoryFields::NAME->value],
                Fields::BODY->value => $post[PostFields::BODY->value],
            ];
        }

        $this->client->bulk($bulkParams);
    }

    public function updatePost(Post $post): void
    {
        $params = [
            Fields::INDEX->value => $this->index,
            CommonFields::ID->value => $post[CommonFields::ID->value],
            Fields::BODY->value => [
               Fields::DOC->value => [
                   PostFields::TITLE->value => $post[PostFields::TITLE->value],
                   Fields::POST_CATEGORY->value => $post->category[CategoryFields::NAME->value],
                   PostFields::BODY->value => $post[PostFields::BODY->value],
               ]
            ]
        ];

        $this->client->update($params);
    }

    public function deletePost(Post $post): void
    {
        $params = [
            Fields::INDEX->value => $this->index,
            CommonFields::ID->value => $post[CommonFields::ID->value],
        ];

        $this->client->delete($params);
    }

    public function searchPosts(string $query, $paginationArray): JsonResponse
    {
        $sortBy = $this->getSortBy($paginationArray);
        $order = $this->getOrder($paginationArray);
        $perPage = $this->getPerPage($paginationArray);
        $page = $this->getPage($paginationArray);

        $params = [
            Fields::INDEX->value => $this->index,
            Fields::BODY->value => [
                Fields::UNDERLINE_SOURCE->value => true,
                Fields::QUERY->value => [
                    Fields::MULTI_MATCH->value => [
                        Fields::QUERY->value => $query,
                        Fields::FIELDS->value => [
                            PostFields::TITLE->value . '^3',
                            Fields::POST_CATEGORY->value,
                            PostFields::BODY->value
                        ],
                        Fields::OPERATOR->value => Fields::AND_OPERATOR->value
                    ]
                ],
                Fields::FROM->value => ($page - 1) * $perPage,
                Fields::SIZE->value => $perPage,
                Fields::SORT->value => [
                    $sortBy.'.keyword' => [
                        Fields::ORDER->value => $order]
                ]
            ]
        ];

        $response = $this->client->search($params);
        $totalPostsCount = $response[Fields::HITS->value][Fields::TOTAL->value][Fields::VALUE->value];

        $posts = array_map(function ($hit) {
            return [
                CommonFields::ID->value => $hit[Fields::UNDERLINE_ID->value],
                PostFields::TITLE->value => $hit[Fields::UNDERLINE_SOURCE->value][PostFields::TITLE->value],
                Fields::POST_CATEGORY->value => $hit[Fields::UNDERLINE_SOURCE->value][Fields::POST_CATEGORY->value],
                Fields::BODY->value => $hit[Fields::UNDERLINE_SOURCE->value][Fields::BODY->value]
            ];
        }, $response[Fields::HITS->value][Fields::HITS->value]);

        return response()->json([
            CommonEntries::DATA->value => $posts,
            CommonEntries::CURRENT_PAGE->value => $page,
            CommonEntries::PER_PAGE->value => $perPage,
            CommonEntries::TOTAL->value => $totalPostsCount,
            CommonEntries::LAST_PAGE->value => ceil($totalPostsCount / $perPage),
        ]);
    }
}
