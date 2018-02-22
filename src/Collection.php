<?php
namespace Fluffy\Assistance;

use ArrayAccess;
use ArrayIterator;
use Fluffy\Assistance\Contracts\Arrayable;
use Fluffy\Assistance\Contracts\Jsonable;
use IteratorAggregate;
use JsonSerializable;
use Traversable;

/**
 * Class Collection
 *
 * @package Fluffy\Assistance\Collection
 */
class Collection
    implements ArrayAccess, IteratorAggregate, JsonSerializable, Arrayable,
               Jsonable
{

    /**
     * @var array
     */
    protected $items;

    /**
     * Collection constructor.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->convertItemsToArray($items);
    }

    /**
     *  Try convert data to array
     *
     * @param array|\Fluffy\Assistance\Collection|Arrayable|Jsonable|JsonSerializable|Traversable $items
     *
     * @return array
     */
    protected function convertItemsToArray($items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof self) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif (is_json($items)) {
            return json_decode($items, true);
        } elseif ($items instanceof JsonSerializable) {
            return $items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        }

        return (array)$items;
    }

    /**
     * Return all items from collection
     *
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Add new item or items to collection
     *
     * @param array|\Fluffy\Assistance\Collection|Arrayable|Jsonable|JsonSerializable|Traversable|mixed $items
     *
     * @return \Fluffy\Assistance\Collection
     */
    public function add($items): Collection
    {
        if (is_array($items)) {
            array_push($this->items, $this->convertItemsToArray($items));
        } else {
            $this->items[] = $items;
        }

        return $this;
    }

    /**
     * Set the value on the given offset
     *
     * @param $offset
     * @param $value
     */
    public function set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * Set the value on the given offset
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * Get an item at given offset
     *
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * Check whether given item exists at  offset
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Count the number of items in collection
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Unset item at given offset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * Retrieve an external iterator
     *
     * @return \Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     *  Specify data which should be serialized to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * Convert object to Json
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->items, $options);
    }

    /**
     * Get the instance as an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
