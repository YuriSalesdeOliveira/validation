<?php

namespace YuriOliveira\Validation;

use YuriOliveira\Validation\Message\Message;
use YuriOliveira\Validation\Message\MessageInterface;

abstract class AbstractValidate
{
    protected MessageInterface $message;

    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $config = [];

    public function __construct(array $data)
    {
        $this->data = $data;

        $this->message = new Message();
    }

    public function validate(array $rules): static
    {
        $this->rules = $this->rules($rules);

        foreach ($this->rules as $key => $rules)
        {
            if (array_key_exists($key, $this->data))
            {
                $this->execute($key, $this->data[$key], $rules);

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

    protected function execute(string $key, string $value, array $rules)
    {
        foreach ($rules as $method => $parameter)
        {
            $return = $this->$method($key, $value, $parameter);

            if ($return === true) continue;

            $this->errors[$key] = $return;
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
}