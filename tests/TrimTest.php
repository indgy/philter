<?php

namespace Indgy\Tests;

use Indgy\Philter;
use function Indgy\philter;


class TrimTest extends \PHPUnit\Framework\TestCase
{
    /**
     *  @dataProvider provideTrimmableValues
     */
    public function testShouldTrimChars($expected, $value, $char)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->trim($char)->toString());
    }
    public function provideTrimmableValues()
    {
        return [
            'null' => [null, null, null],
            'default, trim spaces' => ["first last", " first last ", null],
            'trim slash' => ["the/slug/was/pretty", "/the/slug/was/pretty/", '/'],
            'trim leading slash' => ["the/slug/was/pretty", "/the/slug/was/pretty", '/'],
            'trim trailing slash' => ["the/slug/was/pretty", "the/slug/was/pretty/", '/'],
            'trim double trailing slash' => ["the/slug/was/pretty", "the/slug/was/pretty//", '/'],
        ];
    }

    /**
     *  @dataProvider provideLeftTrimmableValues
     */
    public function testShouldLeftTrimChars($expected, $value, $char)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->ltrim($char)->toString());
    }
    public function provideLeftTrimmableValues()
    {
        return [
            'null' => [null, null, null],
            'default, trim spaces' => ["first last ", " first last ", null],
            'trim slash' => ["the/slug/was/pretty/", "/the/slug/was/pretty/", '/'],
            'trim leading slash' => ["the/slug/was/pretty", "/the/slug/was/pretty", '/'],
            'ignore trailing slash' => ["the/slug/was/pretty/", "the/slug/was/pretty/", '/'],
            'trim double leading slash' => ["the/slug/was/pretty//", "//the/slug/was/pretty//", '/'],
        ];
    }

    /**
     *  @dataProvider provideRightTrimmableValues
     */
    public function testShouldRightTrimChars($expected, $value, $char)
    {
        $this->assertEquals($expected, philter($value, $raw=true)->rtrim($char)->toString());
    }
    public function provideRightTrimmableValues()
    {
        return [
            'null' => [null, null, null],
            'default, trim spaces' => [" first last", " first last ", null],
            'trim trailing slash' => ["/the/slug/was/pretty", "/the/slug/was/pretty/", '/'],
            'trim double trailing slash' => ["/the/slug/was/pretty", "/the/slug/was/pretty//", '/'],
        ];
    }
}