<?php

namespace YuriOliveira\Validation;

use YuriOliveira\Validation\Message\Message;

class Validate
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];
    protected array $config = [];
    protected static array $customValidations;

    public static function extend(string $name, callable $closure)
    {
        self::$customValidations[$name] = $closure;
    }

    public function __call($name, $arguments)
    {
        if (!empty(self::$customValidations[$name]) && $closure = self::$customValidations[$name])
        {
            return $closure(...$arguments);
        }
    }

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
        foreach ($rules as $handler => $parameter)
        {
            $namespace_handler = $this->namespace($handler);

            if (class_exists($namespace_handler))
            {
                $return = $namespace_handler::parse($key, $value, $parameter);

            } else
            {
                $return = $this->$handler($key, $value, $parameter);
            }

            if ($return === false) { break; }
            if (is_string($return)) { $this->errors[$key] = $return; }
        }
    }

    protected function namespace(string $handler)
    {
        if ($handler === 'condition') { return 'YuriOliveira\Validation\\' . ucfirst($handler); }

        return 'YuriOliveira\Validation\Validations\\' . ucfirst($handler);
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

            [$handler, $parameter] = $this->rule($rule);

            $standardized_rules[$handler] = $parameter;
        }

        return $standardized_rules;
    }

    protected function rule(string $rule): array
    {
        $rule = explode(':', $rule);

        $handler = $rule[0];
        $parameter = $rule[1] ?? null; 

        return [$handler, $parameter];
    }

    public function errors(string $key = null): string|array
    {
        return $key ? $this->errors[$key] : $this->errors;
    }
}
