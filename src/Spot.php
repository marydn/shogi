<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

/** @TODO: Validate piece input */
final class Spot
{
    private int $column;
    private int $row;
    private ?PieceInterface $piece;

    public function __construct(int $column, int $row, ?PieceInterface $piece = null)
    {
        $this->column = $column;
        $this->row    = $row;
        $this->piece  = $piece;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function row(): int
    {
        return $this->row;
    }

    public function place(?PieceInterface $piece): void
    {
        $this->piece = $piece;
    }

    public function piece(): ?PieceInterface
    {
        return $this->piece;
    }

    public function isTaken(): bool
    {
        return boolval($this->piece);
    }

    public function pieceIsWhite(): bool
    {
        return $this->piece()->isWhite();
    }

    public function __toString()
    {
        return sprintf('%s:%s', $this->column, $this->row);
        if (!$this->piece()) {
            return str_pad('', 3, ' ');
        }

        return (string) $this->piece();
    }
}