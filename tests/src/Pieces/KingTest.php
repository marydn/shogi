<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;

final class KingTest extends TestCase
{
    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I5');

        $game->currentPlayerMove('I5xH5');

        $this->assertEquals($piece, $game->pieceFromSpot('H5'));
    }

    /** @test */
    public function it_should_not_move_three_step_forward(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I5xF5');
    }

    /** @test */
    public function it_should_not_move_to_busy_spot(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I5xG5');
    }

    /** @test */
    public function it_should_move_two_valid_steps(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I5');

        $game->currentPlayerMove('G5xF5'); // move pawn to free space
        $game->currentPlayerMove('C9xD9'); // white move
        $game->currentPlayerMove('I5xH5'); // Black moves King
        $game->currentPlayerMove('D9xE9'); // white again
        $game->currentPlayerMove('H5xG5');

        $this->assertEquals($piece, $game->pieceFromSpot('G5'));
    }
}