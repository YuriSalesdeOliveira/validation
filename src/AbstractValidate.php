<?php

namespace YuriOliveira\Validation;

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

        foreach (array_keys($this->rules) as $key)
        {
            if (array_key_exists($key, $this->data))
            {
                $this->execute($key, $this->data[$key]);

            } elseif (array_key_exists('required', $rules))
            {
                $this->errors[$key] = $this->message->get('required', attribute: $key);
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

    protected function execute(string $key, string $value)
    {
        foreach ($this->rules[$key] as $method => $parameter)
        {   
            if (!isset($this->rules[$key])) { break; }

            $return = $this->$method($key, $value, $parameter);
            
            if (is_string($return)) { $this->errors[$key] = $return; }
        }
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

            [$method, $parameter] = $this->rule($rule);

            $standardized_rules[$method] = $parameter;
        }

        return $standardized_rules;
    }

    protected function rule(string $rule): array
    {
        $rule = explode(':', $rule);

        $method = $rule[0];
        $parameter = $rule[1] ?? null; 

        return [$method, $parameter];
    }

    public function errors(string $key = null)
    {
        return $key ? $this->errors[$key] : $this->errors;
    }
}