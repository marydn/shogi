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
        return $this->isWhite || (false === $this->isWhite && true === $this->isCaptured);
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

    public function isAvailableFor(bool $isWhite): bool
    {
        if (!$this->isCasted()) {
            return false;
        }

        if ($this->isWhite() === $isWhite) {
            return false === $this->isCaptured();
        }

        return true === $this->isCaptured();
    }

    public function __toString()
    {
        return sprintf('%s%s', $this->isCaptured ? self::CAPTURED_SYMBOL : '', static::NAME);
    }
}