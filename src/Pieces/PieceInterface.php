<?php

namespace Shogi\Pieces;

interface PieceInterface
{
    public function canMove(): bool;
    public function isWhite(): bool;
    public function isCaptured(): bool;
    public function isPromoted(): bool;
}