<?php

declare(strict_types=1);

namespace Shogi\Exception;

final class CoordinateNotWellFormedNotation extends \InvalidArgumentException
{
    protected $message = 'Coordinate (%s) is not a valid notation :(';

    public function __construct(string $notation)
    {
        $this->message = sprintf($this->message, $notation);

        parent::__construct($this->message);
    }
}