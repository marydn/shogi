<?php

declare(strict_types=1);

namespace src\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;

final class BishopTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception_on_invalid_move(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H2xG2');
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_the_left(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H2');

        $game->currentPlayerMove('G3xF3'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H2xG3');

        $this->assertEquals($piece, $game->pieceFromSpot('G3'));
    }

    /** @test */
    public function it_should_move_diagonally_four_steps_to_the_left(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H2');

        $game->currentPlayerMove('G3xF3'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H2xD6');

        $this->assertEquals($piece, $game->pieceFromSpot('D6'));
    }
}