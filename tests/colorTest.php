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
}
