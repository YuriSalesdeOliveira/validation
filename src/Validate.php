<?php

namespace YuriOliveira\Validation;

class Validate extends AbstractValidate
{
    use ValidateConditionTrait, ValidateModelTrait;

    protected function max($key, $value, int $max): bool|string
    {
        if (strlen($value) > $max)
        {
            return $this->message->get(['max' => 'string'], attribute: $key, parameter: $max);
        }

        return true;
    }

    protected function min($key, $value, int $min): bool|string
    {
        if (strlen($value) < $min)
        {
            return $this->message->get(['min' => 'string'], attribute: $key, parameter: $min);
        }

        return true;
    }


    protected function required($key, $value): bool|string
    {
        if (empty($value))
        {
            return $this->message->get('required', attribute: $key);
        }

        return true;
    }

    protected function email($key, $value): bool|string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
        {
            return $this->message->get('email', attribute: $key);
        }

        return true;
    }
}
