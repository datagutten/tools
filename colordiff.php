<?Php
//Compare two colors
function colordiff($ref_rgb,$rgb,$limit_low=0,$limit_high=35)
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
		//var_dump($rdiff,$gdiff,$bdiff);
		if($rdiff<$limit_low || $rdiff>$limit_high)
			return false;
		if($gdiff<$limit_low || $gdiff>$limit_high)
			return false;
		if($bdiff<$limit_low || $bdiff>$limit_high)
			return false;
		return true;
}
?>