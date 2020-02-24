<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\CoordinateNotWellFormedNotation;
use Shogi\Exception\PieceNotFoundInInventory;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\PiecePromotableInterface;

final class Player
{
    private string $name;
    private bool $isWhite;
    private PlayerInventory $inventory;
    private PlayerInventory $capturedPieces;

    public function __construct(string $name, bool $isWhite = false)
    {
        $this->name           = $name;
        $this->isWhite        = $isWhite;
        $this->capturedPieces = new PlayerInventory();
        $this->inventory      = new PlayerInventory();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isWhite(): bool
    {
        return $this->isWhite;
    }

    public function capture(PieceInterface $piece)
    {
        $piece->capture();

        if ($piece instanceof PiecePromotableInterface && $piece->isPromoted()) {
            $piece->demote();
        }

        $this->capturedPieces->add($piece);
    }

    public function captures(): PlayerInventory
    {
        return $this->capturedPieces;
    }

    public function inventory(): PlayerInventory
    {
        return $this->inventory;
    }

    public function ownsAPiece(PieceInterface $piece): bool
    {
        return $this->inventory->contains($piece) || $this->capturedPieces->contains($piece);
    }

    /**
     * @throws PieceNotFoundInInventory
     */
    public function takeCapturedPiece(string $name): PieceInterface
    {
        if (strlen($name) > 1) {
            throw new CoordinateNotWellFormedNotation($name);
        }

        foreach ($this->capturedPieces as $capturedPiece) {
            if ($capturedPiece->name() === $name) {
                return $capturedPiece;
            }
        }

        throw new PieceNotFoundInInventory($name);
    }

    public function setPieceOnBoard(Board $board, string $target, PieceInterface $piece): void
    {
        $this->inventory->add($piece);
        $board->fillSpotAndCastPiece($target, $piece);
    }

    public function __toString()
    {
        return $this->name();
    }
}