<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

final class Pawn extends BasePiece implements PieceInterface
{
    const NAME = 'P';

    public function canMove(Board $board, Spot $from, Spot $to): bool
    {
        if ($to->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        $x = abs($from->column() - $to->column());
        $y = abs($from->row() - $to->row());

        $isMovingForward = $x === 0 && $y === 1;
        if ($isMovingForward) {
            return true;
        }

        return false;
    }
}