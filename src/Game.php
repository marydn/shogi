<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Pieces\Bishop;
use Shogi\Pieces\GoldGeneral;
use Shogi\Pieces\King;
use Shogi\Pieces\Knight;
use Shogi\Pieces\Lance;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\Rook;
use Shogi\Pieces\SilverGeneral;
use Shogi\ValueObject\EmptySpace;

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
        $this->playerBlack = new Player('Black');
        $this->playerWhite = new Player('White', true);
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

    public function currentPlayerMove(string $notation): void
    {
        $notation = strtolower($notation);
        [$from, $to] = explode('x', $notation);

        [$fromX, $fromY] = str_split($from);
        [$toX, $toY] = str_split($to);

        $letters = range('a', 'i');

        $fromX = array_search($fromX, $letters);
        $toX = array_search($toX, $letters);

        $this->positions[$toX][$toY-1] = $this->positions[$fromX][$fromY-1];
        $this->positions[$fromX][$fromY-1] = null;

        $this->currentPlayer = $this->opposingPlayer();
    }

    public function opposingPlayerMove(string $notation): void
    {
    }

    private function isNotationValid(string $notation): bool
    {
        [$from, $to] = explode('x', $notation);
    }


    public function isEnded(): bool
    {
        return false;
    }

    private function isPositionValid($column, $row): bool
    {
        return isset($this->positions[$column][$row]);
    }

    private function resetBoard(): void
    {
        $positions = array_fill(0, 9, array_fill(0, 9, null));

        $currentPlayer = $this->currentPlayer();
        $opposingPlayer = $this->opposingPlayer();

        $l1O = new Lance($opposingPlayer->isWhite());
        $k1O = new Knight($opposingPlayer->isWhite());
        $s1O = new SilverGeneral($opposingPlayer->isWhite());
        $g1O = new GoldGeneral($opposingPlayer->isWhite());
        $kO = new King($opposingPlayer->isWhite());
        $g2O = new GoldGeneral($opposingPlayer->isWhite());
        $s2O = new SilverGeneral($opposingPlayer->isWhite());
        $k2O = new Knight($opposingPlayer->isWhite());
        $l2O = new Lance($opposingPlayer->isWhite());
        $bO = new Bishop($opposingPlayer->isWhite());
        $rO = new Rook($opposingPlayer->isWhite());

        $l1C = new Lance($currentPlayer->isWhite());
        $k1C = new Knight($currentPlayer->isWhite());
        $s1C = new SilverGeneral($currentPlayer->isWhite());
        $g1C = new GoldGeneral($currentPlayer->isWhite());
        $kC = new King($currentPlayer->isWhite());
        $g2C = new GoldGeneral($currentPlayer->isWhite());
        $s2C = new SilverGeneral($currentPlayer->isWhite());
        $k2C = new Knight($currentPlayer->isWhite());
        $l2C = new Lance($currentPlayer->isWhite());
        $bC = new Bishop($currentPlayer->isWhite());
        $rC = new Rook($currentPlayer->isWhite());

        $positions[0] = [$l1O, $k1O, $s1O, $g1O, $kO, $g2O, $s2O, $k2O, $l2O];
        $positions[1][1] = $bO;
        $positions[1][7] = $rO;

        for($i = 0; $i < 9; $i++) {
            $positions[2][$i] = new Pawn($opposingPlayer->isWhite());
            $positions[3][$i] = null;
            $positions[4][$i] = null;
            $positions[5][$i] = null;
            $positions[6][$i] = new Pawn($opposingPlayer->isWhite());
        }

        $positions[7] = [null, $bC, null, null, null, null, null, $rC, null];
        $positions[8] = [$l1C, $k1C, $s1C, $g1C, $kC, $g2C, $s2C, $k2C, $l2C];

        $this->positions = $positions;
    }
}