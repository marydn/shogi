<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Rook's behaviour:
 *  - Can move as many as Steps as it wants.
 *  - Can move only in straight directions backwards and towards and left and right.
 *  - Can be promoted.
 *  - When promoted, moves like a Rook but acquires the power to move a single Step diagonally.
 */
final class Rook extends BasePiece implements PieceInterface
{
    const NAME          = 'R';
    const IS_PROMOTABLE = true;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if ($target->pieceIsPromoted()) {
            // @TODO: move like a Rook and add moves to diagonal Steps
        }

        $x = abs($source->x() - $target->x());
        $y = abs($source->y() - $target->y());

        $isMovingStraight = ($x === 0 && $y > 0) || ($x > 0 && $y === 0);
        if (!$isMovingStraight) {
            return false;
        }

        $isBusy = $this->isPathBusy($board, $source->readableXY(), $target->readableXY());
        if ($isBusy) {
            return false;
        }

        return true;
    }

    public function canBePromoted(): bool
    {
        return self::IS_PROMOTABLE;
    }

    private function isPathBusy(Board $board, $start, $end): bool
    {
        $spacesInBetween = range($start, $end);
        $isBusy          = false;

        foreach ($spacesInBetween as $spaceToCheck) {
            if ($board->pieceFromSpot($spaceToCheck)) {
                $isBusy = true;
                break;
            }
        }

        return $isBusy;
    }
}