<?php

declare(strict_types=1);

namespace Shogi;

use Shogi\Players\Black;
use Shogi\Players\PlayerInterface;
use Shogi\Players\White;

final class Game
{
    private Board $board;
    private PlayerInterface $playerWhite;
    private PlayerInterface $playerBlack;
    private PlayerInterface $currentPlayer;
    private array $moves;

    public static function create()
    {
        $game = new self();
        $game->board = new Board;
        $game->playerWhite = new White;
        $game->playerBlack = new Black;
        $game->currentPlayer = $game->playerWhite;
    }
}