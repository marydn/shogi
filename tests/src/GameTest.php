<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shogi\Game;

final class GameTest extends TestCase
{
    /** @test */
    public function it_should_create_a_new_game(): void
    {
        $game = new Game();

        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_move_a_piece(): void
    {
        $from = 'A1';
        $to = 'B2';

        $game = new Game();

        $board = $game->board();
        $spot = $board->spot($from);
        $piece = $spot->piece();

        $currentPlayer = $game->currentPlayer();
        $currentPlayer->move($piece, $to);

        $oldSpot = $board->spot($from);
        $newSpot = $board->spot($to);

        $this->assertEquals($piece, $newSpot->piece());
        $this->assertTrue($oldSpot->isEmpty());
    }

    public function it_should_not_move_pieces_from_another_player(): void
    {

    }
}