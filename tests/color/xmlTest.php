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

    public function testParsePosition()
    {
        $xml = simplexml_load_file(__DIR__.'/test_data/color_position.xml');
        $color = xml::parse_color($xml->{'position'}->{'color'});
        $position_ref = ['x'=>500, 'y'=>600, 'color'=>$color];
        $position = xml::parse_position($xml->{'position'});
        $this->assertSame($position_ref, $position);
    }

    public function testParsePositionNoColor()
    {
        $xml = simplexml_load_file(__DIR__.'/test_data/position_common_color.xml');
        $position = $xml->xpath('/positions/position[2]')[0];
        $position_ref = ['x'=>500, 'y'=>600];
        $position = xml::parse_position($position);
        $this->assertSame($position_ref, $position);
    }

    public function testPositionInvalidArgument()
    {
        $xml = new SimpleXMLElement('<color></color>');
        $this->expectException(InvalidArgumentException::class);
        xml::parse_position($xml);
    }

    public function testColorInvalidArgument()
    {
        $xml = new SimpleXMLElement('<position></position>');
        $this->expectException(InvalidArgumentException::class);
        xml::parse_color($xml);
    }
}
