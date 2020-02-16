<?php

declare(strict_types=1);

namespace src\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Rook;

final class RookTest extends TestCase
{
    /** @test */
    public function it_should_create_a_rook(): void
    {
        $pawn = new Rook(false);

        $this->assertInstanceOf(Rook::class, $pawn);
    }

    /** @test */
    public function it_should_move_a_rook_straight_front(): void
    {
        $pawn = new Rook(false);

        $this->assertInstanceOf(Rook::class, $pawn);
    }

    /** @test */
    public function it_should_move_straight_one_step(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H8');

        $game->currentPlayerMove('H8xH7');

        $this->assertEquals($piece, $game->pieceFromSpot('H7'));
    }

    /** @test */
    public function it_should_move_straight_five_steps(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H8');

        $game->currentPlayerMove('H8xH3');

        $this->assertEquals($piece, $game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_not_move_to_busy_spot(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('H8xH2');
    }
}