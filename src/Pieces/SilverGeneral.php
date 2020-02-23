<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

/**
 * Silver General's behaviour:
 *  - Can move one step at time.
 *  - Can move to any direction except the straight Spot right behind them.
 *  - When promoted move exactly like a Gold General.
 */
final class SilverGeneral extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'S';

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
        $y = abs($source->y() - $target->y());

        if ($x === 0 && $y === 0) {
            return false;
        }

        if ($x > 1 || $y > 1) {
            return false;
        }

        $realY = $source->y() - $target->y();

        $isMovingBackward            = $this->isWhite() ? $realY === 1 : $realY === -1;
        $isMovingBackwardAndStraight = $isMovingBackward && $x === 0;

        if ($isMovingBackwardAndStraight) {
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

    public function demote(): PieceInterface
    {
        $this->isPromoted = false;

        return $this;
    }
}