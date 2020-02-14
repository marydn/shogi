<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

final class King extends BasePiece implements PieceInterface
{
    const NAME = 'K';

    public function canMove(Board $board, Spot $from, Spot $to): bool
    {
        if ($to->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        $x = abs($from->column() - $to->column());
        $y = abs($from->row() - $to->row());
    }
}