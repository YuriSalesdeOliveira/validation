<?php

namespace YuriOliveira\Validate\Validation;

abstract class ValidationAbstract
{
    public static function execute(string $key, mixed $value, null|string $parameter = null): bool|string
    {
        $method = static::valueType($value);

        return static::$method($key, $value, $parameter);
    }

    protected static function valueType(mixed $value): string
    {
        if (is_numeric($value)) { return 'numeric'; }

        if (is_string($value)) { return 'string'; }

        if (is_array($value)) {

            $file_keys = ['name', 'type', 'tmp_name', 'error', 'size'];

            foreach ($file_keys as $key) {

                if (!in_array($key, array_keys($value))) {

                    return 'array';
                }
            }

            return 'file';
        }
    }
}
