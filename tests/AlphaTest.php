<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class AlphaTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->alpha($allowed)->toString());
    }
    public function provideAllowedValues()
    {
        $abc = "abcdefghijklmnopqrstuvwxyz";
        return [
            'null' => [null, null, null],
            'a-z' => [$abc, $abc, null],
            'a-z with dash' => [$abc, $abc, '-'],
            'with spaces' => ["$abc $abc", "$abc $abc", '\s'],
            'strip spaces' => ["$abc$abc", "$abc $abc", null],
            'strip disallowed by default' => [$abc, "$abc+_{}[];'<>,.", null],
        ];
    }

    // TODO test diacritics and unprintable characters

}