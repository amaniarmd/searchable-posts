<?php

namespace App\Http\Requests;

use App\Enumerations\CommonEntries;
use App\Enumerations\CommonFields;
use App\Enumerations\Rules;
use App\Enumerations\User\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

abstract class PaginatedRequest extends BaseRequest
{

    public function rules(): array
    {
        $defaultRules = [
            CommonEntries::SORT_BY->value => [
                Rules::NULLABLE->value,
                Rules::STRING->value,
                Rule::in(...$this->sortableFields()),
            ],
            CommonEntries::ORDER->value => [
                Rules::NULLABLE->value,
                Rules::STRING->value,
                Rule::in(CommonEntries::ASC_ORDER->value, CommonEntries::DESC_ORDER->value),
            ],
            CommonEntries::PAGE->value => [Rules::NULLABLE->value, Rules::INTEGER->value, Rules::MIN_FROM_ONE->value],
            CommonEntries::PER_PAGE->value => [
                Rules::NULLABLE->value,
                Rules::INTEGER->value,
                Rules::MIN_FROM_ONE->value,
                Rules::MAX_TO_HUNDRED->value,
            ],
        ];

        return array_merge($defaultRules, $this->customRules());
    }

    abstract protected function customRules(): array;

    abstract protected function sortableFields(): array;
}
