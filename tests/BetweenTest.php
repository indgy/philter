<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class BetweenTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldAllowBetweenOrReturnNull($expected, $value, $min, $max)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->between($min, $max)->toInt());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, 10, 100],
            'in range' => [50, 50, 10, 100],
            'at min' => [10, 10, 10, 100],
            'at max' => [100, 100, 10, 100],
            'under range' => [null, 5, 10, 100],
            'over range' => [null, 105, 10, 100],
        ];
    }

}