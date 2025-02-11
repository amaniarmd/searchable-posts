<?php

namespace App\Http\Requests\Post;

use App\Enumerations\Post\Fields;
use App\Enumerations\ElasticSearch\Fields as ElasticSearchFields;
use App\Enumerations\Post\StringEntries;
use App\Enumerations\Rules;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginatedRequest;

class SearchPostsRequest extends PaginatedRequest
{

    protected function sortableFields(): array
    {
        return [
            Fields::TITLE->value,
            ElasticSearchFields::POST_CATEGORY->value,
            Fields::BODY->value
        ];
    }

    protected function customRules(): array
    {
        return [
            StringEntries::SEARCH_TERM->value => [Rules::REQUIRED->value, Rules::STRING->value],
        ];
    }
}
