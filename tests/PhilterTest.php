<?php

namespace Indgy\Tests;

use Indgy\Philter;

class PhilterTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideNonScalarValues
     */
    public function testShouldThrowExceptionIfSuppliedWithNonScalarValue($value)
    {
        $this->expectException('InvalidArgumentException');
        $f = new Philter($value);
    }
    public function provideNonScalarValues()
    {
        return [
            'Array' => [[]],
            'Object' => [new \StdClass],
        ];
    }
}