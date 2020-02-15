<?php

declare(strict_types=1);

namespace src;

use PHPUnit\Framework\TestCase;
use Shogi\CoordinateTranslator;
use Shogi\ValueObject\Coordinate;

final class CoordinateTranslatorTest extends TestCase
{
    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate(): void
    {
        $spotOrigin = 'A3';

        $coordinateTranslator = new CoordinateTranslator(new Coordinate($spotOrigin));

        $this->assertEquals(0, $coordinateTranslator->x());
        $this->assertEquals(2, $coordinateTranslator->y());
    }
}