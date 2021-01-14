<?php

namespace Indgy\Tests;

use Indgy\Philter;

class FloatsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideFloats
     */
    public function testShouldHandleFloats($expected, $float, $decimals)
    {
        $f = new Philter($float, $raw=true);
        $this->assertIsFloat($f->toFloat());
        $this->assertEquals($expected, $f->toFloat($decimals));
    }
    public function provideFloats()
    {
        return [
            '1 no decimals' => [1.0, 1, null],
            '1 two decimals' => [1.00, 1, 2],
            '123 null decimals' => [123.0, 123, null],
            '123.4569 null decimals' => [123.4569, 123.4569, null],
            '123.4569 2 decimals' => [123.46, 123.4569, 2],
        ];
    }
    /**
     *  @dataProvider provideIntegers
     */
    public function testShouldHandleIntegers($expected, $int, $decimals)
    {
        $f = new Philter($int, $raw=true);
        $this->assertIsFloat($f->toFloat());
        $this->assertEquals($expected, $f->toFloat($decimals));
    }
    public function provideIntegers()
    {
        return [
            '1 no decimals' => [1.0, 1, null],
            '1 two decimals' => [1.00, 1, 2],
            '123 null decimals' => [123.0, 123, null],
            '123.4569 null decimals' => [123.4569, 123.4569, null],
            '123.4569 2 decimals' => [123.46, 123.4569, 2],
        ];
    }
    /**
     *  @dataProvider provideStrings
     */
    public function testShouldHandleStrings($expected, $string, $decimals)
    {
        $f = new Philter($string, $raw=true);
        $this->assertIsFloat($f->toFloat());
        $this->assertEquals($expected, $f->toFloat($decimals));
    }
    public function provideStrings()
    {
        return [
            '123 null decimals' => [123.0, "123", null],
        ];
    }

}