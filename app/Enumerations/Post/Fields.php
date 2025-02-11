<?php

namespace App\Enumerations\Post;

enum Fields: string
{
    case TITLE = 'title';
    case BODY = 'body';
    case CATEGORY_ID = 'category_id';
    case CREATED_AT = 'created_at';
    case UPDATED_AT = 'updated_at';
}
