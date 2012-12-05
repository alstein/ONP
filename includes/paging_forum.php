<?php
function quickLink ($linkHref, $desc, $accessKey, $linkTitle) {


   $theLink = '<a href="'. $linkHref .'" title="'. $desc .'" accesskey="'. 
                   $accessKey .'">'. $linkTitle .'</a>';
   return $theLink;

} 
// google_like_pagination.php 
function pagination($number, $show, $showing, $firstlink, $baselink, $seperator, $total_records)
{

	include_once('SiteSetting.php');
	$disp = floor($show / 2);
    if ( $showing <= $disp) :

        ///if ( ($disp - $showing) > 0 ):
        //$low  = ($disp - $showing);
        //else:
        $low = 1;
       // endif;
        $high = ($low + $show) - 1;

    elseif ( ($showing + $disp) > $number) :

        $high = $number;
        $low = ($number - $show) + 1;

    else:

        $low  = ($showing - $disp);
        $high = ($showing + $disp);

    endif;
    
    // next / prev / first / last
    if ( ($showing - 1) > 0 ) :
        if ( ($showing - 1) == 1 ):
        $prev  = quickLink ($firstlink, 'Previous', '', "<<");
        else:
        $prev  = quickLink ($baselink . $seperator . ($showing - 1), 
        'Previous', 'z', "<<");
        endif;
    else:
        $prev  = '';
    endif; 

    $next  = ($showing + 1) <= $number ? 
    quickLink ($baselink . $seperator . ($showing + 1), 'Next', 'x', ">>") : '';

    $navi = '<div id="pagination" class="pagination fr">'."";
    // start the navi

        $navi .= $first . ' '. $prev ." ";

    // loop through the numbers

    foreach (range($low, $high) as $newnumber):

           if($newnumber < 0)
		   		continue;
		   $link = ( $newnumber == 1 ) ? $firstlink : 
                $baselink . $seperator . $newnumber;
           if ($newnumber > $number):
        $navi .= '';
        elseif ($newnumber == 0):
        $navi .= '';
        else:
        $navi .= ( $newnumber == $showing ) ? 
            '<a class="active"> <b>'. $newnumber .'</b></a> '."" :
            ' '. quickLink ($link, 'Page '. $newnumber, '', $newnumber) ." "; 
        endif;
    endforeach;

	$navi .= ' '. $next ." " . $last;
	
// 	if($total_records)
// 		$navi .= " &nbsp; &nbsp; <span class='strong'>" . $total_records . " Records found</span> &nbsp;";
//     $navi .= '</div><br/>';
    
	return $navi;

}



function pageing($number, $show, $showing, $firstlink, $baselink="", $seperator, $total_records) {

	include_once('SiteSetting.php');

    // next / prev / first / last
    if ( ($showing - 1) > 0 ) :
        if ( ($showing - 1) == 1 ):
        $prev  = quickLink ($firstlink, 'Previous', '', "Previous");
        else:
        $prev  = quickLink ($baselink . $seperator . ($showing - 1), 
        'Previous', 'z', "Previous");
        endif;
    else:
        $prev  = '';
    endif; 

    $next  = ($showing + 1) <= $number ? 
    quickLink ($baselink . $seperator . ($showing + 1), 'Next', 'x', "Next") : '';

//     if ( $prev == '')
//     	$first = '';
//     else
//     	$first = quickLink ($firstlink, 'First Page', '', "Next");
// 
// 
//     if ( $prev == '')
//     	$first = '';
//     else
//     	$first = quickLink ($firstlink, 'First Page', '', "First");
// 
//     if ( $showing == $number ):
//     $last = '';    
//     else:
//     $last = quickLink ($baselink . $seperator . $number, 'Last Page', '', "Last");
//     endif;


    $navi = '<div id="pagination" class="pagination fr">'."";
    // start the navi


        $navi .= $first .' '.$prev." ";
    // loop through the numbers



	$navi .= ' '. $next ." " . $last;

    $navi .= '</div><br/>';

	return $navi;

}


// $page	= (($_REQUEST['pageNumber']) ? $_REQUEST['pageNumber'] : '1');
function page_limit($size)
{
	global $page;
	//echo $page.$size;
	$StartRow 	= $size * ($page-1);
	$l 			= $StartRow.','.$size;
	return $l;
}

//function dispay_paging($size, $numrows, $other_params='', $ajax_param='')
function dispay_paging($size, $numrows, $ajax_param='',$limit)
{
	global $page;

	if(count($_GET))
 	{
		$i=0;
		foreach($_GET as $key=>$val)
 		{
			if($i>0)
				$other_params.=",";
			$val = str_replace(" ","+",$val);
			$other_params.=$key.":"."'".$val."'";
			$i++;
		}
		$other_params = "{".$other_params.",";
	}
	else
	{
		$other_params = "{";
	}
	if($numrows > $size)
	{
		$total_pages 	= ceil($numrows / $size);
		$show 			= 10;
		$showing 		= !isset($page) ? 1 : $page;
		
		//$params			= "size=".$size;
		//echo $ajax_param;
		/*if($ajax_param)
			$firstlink		= $ajax_param.$other_params;
		else*/
		$firstlink	= "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		
// 		$sep_attach_with= (($other_params)?'&':'?');
		$seperator		= $other_params."pageNumber";
/*		$seperator 		= $sep_attach_with.'pageNumber='; */
		$baselink  		= $firstlink; 
		$pages 			=  pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $ajax_param, $numrows, $limit); 
	} 
	return $pages;
}

?>