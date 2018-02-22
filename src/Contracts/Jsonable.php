<?php

namespace Fluffy\Assistance\Contracts;

/**
 * Interface Jsonable
 *
 * @package Fluffy\Assistance\Contracts
 */
interface Jsonable
{

    /**
     * Convert object to Json
     *
     * @param int $options JSON Options
     *
     * @return string
     */
    public function toJson($options = 0): string;
}
