<?php

namespace App\Http\Requests\Post;

use App\Enumerations\CommonFields;
use App\Enumerations\Post\Fields;
use App\Enumerations\Rules;
use App\Enumerations\Tables;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            Fields::TITLE->value => [Rules::REQUIRED->value, Rules::STRING->value, Rules::MAX_STRING_LENGTH->value],
            Fields::BODY->value => [Rules::REQUIRED->value, Rules::STRING->value, Rules::MAX_TEXT_LENGTH->value],
            Fields::CATEGORY_ID->value => [Rules::REQUIRED->value, Rules::INTEGER->value, Rule::exists(Tables::CATEGORIES->value, CommonFields::ID->value)],
            CommonFields::ID->value => [Rules::NULLABLE->value, Rules::INTEGER->value, Rule::exists(Tables::POSTS->value, CommonFields::ID->value)],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->route(CommonFields::ID->value) !== null && $this->method() === FormRequest::METHOD_PUT) {
            $this->merge([
                CommonFields::ID->value => $this->route(CommonFields::ID->value),
            ]);
        }
    }
}
