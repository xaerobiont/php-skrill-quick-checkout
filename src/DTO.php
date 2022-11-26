<?php

declare(strict_types=1);

namespace Xaerobiont\Skrill;

abstract class DTO
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
        $data = get_object_vars($this);
        if ($excludeNulls) {
            return array_filter($data, fn($value) => !is_null($value));
        }

        return $data;
    }
}