<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Exception\IllegalMove;
use Shogi\Pieces\PieceInterface;
use Shogi\Pieces\PiecePromotableInterface;

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

            [$pieceName, $target] = explode(' ', strtolower($notation));

            $piece = $player->takeCapturedPiece($pieceName);

            $targetSpot = $this->spotFromBoard($target);

            if ($targetSpot->isTaken() || $targetSpot->isPromotionArea()) {
                throw new IllegalMove();
            }

            $targetSpot->fill($piece);
        } else {
            [$source, $target] = explode('x', strtolower($notation));

            $sourceSpot = $this->spotFromBoard($source);
            $targetSpot = $this->spotFromBoard($target);

            $piece = $sourceSpot->piece();
            if (!$piece) {
                throw new IllegalMove;
            }

            if (!$player->ownsAPiece($piece)) {
                throw new IllegalMove;
            }

            $canMove = $piece->isMoveAllowed($this->board, $sourceSpot, $targetSpot);
            if (!$canMove) {
                throw new IllegalMove;
            }

            if ($targetSpot->isTaken()) {
                $targetPiece = $targetSpot->piece();
                $player->capture($targetPiece);
            }

            $sourceSpot->removePiece();
            $targetSpot->fill($piece);

            if ($targetSpot->isPromotionArea() && $piece instanceof PiecePromotableInterface) {
                $piece->promote();
            }
        }

        $this->flipTurn();
    }
}