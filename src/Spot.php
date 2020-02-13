<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

/** @TODO: Validate piece input */
final class Spot
{
    private int $column;
    private string $row;
    private ?PieceInterface $piece;

    public function __construct(int $column, string $row, ?PieceInterface $piece = null)
    {
        $this->column = $column;
        $this->row    = $row;
        $this->piece  = $piece;
    }

    public function column(): int
    {
        return $this->column;
    }

    public function row(): string
    {
        return $this->row;
    }

    public function fill(?PieceInterface $piece): void
    {
        $this->piece = $piece;
    }

    public function piece(): ?PieceInterface
    {
        return $this->piece;
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