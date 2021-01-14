<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class InTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allowed, $match_case)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->in($allowed, $match_case)->toString());
    }
    public function provideAllowedValues()
    {
         return [
             'null' => [null, null, [], false],

            'str in allowed' => ['abc', 'abc', ['abc','DEF', 123, 456.89], false],
            'str case in allowed' => ['def', 'def', ['abc','DEF', 123, 456.89], false],
            'str upper case in allowed' => ['DEF', 'DEF', ['abc','DEF', 123, 456.89], true],
            'int in allowed' => ["123", 123, ['abc', 'DEF', 123, 456.89], false],
            'float str in allowed' => ["456.89", 456.89, ['abc','DEF', '123', '456.89'], false],
            'float in allowed' => ["456.89", 456.89, ['abc','DEF', 123, 456.89], false],

            'str not in allowed' => [null, 'xyz', ['abc','DEF', 123, 456.89], false],
            'int not in allowed' => [null, 99, ['abc','DEF', 123, 456.89], false],
            'float not in allowed' => [null, 12.34, ['abc','DEF', 123, 456.89], false],
        ];
    }

}
