<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class CutTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldThrowExceptionIfInvalidLengthPassed()
    {
        $this->expectException('InvalidArgumentException');
        philter('this is a string', $raw=true)->cut(-1)->toString();
    }
    /**
     *  @dataProvider provideValues
     */
    public function testShouldCutExceedinglyLongStrings($expected, $value, $length)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->cut($length)->toString());
    }
    public function provideValues()
    {
        $abc = "abcdefghijklmnopqrstuvwxyz";
        $abc_x10 = str_repeat($abc, 10);

        return [
            'null input' => [null, null, null],
            'default length' => ['this is ok', 'this is ok', null],
            'will be cut to default length' => [substr($abc_x10, 0, 255), $abc_x10, null],
            'will be cut to specific length' => [$abc, $abc_x10, 26],
        ];
    }

}