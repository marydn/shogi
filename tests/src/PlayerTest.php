<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Shogi\Player;

final class PlayerTest extends TestCase
{
    /** @test */
    public function it_should_create_a_player(): void
    {
        $player = new Player;

        $this->assertTrue(true);
    }

    /** @test */
    public function it_should_load_twenty_pieces_per_player(): void
    {
        $player = new Player;

        $this->assertCount(20, $player->pieces());
    }
}