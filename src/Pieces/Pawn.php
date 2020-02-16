<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Pawn's behaviour:
 *  - Can move only one Step at time.
 *  - Can capture pieces in front of them.
 *  - Can move only towards Opponent's direction.
 *  - When promoted move exactly like a Gold General.
 */
final class Pawn extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'P';

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
            $isMovingForward = $x === 0 && $y === -1;
        } else {
            $isMovingForward = $x === 0 && $y === 1;
        }

        if (!$isMovingForward) {
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
}