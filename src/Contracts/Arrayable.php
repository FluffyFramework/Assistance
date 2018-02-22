<?php

namespace Fluffy\Assistance\Contracts;

/**
 * Interface Arrayable
 *
 * @package Fluffy\Assistance\Contracts
 */
interface Arrayable
{

    /**
     * Get the instance as an array
     *
     * @return array
     */
    public function toArray(): array;
}
