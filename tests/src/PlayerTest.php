<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shogi\Player;

final class PlayerTest extends TestCase
{
    /** @test */
    public function it_should_create_a_player(): void
    {
        $player = new Player('Player 1');

        $this->assertInstanceOf(Player::class, $player);
    }

    /** @test */
    public function it_should_have_a_name(): void
    {
        $playerName = 'Player 1';
        $player = new Player($playerName);

        $this->assertEquals($playerName, $player->name());
    }

    /** @test */
    public function it_should_create_a_white_player(): void
    {
        $player = new Player('Player 1', true);

        $this->assertTrue($player->isWhite());
    }

    /** @test */
    public function it_should_create_a_black_player(): void
    {
        $player = new Player('Player 1');

        $this->assertFalse($player->isWhite());
    }
}