<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Player;

final class Pawn implements PieceInterface
{
    private Player $player;

    private function __construct(Player $player)
    {
        $this->player = $player;
    }

    public static function create(Player $player): Pawn
    {
        return new self($player);
    }

    public function isWhite(): bool
    {
        return $this->player->isWhite();
    }

    public function canMove(): bool
    {
        // TODO: Implement canMove() method.
    }

    public function isCaptured(): bool
    {
        // TODO: Implement isCaptured() method.
    }

    public function isPromoted(): bool
    {
        // TODO: Implement isPromoted() method.
    }
}