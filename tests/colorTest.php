<?php


use PHPUnit\Framework\TestCase;

class colorTest extends TestCase
{

    public function testColorfilter()
    {

    }

    public function testColordiff()
    {
        $color = new color();
        $result = $color->colordiff(0x0F0A0E, 0x000000);
        $this->assertSame(['r'=>-15, 'g'=>-10, 'b'=>-14], $color->diff);
        $this->assertFalse($result);
    }
}
