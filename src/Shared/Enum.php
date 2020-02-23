<?php

declare(strict_types=1);

namespace Shogi\Shared;

use Doctrine\Common\Inflector\Inflector;

abstract class Enum
{
    protected static array $cache = [];
    protected string $value;

    public function __construct($value)
    {
        $this->ensureIsBetweenAcceptedValues($value);

        $this->value = $value;
    }

    abstract protected function throwExceptionForInvalidValue($value);

    public static function __callStatic(string $name, $args)
    {
        return new static(self::values()[$name]);
    }

    public static function fromString(string $value): self
    {
        return new static($value);
    }

    public static function values(): array
    {
        $class = static::class;

        if (!isset(self::$cache[$class])) {
            $reflected = new \ReflectionClass($class);
            $constants = $reflected->getConstants();

            $keys   = array_map(self::keysFormatter(), array_keys($constants));
            $values = array_values($constants);

            self::$cache[$class] = array_combine($keys, $values);
        }

        return self::$cache[$class];
    }

    public static function randomValue()
    {
        return self::values()[array_rand(self::values())];
    }

    public function value()
    {
        return $this->value;
    }

    public function equals(Enum $other): bool
    {
        return $other === $this;
    }

    private function ensureIsBetweenAcceptedValues($value): void
    {
        if (!\in_array($value, static::values(), true)) {
            $this->throwExceptionForInvalidValue($value);
        }
    }

    public static function random(): self
    {
        return new static(self::randomValue());
    }

    private static function keysFormatter(): callable
    {
        return static function (string $key): string {
            return Inflector::camelize(strtolower($key));
        };
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }
}