<?php

declare(strict_types=1);

namespace src;

use PHPUnit\Framework\TestCase;
use Shogi\Board;

final class BoardTest extends TestCase
{
    /** @test */
    public function it_should_create_a_board(): void
    {
        $board = new Board;

        $this->assertInstanceOf(Board::class, $board);
    }

    /** @test */
    public function it_should_create_spots(): void
    {
        $board = new Board();

        $positions = $board->positions();

        $this->assertArrayHasKey(8, $positions);
        $this->assertArrayHasKey(8, $positions[8]);
    }

    /** @test */
    public function it_should_not_have_extra_spots(): void
    {
        $board = new Board();

        $positions = $board->positions();

        $this->assertArrayNotHasKey(9, $positions);
    }
}