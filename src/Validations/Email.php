<?php

namespace YuriOliveira\Validation\Validations;

use YuriOliveira\Validation\Message\Message;

class Email extends AbstractValidation
{
    protected static function string(string $key, string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            return Message::get('email', attribute: $key);
        }

        return true;
    }
}