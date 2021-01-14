<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class MinTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldAllowGreaterThanMinOrReturnNull($expected, $value, $min)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->min($min)->toInt());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, 10],
            'at min' => [10, 10, 10],
            'greater than min' => [100, 100, 10],
            'less than min' => [null, 10, 100],
        ];
    }

}