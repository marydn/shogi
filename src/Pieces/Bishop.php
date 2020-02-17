<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;
use Shogi\ValueObject\Coordinate;

/**
 * Bishop's behaviour:
 *  - Can move as many as Steps as it wants.
 *  - Can move diagonally in any direction.
 *  - Cannot jump over another piece.
 *  - When promoted, moves like a Bishop but acquires the power to move a single square orthogonally.
 */
final class Bishop extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'B';

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
            // @TODO: move like a Bishop but acquires the power to move a single square orthogonally
        }

        $x = abs($source->x() - $target->x());
        $y = abs($source->y() - $target->y());

        $targetIsValid = $x === $y;
        if (!$targetIsValid) {
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
        $x = $source->y();
        $y = $source->y();

        $counter = 0;
        while ($x !== $target->x() && $y !== $target->y() && $counter < 9) {
            $x = $source->x() > $target->x() ? $x - 1 : $x + 1;
            $y = $source->y() > $target->y() ? $y - 1 : $y + 1;

            $readableX = $x + 1;
            $readableY = Coordinate::LETTERS[$y];

            if ($board->pieceFromSpot(sprintf('%s%s', $readableY, $readableX))) {
                return true;
            }

            $counter++;
        }

        return false;
    }
}