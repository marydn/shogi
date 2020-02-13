<?php

declare(strict_types=1);

namespace Shogi\Pieces;

use Shogi\Player;

abstract class BasePiece
{
    private Player $player;
    protected bool $isCaptured;
    protected bool $isPromoted;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    abstract public function canMove(): bool;

    final public function isWhite(): bool
    {
        return $this->player->isWhite();
    }

    final public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    final public function isPromoted(): bool
    {
        return $this->isPromoted;
    }

    public function __toString()
    {
        return static::NAME . sprintf(' %s', $this->isWhite() ? '○' : '●');
    }
}