<?php

namespace YuriOliveira\Validation;

class Validate extends AbstractValidate
{
    protected static array $customValidations;

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
}
