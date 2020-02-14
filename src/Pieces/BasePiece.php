<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Exception\IllegalMove;
use Shogi\Spot;

abstract class BasePiece
{
    protected const WHITE_SYMBOL = '○';
    protected const BLACK_SYMBOL = '●';

    protected bool $isWhite;
    protected bool $isCaptured;
    protected bool $isPromoted;

    public function __construct(bool $isWhite)
    {
        $this->isWhite = $isWhite;
    }

    abstract public function canMove(Board $board, Spot $from, Spot $to): bool;

    final public function isWhite(): bool
    {
        return $this->isWhite;
    }

    final public function capture(): void
    {
        $this->isCaptured = true;
    }

    final public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    final public function promote(): void
    {
        $this->isPromoted = true;
    }

    final public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    private function symbol(): string
    {
        return $this->isWhite() ? self::WHITE_SYMBOL : self::BLACK_SYMBOL;
    }

    public function __toString()
    {
        return sprintf('%s %s', static::NAME, $this->symbol());
    }
}