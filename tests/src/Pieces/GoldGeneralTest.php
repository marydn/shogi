<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\GoldGeneral;
use Shogi\Pieces\Pawn;

final class GoldGeneralTest extends TestCase
{
    private Game $game;
    private GoldGeneral $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = GoldGeneral::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('I6', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I6'));
    }

    /** @test */
    public function it_should_move_one_step_straight_upfront(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xE4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('E4'));
    }

    /** @test */
    public function it_should_move_one_step_diagonally_to_the_to_right(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xE3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('E3'));
    }

    /** @test */
    public function it_should_move_one_step_diagonally_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xE5');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('E5'));
    }

    /** @test */
    public function it_should_move_one_step_to_right(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xF3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('F3'));
    }

    /** @test */
    public function it_should_move_one_step_to_left(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xF5');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('F5'));
    }

    /** @test */
    public function it_should_move_one_step_to_behind(): void
    {
        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xG4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G4'));
    }

    /** @test */
    public function it_should_not_move_one_step_behind_to_the_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xG5');
    }

    /** @test */
    public function it_should_not_move_one_step_behind_to_the_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('F4xG3');
    }

    /** @test */
    public function it_should_not_move_three_steps_straight_upfront(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F4', $this->piece);

        $this->game->currentPlayerMove('E4xC4');
    }

    /** @test */
    public function it_should_not_move_three_steps_straight_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E4', $this->piece);

        $this->game->currentPlayerMove('E4xH4');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I4', $this->piece);
        $this->game->currentPlayerSetPiece('H4', Pawn::createBlack());

        $this->game->currentPlayerMove('I4xH4');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('I4', $this->piece);
        $this->game->currentPlayerSetPiece('H4', $captured);

        $this->game->currentPlayerMove('I4xH4');

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }
}