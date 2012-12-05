<?php
function quickLink ($linkHref, $desc, $accessKey, $linkTitle) {

   $theLink = '<a href="'. $linkHref .'" title="'. $desc .'" accesskey="'. 
                   $accessKey .'">'. $linkTitle .' </a>';
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
        $prev  = quickLink ($firstlink, 'Previous', '', "< Previous ");
        else:
        $prev  = quickLink ($baselink . $seperator . ($showing - 1), 
        'Previous', 'z', "< Previous");
        endif;
    else:
        $prev  = '';
    endif; 

    $next  = ($showing + 1) <= $number ? 
    quickLink ($baselink . $seperator . ($showing + 1), 'Next', 'x', "  Next >") : '';

    if($number >= 1):
    $navi .= '<table cellpadding="0" cellspacing="0" border="0" class="pagingtable">
	      <tr>
	      <td><span class="strong">Page</span> '.$showing.' of '.$number.'</td>';

    $navi .='<td class="rightAlign">';

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
	$navi .='</td>';

// 	      <td class="rightAlign">&nbsp;
//             </td>
// 	  </tr>
// 	  </table>'

//         $tmp ='alert(this.value);window.location="http://google.com?id=+this.value"';

        //$tmp="javascript: document.frm.submit();";
// 	$navi .='</td>
// 	      <td class="rightAlign"><strong>Go to page</strong> 
//                 <form id="frm" name="frm">
// 		  <select name="pg_no" id="pg_no" class="selectbox" >';
//   
// 		    foreach (range($showing, $number) as $newnumber):
// 			$navi .= '<option value="'.$newnumber.'">'.$newnumber.'</option>'; 
// 		    endforeach;
// 
// 
// 	$navi  .='</select>
// 		<input type="button" value="go" onclick="'.$tmp.'" class="btn"/>
//               </form>
//             </td>
// 	  </tr>
// 	  </table>';

      endif;
        $navi1['min']=$showing;
        $navi1['max']=$number;
        $navi1['navi']=$navi;
	return $navi1;
}

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