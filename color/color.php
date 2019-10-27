<?php


namespace datagutten\tools\color;


class color
{
    /**
     * Check if a color is within the specified offset from a reference color
     * @param int $ref_rgb Reference color
     * @param int $rgb Color to be checked
     * @param int $limit_low Minimum allowed offset to the reference color
     * @param int $limit_high Maximal allowed offset to the reference color
     * @param array $diff Difference to ref_rgb for each color
     * @return bool Return false if the color is not within limits
     */
    public static function color_diff($ref_rgb,$rgb,$limit_low=0,$limit_high=35, &$diff=null)
    {
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $ref_r = ($ref_rgb >> 16) & 0xFF;
        $ref_g = ($ref_rgb >> 8) & 0xFF;
        $ref_b = $ref_rgb & 0xFF;
        $rdiff=$r-$ref_r;
        $gdiff=$g-$ref_g;
        $bdiff=$b-$ref_b;

        $diff=array('r'=>$rdiff,'g'=>$gdiff,'b'=>$bdiff);
        if($rdiff<$limit_low || $rdiff>$limit_high)
            return false;
        if($gdiff<$limit_low || $gdiff>$limit_high)
            return false;
        if($bdiff<$limit_low || $bdiff>$limit_high)
            return false;
        return true;
    }

    /**
     * Remove colors not within the specified offset from a reference color
     * @param $im resource Source image resource identifier
     * @param int $ref_rgb Reference color
     * @param int $limit_low Minimum allowed offset to the reference color
     * @param int $limit_high Maximal allowed offset to the reference color
     * @return resource Image with only colors within the limits left
     */
    public static function color_filter($im,$ref_rgb,$limit_low=0,$limit_high=35)
    {
        $im_out=imagecreatetruecolor(imagesx($im),imagesy($im));
        for($x=0; $x<imagesx($im); $x++)
        {
            for($y=0; $y<imagesy($im); $y++)
            {
                $color=imagecolorat($im,$x,$y);
                if(self::color_diff($ref_rgb,$color,$limit_low,$limit_high)) //Check if the color is valid
                    imagecopy($im_out,$im,$x,$y,$x,$y,1,1); //Copy a pixel
            }
        }
        return $im_out;
    }
}