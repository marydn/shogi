<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Knight's behaviour:
 *  - Can move in L form.
 *  - L form is restricted to 2 steps in Y and 1 step in X.
 *  - Can jump over other pieces.
 *  - When promoted move exactly like a Gold General.
 */
final class Knight extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'N';

    private bool $isPromoted = false;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if (!$this->isAvailable()) {
            return false;
        }

        if ($this->isPromoted()) {
            // @TODO: move like a Gold General
        }

        $x = abs($source->x() - $target->x());
        $y = $source->y() - $target->y();

        if ($this->isWhite()) {
            $isMovingForward = $x === 1 && $y === -2;
        } else {
            $isMovingForward = $x === 1 && $y === 2;
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