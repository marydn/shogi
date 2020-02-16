<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

final class Spot
{
    private CoordinateTranslator $coordinate;
    private ?PieceInterface $piece;

    public function __construct(CoordinateTranslator $coordinate, ?PieceInterface $piece = null)
    {
        $this->coordinate = $coordinate;
        $this->piece      = $piece;
    }

    public function coordinate(): CoordinateTranslator
    {
        return $this->coordinate;
    }

    public function removePiece(): self
    {
        $this->piece = null;

        return $this;
    }

    public function fill(PieceInterface $piece): self
    {
        $this->piece = $piece;

        return $this;
    }

    public function fillAndCastPiece(PieceInterface $piece): self
    {
        $piece->cast();
        $this->fill($piece);

        return $this;
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
        return $this->piece() ? $this->piece()->isWhite() : false;
    }

    public function x()
    {
        return $this->coordinate->x();
    }

    public function y()
    {
        return $this->coordinate->y();
    }

    public function __toString()
    {
        return (string) $this->piece();
    }
}