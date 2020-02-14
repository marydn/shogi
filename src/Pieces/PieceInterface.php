<?php

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

interface PieceInterface
{
    public function canMove(Board $board, Spot $from, Spot $to): bool;
    public function isWhite(): bool;
    public function isCaptured(): bool;
    public function isPromoted(): bool;
    public function capture(): void;
    public function promote(): void;
}