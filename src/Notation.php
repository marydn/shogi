<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;
use Shogi\ValueObject\NotationType;

final class Notation
{
    private Player $player;
    private PieceInterface $piece;
    private ?Spot $source;
    private Spot $target;
    private NotationType $type;

    private function __construct(Player $player, NotationType $type, PieceInterface $piece, ?Spot $source, Spot $target)
    {
        $this->player = $player;
        $this->type   = $type;
        $this->piece  = $piece;
        $this->source = $source;
        $this->target = $target;
    }

    public static function annotateCapture(Player $player, PieceInterface $piece, Spot $source, Spot $target)
    {
        return new self($player, NotationType::capture(), $piece, $source, $target);
    }

    public static function annotateSimple(Player $player, PieceInterface $piece, Spot $source, Spot $target)
    {
        return new self($player, NotationType::simple(), $piece, $source, $target);
    }

    public static function annotatePromoted(Player $player, PieceInterface $piece, Spot $source, Spot $target)
    {
        return new self($player, NotationType::promoted(), $piece, $source, $target);
    }

    public static function annotateDrop(Player $player, PieceInterface $piece, Spot $target)
    {
        return new self($player, NotationType::drop(), $piece, null, $target);
    }

    private function from(): string
    {
        return $this->source->readableXY();
    }

    private function to(): string
    {
        return $this->target->readableXY();
    }

    public function __toString()
    {
        return sprintf('%s%s%s', $this->piece, $this->from(), $this->to());
    }
}