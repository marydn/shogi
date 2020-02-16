<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

abstract class BasePiece
{
    protected bool $isWhite = false;
    protected bool $isCaptured = false;
    protected bool $isPromoted = false;
    protected bool $isCasted = false;

    public function __construct(bool $isWhite)
    {
        $this->isWhite = $isWhite;
    }

    abstract public function isMoveAllowed(Board $board, Spot $from, Spot $to): bool;

    abstract public function canBePromoted(): bool;

    final public function isWhite(): bool
    {
        return $this->isWhite;
    }

    final public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    final public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    final public function isCasted(): bool
    {
        return $this->isCasted;
    }

    final public function promote(): PieceInterface
    {
        $this->isPromoted = true;

        return $this;
    }

    final public function capture(): PieceInterface
    {
        $this->isCaptured = true;

        return $this;
    }

    final public function cast(): PieceInterface
    {
        $this->isCasted = true;

        return $this;
    }

    public function __toString()
    {
        return static::NAME;
    }
}