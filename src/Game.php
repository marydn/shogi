<?php

declare(strict_types=1);

namespace Shogi;

final class Game
{
    private Board $board;
    private Player $playerWhite;
    private Player $playerBlack;
    private Player $currentPlayer;
    private array $moves;

    public static function create()
    {
        $game = new self();
        $game->board = new Board;
        $game->playerWhite = new Player;
        $game->playerBlack = new Player;
        $game->currentPlayer = $game->playerWhite;
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
}