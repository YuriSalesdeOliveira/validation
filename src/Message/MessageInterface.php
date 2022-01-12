<?php

namespace YuriOliveira\Validation\Message;

interface MessageInterface
{
    public static function get(string|array $key, string $attribute, string $parameter = null): string;    
}