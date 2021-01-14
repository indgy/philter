<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class DefaultTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldThrowErrorIfNoArgPassed()
    {
        $this->expectException('ArgumentCountError');
        philter('this is a string', $raw=true)->allow()->default()->toString();
    }
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldSetStringDefaultValueIfNull($expected, $value, $default)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->default($default)->toString());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, null],
            'abc' => ['abc', 'abc', 'DEFAULT'],
            'return default' => ['DEFAULT', null, 'DEFAULT'],
        ];
    }

}