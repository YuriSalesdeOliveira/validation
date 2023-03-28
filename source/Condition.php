<?php

namespace YuriOliveira\Validate;

use Exception;

class Condition
{
    protected static array $customConditions;

    public static function extend(string $name, callable $closure): void
    {
        self::$customConditions[$name] = $closure;
    }

    public static function __callStatic($name, $arguments): bool
    {
        if (isset(self::$customConditions[$name])) {

            $closure = self::$customConditions[$name];

            return $closure(...$arguments);
        }

        throw new Exception('A condition utilizada não foi encontrada');
    }

    public static function execute($key, $value, $condition): bool
    {
        $method = strtolower($condition);

        return self::$method($value, $key);
    }

    protected static function filled($value): bool
    {
        return empty($value) ? false : true;
    }

    protected static function empty($value): bool
    {
        return empty($value) ? true : false;
    }
}
