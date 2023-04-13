<?php

namespace YuriOliveira\Validate\Validation;

abstract class ValidationAbstract
{
    /**
     * execute
     *
     * @param string $key
     * @param $value
     * @param null|string $parameter
     * @return boolean|string
     */
    public static function execute($key, $value, $parameter = null)
    {
        $method = static::valueType($value);

        return static::$method($key, $value, $parameter);
    }

    /**
     * valueType
     *
     * @param $value
     * @return string
     */
    protected static function valueType($value): string
    {
        if (is_numeric($value)) {
            return 'numeric';
        }

        if (is_string($value)) {
            return 'string';
        }

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
