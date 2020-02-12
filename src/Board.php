<?php

declare(strict_types=1);

namespace Shogi;

final class Board
{
    const LIMIT_X = 9;
    const LIMIT_Y = 9;

    private array $columns;
    private array $rows;

    public function __construct()
    {
        $this->columns = range(1, self::LIMIT_X);
        $this->rows    = array_slice(range('A', 'Z'), 0, self::LIMIT_X-1);
    }

    public function rows(): array
    {
        return $this->rows;
    }

    public function columns(): array
    {
        return $this->columns;
    }
}