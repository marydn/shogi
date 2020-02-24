<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;

final class GoldGeneralTest extends TestCase
{
    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I4');

        $game->currentPlayerMove('I4xH4');

        $this->assertEquals($piece, $game->pieceFromSpot('H4'));
    }

    /** @test */
    public function it_should_move_one_step_diagonal_left(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I4');

        $game->currentPlayerMove('I4xH5');

        $this->assertEquals($piece, $game->pieceFromSpot('H5'));
    }

    /** @test */
    public function it_should_move_one_step_diagonal_right(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I4');

        $game->currentPlayerMove('I4xH3');

        $this->assertEquals($piece, $game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_move_one_step_straight_behind(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I4');

        $game->currentPlayerMove('I4xH4');
        $game->currentPlayerMove('C9xD9');
        $game->currentPlayerMove('H4xI4');

        $this->assertEquals($piece, $game->pieceFromSpot('I4'));
    }

    /** @test */
    public function it_should_not_move_diagonally_to_left_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I4xH3');
        $game->currentPlayerMove('C9xD9');
        $game->currentPlayerMove('H3xI4');
    }

    /** @test */
    public function it_should_not_move_diagonally_to_right_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I4xH5');
        $game->currentPlayerMove('C9xD9');
        $game->currentPlayerMove('H5xI4');
    }
}