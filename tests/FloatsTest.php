<?php

namespace Indgy\Tests;

use Indgy\Philter;

class FloatsTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldReturnFloat()
    {
        $f = new Philter(123.45678);
        $this->assertIsFloat($f->toFloat());
        $this->assertEquals(123.45678, $f->toFloat());
    }
    public function testShouldReturnFloatWithOneDecimalPlace()
    {
        $f = new Philter(1.234);
        $this->assertIsFloat($f->toFloat(1));
        $this->assertEquals(1.2, $f->toFloat(1));
    }
}