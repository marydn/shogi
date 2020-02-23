<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\PieceDroppableInterface;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\PiecePromotableInterface;

final class Move
{
    private Notation $notation;

    private function __construct(Notation $notation)
    {
        $this->notation = $notation;
    }

    public function notation(): Notation
    {
        return $this->notation;
    }

    /**
     * @throws IllegalMove
     */
    public static function drop(Board $board, Player $player, PieceInterface $piece, Spot $target): self
    {
        if (!$piece instanceof PieceDroppableInterface) {
            throw new IllegalMove('You cannot drop this piece');
        }

        $canDrop = $piece->isDropAllowed($board, $piece, $target);
        if (!$canDrop) {
            throw new IllegalMove('Drop is not allowed');
        }

        $target->fill($piece);

        return new self(Notation::annotateDrop($player, $piece, $target));
    }

    /**
     * @throws IllegalMove
     */
    public static function make(Board $board, Player $player, Spot $source, Spot $target): self
    {
        $piece = $source->piece();
        if (!$piece) {
            throw new IllegalMove('There is not piece to move');
        }

        if (!$player->ownsAPiece($piece)) {
            throw new IllegalMove('This piece is not yours');
        }

        $canMove = $piece->isMoveAllowed($board, $source, $target);
        if (!$canMove) {
            throw new IllegalMove('Move is not allowed');
        }

        if ($target->isTaken()) {
            $targetPiece = $target->piece();
            $player->capture($targetPiece);
        }

        $source->removePiece();
        $target->fill($piece);

        if ($target->isPromotionArea() && $piece instanceof PiecePromotableInterface) {
            $piece->promote();
        }

        return new self(Notation::annotateSimple($player, $piece, $source, $target));
    }
}