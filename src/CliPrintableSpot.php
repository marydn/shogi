<?php

declare(strict_types=1);

namespace Shogi;

final class CliPrintableSpot
{
    private const SPACE_UTF8_CHAR      = "\x20";
    private const ARROW_DOWN_UTF8_CHAR = "\xE2\x86\x93";
    private const ARROW_UP_UTF8_CHAR   = "\xE2\x86\x91";

    private Spot $spot;

    public function __construct(Spot $spot)
    {
        $this->spot = $spot;
    }

    private function emptySpace(): string
    {
        return \str_pad(self::SPACE_UTF8_CHAR, 2, self::SPACE_UTF8_CHAR, \STR_PAD_BOTH);
    }

    private function formattedOutput(): string
    {
        $piece        = $this->spot->piece();
        $pieceIsWhite = $this->spot->pieceIsWhite();
        $style        = $pieceIsWhite ? 'white-piece' : 'black-piece';
        $arrow        = $pieceIsWhite ? self::ARROW_DOWN_UTF8_CHAR : self::ARROW_UP_UTF8_CHAR;

        $prefix         = sprintf('%s', self::SPACE_UTF8_CHAR);
        $suffix         = sprintf('%s%s', $arrow, self::SPACE_UTF8_CHAR);

        $decoratedPiece = sprintf('%s%s%s', $prefix, $piece, $suffix);

        return sprintf('<%s>%s</>', $style, $decoratedPiece);
    }

    public function __toString()
    {
        if ($this->spot->isTaken()) {
            return $this->formattedOutput();
        }

        return $this->emptySpace();
    }
}