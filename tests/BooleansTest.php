<?php

namespace Indgy\Tests;

use Indgy\Philter;

class BooleansTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldReturnTrue()
    {
        $f = new Philter(true, $raw=true);
        $this->assertIsBool($f->toBool());
        $this->assertTrue($f->toBool());
    }
    public function testShouldReturnFalse()
    {
        $f = new Philter(false, $raw=true);
        $this->assertIsBool($f->toBool());
        $this->assertFalse($f->toBool());
    }
}