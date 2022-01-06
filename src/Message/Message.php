<?php

namespace YuriOliveira\Validation\Message;

use Exception;

class Message implements MessageInterface
{
    protected array $messages;
    protected array $allowed_types = [
        'numeric',
        'file',
        'string',
        'array'
    ];

    public function __construct(string $messages_file = null)
    {
        $this->getMessages($messages_file);
    }

    protected function getMessages(?string $messages_file)
    {
        $messages_file = $messages_file ?? dirname(__DIR__, 2) . '/resources/language/pt-br/validation.php';

        $this->messages = require_once($messages_file);
    }

    public function get(string|array $key, string $attribute, string $parameter = null): string
    {
        if (is_array($key))
        {
            foreach ($key as $key => $type)
            {
                $this->validateType($type);

                $message = $this->messages[$key][$type];

                return $this->formatMessage($message, $attribute, [$key => $parameter]);
            }
        }

        $message = $this->messages[$key];

        return $this->formatMessage($message, $attribute);
    }

    protected function formatMessage(string $message, string $attribute, array $parameter = []): string
    {
        $attribute = $this->changeAttribute($attribute);

        $returned_message = str_replace(':attribute', $attribute, $message);

        if ($parameter)
        {
            foreach ($parameter as $key => $value)
            {
                $returned_message = str_replace(":{$key}", $value, $returned_message);
            }
        }

        return $returned_message;
    }

    protected function changeAttribute(string $attribute): string
    {
        foreach ($this->messages['attributes'] as $current => $new)
        {
            if ($current === $attribute) $attribute = $new;
        }

        return $attribute;
    }

    protected function validateType(string $type): bool
    {
        if (!in_array($type, $this->types))
        {
            throw new Exception('Tipos permitidos ' . implode(',', $this->types));
        }
        
        return true;
    }
}