<?php

namespace YuriOliveira\Validate\Validation;

use YuriOliveira\Validate\Message\Message;

class Min extends ValidationAbstract
{
    protected static function string(string $key, string $value, int $min)
    {
        if (strlen($value) < $min) {

            return Message::get('min.string', $key, $min);
        }

        return true;
    }

    protected static function file(string $key, array $value, int $min)
    {
        if ($value['size'] < $min) {

            return Message::get('min.file', $key, $min);
        }

        return true;
    }
}
