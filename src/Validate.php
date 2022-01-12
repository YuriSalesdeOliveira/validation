<?php

namespace YuriOliveira\Validation;

use YuriOliveira\Validation\Message\Message;

class Validate extends ValidateCondition
{
    use ValidateModelTrait;

    protected static Array $customValidations;

    public static function extend(string $name, callable $closure)
    {
        self::$customValidations[$name] = $closure;
    }

    public function __call($name, $arguments)
    {
        if (!empty(self::$customValidations[$name]) && $closure = self::$customValidations[$name])
        {
            return $closure(...$arguments);
        }
    }

    protected function max($key, $value, int $max): bool|string
    {
        if (strlen($value) > $max)
        {
            return Message::get(['max' => 'string'], attribute: $key, parameter: $max);
        }

        return true;
    }

    protected function min($key, $value, int $min): bool|string
    {
        if (strlen($value) < $min)
        {
            return Message::get(['min' => 'string'], attribute: $key, parameter: $min);
        }

        return true;
    }


    protected function required($key, $value): bool|string
    {
        if (empty($value))
        {
            return Message::get('required', attribute: $key);
        }

        return true;
    }

    protected function email($key, $value): bool|string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            return Message::get('email', attribute: $key);
        }

        return true;
    }
    
    protected function specific($key, $value, int $specific): bool|string
    {
        if (strlen($value) !== $specific)
        {
            return Message::get(['specific' => 'string'], attribute: $key);
        }

        return true;
    }
}
