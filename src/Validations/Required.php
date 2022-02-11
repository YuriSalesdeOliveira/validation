<?php

namespace YuriOliveira\Validation\Validations;

use YuriOliveira\Validation\Message\Message;

class Required extends AbstractValidation
{
    protected static function string(string $key, string $value)
    {
        if (empty($value))
        {
            return Message::get('required', attribute: $key);
        }

        return true;
    }

    protected static function file(string $key, array $value)
    {
        if ($value['size'] === 0)
        {
            return Message::get('required', attribute: $key);
        }

        return true;
    }
}