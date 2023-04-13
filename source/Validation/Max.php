<?php

namespace YuriOliveira\Validate\Validation;

use YuriOliveira\Validate\Message\Message;

class Max extends ValidationAbstract
{
    protected static function string(string $key, string $value, int $max)
    {
        if (strlen($value) > $max) {

            return Message::get('max.string', $key, $max);
        }

        return true;
    }

    protected static function file(string $key, array $value, int $max)
    {
        if ($value['size'] > $max) {

            return Message::get('max.file', $key, $max);
        }

        return true;
    }
}
