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
        $pawn = Rook::create(false);

        $this->assertInstanceOf(Rook::class, $pawn);
    }

    /** @test */
    public function it_should_move_straight_one_step(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H2');

        $game->currentPlayerMove('H2xH3');

        $this->assertEquals($piece, $game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_move_straight_five_steps(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H2');

        $game->currentPlayerMove('H2xH7');

        $this->assertEquals($piece, $game->pieceFromSpot('H7'));
    }

    /** @test */
    public function it_should_not_move_to_a_busy_spot_of_mine(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('H2xH8');
    }

    /** @test */
    public function it_should_not_move_over_spots_filled_up_by_my_pieces(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('H2xH9');
    }

    /** @test */
    public function it_should_move_straight_up(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('H2');

        $game->currentPlayerMove('G2xF2');
        $game->currentPlayerMove('C9xD9');
        $game->currentPlayerMove('H2xG2');

        $this->assertEquals($piece, $game->pieceFromSpot('G2'));
    }

    /** @test */
    public function it_should_capture_a_piece(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('C2');

        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C2xD2'); // white
        $game->currentPlayerMove('F2xE2'); // black
        $game->currentPlayerMove('D2xE2'); // white captures pawn
        $game->currentPlayerMove('H2xE2'); // rook captures

        $this->assertContains($piece, $game->blackPlayerCaptures());
    }
}