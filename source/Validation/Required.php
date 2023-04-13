<?php

namespace YuriOliveira\Validate\Validation;

use YuriOliveira\Validate\Message\Message;

class Required extends ValidationAbstract
{
    protected static function string(string $key, string $value)
    {
        if (empty($value)) {

            return Message::get('required', $key);
        }

        return true;
    }

    protected static function file(string $key, array $value)
    {
        if ($value['size'] === 0) {
            
            return Message::get('required', $key);
        }

        return true;
    }
}
