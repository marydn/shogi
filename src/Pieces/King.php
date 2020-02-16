<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * King's behaviour:
 *  - Can move one Step at time.
 *  - Can move in any direction.
 *  - Cannot be promoted.
 */
final class King extends BasePiece implements PieceInterface
{
    const NAME = 'K';

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if (!$source->pieceIsAvailableFor($this->isWhite())) {
            return false;
        }

        $x = abs($source->x() - $target->x());
        $y = abs($source->y() - $target->y());

        if ($x === 0 && $y === 0) {
            return false;
        }

        if ($x > 1 || $y > 1) {
            return false;
        }

        return true;
    }
}