<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\ValueObject\Coordinate;

final class CoordinateTranslator
{
    public Coordinate $readableCoordinate;

    public function __construct(string $coordinate)
    {
        $this->readableCoordinate = new Coordinate($coordinate);
    }

    public function x(): int
    {
        $readableX = $this->readableCoordinate->x();
        $readableX = abs(count(Coordinate::LETTERS) - $readableX);

        return $readableX;
    }

    public function y(): int
    {
        return array_search($this->readableCoordinate->y(), Coordinate::LETTERS);
    }
}