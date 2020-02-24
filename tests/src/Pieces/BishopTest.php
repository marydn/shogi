<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

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
        $game->currentPlayerMove('G8xF8'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H8xG8');
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_the_left_for_black(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H8');

        $game->currentPlayerMove('G9xF9'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H8xG9');

        $this->assertEquals($piece, $game->pieceFromSpot('G9'));
    }

    /** @test */
    public function it_should_move_diagonally_four_steps_to_the_right_for_black(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H8');

        $game->currentPlayerMove('G7xF7'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H8xD4');

        $this->assertEquals($piece, $game->pieceFromSpot('D4'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_the_left_for_white(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('B2');

        $game->currentPlayerMove('G1xF1'); // black
        $game->currentPlayerMove('C1xD1'); // white
        $game->currentPlayerMove('F1xE1'); // black

        $game->currentPlayerMove('B2xC1');

        $this->assertEquals($piece, $game->pieceFromSpot('C1'));
    }

    /** @test */
    public function it_should_move_diagonally_four_steps_to_the_left_for_white(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('B2');

        $game->currentPlayerMove('G1xF1'); // black
        $game->currentPlayerMove('C3xD3'); // white
        $game->currentPlayerMove('F1xE1'); // black
        $game->currentPlayerMove('B2xF6');

        $this->assertEquals($piece, $game->pieceFromSpot('F6'));
    }

    /** @test */
    public function it_should_move_diagonally_right_up_and_then_right_down_for_black(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H8');

        $game->currentPlayerMove('G7xF7'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('H8xD4'); // black - Bishop up right
        $game->currentPlayerMove('D9xE9'); // white
        $game->currentPlayerMove('D4xF2'); // black - Bishop down right

        $this->assertEquals($piece, $game->pieceFromSpot('F2'));
    }

    /** @test */
    public function it_should_capture_a_piece(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('C3');

        $game->currentPlayerMove('G7xF7');
        $game->currentPlayerMove('C1xD1');
        $game->currentPlayerMove('H8xC3');

        $this->assertContains($piece, $game->blackPlayerCaptures());
    }
}