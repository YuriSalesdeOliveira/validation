<?php

namespace YuriOliveira\Validate\Validation;

use YuriOliveira\Validate\Message\Message;

class Email extends ValidationAbstract
{
    protected static function string(string $key, string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {

            return Message::get('email', $key);
        }

        return true;
    }
}
