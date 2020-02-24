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

    public function __construct(bool $initialize = true)
    {
        $this->board         = new Board;
        $this->playerBlack   = new Player('Black', false);
        $this->playerWhite   = new Player('White', true);
        $this->currentPlayer = $this->playerBlack;
        $this->moves         = new MovesList();

        if ($initialize) {
            $this->setPiecesOnBoard();
        }
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

    public function pieceFromSpot(string $source): ?PieceInterface
    {
        return $this->board->pieceFromSpot($source);
    }

    public function flipTurn(): void
    {
        $this->currentPlayer = $this->opposingPlayer();
    }

    public function currentPlayerMove(string $notation): void
    {
        $this->playerMakesAMove($this->currentPlayer(), $notation);
    }

    public function currentPlayerCaptures(): PlayerInventory
    {
        return $this->currentPlayer()->captures();
    }

    public function opposingPlayerCaptures(): PlayerInventory
    {
        return $this->opposingPlayer()->captures();
    }

    public function opposingPlayerMove(string $notation): void
    {
        $this->playerMakesAMove($this->opposingPlayer(), $notation);
    }

    public function whitePlayerCaptures(): PlayerInventory
    {
        return $this->playerWhite()->captures();
    }

    public function blackPlayerCaptures(): PlayerInventory
    {
        return $this->playerBlack()->captures();
    }

    public function currentPlayerSetPiece(string $notation, PieceInterface $piece): void
    {
        $this->currentPlayer()->setPieceOnBoard($this->board, $notation, $piece);
    }

    public function opposingPlayerSetPiece(string $notation, PieceInterface $piece): void
    {
        $this->opposingPlayer()->setPieceOnBoard($this->board, $notation, $piece);
    }

    public function hasEnded(): bool
    {
        return false;
    }

    public function spotFromBoard(string $notation): Spot
    {
        return $this->board->spot($notation);
    }

    /**
     * @throws IllegalMove
     */
    private function playerMakesAMove(Player $player, string $notation): void
    {
        if (false !== stripos($notation, 'drop ')) {
            $notation = str_replace('drop ', '', $notation);

            [$pieceName, $target] = explode(' ', strtoupper($notation));

            $piece      = $player->takeCapturedPiece($pieceName);
            $targetSpot = $this->spotFromBoard($target);

            $move = Move::drop($this->board, $player, $piece, $targetSpot);
        } else {
            [$source, $target] = explode('x', strtolower($notation));

            $sourceSpot = $this->spotFromBoard($source);
            $targetSpot = $this->spotFromBoard($target);

            $move = Move::make($this->board, $player, $sourceSpot, $targetSpot);
        }

        $this->moves->add($move);

        $this->flipTurn();
    }

    private function setPiecesOnBoard()
    {
        $this->playerWhite->setPieceOnBoard($this->board, 'A1', Lance::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A2', Knight::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A3', SilverGeneral::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A4', GoldGeneral::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A5', King::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A6', GoldGeneral::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A7', SilverGeneral::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A8', Knight::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'A9', Lance::createWhite());

        $this->playerWhite->setPieceOnBoard($this->board, 'B2', Bishop::createWhite());
        $this->playerWhite->setPieceOnBoard($this->board, 'B8', Rook::createWhite());

        for ($i = 9; $i >= 1; $i--) {
            $this->playerWhite->setPieceOnBoard($this->board, 'C'.$i, Pawn::createWhite());

            $this->playerBlack->setPieceOnBoard($this->board, 'G'.$i, Pawn::createBlack());
        }

        $this->playerBlack->setPieceOnBoard($this->board, 'H2', Rook::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'H8', Bishop::createBlack());

        $this->playerBlack->setPieceOnBoard($this->board, 'I1', Lance::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I2', Knight::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I3', SilverGeneral::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I4', GoldGeneral::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I5', King::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I6', GoldGeneral::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I7', SilverGeneral::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I8', Knight::createBlack());
        $this->playerBlack->setPieceOnBoard($this->board, 'I9', Lance::createBlack());
    }
}