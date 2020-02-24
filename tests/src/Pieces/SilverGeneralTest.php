<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;

final class SilverGeneralTest extends TestCase
{
    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I3');

        $game->currentPlayerMove('I3xH3');

        $this->assertEquals($piece, $game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_move_one_step_diagonal_left(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I3');

        $game->currentPlayerMove('I3xH4');

        $this->assertEquals($piece, $game->pieceFromSpot('H4'));
    }

    /** @test */
    public function it_should_not_move_one_step_diagonal_right(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I3xH2');
    }

    /** @test */
    public function it_should_not_move_one_step_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('I3xH3');
        $game->currentPlayerMove('C9xD9');
        $game->currentPlayerMove('H3xI3');
    }
}