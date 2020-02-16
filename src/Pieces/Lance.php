<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Lance's behaviour:
 *  - Can move as many as Steps as it wants.
 *  - Can move only in straight directions towards Opponent.
 *  - Cannot jump over other pieces, should capture them first.
 *  - When promoted move exactly like a Gold General.
 */
final class Lance extends BasePiece implements PieceInterface
{
    const NAME          = 'L';
    const IS_PROMOTABLE = true;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if ($target->pieceIsPromoted()) {
            // @TODO: move like a Gold General
        }

        $x = abs($source->x() - $target->x());
        $y = $source->y() - $target->y();

        if ($this->isWhite()) {
            $isMovingForward = $x === 0 && $y < 0;
        } else {
            $isMovingForward = $x === 0 && $y > 0;
        }

        if (!$isMovingForward) {
            return false;
        }

        $isBusy = $this->isPathBusy($board, $source->readableX(), $source->readableY(), $target->readableY());
        if ($isBusy) {
            return false;
        }

        return true;
    }

    public function canBePromoted(): bool
    {
        return self::IS_PROMOTABLE;
    }

    private function isPathBusy(Board $board, $x, $start, $end): bool
    {
        $spacesInBetween = range($start, $end);

        foreach ($spacesInBetween as $spaceToCheck) {
            if ($board->pieceFromSpot(sprintf('%s%s', $spaceToCheck, $x))) {
                return true;
            }
        }

        return false;
    }
}