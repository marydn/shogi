<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;

final class Notation
{
    const SIMPLE     = '-';
    const CAPTURE    = 'x';
    const DROP       = '*';
    const PROMOTED   = '+';
    const UNPROMOTED = '=';

    private Player $player;
    private PieceInterface $piece;
    private Spot $source;
    private Spot $target;

    public function __construct(Player $player, PieceInterface $piece, Spot $source, Spot $target)
    {
        $this->player = $player;
        $this->piece  = $piece;
        $this->source = $source;
        $this->target = $target;
    }

    private function from(): string
    {
        return $this->source->readableXY().self::SIMPLE;
    }

    private function to(): string
    {
        return $this->target->readableXY();
    }

    public function __toString()
    {
        return sprintf('%s%s%s', $this->piece, $this->from(), $this->to());
    }
}