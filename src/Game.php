<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\Bishop;
use Shogi\Pieces\GoldGeneral;
use Shogi\Pieces\King;
use Shogi\Pieces\Knight;
use Shogi\Pieces\Lance;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\Rook;
use Shogi\Pieces\SilverGeneral;

final class Game
{
    private Board $board;
    private Player $playerWhite;
    private Player $playerBlack;
    private Player $currentPlayer;
    private MovesList $moves;

    public function __construct()
    {
        $this->board         = new Board;
        $this->playerBlack   = new Player('Black');
        $this->playerWhite   = new Player('White', true);
        $this->currentPlayer = $this->playerBlack;
        $this->moves         = new MovesList();

        $this->playerWhite->putPiecesOnBoard($this->board);
        $this->playerBlack->putPiecesOnBoard($this->board);
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

    public function moves(): MovesList
    {
        return $this->moves;
    }

    public function positions(): array
    {
        return $this->board->positions();
    }

    public function pieceFromSpot(string $from): ?PieceInterface
    {
        $spot = $this->board->spot($from);

        return $spot->piece();
    }

    public function flipTurn(): void
    {
        $this->currentPlayer = $this->opposingPlayer();
    }

    public function currentPlayerMove(string $notation): void
    {
        $this->playerMakesAMove($this->currentPlayer(), $notation);
    }

    public function opposingPlayerMove(string $notation): void
    {
        $this->playerMakesAMove($this->opposingPlayer(), $notation);
    }

    public function hasEnded(): bool
    {
        return false;
    }

    /**
     * @throws IllegalMove
     */
    private function playerMakesAMove(Player $player, string $notation): void
    {
        [$source, $target] = explode('x', strtolower($notation));

        $sourceSpot = $this->board->spot($source);
        $targetSpot = $this->board->spot($target);

        $this->moves->add(
            new Move($this->board, $player, $sourceSpot, $targetSpot)
        );

        $this->flipTurn();
    }
}