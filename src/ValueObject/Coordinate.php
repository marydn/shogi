<?php

declare(strict_types=1);

namespace Shogi\ValueObject;

use Shogi\Exception\CoordinateNotFound;

final class Coordinate
{
    private string $x;
    private int $y;

    public function __construct(string $notation)
    {
        self::validate($notation);

        [$x, $y] = str_split($notation);

        $this->x = strtoupper($x);
        $this->y = (int) $y;
    }

    public function x(): string
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    private static function validate(string $notation)
    {
        if (strlen(trim($notation)) > 2) {
            throw new CoordinateNotFound;
        }

        [$x, $y] = str_split($notation);

        $x = array_search(strtoupper($x), range('A', 'I'));

        if (false === $x) {
            throw new CoordinateNotFound;
        }

        if ($y < 1 || $y > 9) {
            throw new CoordinateNotFound;
        }
    }
}