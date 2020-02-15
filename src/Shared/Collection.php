<?php

declare(strict_types=1);

namespace Shogi\Shared;

abstract class Collection implements \Countable, \IteratorAggregate
{
    private array $items;

    abstract protected function getType(): string;

    public function __construct(array $items = array())
    {
        static::validateType($this->getType(), $items);

        $this->items = $items;
    }

    public function add($item)
    {
        static::validateType($this->getType(), [$item]);

        $this->items[] = $item;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this);
    }

    public function count(): int
    {
        return count($this->items);
    }

    protected function items(): array
    {
        return $this->items;
    }

    protected function each(callable $function)
    {
        return array_map(function($item) use ($function) {
            return call_user_func($function, $item);
        }, $this->items);
    }

    private static function validateType(string $type, $items)
    {
        $validator = function($item) use ($type) {
            if (!$item instanceof $type) {
                throw new \InvalidArgumentException(sprintf('Only %s can be added', $type));
            }
        };

        return array_map(function($item) use ($validator) {
            return call_user_func($validator, $item);
        }, $items);
    }
}