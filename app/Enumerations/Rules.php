<?php

namespace App\Enumerations;

enum Rules: string
{
    case REQUIRED = 'required';
    case NULLABLE = 'nullable';
    case STRING = 'string';
    case INTEGER = 'integer';
    case MIN_FROM_ONE = 'min:1';
    case MAX_TO_HUNDRED = 'max:100';
    case MAX_STRING_LENGTH = 'max:255';
    case MAX_TEXT_LENGTH = 'max:1000';
}
