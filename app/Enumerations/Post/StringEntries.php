<?php

namespace App\Enumerations\Post;

enum StringEntries: string
{
    case POST_CREATED_SUCCESSFULLY = 'Post created successfully';
    case POST_UPDATED_SUCCESSFULLY = 'Post updated successfully';
    case SEARCH_TERM = 'term';
}
