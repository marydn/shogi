<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;
use Shogi\Players\PlayerInterface;

final class Move
{
    private PlayerInterface $player;
    private Spot $from;
    private Spot $to;
    private PieceInterface $pieceMoved;
    private ?PieceInterface $pieceTarget;

    private function __construct(PlayerInterface $player, Spot $from, Spot $to, PieceInterface $pieceMoved, ?PieceInterface $pieceTarget)
    {
        $this->player      = $player;
        $this->from        = $from;
        $this->to          = $to;
        $this->pieceMoved  = $pieceMoved;
        $this->pieceTarget = $pieceTarget;
    }

    public static function make(PlayerInterface $player, Spot $from, Spot $to, PieceInterface $pieceMoved, ?PieceInterface $pieceTarget = null): self
    {
        return new self($player, $from, $to, $pieceMoved, $pieceTarget);
    }
}