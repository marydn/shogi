<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Bishop;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;

final class BishopTest extends TestCase
{
    private Game $game;
    private Bishop $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = Bishop::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('H8', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H8'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_left(): void
    {
        $this->game->currentPlayerSetPiece('H8', $this->piece);

        $this->game->currentPlayerMove('H8xG9');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G9'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_right(): void
    {
        $this->game->currentPlayerSetPiece('H8', $this->piece);

        $this->game->currentPlayerMove('H8xG7');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G7'));
    }

    /** @test */
    public function it_should_move_diagonally_three_steps_to_left(): void
    {
        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xC9');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('C9'));
    }

    /** @test */
    public function it_should_move_diagonally_three_steps_to_right(): void
    {
        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xC3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('C3'));
    }

    /** @test */
    public function it_should_move_diagonally_three_steps_to_left_backwards(): void
    {
        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xH8');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H8'));
    }

    /** @test */
    public function it_should_move_diagonally_four_steps_to_right_backwards(): void
    {
        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xI3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I3'));
    }

    /** @test */
    public function it_should_not_move_straight_one_step(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xE6');
    }

    /** @test */
    public function it_should_not_move_straight_three_steps(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xC6');
    }

    /** @test */
    public function it_should_not_move_straight_three_steps_backwards(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F6', $this->piece);

        $this->game->currentPlayerMove('F6xI6');
    }

    /** @test */
    public function it_should_not_jump_over_an_enemy_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F6', $this->piece);
        $this->game->currentPlayerSetPiece('E5', Pawn::createWhite());

        $this->game->currentPlayerMove('F6xD4');
    }

    /** @test */
    public function it_should_not_jump_over_another_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F6', $this->piece);
        $this->game->currentPlayerSetPiece('E5', Pawn::createBlack());

        $this->game->currentPlayerMove('F6xD4');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('E5', Pawn::createBlack());

        $this->game->currentPlayerMove('H8xE5');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('E5', $captured);

        $this->game->currentPlayerMove('H8xE5');

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }

    /** @test */
    public function it_should_be_promotable(): void
    {
        $this->assertInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}