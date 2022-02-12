<?php

namespace YuriOliveira\Validation;

class Condition
{
    protected static array $customConditions;

    public static function parse($key, $value, $condition)
    {
        $method = strtolower($condition);

        if (method_exists(static::class, $method))
        {
            return static::$method($key, $value);
        }
    }

    protected static function filled($key, $value): bool
    {
        return empty($value) ? false : true;
    }

    protected static function empty($key, $value): bool
    {
        if (!empty($value)) { return false; }
        
        return true;
    }

    public static function extend(string $name, callable $closure)
    {
        self::$customConditions[$name] = $closure;
    }

    public function __call($name, $arguments)
    {
        if (!empty(self::$customConditions[$name]) && $closure = self::$customConditions[$name])
        {
            return $closure(...$arguments);
        }
    }
}