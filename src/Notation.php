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

    const KING           = 'K';
    const ROOK           = 'R';
    const BISHOP         = 'B';
    const GOLD_GENERAL   = 'G';
    const SILVER_GENERAL = 'S';
    const KNIGHT         = 'N';
    const LANCE          = 'L';
    const PAWN           = 'P';

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
}