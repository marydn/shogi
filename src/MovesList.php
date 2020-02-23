<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Shared\Collection;

final class MovesList extends Collection
{
    protected function getType(): string
    {
        return Move::class;
    }

    public function add(Move $move): self
    {
        $this->items = [...$this->items(), ...[$move]];

        return $this;
    }
}