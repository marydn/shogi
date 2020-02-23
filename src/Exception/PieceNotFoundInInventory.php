<?php

declare(strict_types=1);

namespace Shogi\Exception;

final class PieceNotFoundInInventory extends \OutOfBoundsException
{
    protected $message = 'Piece (%s) does not exist in your inventory';

    public function __construct(string $pieceName)
    {
        $this->message = sprintf($this->message, $pieceName);

        parent::__construct($this->message);
    }
}