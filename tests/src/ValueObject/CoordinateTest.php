<?php

declare(strict_types=1);

namespace src\ValueObject;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\CoordinateNotFound;
use Shogi\ValueObject\Coordinate;

final class CoordinateTest extends TestCase
{
    /** @test */
    public function it_should_create_a_coordinate(): void
    {
        $spotOrigin = 'A1';

        $coordinate = new Coordinate($spotOrigin);

        $this->assertEquals('A', $coordinate->x());
        $this->assertEquals(1, $coordinate->y());
    }

    /** @test */
    public function it_should_throw_exception_on_three_letter_input(): void
    {
        $spotOrigin = 'AA1';

        $this->expectException(CoordinateNotFound::class);

        new Coordinate($spotOrigin);
    }
}