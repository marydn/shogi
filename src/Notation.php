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
}