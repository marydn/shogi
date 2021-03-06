<?php

declare(strict_types=1);

namespace Shogi\Exception;

final class CoordinateNotFound extends \OutOfRangeException
{
    protected $message = 'Coordinate (%s) does not exist in this board!';

    public function __construct(string $notation)
    {
        $this->message = sprintf($this->message, $notation);

        parent::__construct($this->message);
    }
}