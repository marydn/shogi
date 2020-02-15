<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\ValueObject\Coordinate;

final class CoordinateTranslator
{
    const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

    public Coordinate $coordinate;

    public function __construct(string $coordinate)
    {
        $this->coordinate = new Coordinate($coordinate);
    }

    public function x(): int
    {
        return array_search($this->coordinate->x(), self::LETTERS);
    }

    public function y(): int
    {
        return $this->coordinate->y() - 1;
    }
}