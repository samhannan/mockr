<?php

namespace App\Http\DataTransferObjects;

use DomainException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionProperty;

class DataTransferObject implements Arrayable
{
    protected bool $strict = false;

    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $property = $property->getName();

            if (array_key_exists($property, $parameters)) {
                $this->{$property} = $parameters[$property];
            }
            Arr::forget($parameters, $property);
        }

        if ($this->isStrict() && count($parameters)) {
            throw new DomainException(static::class, array_keys($parameters));
        }
    }

    public function all(): array
    {
        $class = new ReflectionClass(static::class);
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        $data = [];
        foreach ($properties as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $data[$property->getName()] = $property->getValue($this);
        }

        return $data;
    }

    public function except(array $keysToIgnore): array
    {
        return Arr::except($this->all(), $keysToIgnore);
    }

    public function toArray(): array
    {
        return $this->parseArray($this->all());
    }

    public function toFilteredArray(): array
    {
        return array_filter($this->toArray(), fn ($v) => ! is_null($v));
    }

    protected function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($value instanceof DataTransferObject) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (! is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }

    protected function isStrict(): bool
    {
        return $this->strict;
    }
}
