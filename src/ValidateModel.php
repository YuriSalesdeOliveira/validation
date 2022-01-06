<?php

namespace YuriOliveira\Validation;

class ValidateModel extends ValidateConditions
{
    protected array $config = [
        'model_namespace' => 'Source\Model\\'
    ];

    protected function unique($key, $value, $model): bool|string
    {
        $model = $this->config['model_namespace'] . ucfirst($model);
        
        if (class_exists($model))
        {
            $result = $model::find([$key => $value])->first();

            if ($result) return $this->message->get('unique', attribute: $key);
            
        }

        return true;
    }

    protected function exists($key, $value, $model): bool|string
    {
        $model = $this->config['model_namespace'] . ucfirst($model);
        
        if (class_exists($model)) {
            
            $result = $model::find([$key => $value])->first();

            if (!$result) return $this->message->get('exists', attribute: $key);
            
        }

        return true;
    }
}