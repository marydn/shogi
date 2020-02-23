<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use phpDocumentor\Reflection\DocBlock\Tags\Var_;
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

    public function demote(): PieceInterface
    {
        $this->isPromoted = false;

        return $this;
    }

    private function isPathBusy(Board $board, Spot $source, Spot $target): bool
    {
        $spacesInBetween = range($source->readableY(), $target->readableY());

        foreach ($spacesInBetween as $spaceToCheck) {
            $coordinate = sprintf('%s%s', $spaceToCheck, $source->readableX());

            if ($coordinate === $source->readableXY()) {
                continue;
            }

            if ($board->pieceFromSpot($coordinate)) {
                return true;
            }
        }

        return false;
    }
}