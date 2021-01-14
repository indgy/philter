<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class NumericTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->numeric($allowed)->toString());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, null],
            'default' => ["+1,123,456.78", "+1,123,456.78", null],
            // 'with dash' => [$digits, $digits, '-'],
            // 'with spaces' => [$digits, " $digits", '\s'],
            // 'strip spaces' => [$digits, "$digits ", null],
            // 'strip disallowed by default' => [$digits, "$digits+_{}[];'<>,.", null],
            // 'strip disallowed by default allow decimal' => [$digits, "+_{}[];'<>,$digits.", '.'],
        ];
    }

}