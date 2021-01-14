<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class AllowTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldThrowErrorIfNoArgPassed()
    {
        $this->expectException('ArgumentCountError');
        philter('this is a string', $raw=true)->allow()->toString();
    }
    /**
     *  @dataProvider provideAllowedValues
     */
    public function testShouldStripAllButAllowed($expected, $value, $allow)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->allow($allow)->toString());
    }
    public function provideAllowedValues()
    {
        return [
            'null' => [null, null, ''],
            'a-z' => ['allowed', 'allowed', 'a-z'],
            '0-9' => ['0123456789', 'this is not allowed 0123456789', '0-9'],
            'a-z with spaces' => ['this is allowed', 'this is allowed', 'a-z\s'],
        ];
    }

}