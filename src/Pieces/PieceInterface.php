<?php

namespace Shogi\Pieces;

use Shogi\Board;
use Shogi\Spot;

interface PieceInterface
{
    public function isMoveAllowed(Board $board, Spot $source, Spot $target): bool;
    public function isWhite(): bool;
    public function isCaptured(): bool;
    public function isCasted(): bool;
    public function isAvailableFor(bool $isWhite): bool;
    public function capture(): PieceInterface;
    public function cast(): PieceInterface;
}