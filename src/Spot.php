<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

/** @TODO: Create a ValueObject for empty Spots */
/** @TODO: Validate piece input */
final class Spot
{
    private int $column;
    private string $row;
    private ?PieceInterface $piece;

    private function __construct(int $column, string $row, ?PieceInterface $piece)
    {
        $this->column = $column;
        $this->row    = $row;
        $this->piece  = $piece;
    }

    public static function add(int $column, string $row, ?PieceInterface $piece)
    {
        return new self($column, $row, $piece);
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
}