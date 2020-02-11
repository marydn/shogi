<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

final class Spot
{
    private const LIMIT_X = 9;
    private const LIMIT_Y = 9;

    private string $x;
    private string $y;
    private ?PieceInterface $piece;

    public function __construct(string $x, string $y, ?PieceInterface $piece)
    {
        $this->validateCoordinates($x, $y);

        $this->x     = $x;
        $this->y     = $y;
        $this->piece = $piece;
    }

    public static function add(string $x, string $y, ?PieceInterface $piece)
    {
        return new self($x, $y, $piece);
    }

    private function validateCoordinates($x, $y)
    {
        if ($x < 1 && $x > self::LIMIT_X) {
            throw new \InvalidArgumentException();
        }

        if ($y < 1 && $y > self::LIMIT_Y) {
            throw new \InvalidArgumentException();
        }
    }
}