<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class MaxTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldAllowLessThanMaxOrReturnNull($expected, $value, $max)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->max($max)->toInt());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, 10],
            'at max' => [10, 10, 10],
            'greater than max' => [null, 100, 10],
            'less than max' => [10, 10, 100],
        ];
    }

}