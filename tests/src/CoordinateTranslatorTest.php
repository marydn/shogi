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

        $this->assertEquals(0, $coordinateTranslator->y());
        $this->assertEquals(6, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate2(): void
    {
        $coordinateTranslator = new CoordinateTranslator('A1');

        $this->assertEquals(0, $coordinateTranslator->y());
        $this->assertEquals(8, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate3(): void
    {
        $coordinateTranslator = new CoordinateTranslator('B2');

        $this->assertEquals(1, $coordinateTranslator->y());
        $this->assertEquals(7, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate4(): void
    {
        $coordinateTranslator = new CoordinateTranslator('C9');

        $this->assertEquals(2, $coordinateTranslator->y());
        $this->assertEquals(0, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate5(): void
    {
        $coordinateTranslator = new CoordinateTranslator('B8');

        $this->assertEquals(1, $coordinateTranslator->y());
        $this->assertEquals(1, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate6(): void
    {
        $coordinateTranslator = new CoordinateTranslator('A9');

        $this->assertEquals(0, $coordinateTranslator->y());
        $this->assertEquals(0, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate7(): void
    {
        $coordinateTranslator = new CoordinateTranslator('H2');

        $this->assertEquals(7, $coordinateTranslator->y());
        $this->assertEquals(7, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_translate_input_to_a_valid_spot_coordinate8(): void
    {
        $coordinateTranslator = new CoordinateTranslator('G3');

        $this->assertEquals(6, $coordinateTranslator->y());
        $this->assertEquals(6, $coordinateTranslator->x());
    }

    /** @test */
    public function it_should_be_a_valid_forward_y_step(): void
    {
        $source = new CoordinateTranslator('G1');
        $target = new CoordinateTranslator('F1');

        $this->assertEquals(1, $source->y() - $target->y());
    }

    /** @test */
    public function it_should_be_a_valid_forward_x_step(): void
    {
        $source = new CoordinateTranslator('G1');
        $target = new CoordinateTranslator('G2');

        $this->assertEquals(1, $source->x() - $target->x());
    }
}