<?php


namespace datagutten\tools\color;


use SimpleXMLElement;

class xml
{
    /**
     * Parse a <color> element
     * @param SimpleXMLElement $color
     * @return array
     */
    public static function parse_color($color)
    {
        $color = (array)$color;
        $color['reference'] = hexdec($color['reference']);
        $color['low'] = intval($color['low']);
        $color['high'] = intval($color['high']);
        return $color;
    }
}