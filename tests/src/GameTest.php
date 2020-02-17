<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shogi\Exception\CoordinateNotFound;
use Shogi\Exception\IllegalMove;
use Shogi\Game;

final class GameTest extends TestCase
{
    /** @test */
    public function it_should_create_a_new_game(): void
    {
        $game = new Game;

        $this->assertInstanceOf(Game::class, $game);
    }

    /** @test */
    public function it_should_move_a_piece(): void
    {
        $game = new Game;

        $pieceToMove = $game->pieceFromSpot('G3');

        $game->currentPlayerMove('G3xF3');

        $this->assertEquals($pieceToMove, $game->pieceFromSpot('F3'));
    }

    /** @test */
    public function it_should_empty_old_spot(): void
    {
        $source = 'G1';
        $target = 'F1';
        $notationFromUser = sprintf('%sx%s', $source, $target);

        $game = new Game;

        $pieceToMove = $game->pieceFromSpot($source);

        $game->currentPlayerMove($notationFromUser);

        $this->assertNull($game->pieceFromSpot($source));
    }

    /** @test */
    public function it_should_throw_exception_when_move_pieces_from_opposing_player(): void
    {
        $userInput = 'A3xA4';

        $this->expectException(IllegalMove::class);

        $game = new Game;
        $game->opposingPlayerMove($userInput);
    }

    /** @test */
    public function it_should_throw_exception_when_spot_does_not_exist(): void
    {
        $userInput = 'A3xZ1';

        $this->expectException(CoordinateNotFound::class);

        $game = new Game;
        $game->currentPlayerMove($userInput);
    }

    /** @test */
    public function it_should_capture_a_pawn(): void
    {
        $game = new Game;

        $piece = $game->pieceFromSpot('c1');
        $player = $game->playerBlack();

        $player->capturePiece($piece);

        $this->assertCount(1, $player->captures());
    }
}