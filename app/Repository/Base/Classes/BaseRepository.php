<?php

namespace App\Repository\Base\Classes;

use App\Enumerations\CommonEntries;
use App\Enumerations\CommonFields;
use App\Enumerations\Post\Fields;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Morilog\Jalali\Jalalian;

abstract class BaseRepository
{
    protected function convertJalaliToGregorian($jalaliDate)
    {
        return Jalalian::fromFormat(CommonEntries::DEFAULT_DATE_FORMAT->value, $jalaliDate)->toCarbon();
    }

    protected function addSearchFields(Builder &$query, array $searchFields): void
    {
        foreach ($searchFields as $field => $value) {
            $query->where($field, 'LIKE', '%' . $value . '%')->limit(CommonEntries::SEARCH_LIMIT->default());
        }
    }

    protected function orderQuery(Builder &$query, array $searchParameters): void
    {
        $sortBy = $this->getSortBy($searchParameters);
        $order = $this->getOrder($searchParameters);

        $query->orderBy($sortBy, $order);
    }

    protected function getSortBy(array $searchParameters): string
    {
        if (isset($searchParameters[CommonEntries::SORT_BY->value])) {
            return $searchParameters[CommonEntries::SORT_BY->value];
        }

        return Fields::TITLE->value;
    }

    protected function getOrder(array $searchParameters): string
    {
        if (isset($searchParameters[CommonEntries::ORDER->value])) {
            return $searchParameters[CommonEntries::ORDER->value];
        }

        return CommonEntries::ASC_ORDER->value;
    }

    protected function addSearchParameters(Builder $builder, array $searchParameters): LengthAwarePaginator
    {
        $perPage = $this->getPerPage($searchParameters);
        $page = $this->getPage($searchParameters);

        return $builder->paginate($perPage, ['*'], CommonEntries::PAGE->value, $page);
    }

    protected function getPerPage(array $searchParameters): int
    {
        if (isset($searchParameters[CommonEntries::PER_PAGE->value])) {
            return $searchParameters[CommonEntries::PER_PAGE->value];
        }

        return CommonEntries::PER_PAGE->default();
    }

    protected function getPage(array $searchParameters): int
    {
        if (isset($searchParameters[CommonEntries::PAGE->value])) {
            return $searchParameters[CommonEntries::PAGE->value];
        }

        return CommonEntries::PAGE->default();
    }
}
