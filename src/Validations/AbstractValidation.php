<?php

namespace YuriOliveira\Validation\Validations;

abstract class AbstractValidation
{
    public static function parse(string $key, mixed $value, null|string $parameter = null): bool|string
    {
        $method = static::valueType($value);

        return static::$method($key, $value, $parameter);
    }

    protected static function valueType(mixed $value): string
    {
        if (is_numeric($value)) { return 'numeric'; }
        if (is_string($value)) { return 'string'; }
        if (is_array($value))
        {
            $file = ['name', 'type', 'tmp_name', 'error', 'size'];

            foreach ($file as $key)
            {
                if (!in_array($key, array_keys($value))) { return 'array'; }
            }

            return 'file';
        }
    }
}