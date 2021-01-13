<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class PhilterTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldUseFunction()
    {
        $str = 'this is philter';
        $this->assertEquals($str, philter($str)->toString());
    }
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