<?php

declare(strict_types=1);

namespace Shogi\Exception;

final class IllegalMove extends \OutOfBoundsException
{
    protected $message = 'Illegal move';
}