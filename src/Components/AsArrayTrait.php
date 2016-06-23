<?php

namespace zvook\Skrill\Components;

/**
 * @package zvook\Skrill\Components
 * @author Dmitry zvook Klyukin
 */
trait AsArrayTrait
{
    /**
     * @return array
     */
    public final function asArray()
    {
        $params = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PROTECTED);
        foreach ($props as $prop) {
            $propName = $prop->getName();
            $propValue = $this->$propName;
            if (!is_null($propValue)) {
                $params[$propName] = $this->$propName;
            }
        }

        return $params;
    }
}