<?php

namespace Shogi\Pieces;

interface PiecePromotableInterface
{
    public function isPromoted(): bool;
    public function promote(): PieceInterface;
    public function demote(): PieceInterface;
    public function promoteTo(): PieceInterface;
}