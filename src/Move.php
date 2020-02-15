<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\PieceInterface;

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
        $piece = $this->pieceToMove();

        $canMove = $piece->isMoveAllowed($this->board, $this->source, $this->target);
        if (!$canMove) {
            throw new IllegalMove;
        }

        $this->movePieceFromSourceToTarget();
    }

    private function pieceToMove(): PieceInterface
    {
        return $this->source->piece();
    }

    private function movePieceFromSourceToTarget(): self
    {
        $this->source->removePiece();
        $this->target->replacePiece($this->pieceToMove());

        $this->annotateMove();
    }

    private function annotateMove(): void
    {
        $this->notation = new Notation(
            $this->player,
            $this->pieceToMove(),
            $this->source,
            $this->target
        );
    }
}