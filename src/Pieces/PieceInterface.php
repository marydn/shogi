<?php

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

interface PieceInterface
{
    public function isMoveAllowed(Board $board, Spot $from, Spot $to): bool;
    public function isWhite(): bool;
    public function isCaptured(): bool;
    public function isPromoted(): bool;
    public function isCasted(): bool;
    public function capture(): PieceInterface;
    public function promote(): PieceInterface;
    public function cast(): PieceInterface;
}