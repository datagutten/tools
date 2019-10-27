<?php


namespace datagutten\tools\color;


use InvalidArgumentException;
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

    /**
     * Parse a <position> element
     * @param SimpleXMLElement $position_xml
     * @return array
     */
    public static function parse_position($position_xml)
    {
        $tag = $position_xml->getName();
        if($tag!=='position')
            throw new InvalidArgumentException('Invalid tag: '.$tag);
        $attributes = $position_xml->attributes();
        $position = ['x'=>(int)$attributes['x'], 'y'=>(int)$attributes['y']];
        if(!empty($position_xml->{'color'}))
            $position['color'] = self::parse_color($position_xml->{'color'});
        return $position;
    }
}