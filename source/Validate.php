<?php

namespace YuriOliveira\Validate;

use Exception;
use YuriOliveira\Validate\Message\Message;

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
        if (isset(self::$customValidations[$name])) {

            $closure = self::$customValidations[$name];

            return $closure(...$arguments);
        }

        throw new Exception('A validation utilizada não foi encontrada');
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function create(array $data): self
    {
        $instance = new self($data);

        return $instance;
    }

    public function validate(array $rules): self
    {
        $this->rules = $this->rules($rules);

        foreach ($this->rules as $key => $rules) {

            if (array_key_exists($key, $this->data)) {

                $this->execute($key, $rules, $this->data[$key]);

            } elseif (array_key_exists('required', $rules)) {

                $this->errors[$key] = Message::get('required', $key);
            }
        }

        return $this;
    }

    protected function config(array $config = [])
    {
        foreach ($config as $key => $value) {

            $this->config[$key] = $value;
        }
    }

    protected function execute(string $key, array $rules, $value)
    {
        foreach ($rules as $handler => $parameter) {

            $namespace_handler = $this->namespace($handler);

            if (class_exists($namespace_handler)) {

                $return = $namespace_handler::execute($key, $value, $parameter);
                
            } else {

                $return = $this->$handler($key, $value, $parameter);
            }

            if ($return === false) { break; }
            
            if (is_string($return)) {

                $this->errors[$key] = $return;

                break;
            }
        }
    }

    protected function namespace(string $handler)
    {
        if ($handler === 'condition') {

            return 'YuriOliveira\Validate\\' . ucfirst($handler);
        }

        return 'YuriOliveira\Validate\Validation\\' . ucfirst($handler);
    }

    protected function rules(array $rules): array
    {
        $return_rules = [];

        foreach ($rules as $key => $rules) {

            $return_rules[$key] = $this->standardizeRules($rules);
        }

        return $return_rules;
    }

    protected function standardizeRules(array $rules)
    {
        $standardized_rules = [];

        foreach ($rules as $rule) {

            [$handler, $parameter] = explode(':', $rule) + [0 => null, 1 => null];

            $standardized_rules[$handler] = $parameter;
        }

        return $standardized_rules;
    }

    /**
     * errors
     *
     * @param string|null $key
     * @return string|array
     */
    public function errors($key = null)
    {
        return $key ? $this->errors[$key] : $this->errors;
    }
}
