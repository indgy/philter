<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class ContainsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldAllowIfStringContainsOrReturnNull($expected, $value, $match, $match_case)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->contains($match, $match_case)->toString());
    }
    public function provideAllowedValues()
    {
        return [
            'null input' => [null, null, 'is', false],
            'input contains match' => ['this is the string', 'this is the string', 'is the', false],
            'input does not contain match' => [null, 'this is the string', 'is not', false],
            'input contains match and case' => ['this Is The string', 'this Is The string', 'Is The', true],
            'input does not contain match case' => [null, 'this Is the string', 'is the', true],
        ];
    }

}