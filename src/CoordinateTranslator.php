<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\ValueObject\Coordinate;

final class CoordinateTranslator
{
    const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

    public Coordinate $readableCoordinate;

    public function __construct(string $coordinate)
    {
        $this->readableCoordinate = new Coordinate($coordinate);
    }

    public function x(): int
    {
        return array_search($this->readableCoordinate->x(), self::LETTERS);
    }

    public function y(): int
    {
        return $this->readableCoordinate->y() - 1;
    }
}