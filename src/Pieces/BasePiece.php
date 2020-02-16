<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

abstract class BasePiece
{
    const CAPTURED_SYMBOL = '*';

    protected bool $isWhite = false;
    protected bool $isCaptured = false;
    protected bool $isCasted = false;

    public function __construct(bool $isWhite)
    {
        $this->isWhite = $isWhite;
    }

    abstract public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool;

    final public function isWhite(): bool
    {
        return $this->isWhite;
    }

    final public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    final public function isCasted(): bool
    {
        return $this->isCasted;
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

    public function isAvailable(): bool
    {
        return false === $this->isCaptured() && true === $this->isCasted();
    }

    public function __toString()
    {
        return sprintf('%s%s', $this->isCaptured ? self::CAPTURED_SYMBOL : '', static::NAME);
    }
}