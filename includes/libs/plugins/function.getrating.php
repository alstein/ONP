<?
function smarty_function_getrating($param)
{
	$tmpint = (int)$param['rating'];
	$tmpfrct = $param['rating'] - $tmpint;
	
	$img = NULL;
	for($i=0; $i<$tmpint; $i++)
	{
		$img .= "<img src='".$param['siteroot']."/templates/default/images/icons/star-yellow.png'>";
	}
	if($tmpfrct > 0.2 && $tmpfrct < 0.8)
		$img .= "<img src='".$param['siteroot']."/templates/default/images/icons/star-half-yellow.png'>";
	elseif($tmpfrct > 0.8)
		$img .= "<img src='".$param['siteroot']."/templates/default/images/icons/star-yellow.png'>";
		
	echo $img;
}
?>