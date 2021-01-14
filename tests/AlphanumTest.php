<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class AlphanumTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->alphanum($allowed)->toString());
    }
    public function provideAllowedValues()
    {
        $abc = "abcdefghijklmnopqrstuvwxyz1234567890";
        return [
            'null' => [null, null, null],
            'a-z0-9' => [$abc, $abc, null],
            'with dash' => [$abc, $abc, '-'],
            'with spaces' => ["$abc $abc", "$abc $abc", '\s'],
            'strip spaces' => ["$abc$abc", "$abc $abc", null],
            'strip disallowed by default' => [$abc, "$abc+_{}[];'<>,.", null],
        ];
    }

}