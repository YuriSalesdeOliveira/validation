<?php

namespace YuriOliveira\Validate\Validation;

use YuriOliveira\Validate\Message\Message;

class Specific extends ValidationAbstract
{
    protected static function string(string $key, string $value, int $specific)
    {
        if (strlen($value) !== $specific) {

            return Message::get('specific.string', $key, $specific);
        }

        return true;
    }

    protected static function file(string $key, array $value, int $specific)
    {
        if ($value['size'] !== $specific) {

            return Message::get('specific.file', $key, $specific);
        }

        return true;
    }
}
