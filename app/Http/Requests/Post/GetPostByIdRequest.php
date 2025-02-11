<?php

namespace App\Http\Requests\Post;

use App\Enumerations\CommonFields;
use App\Enumerations\Rules;
use App\Enumerations\Tables;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class GetPostByIdRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            CommonFields::ID->value => [Rules::REQUIRED->value, Rules::INTEGER->value, Rule::exists(Tables::POSTS->value, CommonFields::ID->value)],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            CommonFields::ID->value => $this->route(CommonFields::ID->value),
        ]);
    }
}
