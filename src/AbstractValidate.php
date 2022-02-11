<?php

namespace YuriOliveira\Validation;

use YuriOliveira\Validation\Message\Message;

abstract class AbstractValidate
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $config = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): static
    {
        $this->rules = $this->rules($rules);

        foreach ($this->rules as $key => $rules)
        {
            if (array_key_exists($key, $this->data))
            {
                $this->execute($key, $rules, $this->data[$key]);

            } elseif (array_key_exists('required', $rules))
            {
                $this->errors[$key] = Message::get('required', attribute: $key);
            }
        }

        return $this;
    }

    protected function config(array $config = [])
    {
        foreach ($config as $key => $value)
        {
            $this->config[$key] = $value;
        }
    }

    protected function execute(string $key, array $rules, mixed $value)
    {
        foreach ($rules as $class => $parameter)
        {
            $class = $this->namespace($class);

            $return = $class::parse($key, $value, $parameter);
            
            if ($return === false) { break; }
            if (is_string($return)) { $this->errors[$key] = $return; }
        }
    }

    protected function namespace(string $class)
    {
        if ($class === 'condition')
        {
            return 'YuriOliveira\Validation\\' . ucfirst($class);
        }

        return 'YuriOliveira\Validation\Validations\\' . ucfirst($class);
    }

    protected function rules(array $rules): array
    {
        $return_rules = [];

        foreach ($rules as $key => $rules)
        {
            $return_rules[$key] = $this->standardizeRules($rules);
        }

        return $return_rules;
    }

    protected function standardizeRules(array $rules)
    {
        $standardized_rules = [];
        
        foreach ($rules as $rule) {

            [$class, $parameter] = $this->rule($rule);

            $standardized_rules[$class] = $parameter;
        }

        return $standardized_rules;
    }

    protected function rule(string $rule): array
    {
        $rule = explode(':', $rule);

        $class = $rule[0];
        $parameter = $rule[1] ?? null; 

        return [$class, $parameter];
    }

    public function errors(string $key = null)
    {
        return $key ? $this->errors[$key] : $this->errors;
    }
}