<?php

namespace zvook\Skrill\Models;

use zvook\Skrill\Components\SkrillException;

/**
 * @package zvook\Skrill
 * @author Dmitry zvook Klyukin
 */
abstract class Model
{
    /**
     * @param array $params
     * @throws SkrillException
     */
    function __construct($params = [])
    {
        foreach ($params as $name => $value) {
            if (!property_exists($this, $name)) {
                throw new SkrillException(sprintf('Invalid property %s', $name));
            }
            $this->$name = $value;
        }
    }
}