<?php

namespace YuriOliveira\Validate\Message;

use Exception;

class Message
{
    protected array $messages;
    protected array $allowed_types = [
        'numeric',
        'file',
        'string',
        'array'
    ];

    protected static array $customMessages = [];

    public static function extend(array $messages)
    {
        self::$customMessages = $messages;
    }

    public function __construct()
    {
        $defaultMessages = require(dirname(__DIR__, 2) . '/resources/language/pt-br/validation.php');

        $this->messages = array_merge($defaultMessages, self::$customMessages);
    }

    public static function get(string $key, string $attribute, string $parameter = null): string
    {
        $instance = new static;

        if (str_contains($key, '.')) {
        
            [$key, $type] = explode('.', $key);

            $instance->validateType($type);

            $message = $instance->messages[$key][$type];

            return $instance->formatMessage($message, $attribute, [$key => $parameter]);
        }

        $message = $instance->messages[$key];

        return $instance->formatMessage($message, $attribute);
    }

    protected function formatMessage(string $message, string $attribute, array $parameter = []): string
    {
        $attribute = $this->changeAttribute($attribute);

        $returned_message = str_replace(':attribute', $attribute, $message);

        if ($parameter) {
            
            foreach ($parameter as $key => $value) {
                
                $returned_message = str_replace(":{$key}", $value, $returned_message);
            }
        }

        return $returned_message;
    }

    protected function changeAttribute(string $attribute): string
    {
        foreach ($this->messages['attributes'] as $from => $to) {

            if ($from === $attribute) { $attribute = $to; }
        }

        return $attribute;
    }

    protected function validateType(string $type): bool
    {
        if (!in_array($type, $this->allowed_types)) {

            throw new Exception("O tipo {$type} não é permitido. Os tipos permitidos são " . implode(',', $this->allowed_types));
        }

        return true;
    }
}
