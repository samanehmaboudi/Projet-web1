<?php

namespace App\Providers;

use App\Models;

class Validator
{
    private array $errors = [];
    private string $key;
    private mixed $value;
    private string $name;

   
    public function field( $key, $value, $name = null): static
    {
        $this->key = $key;
        $this->value = $value;
        $this->name = $name ? ucfirst($name) : ucfirst($key);
        return $this;
    }

   
    public function required(): static
    {
        if (empty($this->value)) {
            $this->errors[$this->key] = "$this->name is required!";
        }
        return $this;
    }

    
    public function max(int $length): static
    {
        if (strlen($this->value) > $length) {
            $this->errors[$this->key] = "$this->name must be less than $length characters!";
        }
        return $this;
    }

   
    public function min(int $length): static
    {
        if (strlen($this->value) < $length) {
            $this->errors[$this->key] = "$this->name must be more than $length characters!";
        }
        return $this;
    }

    
    public function number(): static
    {
        if (!empty($this->value) && !is_numeric($this->value)) {
            $this->errors[$this->key] = "$this->name must be a number!";
        }
        return $this;
    }

    
    public function email(): static
    {
        if (!empty($this->value) && !filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$this->key] = "$this->name invalid!";
        }
        return $this;
    }



    public function unique(string $model): static
    {
        $modelClass = 'App\\Models\\' . $model;
        $instance = new $modelClass;

        if (method_exists($instance, 'unique')) {
            if ($instance->unique($this->key, $this->value)) {
                $this->errors[$this->key] = "$this->name must be unique!";
            }
        }
        return $this;
    }

    public function isSuccess(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array|null
    {
        return $this->isSuccess() ? null : $this->errors;
    }
}
