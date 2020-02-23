<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\CoordinateNotWellFormedNotation;
use Shogi\Exception\PieceNotFoundInInventory;
use Shogi\Pieces\Bishop;
use Shogi\Pieces\GoldGeneral;
use Shogi\Pieces\King;
use Shogi\Pieces\Knight;
use Shogi\Pieces\Lance;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\Rook;
use Shogi\Pieces\SilverGeneral;

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

    public function putPiecesOnBoard(Board $board): Player
    {
        $this->putPiece($board, $this->isWhite ? 'A1' : 'I1', Lance::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A2' : 'I2', Knight::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A3' : 'I3', SilverGeneral::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A4' : 'I4', GoldGeneral::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A5' : 'I5', King::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A6' : 'I6', GoldGeneral::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A7' : 'I7', SilverGeneral::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A8' : 'I8', Knight::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'A9' : 'I9', Lance::create($this->isWhite));

        $this->putPiece($board, $this->isWhite ? 'B2' : 'H8', Bishop::create($this->isWhite));
        $this->putPiece($board, $this->isWhite ? 'B8' : 'H2', Rook::create($this->isWhite));

        for ($i = 9; $i >= 1; $i--) {
            $this->putPiece($board, $this->isWhite ? 'C'.$i : 'G'.$i, Pawn::create($this->isWhite));
        }

        return $this;
    }

    private function putPiece(Board $board, string $target, PieceInterface $piece): void
    {
        $this->inventory->add($piece);
        $board->fillSpotAndCastPiece($target, $piece);
    }

    public function __toString()
    {
        return $this->name();
    }
}