<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class DigitsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->digits($allowed)->toInt());
    }
    public function provideAllowedValues()
    {
        $digits = "1234567890";
        return [
            'null' => [null, null, null],
            
            '0-9' => [$digits, $digits, null],
            'with dash' => [$digits, $digits, '-'],
            'with spaces' => [$digits, " $digits", '\s'],
            'strip spaces' => [$digits, "$digits ", null],
            'strip disallowed by default' => [$digits, "$digits+_{}[];'<>,.", null],
            'strip disallowed by default allow decimal' => [$digits, "+_{}[];'<>,$digits.", '.'],
        ];
    }

}