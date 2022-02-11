<?php

namespace YuriOliveira\Validation\Validations;

use YuriOliveira\Validation\Message\Message;

class Specific extends AbstractValidation
{
    protected static function string(string $key, string $value, int $specific)
    {
        if (strlen($value) !== $specific)
        {
            return Message::get(['specific' => 'string'], attribute: $key, parameter: $specific);
        }

        return true;
    }

    protected static function file(string $key, array $value, int $specific)
    {
        if ($value['size'] !== $specific)
        {
            return Message::get(['specific' => 'file'], attribute: $key, parameter: $specific);
        }

        return true;
    }
}