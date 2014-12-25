<?Php
//Compare two colors
class color
{
	public $diff;
	public function colordiff($ref_rgb,$rgb,$limit_low=0,$limit_high=35)
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
			//echo dechex($rgb)."\n";
			$this->diff=array('r'=>$rdiff,'g'=>$gdiff,'b'=>$bdiff);
			if($rdiff<$limit_low || $rdiff>$limit_high)
				return false;
			if($gdiff<$limit_low || $gdiff>$limit_high)
				return false;
			if($bdiff<$limit_low || $bdiff>$limit_high)
				return false;
			return true;
	}
	public function colorfilter($im,$ref_rgb,$limit_low=0,$limit_high=35)
	{
		$im_out=imagecreatetruecolor(imagesx($im),imagesy($im));
		for($x=0; $x<imagesx($im); $x++)
		{
			for($y=0; $y<imagesy($im); $y++)
			{
				$color=imagecolorat($im,$x,$y);
				if($this->colordiff($ref_rgb,$color,$limit_low,$limit_high)) //Check if the color is valid
					imagecopy($im_out,$im,$x,$y,$x,$y,1,1); //Copy a pixel
			}
		}
		return $im_out;
	}
}
?>