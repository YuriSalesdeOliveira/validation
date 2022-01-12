<?php

namespace YuriOliveira\Validation;

class ValidateCondition extends AbstractValidate
{
    protected function condition($key, $value, $condition)
    {
        $method = strtolower($condition) . 'Condition';

        if (method_exists($this, $method))
        {
            $this->$method($key, $value);
        }
    }

    protected function filledCondition($key, $value): bool
    {
        if (empty($value))
        {
            unset($this->rules[$key]);
            
            return false;
        }

        return true;
    }

    protected function emptyCondition($key, $value): bool
    {
        if (!empty($value))
        {
            unset($this->rules[$key]);
            
            return false;
        }

        return true;
    }
}