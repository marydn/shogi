<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Notation;
use Shogi\ValueObject\NotationType;

abstract class BasePiece
{
    protected bool $isWhite = false;
    protected bool $isCaptured = false;
    protected bool $isCasted = false;

    private function __construct(bool $isWhite)
    {
        $this->isWhite = $isWhite;
    }

    public static function createWhite(): self
    {
        return new static(true);
    }

    public static function createBlack(): self
    {
        return new static(false);
    }

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
        $this->isWhite    = !$this->isWhite;

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

    public function name(): string
    {
        return static::NAME;
    }

    public function __toString()
    {
        return sprintf('%s%s%s',
            $this->isCaptured ? NotationType::capture() : '',
            static::NAME,
            $this instanceof PiecePromotableInterface && $this->isPromoted() ? NotationType::promoted() : ''
        );
    }
}