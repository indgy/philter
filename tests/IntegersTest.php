<?php

namespace Indgy\Tests;

use Indgy\Philter;

class IntegersTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldReturnInt()
    {
        $f = new Philter(456);
        $this->assertIsInt($f->toInt());
        $this->assertEquals(456, $f->toInt());
    }
}