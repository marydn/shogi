<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;
use Shogi\Pieces\Rook;

final class RookTest extends TestCase
{
    private Game $game;
    private Rook $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = Rook::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('H2', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H2'));
    }

    /** @test */
    public function it_should_move_one_step_forward(): void
    {
        $this->game->currentPlayerSetPiece('H2', $this->piece);

        $this->game->currentPlayerMove('H2xG2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G2'));
    }

    /** @test */
    public function it_should_move_three_steps_forward(): void
    {
        $this->game->currentPlayerSetPiece('H2', $this->piece);

        $this->game->currentPlayerMove('H2xE2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('E2'));
    }

    /** @test */
    public function it_should_move_five_steps_forward(): void
    {
        $this->game->currentPlayerSetPiece('H2', $this->piece);

        $this->game->currentPlayerMove('H2xC2');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('C2'));
    }

    /** @test */
    public function it_should_move_five_steps_to_the_right(): void
    {
        $this->game->currentPlayerSetPiece('H8', $this->piece);

        $this->game->currentPlayerMove('H8xH3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_move_five_steps_to_the_left(): void
    {
        $this->game->currentPlayerSetPiece('H3', $this->piece);

        $this->game->currentPlayerMove('H3xH8');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H8'));
    }

    /** @test */
    public function it_should_move_five_steps_to_the_bottom(): void
    {
        $this->game->currentPlayerSetPiece('C3', $this->piece);

        $this->game->currentPlayerMove('C3xH3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('H3'));
    }

    /** @test */
    public function it_should_not_move_diagonally_to_the_left(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H2', $this->piece);

        $this->game->currentPlayerMove('H2xG3');
    }

    /** @test */
    public function it_should_not_move_diagonally_to_the_right(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H8', $this->piece);

        $this->game->currentPlayerMove('H8xG7');
    }

    /** @test */
    public function it_should_not_jump_over_another_white_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('G8', Pawn::createWhite());

        $this->game->currentPlayerMove('H8xF8');
    }

    /** @test */
    public function it_should_not_jump_over_another_black_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('G8', Pawn::createBlack());

        $this->game->currentPlayerMove('H8xF8');
    }

    /** @test */
    public function it_should_capture_a_white_piece(): void
    {
        $capture = Pawn::createWhite();

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('G8', $capture);

        $this->game->currentPlayerMove('H8xG8');

        $this->assertContains($capture, $this->game->blackPlayerCaptures());
    }

    /** @test */
    public function it_should_not_capture_a_black_piece(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('H8', $this->piece);
        $this->game->currentPlayerSetPiece('G8', Pawn::createBlack());

        $this->game->currentPlayerMove('H8xG8');
    }

    /** @test */
    public function it_should_be_promotable(): void
    {
        $this->assertInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}