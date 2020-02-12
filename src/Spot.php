<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

final class Spot
{
    private int $x;
    private string $y;
    private ?PieceInterface $piece;

    public function __construct(int $x, string $y, ?PieceInterface $piece)
    {
        $this->validateCoordinates($x, $y);

        $this->x     = $x;
        $this->y     = $y;
        $this->piece = $piece;
    }

    public static function add(int $x, string $y, ?PieceInterface $piece)
    {
        return new self($x, $y, $piece);
    }

    public function piece(): PieceInterface
    {
        return $this->piece;
    }

    private function validateCoordinates(int $x, string $y)
    {
        if ($x < 1 && $x > Board::LIMIT_X) {
            throw new \InvalidArgumentException();
        }

        if (in_array($y, range('A', 'I'))) {
            throw new \InvalidArgumentException();
        }
    }
}