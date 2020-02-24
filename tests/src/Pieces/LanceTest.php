<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Game;

final class LanceTest extends TestCase
{
    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('I1');

        $game->currentPlayerMove('I1xH1');

        $this->assertEquals($piece, $game->pieceFromSpot('H1'));
    }
}