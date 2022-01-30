<?php

namespace YuriOliveira\Validation;

class ValidateCondition extends AbstractValidate
{
    protected function condition($key, $value, $condition)
    {
        $method = strtolower($condition) . 'Condition';

        if (method_exists($this, $method))
        {
            return $this->$method($key, $value);
        }
    }

    protected function filledCondition($key, $value): bool
    {
        return empty($value) ? false : true;
    }

    protected function emptyCondition($key, $value): bool
    {
        if (!empty($value)) { return false; }

        return true;
    }
}