<?php

namespace App\Http\Requests\Post;

use App\Enumerations\Post\Fields;
use App\Http\Requests\PaginatedRequest;
use Illuminate\Foundation\Http\FormRequest;

class GetPostsRequest extends PaginatedRequest
{
    protected function sortableFields(): array
    {
        return [
            Fields::TITLE->value,
            Fields::CREATED_AT->value,
            Fields::UPDATED_AT->value,
        ];
    }

    protected function customRules(): array
    {
        return [];
    }
}
