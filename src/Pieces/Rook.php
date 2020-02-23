<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;
use Shogi\ValueObject\Coordinate;

/**
 * Rook's behaviour:
 *  - Can move as many as Steps as it wants.
 *  - Can move in any straight direction.
 *  - Can be promoted.
 *  - Cannot jump over another piece.
 *  - When promoted, moves like a Rook but acquires the power to move a single Step diagonally.
 */
final class Rook extends BasePiece implements PieceInterface, PiecePromotableInterface
{
    const NAME = 'R';

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
            // @TODO: move like a Rook and add moves to diagonal Steps
        }

        $x = abs($source->x() - $target->x());
        $y = abs($source->y() - $target->y());

        $isMovingStraight = ($x === 0 && $y > 0) || ($x > 0 && $y === 0);
        if (!$isMovingStraight) {
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
        $x = $source->x();
        $y = $source->y();

        $counter = 0;
        do {
            if ($x === $target->x()) {
                $y = $source->y() > $target->y() ? $y - 1 : $y + 1;
            }

            if ($y === $target->y()) {
                $x = $source->x() > $target->x() ? $x - 1 : $x + 1;
            }

            $readableX  = abs($x - 9);
            $readableY  = Coordinate::LETTERS[$y];
            $coordinate = sprintf('%s%s', $readableY, $readableX);

            if ($board->pieceFromSpot($coordinate)) {
                return true;
            }

            $counter++;
        } while (($x !== $target->x() || $y !== $target->y()) && $counter < 9);

        return false;
    }
}