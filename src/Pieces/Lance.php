<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

final class Lance extends BasePiece implements PieceInterface
{
    const NAME = 'L';

    public function canMove(Board $board, Spot $from, Spot $to): bool
    {
        if ($to->pieceIsWhite() === $this->isWhite()) {
            return false;
        }
    }
}