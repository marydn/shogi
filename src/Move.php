<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\PiecePromotableInterface;

final class Move
{
    private Board $board;
    private Player $player;
    private Spot $source;
    private Spot $target;
    private Notation $notation;

    public function __construct(Board $board, Player $player, Spot $source, Spot $target)
    {
        $this->board  = $board;
        $this->player = $player;
        $this->source = $source;
        $this->target = $target;

        $this->make();
    }

    public function notation(): Notation
    {
        return $this->notation;
    }

    /**
     * @throws IllegalMove
     */
    private function make()
    {
        $piece = $this->source->piece();
        if (!$piece) {
            throw new IllegalMove;
        }

        $canMove = $piece->isMoveAllowed($this->board, $this->source, $this->target);
        if (!$canMove) {
            throw new IllegalMove;
        }

        if ($this->target->isTaken()) {
            $this->player->capturePiece($this->target->piece());
        }

        $this->source->removePiece();
        $this->target->fill($piece);

        if ($this->target->isPromotionArea() && $piece instanceof PiecePromotableInterface) {
            $piece->promote();
        }

        $this->notation = new Notation($this->player, $piece, $this->source, $this->target);
    }
}