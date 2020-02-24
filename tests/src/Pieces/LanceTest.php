<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Lance;
use Shogi\Pieces\Pawn;

final class LanceTest extends TestCase
{
    private Game $game;
    private Lance $lance;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->lance = Lance::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->lance);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('I1', $this->lance);

        $this->assertEquals($this->lance, $this->game->pieceFromSpot('I1'));
    }

    /** @test */
    public function it_should_move_straight_one_step_forward(): void
    {
        $this->game->currentPlayerSetPiece('I1', $this->lance);

        $this->game->currentPlayerMove('I1xH1');

        $this->assertEquals($this->lance, $this->game->pieceFromSpot('H1'));
    }

    /** @test */
    public function it_should_move_straight_three_steps_forward(): void
    {
        $this->game->currentPlayerSetPiece('I1', $this->lance);

        $this->game->currentPlayerMove('I1xF1');

        $this->assertEquals($this->lance, $this->game->pieceFromSpot('F1'));
    }

    /** @test */
    public function it_should_move_straight_five_steps_forward(): void
    {
        $this->game->currentPlayerSetPiece('I1', $this->lance);

        $this->game->currentPlayerMove('I1xD1');

        $this->assertEquals($this->lance, $this->game->pieceFromSpot('D1'));
    }

    /** @test */
    public function it_should_not_move_backwards_one_step(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E1', $this->lance);

        $this->game->currentPlayerMove('E1xF1');
    }

    /** @test */
    public function it_should_not_move_backwards_three_steps(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E1', $this->lance);

        $this->game->currentPlayerMove('E1xH1');
    }

    /** @test */
    public function it_should_not_move_to_left_one_step(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E1', $this->lance);

        $this->game->currentPlayerMove('E1xE2');
    }

    /** @test */
    public function it_should_not_move_to_left_three_steps(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E1', $this->lance);

        $this->game->currentPlayerMove('E1xE4');
    }

    /** @test */
    public function it_should_not_move_to_right_one_step(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('D4', $this->lance);

        $this->game->currentPlayerMove('D4xD3');
    }

    /** @test */
    public function it_should_not_move_to_right_three_steps(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('D4', $this->lance);

        $this->game->currentPlayerMove('D4xD1');
    }

    /** @test */
    public function it_should_not_move_diagonally_one_step_to_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('D4', $this->lance);

        $this->game->currentPlayerMove('D4xE3');
    }

    /** @test */
    public function it_should_not_move_diagonally_one_step_to_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E4', $this->lance);

        $this->game->currentPlayerMove('E4xD5');
    }

    /** @test */
    public function it_should_not_jump_over_another_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E4', $this->lance);
        $this->game->currentPlayerSetPiece('E6', Pawn::createBlack());

        $this->game->currentPlayerMove('E4xE9');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E4', $this->lance);
        $this->game->currentPlayerSetPiece('E6', Pawn::createBlack());

        $this->game->currentPlayerMove('E4xE6');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece_in_the_same_column(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('F3', $this->lance);
        $this->game->opposingPlayerSetPiece('D3', $captured);

        $this->game->currentPlayerMove('F3xD3'); // this changes turns

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }
}