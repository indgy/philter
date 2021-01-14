<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class AsciiTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->ascii($allowed)->toString());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, null],
            'ascii' => ["abc123", "abc123", null],
            'ascii with allowed' => ["abc-123", "abc-123", '-'],
            'diacritics' => ["creme brulee", "créme brulée", null],
        ];
    }

}