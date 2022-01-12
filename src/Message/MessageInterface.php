<?php

namespace YuriOliveira\Validation\Message;

interface MessageInterface
{
    public function get(string|array $key, string $attribute, string $parameter = null): string;    
}