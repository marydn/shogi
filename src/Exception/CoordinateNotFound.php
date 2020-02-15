<?php

declare(strict_types=1);

namespace Shogi\Exception;

final class CoordinateNotFound extends \OutOfRangeException
{
    protected $message = 'Coordinates are not valid';
}