<?php

declare(strict_types=1);

namespace Shogi\ValueObject;

use Shogi\Exception\CoordinateNotFound;
use Shogi\Exception\CoordinateNotWellFormedNotation;

final class Coordinate
{
    const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

    private int $x;
    private string $y;

    public function __construct(string $notation)
    {
        self::validate($notation);

        [$y, $x] = str_split($notation);

        $this->x = (int) $x;
        $this->y = strtoupper($y);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): string
    {
        return $this->y;
    }

    private static function validate(string $notation)
    {
        if (strlen(trim($notation)) > 2) {
            throw new CoordinateNotWellFormedNotation($notation);
        }

        [$y, $x] = str_split($notation);

        $y = array_search(strtoupper($y), self::LETTERS);

        if (false === $y) {
            throw new CoordinateNotFound($notation);
        }

        if ($x < 1 || $x > 9) {
            throw new CoordinateNotFound($notation);
        }
    }
}