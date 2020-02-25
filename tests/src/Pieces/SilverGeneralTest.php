<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;
use Shogi\Pieces\SilverGeneral;

final class SilverGeneralTest extends TestCase
{
    private Game $game;
    private SilverGeneral $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = SilverGeneral::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I3'));
    }

    /** @test */
    public function it_should_move_one_step_straight_upfront(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->game->currentPlayerMove('I3xH3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_move_one_step_diagonally_to_the_to_right(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->game->currentPlayerMove('I3xH2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H2'));
    }

    /** @test */
    public function it_should_move_one_step_diagonally_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->game->currentPlayerMove('I3xH4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H4'));
    }

    /** @test */
    public function it_should_move_one_step_to_right(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->game->currentPlayerMove('I3xI2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I2'));
    }

    /** @test */
    public function it_should_move_one_step_to_left(): void
    {
        $this->game->currentPlayerSetPiece('I3', $this->piece);

        $this->game->currentPlayerMove('I3xI4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I4'));
    }

    /** @test */
    public function it_should_not_move_one_step_to_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H3', $this->piece);

        $this->game->currentPlayerMove('H3xI3');
    }

    /** @test */
    public function it_should_move_one_step_behind_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('H3', $this->piece);

        $this->game->currentPlayerMove('H3xI4');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I4'));
    }

    /** @test */
    public function it_should_move_one_step_behind_to_the_right(): void
    {
        $this->game->currentPlayerSetPiece('H3', $this->piece);

        $this->game->currentPlayerMove('H3xI2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I2'));
    }

    /** @test */
    public function it_should_not_move_three_steps_straight_upfront(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H3', $this->piece);

        $this->game->currentPlayerMove('H3xE3');
    }

    /** @test */
    public function it_should_not_move_three_steps_straight_behind(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('E4', $this->piece);

        $this->game->currentPlayerMove('E4xH3');
    }

    /** @test */
    public function it_should_not_capture_a_piece_of_same_player(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('F3', $this->piece);
        $this->game->currentPlayerSetPiece('E3', Pawn::createBlack());

        $this->game->currentPlayerMove('F3xE3');
    }

    /** @test */
    public function it_should_capture_an_enemy_piece(): void
    {
        $captured = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('F3', $this->piece);
        $this->game->currentPlayerSetPiece('E3', $captured);

        $this->game->currentPlayerMove('F3xE3');

        $this->assertContains($captured, $this->game->opposingPlayerCaptures());
    }

    /** @test */
    public function it_should_be_promotable(): void
    {
        $this->assertInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}