<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\PiecePromotableInterface;

final class Move
{
    private Notation $notation;

    /**
     * @throws IllegalMove
     */
    public function __construct(Board $board, Player $player, Spot $source, Spot $target)
    {
        $piece = $source->piece();
        if (!$piece) {
            throw new IllegalMove;
        }

        if (!$player->ownsAPiece($piece)) {
            throw new IllegalMove;
        }

        $canMove = $piece->isMoveAllowed($board, $source, $target);
        if (!$canMove) {
            throw new IllegalMove;
        }

        if ($target->isTaken()) {
            $targetPiece = $target->piece();
            $target->removePiece();
            $player->capturePiece($targetPiece);
        }

        $source->removePiece();
        $target->fill($piece);

        if ($target->isPromotionArea() && $piece instanceof PiecePromotableInterface) {
            $piece->promote();
        }

        $this->notation = new Notation($player, $piece, $source, $target);
    }

    public function __toString()
    {
        return (string) $this->notation;
    }
}