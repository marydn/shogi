<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;
use Shogi\Shared\Collection;

final class PlayerInventory extends Collection
{
    protected function getType(): string
    {
        return PieceInterface::class;
    }

    public function add(PieceInterface $piece): self
    {
        $this->items = [...$this->items(), ...[$piece]];

        return $this;
    }
}