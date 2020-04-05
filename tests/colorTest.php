<?php


use datagutten\tools\color\color;
use PHPUnit\Framework\TestCase;

class color_Test extends TestCase
{

    /*public function testColor_filter()
    {

    }*/

    public function testColor_diff()
    {
        $diff = [];
        $result = color::color_diff(0x0F0A0E, 0x000000, 0, 15, $diff);
        $this->assertSame(['r'=>-15, 'g'=>-10, 'b'=>-14], $diff);
        $this->assertFalse($result);
    }

    public function testNoCommonColor()
    {
        $im = imagecreatetruecolor(700,700);
        imagefill($im, 0,0, imagecolorallocate($im, 0xff, 0xfe, 0xfd));
        $xml = simplexml_load_file(__DIR__.'/color/test_data/position_no_common_color.xml');
        $result = color::color_check_xml($im, $xml);
        $this->assertTrue($result);
    }

    public function testColorCheck()
    {
        $im = imagecreatetruecolor(700,700);
        imagefill($im, 0,0, imagecolorallocate($im, 0xff, 0xfe, 0xfd));
        $xml = simplexml_load_file(__DIR__.'/color/test_data/position_common_color.xml');
        $result = color::color_check_xml($im, $xml);
        $this->assertTrue($result);
    }
}
