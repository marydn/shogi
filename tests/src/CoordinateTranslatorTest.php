<?php

declare(strict_types=1);

namespace src;

use PHPUnit\Framework\TestCase;
use Shogi\CoordinateTranslator;

final class CoordinateTranslatorTest extends TestCase
{
    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate(): void
    {
        $coordinateTranslator = new CoordinateTranslator('A3');

        $this->assertEquals(0, $coordinateTranslator->x());
        $this->assertEquals(2, $coordinateTranslator->y());
    }
}