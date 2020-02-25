<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;

final class PawnTest extends TestCase
{
    private Game $game;
    private Pawn $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = Pawn::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_create_a_pawn(): void
    {
        $pawn = Pawn::createBlack();

        $this->assertInstanceOf(Pawn::class, $pawn);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('G1', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G1'));
    }

    /** @test */
    public function it_should_move_only_one_step(): void
    {
        $this->game->currentPlayerSetPiece('G1', $this->piece);

        $this->game->currentPlayerMove('G1xF1');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('F1'));
    }

    /** @test */
    public function it_should_not_move_two_steps_forward_for_black_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G1', $this->piece);

        $this->game->currentPlayerMove('G1xE1');
    }

    /** @test */
    public function it_should_not_move_one_step_backward_for_black_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G1', $this->piece);

        $this->game->currentPlayerMove('G1xH1');
    }

    /** @test */
    public function it_should_not_move_one_step_backward_for_white_pieces(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G1', $this->piece);
        $this->game->opposingPlayerSetPiece('C1', Pawn::createWhite());

        $this->game->currentPlayerMove('G1xF1');
        $this->game->currentPlayerMove('C1xB1');
    }

    /** @test */
    public function it_should_not_move_to_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xG1');
    }

    /** @test */
    public function it_should_not_move_to_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xG3');
    }

    /** @test */
    public function it_should_not_move_to_diagonal_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xF3');
    }

    /** @test */
    public function it_should_not_move_to_diagonal_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xF1');
    }

    /** @test */
    public function it_should_not_move_backward_to_diagonal_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xH3');
    }

    /** @test */
    public function it_should_not_move_backward_to_diagonal_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);

        $this->game->currentPlayerMove('G2xH1');
    }

    /** @test */
    public function it_should_not_jump_over_another_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('G2', $this->piece);
        $this->game->currentPlayerSetPiece('G3', Pawn::createBlack());

        $this->game->currentPlayerMove('G2xG3');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F4', $this->piece);
        $this->game->currentPlayerSetPiece('E4', Pawn::createBlack());

        $this->game->currentPlayerMove('F4xE4');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('F4', $this->piece);
        $this->game->currentPlayerSetPiece('E4', $captured);

        $this->game->currentPlayerMove('F4xE4');

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }

    /** @test */
    public function it_should_drop_a_pawn(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('F4', $this->piece);
        $this->game->currentPlayerSetPiece('E4', $captured);

        $this->game->currentPlayerMove('F4xE4'); // black captures and flip turns
        $this->game->opposingPlayerMove('drop p E9'); // black drops

        $this->assertEquals($captured, $this->game->pieceFromSpot('E9'));
    }

    /** @test */
    public function it_should_be_promotable(): void
    {
        $this->assertInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}