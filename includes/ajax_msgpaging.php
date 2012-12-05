<?php
function quickLnk ($linkHref, $desc, $accessKey, $linkTitle,$class,$show,$showing, $ajax_params) 
{
	if($ajax_params!='')
	{
		$arr_linkHref = explode('?',$linkHref);
		$linkHref = $arr_linkHref[0];
		$req_params = $arr_linkHref[1];

		$ajax_fun="javascript:ajaxPaging('$linkHref',$req_params,$ajax_params)";
		$lnk = "href='javascript:void(0)' onClick=".$ajax_fun;
	}	
	else
	{
		$arr_linkHref = explode('-',$linkHref);
		
		$linkHref = $arr_linkHref[0];
		$req_params = $arr_linkHref[1];

		$cnvt_param = substr($req_params,1,(strlen($req_params)-2));
		$req_params = str_replace(":","=",$cnvt_param);
		$lnk = "href='". $linkHref ."?".$req_params."'";
	}

	if($linkTitle=="Next" || $linkTitle == "Previous")
	{
		$theLink = '<a '.$lnk.' title="'. $desc .'" accesskey="'. $accessKey .'"  class="'.$class .'"  >'. $linkTitle .'</a>';

	}
	else
	{
		$class = (($linkTitle==$showing)?'seleted':'');
		if($linkTitle=="Next")
		{
			$theLink = '<a '.$lnk.' title="'. $desc .'" accesskey="'. $accessKey .'"  class="'.$class .'"  >'. $linkTitle .'</a>';
	
		}
		else if($linkTitle !="Page of {$desc}")
		{
			$theLink .='<a '.$lnk.' title="'. $desc .'"  accesskey="'.$accessKey .'" class="'.$class.'"  >'. $linkTitle .'</a> | ';
		}
		else
		{
			$theLink .='<a '.$lnk.' title="'. $desc .'"  accesskey="'.$accessKey .'" class="'.$class.'" >'. $linkTitle .'</a>  ';
		}
	}

	return $theLink;
}


function pagination($number, $show, $showing, $firstlink, $baselink, $seperator, $ajax_params, $numrows, $limit) 
{
	$no_display = explode(",",$limit);
	$start_no = $no_display[0];
	if(($start_no + $no_display[1])<$numrows)
		$end_no = $start_no + $no_display[1];
	else
		$end_no = $numrows;

	$disp = floor($show / 2);
	$showing;
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
	{
		$prev  = quickLnk ($firstlink."?".$seperator.":".($showing - 1)."}", 'Previous', '', 'Previous','',$show,$showing, $ajax_params);
	}
	else:
		$prev  = quickLnk ($baselink."?".$seperator.":".($showing - 1)."}",  'Previous', 'z', 'Previous','',$show,$showing, $ajax_params);
	endif;
	else:
		$prev  = 'Previous';
	endif; 

	$next  = ($showing + 1) <= $number ? 
	quickLnk ($baselink."?".$seperator.":".($showing + 1)."}", 'Next', 'x', 'Next ','',$show,$showing, $ajax_params) : 'Next';

	if ( $_SERVER['REQUEST_URI'] == $firstlink ):
		$first = '<span class="sel">First Page</span>';
	else:
		$first = quickLnk ($firstlink, 'First Page', '', 'First Page','seleted',$show,$showing, $ajax_params);
	endif;

	if ( $showing == $number ):
		$last = '<span class="sel">Last Page</span>';
	else:
		$last = quickLnk ($baselink."?".$seperator.":".$number."}", 'Last Page', '', 'Last Page','seleted',$show,$showing, $ajax_params);
	endif;
	

	$navi .= '<table cellpadding="0" cellspacing="0" border="0" class="pagingtable">
	      <tr>
	      <td><span class="strong">Page</span> '.$showing.' of '.$number.'</td>';

	$navi .='<td class="cenerAlign">&lt'.' '. $prev ." ";

	
	// loop through the numbers
	if($number > 5 )
	{
		if($number >= $showing && $showing > 3 )
		{
			$navi.= quickLnk ($baselink."?".$seperator.":1}", '', '','1'.'....','seleted',$show,$showing, $ajax_params);
		}
	}
	

	foreach (range($low, $high) as $newnumber):
		if($newnumber < 0)
			continue;
		$link = ( $newnumber == 1 ) ? $firstlink."?".$seperator.":1}" :
		$baselink."?".$seperator.":".$newnumber."}";
		if ($newnumber > $number):
			$navi .= '';
		elseif ($newnumber == 0):
			$navi .= '';
		else:
			$navi .= ($newnumber == $showing ) ? 
			' '. quickLnk ($link, 'Page '. $newnumber, '', $newnumber,'seleted',$show,$showing, $ajax_params) .' '."" :
			' '. quickLnk ($link, 'Page '. $newnumber, '', $newnumber,'seleted',$show,$showing, $ajax_params)."";
		endif;
	endforeach; 

	if( $number > 5 )
	{
		if($number!=$showing && $number-1!=$showing && $number-2!=$showing  )
		{
			$navi.= quickLnk ($baselink."?".$seperator.":".$number."}", '', '','.....'.$number,'seleted',$show,$showing, $ajax_params);
		}
	}

	$navi=substr($navi,0,-2);

	$navi .= ' '. $next ." &gt";

// 	$navi .='</td>
// 	      <td class="rightAlign"><strong>Go to page</strong> 
//                 <select><option></option></select>
//                 <input type="button" value="go" class="btn" />
//             </td>
// 	  </tr>
// 	  </table>';
	$navi .='</td>
	      <td class="rightAlign">&nbsp;
            </td>
	  </tr>
	  </table>';

	return $navi;
}

$page	= (($_REQUEST['pageNumber']) ? $_REQUEST['pageNumber'] : '1');

function page_limit($size)
{
	global $page;
	//echo $page.$size;
	$StartRow 	= $size * ($page-1);
	$l 			= $StartRow.','.$size;
	return $l;
}
function page_limits($size)
{
	global $page;
	//echo $page.$size;
	$StartRow 	= $size * ($page-1);
	$l 			= ($StartRow+2).','.$size;
	return $l;
}
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
		$show 		= 10;
		$showing 	= !isset($page) ? 1 : $page;
		$firstlink	= "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$seperator	= $other_params."pageNumber";
		$baselink  	= $firstlink; 
		$pages 		=  pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $ajax_param, $numrows, $limit); 
	} 
	return $pages;
}
?>