<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Gold General's behaviour:
 *  - Can move one step at time.
 *  - Can move to any direction except left and right diagonal Steps behind.
 */
final class GoldGeneral extends BasePiece implements PieceInterface
{
    const NAME = 'G';

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
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

        $realY = $source->y() - $target->y();

        $isMovingBackward           = $this->isWhite() ? $realY === 1 : $realY === -1;
        $isMovingBackwardDiagonally = $isMovingBackward && $x === 1;

        if ($isMovingBackwardDiagonally) {
            return false;
        }

        return true;
    }
}