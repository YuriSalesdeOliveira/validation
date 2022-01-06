<?php

namespace YuriOliveira\Validation;

class ValidateConditions extends AbstractValidate
{
    protected function conditionContent($key, $value): bool
    {
        if (empty($value)) unset($this->rules[$key]);

        return true;
    }

    public function __call($name, $arguments)
    {
        $name = explode('.', $name);

        if ($name[0] === 'c') 
        {
            $method = 'condition' . ucfirst($name[1]);

            $this->$method(...$arguments);
        }
    }
}