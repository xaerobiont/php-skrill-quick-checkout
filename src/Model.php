<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

use ReflectionClass;
use ReflectionProperty;

abstract class Model
{
    /**
     * @throws SkrillException
     */
    function __construct(array $params = [], bool $skipUndefined = false)
    {
        foreach ($params as $name => $value) {
            if (!property_exists($this, $name)) {
                if (!$skipUndefined) {
                    throw new SkrillException(sprintf('Property %s does not exist in %s', $name, $this::class));
                }
            } else {
                $this->$name = $value;
            }
        }
    }

    public function toArray(bool $excludeNulls = true): array
    {
        $result = [];
        $reflect = new ReflectionClass($this);
        foreach ($reflect->getProperties(ReflectionProperty::IS_PROTECTED) as $prop) {
            $propName = $prop->getName();
            $getter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $propName)));
            if (method_exists($this, $getter)) {
                $propValue = $this->$getter();
            } else {
                $propValue = $this->$propName;
            }
            if ($excludeNulls && is_null($propValue)) {
                continue;
            }
            $result[$propName] = $propValue;
        }

        return $result;
    }
}