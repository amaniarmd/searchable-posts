<?php

namespace App\Enumerations;

enum CommonEntries: string
{
    case DEFAULT_DATE_FORMAT = 'Y/m/d';
    case MESSAGE = 'message';
    case SORT_BY = 'sortBy';
    case ORDER = 'order';
    case ASC_ORDER = 'asc';
    case DESC_ORDER = 'desc';
    case PAGE = 'page';
    case PER_PAGE = 'perPage';

    case SEARCH_LIMIT = 'searchLimit';
    case DATA = 'data';
    case CURRENT_PAGE = 'currentPage';
    case TOTAL = 'total';
    case LAST_PAGE = 'lastPage';

    public static function searchParameters(): array
    {
        return [
            self::SORT_BY->value,
            self::ORDER->value,
            self::ASC_ORDER->value,
            self::DESC_ORDER->value,
            self::PAGE->value,
            self::PER_PAGE->value,
        ];
    }

    public function default()
    {
        return match ($this) {
            self::PER_PAGE => 10,
            self::PAGE => 1,
            self::SEARCH_LIMIT => 100
        };
    }
}
