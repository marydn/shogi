<?php

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

interface PieceDroppableInterface
{
    public function isDropAllowed(Board $board, Spot $target): bool;
}