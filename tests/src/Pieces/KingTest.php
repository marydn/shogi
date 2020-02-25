<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\King;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;

final class KingTest extends TestCase
{
    private Game $game;
    private King $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = King::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I5'));
    }

    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xH5');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H5'));
    }

    /** @test */
    public function it_should_move_one_step_to_the_right(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xI4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I4'));
    }

    /** @test */
    public function it_should_move_one_step_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xI6');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I6'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_the_upper_right(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xH4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H4'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_to_the_upper_left(): void
    {
        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xH6');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H6'));
    }

    /** @test */
    public function it_should_move_one_step_backward(): void
    {
        $this->game->currentPlayerSetPiece('H5', $this->piece);

        $this->game->currentPlayerMove('H5xI5');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I5'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_backward_to_the_right(): void
    {
        $this->game->currentPlayerSetPiece('H5', $this->piece);

        $this->game->currentPlayerMove('H5xI4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I4'));
    }

    /** @test */
    public function it_should_move_diagonally_one_step_backward_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('H5', $this->piece);

        $this->game->currentPlayerMove('H5xI6');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I6'));
    }

    /** @test */
    public function it_should_not_move_three_steps_forward(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xF5');
    }

    /** @test */
    public function it_should_not_move_three_steps_to_the_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xI2');
    }

    /** @test */
    public function it_should_not_move_three_steps_to_the_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I5', $this->piece);

        $this->game->currentPlayerMove('I5xI8');
    }

    /** @test */
    public function it_should_not_move_three_steps_backwards(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E5', $this->piece);

        $this->game->currentPlayerMove('E5xI5');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I5', $this->piece);
        $this->game->currentPlayerSetPiece('H5', Pawn::createBlack());

        $this->game->currentPlayerMove('I5xH5');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('I5', $this->piece);
        $this->game->currentPlayerSetPiece('H5', $captured);

        $this->game->currentPlayerMove('I5xH5');

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }

    /** @test */
    public function it_should_not_be_promoted(): void
    {
        $this->assertNotInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}