<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Exception\IllegalMove;
use Shogi\Spot;

/**
 * Pawn's behaviour:
 *  - Can move only one Step at time.
 *  - Can capture pieces in front of them.
 *  - Can move only towards Opponent's direction.
 *  - When promoted move exactly like a Gold General.
 */
final class Pawn extends BasePiece implements PieceInterface, PiecePromotableInterface, PieceDroppableInterface
{
    const NAME = 'P';

    private bool $isPromoted = false;

    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool
    {
        if ($target->isTaken() && $target->pieceIsWhite() === $this->isWhite()) {
            return false;
        }

        if ($this->isPromoted()) {
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

    public function isDropAllowed(Board $board, PieceInterface $pieceToDrop, Spot $target): bool
    {
        if ($target->isTaken() || $target->isPromotionArea()) {
            return false;
        }

        $row = $target->x();
        $ys = range('A', 'I');

        foreach ($ys as $y) {
            $coordinate = sprintf('%s%s', $y, $row);

            $piece = $board->pieceFromSpot($coordinate);

            $samePlayer = $piece->isWhite() === $pieceToDrop->isWhite();
            $isPawn     = $piece instanceof Pawn;
            $isPromoted = $this instanceof PiecePromotableInterface && $this->isPromoted();

            if ($samePlayer && $isPawn && !$isPromoted) {
                return false;
            }

            // @TODO: Can give check but not checkmate
        }

        return true;
    }
}