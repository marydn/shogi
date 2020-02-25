<?php

declare(strict_types=1);

namespace Shogi\Test\Pieces;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\IllegalMove;
use Shogi\Game;
use Shogi\Pieces\Knight;
use Shogi\Pieces\Pawn;
use Shogi\Pieces\PiecePromotableInterface;

final class KnightTest extends TestCase
{
    private Game $game;
    private Knight $piece;

    public function setUp(): void
    {
        $this->game  = new Game(false);
        $this->piece = Knight::createBlack();
    }

    public function tearDown(): void
    {
        unset($this->game, $this->piece);
    }

    /** @test */
    public function it_should_set_a_piece(): void
    {
        $this->game->currentPlayerSetPiece('I8', $this->piece);

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('I8'));
    }

    /** @test */
    public function it_should_make_a_correct_move(): void
    {
        $this->game->currentPlayerSetPiece('I2', $this->piece);

        $this->game->currentPlayerMove('I2xG3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G3'));
    }

    /** @test */
    public function it_should_not_move_when_move_is_incorrect(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I2', $this->piece);

        $this->game->currentPlayerMove('I2xG4');
    }

    /** @test */
    public function it_should_move_over_a_white_piece(): void
    {
        $this->game->currentPlayerSetPiece('I2', $this->piece);
        $this->game->currentPlayerSetPiece('H2', Pawn::createWhite());

        $this->game->currentPlayerMove('I2xG3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G3'));
    }

    /** @test */
    public function it_should_move_over_a_black_piece(): void
    {
        $this->game->currentPlayerSetPiece('I2', $this->piece);
        $this->game->currentPlayerSetPiece('H2', Pawn::createBlack());

        $this->game->currentPlayerMove('I2xG3');

        $this->assertEquals($this->piece, $this->game->pieceFromSpot('G3'));
    }

    /** @test */
    public function it_should_not_move_more_than_three_steps(): void
    {
        $this->expectException(IllegalMove::class);

        $this->game->currentPlayerSetPiece('I2', $this->piece);

        $this->game->currentPlayerMove('I2xF3');
    }

    /** @test */
    public function it_should_be_promotable(): void
    {
        $this->assertInstanceOf(PiecePromotableInterface::class, $this->piece);
    }
}