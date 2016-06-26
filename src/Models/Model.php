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
     * @param bool|false $skipNonExistent
     * @throws SkrillException
     */
    function __construct($params = [], $skipNonExistent = false)
    {
        foreach ($params as $name => $value) {
            if (!property_exists($this, $name)) {
                if (!$skipNonExistent) {
                    throw new SkrillException(sprintf('Invalid property %s', $name));
                }
            } else {
                $this->$name = $value;
            }
        }
    }
}