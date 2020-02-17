<?php

declare(strict_types=1);

namespace Shogi;

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

        $this->initializeInventory();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isWhite(): bool
    {
        return $this->isWhite;
    }

    public function capturePiece(PieceInterface $piece)
    {
        $this->capturedPieces->add($piece);
    }

    public function captures(): PlayerInventory
    {
        return $this->capturedPieces;
    }

    public function ownsAPiece(PieceInterface $piece)
    {
        return $this->inventory->contains($piece);
    }

    public function putPiecesOnBoard(Board $board): Player
    {
        foreach ($this->inventory as $piece) {
            if ($piece->isCasted()) {
                continue;
            }

            if ($piece instanceof King) {
                $board->fillSpotAndCastPiece($this->isWhite ? 'A5' : 'I5', $piece);
            }

            if ($piece instanceof Lance) {
                $target = $this->isWhite ? 'A9' : 'I9';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }

                $target = $this->isWhite ? 'A1' : 'I1';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }
            }

            if ($piece instanceof Knight) {
                $target = $this->isWhite ? 'A8' : 'I8';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }

                $target = $this->isWhite ? 'A2' : 'I2';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }
            }

            if ($piece instanceof SilverGeneral) {
                $target = $this->isWhite ? 'A7' : 'I7';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }

                $target = $this->isWhite ? 'A3' : 'I3';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }
            }

            if ($piece instanceof GoldGeneral) {
                $target = $this->isWhite ? 'A6' : 'I6';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }

                $target = $this->isWhite ? 'A4' : 'I4';
                if (!$board->spotContainsPiece($target, $piece)) {
                    $board->fillSpotAndCastPiece($target, $piece);
                }
            }

            if ($piece instanceof Bishop) {
                $target = $this->isWhite ? 'B2' : 'H8';
                $board->fillSpotAndCastPiece($target, $piece);
            }

            if ($piece instanceof Rook) {
                $target = $this->isWhite ? 'B8' : 'H2';
                $board->fillSpotAndCastPiece($target, $piece);
            }

            if ($piece instanceof Pawn) {
                for($i = 9; $i >= 1; $i--) {
                    $target = $this->isWhite ? 'C'.$i : 'G'.$i;
                    if (!$board->spotContainsPiece($target, $piece)) {
                        $board->fillSpotAndCastPiece($target, $piece);
                    }
                }
            }
        }

        return $this;
    }

    private function initializeInventory(): void
    {
        $bigPieces = [
            new King($this->isWhite),
            new Lance($this->isWhite),
            new Lance($this->isWhite),
            new Knight($this->isWhite),
            new Knight($this->isWhite),
            new SilverGeneral($this->isWhite),
            new SilverGeneral($this->isWhite),
            new GoldGeneral($this->isWhite),
            new GoldGeneral($this->isWhite),

            new Bishop($this->isWhite),
            new Rook($this->isWhite),
        ];

        $pawns = array_fill(0, 9, new Pawn($this->isWhite));

        $this->inventory = new PlayerInventory([...$bigPieces, ...$pawns]);
    }

    public function __toString()
    {
        return $this->name();
    }
}