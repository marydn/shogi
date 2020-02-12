<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shogi\Game;

final class GameTest extends TestCase
{
    /** @test */
    public function it_should_create_a_new_game(): void
    {
        new Game();

        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_move_a_piece(): void
    {
        $from = '1A';
        $to = '2B';

        $game = new Game();
        $originalPiece = $game->pieceFromSpot($from);

        $game->currentPlayerMove($from, $to);

        $this->assertEquals($originalPiece, $game->pieceFromSpot($to));
        $this->assertNotEquals($originalPiece, $game->pieceFromSpot($from));
    }

    /** @test */
    public function it_should_undo_pieces_movements_from_another_player(): void
    {
        $from = '1A';
        $to = '2B';

        $game = new Game();

        $originalPiece = $game->pieceFromSpot($from);

        $game->opposingPlayerMove($from, $to);

        $this->assertEquals($originalPiece, $game->pieceFromSpot($from));
        $this->assertNotEquals($originalPiece, $game->pieceFromSpot($to));
    }

    /** @test */
    public function it_should_undo_a_move_to_non_existent_spots(): void
    {
        $from = '1A';
        $to = '2Z';

        $game = new Game();

        $originalPiece = $game->pieceFromSpot($from);

        $game->currentPlayerMove($from, $to);

        $this->assertEquals($originalPiece, $game->pieceFromSpot($from));
        $this->assertNotEquals($originalPiece, $game->pieceFromSpot($to));
    }
}