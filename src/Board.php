<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\PieceInterface;
use Shogi\ValueObject\Coordinate;

final class Board
{
    private array $positions;

    public function __construct()
    {
        $this->resetBoard();
    }

    public function positions(): array
    {
        return $this->positions;
    }

    public function spot(string $target): Spot
    {
        $translated = $this->translateInput($target);

        $x = $translated->x();
        $y = $translated->y();

        return $this->positions[$y][$x];
    }

    public function pieceFromSpot(string $source): ?PieceInterface
    {
        $spot = $this->spot($source);

        return $spot->piece();
    }

    public function fillSpotAndCastPiece(string $target, PieceInterface $piece): self
    {
        if (!$this->spotContainsPiece($target, $piece) && !$this->spotIsTaken($target)) {
            $spot = $this->spot($target);
            $spot->fillAndCastPiece($piece);
        }

        return $this;
    }

    public function spotContainsPiece(string $target, PieceInterface $piece): bool
    {
        $spot = $this->spot($target);
        if (!$spot->piece()) {
            return false;
        }

        return \spl_object_hash($spot->piece()) === \spl_object_hash($piece);
    }

    private function spotIsTaken(string $target): bool
    {
        return $this->spot($target)->isTaken();
    }

    private function translateInput(string $input): CoordinateTranslator
    {
        return new CoordinateTranslator($input);
    }

    private function resetBoard(): void
    {
        $rows    = Coordinate::LETTERS;
        $columns = range(count($rows), 1);

        foreach ($rows as $row) {
            foreach ($columns as $column) {
                $this->createEmptySpot($column, $row);
            }
        }
    }

    private function createEmptySpot($column, $row): void
    {
        $coordinate = sprintf('%s%s', $row,$column);
        $coordinate = new CoordinateTranslator($coordinate);
        $internalX  = $coordinate->x();
        $internalY  = $coordinate->y();

        $emptySpot = new Spot($coordinate);

        $this->positions[$internalY][$internalX] = $emptySpot;
    }
}