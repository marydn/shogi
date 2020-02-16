<?php

declare(strict_types=1);

namespace src\ValueObject;

use PHPUnit\Framework\TestCase;
use Shogi\Exception\CoordinateNotFound;
use Shogi\Exception\CoordinateNotWellFormedNotation;
use Shogi\ValueObject\Coordinate;

final class CoordinateTest extends TestCase
{
    /** @test */
    public function it_should_create_a_coordinate(): void
    {
        $spotOrigin = 'A1';

        $coordinate = new Coordinate($spotOrigin);

        $this->assertEquals('A', $coordinate->y());
        $this->assertEquals(1, $coordinate->x());
    }

    /** @test */
    public function it_should_throw_exception_on_three_letter_input(): void
    {
        $spotOrigin = 'AA1';

        $this->expectException(CoordinateNotWellFormedNotation::class);

        new Coordinate($spotOrigin);
    }

    /** @test */
    public function it_should_throw_exception_on_out_of_boundary_input(): void
    {
        $spotOrigin = 'Z3';

        $this->expectException(CoordinateNotFound::class);

        new Coordinate($spotOrigin);
    }
}