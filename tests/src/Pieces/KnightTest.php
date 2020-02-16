<?php

declare(strict_types=1);

namespace src\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Game;

final class KnightTest extends TestCase
{
    /** @test */
    public function it_should_move_in_L(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I2');

        $game->currentPlayerMove('G3xF3'); // black
        $game->currentPlayerMove('C9xD9'); // white
        $game->currentPlayerMove('I2xG3');

        $this->assertEquals($piece, $game->pieceFromSpot('G3'));
    }
}