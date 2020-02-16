<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Pawn's behaviour:
 *  - Can move only one Step at time
 *  - Can capture pieces in front of them
 *  - Can move only towards Opponent's direction
 */
final class Pawn extends BasePiece implements PieceInterface
{
    const NAME          = 'P';
    const IS_PROMOTABLE = true;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        $x = abs($source->x() - $target->x());
        $y = abs($source->y() - $target->y());

        $isMovingForward = $x === 0 && $y === 1;
        if (!$isMovingForward) {
            return false;
        }

        return true;
    }

    public function canBePromoted(): bool
    {
        return self::IS_PROMOTABLE;
    }
}