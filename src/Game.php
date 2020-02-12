<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\Pawn;
use Shogi\Pieces\PieceInterface;

final class Game
{
    private Board $board;
    private Player $playerWhite;
    private Player $playerBlack;
    private Player $currentPlayer;
    private array $moves;

    private array $positions;

    public function __construct()
    {
        $this->board = new Board;
        $this->playerWhite = new Player;
        $this->playerBlack = new Player;
        $this->currentPlayer = $this->playerBlack;

        $this->resetBoard();
    }

    public function playerWhite(): Player
    {
        return $this->playerWhite;
    }

    public function playerBlack(): Player
    {
        return $this->playerBlack;
    }

    public function currentPlayer(): Player
    {
        return $this->currentPlayer;
    }

    public function opposingPlayer(): Player
    {
        return $this->currentPlayer() === $this->playerWhite()
            ? $this->playerBlack()
            : $this->playerWhite();
    }

    public function positions(): array
    {
        return $this->positions;
    }

    public function pieceFromSpot(string $from): ?PieceInterface
    {
        [$column, $row] = str_split($from);

        if (!$this->isPositionValid($column, $row)) {
            return null;
        }

        $spot = $this->positions[$column][$row];

        return $spot->piece();
    }

    public function currentPlayerMove($from, $to): void
    {

    }

    public function opposingPlayerMove($from, $to): void
    {

    }

    private function isPositionValid($column, $row): bool
    {
        return isset($this->positions[$column][$row]);
    }

    private function resetBoard(): void
    {
        $positions = [];
        $columns   = range(9, 1);
        $rows      = range('A', 'I');

        foreach ($columns as $column) {
            foreach ($rows as $row) {
                if ($row <= 3) {
                    $fill = Pawn::create($this->currentPlayer());
                } else if ($row > 6) {
                    $fill = Pawn::create($this->opposingPlayer());
                } else {
                    $fill = null;
                }

                $positions[$column][$row] = Spot::add($column, $row, $fill);
            }
        }

        $this->positions = $positions;
    }
}