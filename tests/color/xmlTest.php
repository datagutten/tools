<?php


use datagutten\tools\color\xml;
use PHPUnit\Framework\TestCase;

class xmlTest extends TestCase
{

    public function testParse_color()
    {
        $xml = simplexml_load_file(__DIR__.'/test_data/color.xml');
        $color = xml::parse_color($xml);
        $color_ref = ['reference'=>0xfdfdfd, 'low'=>-5, 'high'=>5];
        $this->assertSame($color_ref, $color);
    }
}
