<?php

namespace YuriOliveira\Validation\Validations;

use YuriOliveira\Validation\Message\Message;

class Max extends AbstractValidation
{
    protected static function string(string $key, string $value, int $max)
    {
        if (strlen($value) > $max)
        {
            return Message::get(['max' => 'string'], attribute: $key, parameter: $max);
        }

        return true;
    }

    protected static function file(string $key, array $value, int $max)
    {
        if ($value['size'] > $max)
        {
            return Message::get(['max' => 'file'], attribute: $key, parameter: $max);
        }

        return true;
    }
}