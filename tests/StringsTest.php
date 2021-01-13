<?php

namespace Indgy\Tests;

use Indgy\Philter;

class StringsTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldReturnString()
    {
        $f = new Philter('unsafe');
        $str = $f->toString();

        $this->assertIsString($str);
        $this->assertEquals('unsafe', $str);
    }
}