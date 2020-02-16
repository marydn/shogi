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
final class Lance extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'L';

    private bool $isPromoted = false;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if (!$source->pieceIsAvailableFor($this->isWhite())) {
            return false;
        }

        if ($source->pieceIsPromoted()) {
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

        $isBusy = $this->isPathBusy($board, $source, $target);
        if ($isBusy) {
            return false;
        }

        return true;
    }

    public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    public function promote(): PieceInterface
    {
        $this->isPromoted = true;

        return $this;
    }

    private function isPathBusy(Board $board, Spot $source, Spot $target): bool
    {
        $spacesInBetween = range($source->readableY(), $target->readableY());

        foreach ($spacesInBetween as $spaceToCheck) {
            if ($board->pieceFromSpot(sprintf('%s%s', $spaceToCheck, $source->x()))) {
                return true;
            }
        }

        return false;
    }
}