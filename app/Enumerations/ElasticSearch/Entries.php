<?php

namespace App\Enumerations\ElasticSearch;

enum Entries: int
{
    case BULK_INDEX_PER_TRANSACTION = 50;
}
