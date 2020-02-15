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

    public function removePiece(): void
    {
        $this->piece = null;
    }

    public function replacePiece(?PieceInterface $piece): void
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

    private function readableCoordinateX(): string
    {
        return $this->coordinate->readableCoordinate->x();
    }

    private function readableCoordinateY(): int
    {
        return $this->coordinate->readableCoordinate->y();
    }

    public function __toString()
    {
        return sprintf('%s:%s - %s', $this->readableCoordinateX(), $this->readableCoordinateY(), $this->piece());
    }
}