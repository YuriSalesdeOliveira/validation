<?php

namespace YuriOliveira\Validation;

trait ValidateConditionTrait
{
    protected function conditionFilled($key, $value): bool
    {
        if (empty($value))
        {
            unset($this->rules[$key]);
            
            return false;
        }

        return true;
    }

    protected function conditionEmpty($key, $value): bool
    {
        if (!empty($value))
        {
            unset($this->rules[$key]);
            
            return false;
        }

        return true;
    }

    public function __call($name, $arguments)
    {   
        $name = explode('_', $name);

        if ($name[0] === 'c')
        {
            $method = 'condition' . ucfirst($name[1]);
            
            if (method_exists($this, $method))
            {
                return $this->$method(...$arguments);
            }
        }
    }
}