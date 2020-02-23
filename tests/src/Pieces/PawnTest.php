<?php

declare(strict_types=1);

namespace src\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Board;
use Shogi\CoordinateTranslator;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Pawn;
use Shogi\Spot;

final class PawnTest extends TestCase
{
    /** @test */
    public function it_should_create_a_pawn(): void
    {
        $pawn = Pawn::create(false);

        $this->assertInstanceOf(Pawn::class, $pawn);
    }

    /** @test */
    public function it_should_move_only_one_step(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('G1');

        $game->currentPlayerMove('G1xF1');

        $this->assertEquals($piece, $game->pieceFromSpot('F1'));
    }

    /** @test */
    public function it_should_not_move_two_steps_for_black_pieces(): void
    {
        $board  = new Board;
        $source = new Spot(new CoordinateTranslator('G1'));
        $target = new Spot(new CoordinateTranslator('E1'));

        $pawn = Pawn::create(false);

        $this->assertFalse($pawn->isMoveAllowed($board, $source, $target));
    }

    /** @test */
    public function it_should_not_move_one_step_backwards_for_black_pieces(): void
    {
        $board  = new Board;
        $source = new Spot(new CoordinateTranslator('G1'));
        $target = new Spot(new CoordinateTranslator('H1'));

        $pawn = Pawn::create(false);

        $this->assertFalse($pawn->isMoveAllowed($board, $source, $target));
    }

    /** @test */
    public function it_should_not_move_one_step_backwards_for_white_pieces(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G1xF1');
        $game->currentPlayerMove('C1xB1');
    }

    /** @test */
    public function it_should_not_move_to_right(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xF1'); // black
    }

    /** @test */
    public function it_should_not_move_to_left(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xF3'); // black
    }

    /** @test */
    public function it_should_not_move_to_diagonal_left(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xE3'); // black
    }

    /** @test */
    public function it_should_not_move_to_diagonal_right(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xE1'); // black
    }

    /** @test */
    public function it_should_not_move_to_diagonal_left_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xE2'); // black
        $game->currentPlayerMove('D1xE1'); // White
        $game->currentPlayerMove('E2xF3'); // black
    }

    /** @test */
    public function it_should_not_move_to_diagonal_right_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->currentPlayerMove('G2xF2'); // black
        $game->currentPlayerMove('C1xD1'); // White
        $game->currentPlayerMove('F2xE2'); // black
        $game->currentPlayerMove('D1xE1'); // White
        $game->currentPlayerMove('E2xF1'); // black
    }
}