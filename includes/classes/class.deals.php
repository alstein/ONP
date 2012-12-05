<?php
class deals extends DBTransact
{
    //Start to Get Group by featured deal OR Any one Group By Type Other deal
    function getCountGroupByMainDeals($isFeaturedOnly = 'yes')
    {
	global $date;

	$l_gByDl= ""; //1;
	$ordBy= "d.sizeorder";

	$tbl_gByDl="tbl_deal as d";

	if($isFeaturedOnly == 'yes')
	{
		//Start to Get Group by featured deal
		//$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND d.featured = 1 AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 3";
		$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 3";
		$ordBy= " d.featured DESC";
	}else
	{
		//if there is no any featured deal is set then show any other deal of group by type
		$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 3";
	}
	
	$arr_gByDl=$this->gj($tbl_gByDl,"d.*",$cnd_gByDl,$ordBy,"","",$l_gByDl,"");
	$count_gByDl=@mysql_num_rows($arr_gByDl);
	return $count_gByDl;
    }

    function getGroupByMainDeals($isFeaturedOnly = 'yes')
    {
	global $date, $currTime;

	$l_gByDl= ""; //1;
	$ordBy= "d.sizeorder";
	
	$tbl_gByDl="tbl_deal as d, tbl_dealtype as dt";

	if($isFeaturedOnly == 'yes')
	{
		//Start to Get Group by featured deal
		//$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND d.featured = 1 AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 3";
		$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = dt.typeid and dt.price_option = 'groupbuy'";
		$ordBy= " d.featured DESC";
	}else
	{
		//if there is no any featured deal is set then show any other deal of group by type
		$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = dt.typeid and dt.price_option = 'groupbuy'";
	}
	
	$arr_gByDl=$this->gj($tbl_gByDl,"d.*",$cnd_gByDl,$ordBy,"","",$l_gByDl,"");

	if($arr_gByDl != 'n')
	{
		$i=0;
		while($deal=@mysql_fetch_assoc($arr_gByDl))
		{
			$deal_ar[]=$deal;
		
			if($deal['deal_currency'] == 'euro')
				$curr_type = '&#8364;';
			else
				$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');
	
			$deal_ar[$i]['deal_currency_type'] = $curr_type;
		
			$deal_ar[$i]['groupbuy_price']=round($deal['groupbuy_price']);
			$deal_ar[$i]['orignal_price']=round($deal['orignal_price']);
			$deal_ar[$i]['discount']=$deal['quantity'];
			$deal_ar[$i]['saving']=round($deal['orignal_price']-$deal['groupbuy_price']);
		
			$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
			$qry_contri2 = @mysql_query($sql_contri2);
			$arr_contri2 = @mysql_fetch_assoc($qry_contri2);

			$totalPurQty = ($arr_contri2['sum_contribute']?$arr_contri2['sum_contribute']:0);

			/*$image1=$deal['small_image'];
			$image=explode(",",$image1);
			$deal_ar[$i]['small_image']=$image[0];
			
			$bimage1=$deal['big_image'];
			$bimage=explode(",",$bimage1);
			$deal_ar[$i]['big_image']=$bimage[0];
			$test=$arr_contri2['sum_contribute']+$deal['fake_user'];
			if($test >= $deal['max_buyer'])
			{  
				$test2=$test-$deal['max_buyer'];
				$total_contribution2=$test-$test2;
			}
			else
			{
				$total_contribution2=$arr_contri2['sum_contribute']+$deal['fake_user'];
			}
		
			if($total_contribution2 >= $deal['min_buyer'])
			{
				$deal_ar[$i]['total_buy']=1;
			} 
			if($total_contribution2 >= $deal['max_buyer'])
			{	
				$deal_ar[$i]['deal_flag1']=2;
			}
			$deal_ar[$i]['bought1']=$total_contribution2;*/
	
			/*$orignal_bucket_value2=$deal['max_buyer'];
			$complete2=($total_contribution2/$orignal_bucket_value2)*100;
			$total2=(100*$deal['min_buyer'])/$deal['max_buyer'];
			//$leftside=($total/100);
			$deal_ar[$i]['progress']=@round($complete2);
		
			$prog2 = ($deal_ar[$i]['progress']/100)*286;
			$left2 = ($total2/100)*286;
			$proleft2 = $left2-8;
			$deal_ar[$i]['min_bar']=$proleft2;
			$deal_ar[$i]['proleft3']=$left2;
			$deal_ar[$i]['proleft2']=$prog2;
			$pwidth2 = ($deal_ar[$i]['progress']/100)*286;
			$prowidth2 = 0+$pwidth1;
			$deal_ar[$i]['prowidth']=$prowidth2;*/
	
	
			////////////////////////////////////////////////////////
			$price_progressbar = "";
			$price_progressbarstage = 0;
			$price_progressbarGreenBar = 0;
			$price_progressbarGreenBarDevider = (($arr_contri2['sum_contribute'] > 0) ? $arr_contri2['sum_contribute'] : 0);
	
			//$price_progressbarGreenBar = round(((422/100)*$price_progressbarGreenBarDevider));
			
			$maxBuyer = $deal['max_buyer'];
			if($deal['range_1'] == "true" && $deal['range_2'] == "false" && $deal['range_3'] == "false" && $deal['range_4'] == "false" && $deal['range_5'] == "false")
			{
				$maxBuyer = $deal['max_buyer_1'];
				$price_progressbarstage = 1;
				//$price_progressbarGreenBar = 422;
			}
	
			if($deal['range_1'] == "true" && $deal['range_2'] == "true" && $deal['range_3'] == "false" && $deal['range_4'] == "false" && $deal['range_5'] == "false")
			{
				$maxBuyer = $deal['max_buyer_2'];
				$price_progressbarstage = 2;
				//$price_progressbarGreenBar = (422/2);
			}
	
			if($deal['range_1'] == "true" && $deal['range_2'] == "true" && $deal['range_3'] == "true" && $deal['range_4'] == "false" && $deal['range_5'] == "false")
			{
				$maxBuyer = $deal['max_buyer_3'];
				$price_progressbarstage = 3;
				//$price_progressbarGreenBar = (422/3);
			}
	
			if($deal['range_1'] == "true" && $deal['range_2'] == "true" && $deal['range_3'] == "true" && $deal['range_4'] == "true" && $deal['range_5'] == "false")
			{
				$maxBuyer = $deal['max_buyer_4'];
				$price_progressbarstage = 4;
				//$price_progressbarGreenBar = (422/4);
			}
	
			if($deal['range_1'] == "true" && $deal['range_2'] == "true" && $deal['range_3'] == "true" && $deal['range_4'] == "true" && $deal['range_5'] == "true")
			{
				$maxBuyer = $deal['max_buyer_5'];
				$price_progressbarstage = 5;
				//$price_progressbarGreenBar = (422/5);
			}

			$price_progressbarGreenBar = round(((422/$deal['max_buyer_'.$price_progressbarstage])*$price_progressbarGreenBarDevider));

			switch ($price_progressbarstage) {
					case "1":
						$price_progressbar = '<div class="fl priceprogress vspaceottop-1">
							<div class="blackbg rel">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="greenbg" width="'.$price_progressbarGreenBar.'"></td>
								</tr>
								</table>
								<div class="progressdivider" style="left:0px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['min_buyer_1'].' Brought</div>
								</div>
								
								<div class="progressdivider2">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical fr"></div>
								<div class="clr"></div>
								<div class="buyers">'.$deal['max_buyer_1'].'</div>
								</div>
							</div>	
						</div>';
						break;
					case "2":
						$price_progressbarDeviderWidth1 = round((422*$deal['max_buyer_1'])/$deal['max_buyer_2']);
						$price_progressbar = '<div class="fl priceprogress vspaceottop-1">
							<div class="blackbg rel">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="greenbg" width="'.$price_progressbarGreenBar.'"></td>
								</tr>
								</table>
								<div class="progressdivider" style="left:0px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['min_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth1.'px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_2'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_1'].' Brought</div>
								</div>
								
								<div class="progressdivider2">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_2'].'</div>
								<div class="vertical fr"></div>
								<div class="clr"></div>
								<div class="buyers">'.$deal['max_buyer_2'].'</div>
								</div>
							</div>	
						</div>';
						break;
					case "3":
						$price_progressbarDeviderWidth1 = round((422*$deal['max_buyer_1'])/$deal['max_buyer_3']);
						$price_progressbarDeviderWidth2 = round((422*$deal['max_buyer_2'])/$deal['max_buyer_3']);
						$price_progressbar = '<div class="fl priceprogress vspaceottop-1">
							<div class="blackbg rel">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="greenbg" width="'.$price_progressbarGreenBar.'"></td>
								</tr>
								</table>
								<div class="progressdivider" style="left:0px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['min_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth1.'px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_2'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth2.'px;">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_3'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_2'].' Brought</div>
								</div>
								
								<div class="progressdivider2">
								<div class="price1">'.$curr_type.' '.$deal['buy_price_3'].'</div>
								<div class="vertical fr"></div>
								<div class="clr"></div>
								<div class="buyers">'.$deal['max_buyer_3'].'</div>
								</div>
							</div>	
						</div>';
						break;
					case "4":
						$price_progressbarDeviderWidth1 = round((422*$deal['max_buyer_1'])/$deal['max_buyer_4']);
						$price_progressbarDeviderWidth2 = round((422*$deal['max_buyer_2'])/$deal['max_buyer_4']);
						$price_progressbarDeviderWidth3 = round((422*$deal['max_buyer_3'])/$deal['max_buyer_4']);
						$price_progressbar = '<div class="fl priceprogress vspaceottop-1">
							<div class="blackbg rel">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="greenbg" width="'.$price_progressbarGreenBar.'"></td>
								</tr>
								</table>
								<div class="progressdivider" style="left:0px;">
								<div class="price4">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['min_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth1.'px;">
								<div class="price4">'.$curr_type.' '.$deal['buy_price_2'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth2.'px;">
								<div class="price4">'.$curr_type.' '.$deal['buy_price_3'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_2'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth3.'px;">
								<div class="price4">'.$curr_type.' '.$deal['buy_price_4'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_3'].' Brought</div>
								</div>
								
								<div class="progressdivider2">
								<div class="price4">'.$curr_type.' '.$deal['buy_price_4'].'</div>
								<div class="vertical fr"></div>
								<div class="clr"></div>
								<div class="buyers">'.$deal['max_buyer_4'].'</div>
								</div>
							</div>	
						</div>';
						break;
					case "5":
						$price_progressbarDeviderWidth1 = round((422*$deal['max_buyer_1'])/$deal['max_buyer_5']);
						$price_progressbarDeviderWidth2 = round((422*$deal['max_buyer_2'])/$deal['max_buyer_5']);
						$price_progressbarDeviderWidth3 = round((422*$deal['max_buyer_3'])/$deal['max_buyer_5']);
						$price_progressbarDeviderWidth4 = round((422*$deal['max_buyer_4'])/$deal['max_buyer_5']);			$price_progressbar = '<div class="fl priceprogress vspaceottop-1">
							<div class="blackbg rel">
								<table border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td class="greenbg" width="'.$price_progressbarGreenBar.'"></td>
								</tr>
								</table>
								<div class="progressdivider" style="left:0px;">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_1'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['min_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth1.'px;">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_2'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_1'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth2.'px;">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_3'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_2'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth3.'px;">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_4'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_3'].'</div>
								</div>
								<div class="progressdivider" style="left:'.$price_progressbarDeviderWidth4.'px;">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_5'].'</div>
								<div class="vertical"></div>
								<div class="buyers" style="text-align:left">'.$deal['max_buyer_4'].' Brought</div>
								</div>
								
								<div class="progressdivider2">
								<div class="price5">'.$curr_type.' '.$deal['buy_price_5'].'</div>
								<div class="vertical fr"></div>
								<div class="clr"></div>
								<div class="buyers">'.$deal['max_buyer_5'].'</div>
								</div>
							</div>	
						</div>';
						break;
					default:
						$price_progressbar = "";
				}
			$deal_ar[$i]['price_progressbar'] = $price_progressbar;
			////////////////////////////////////////////////////////		
	
			//assign total deal purchased and no. of. deal can access.
			$deal_ar[$i]['maxQty'] = $maxBuyer;
			$deal_ar[$i]['totalPurQty'] = $totalPurQty;
			if(($maxBuyer-$totalPurQty)>0)
				$deal_ar[$i]['buyStatus'] = 'not sold';
			else
				$deal_ar[$i]['buyStatus'] = 'sold';
			/////////////////////////////////////////////////////////

			//get forum details as per deal
			$tbl2="tbl_forum f";
			$sf2="f.*";
			$ordeby="forumid DESC";
			$wf2 = array("f.deal_id");
			$wv2 = array($deal['deal_unique_id']);
			$rs2 = $this->cgs($tbl2, $sf2, $wf2, $wv2,$ordeby, "", "");
                        $row2=@mysql_fetch_assoc($rs2);
		
			$deal_ar[$i]['forumid']=$row2['forumid'];
			$deal_ar[$i]['end_date']=date("Y-m-d H:i:s",strtotime($deal['end_date']));

			//get reviews and rating details as per deal
			$avgRateForStar= $this->getTotalrating($deal['deal_unique_id']);
			$deal_ar[$i]['avgRateFillStar']=$avgRateForStar;
			$deal_ar[$i]['avgRateEmptyStar']=(5-$avgRateForStar);

			///////////////////////////////////////////////////////
			$clossingdate = $deal['end_date'];
			$clossingdate_array = explode(" ",$clossingdate);
			$date_array = explode("-",$clossingdate_array[0]);
			$time_array = explode(":",$clossingdate_array[1]);
			
			$year = $date_array[0];
			$month = $date_array[1];
			$day = $date_array[2];
		
			$hour = $time_array[0];
			$min = $time_array[1];
			$sec = $time_array[2];
		
			$timeDiff = "00:00:00:00";

			if($clossingdate){
				
				$timeDiff = getMyTimeDiff(date("j:H:i:s",$currTime),date("j:H:i:s",strtotime($clossingdate)));				
				$exp_timeDiff = explode(":",$timeDiff);

				$timeDiff_day = $exp_timeDiff[0];
				$timeDiff_hrs = $exp_timeDiff[1];
				$timeDiff_min =  $exp_timeDiff[2];
				$timeDiff_sec =  $exp_timeDiff[3];

				$dd_part_str = "";
				$dd_part = "$timeDiff_day";
				$dd_part_len = strlen($dd_part);
				for ($dd=0; $dd<$dd_part_len; $dd++)
				{
					$dd_part_str .= "<span>".($dd_part[$dd])."</span>";
				}

				$hh_part_str = "";
				$hh_part = "$timeDiff_hrs";
				$hh_part_len = strlen($hh_part);
				for ($hh=0; $hh<$hh_part_len; $hh++)
				{
					$hh_part_str .= "<span>".($hh_part[$hh])."</span>";
				}

				$mm_part_str = "";
				$mm_part = "$timeDiff_min";
				$mm_part_len = strlen($mm_part);
				for ($mm=0; $mm<$mm_part_len; $mm++)
				{
					$mm_part_str .= "<span>".($mm_part[$mm])."</span>";
				}

				$ss_part_str = "";
				$ss_part = "$timeDiff_sec";
				$ss_part_len = strlen($ss_part);
				for ($ss=0; $ss<$ss_part_len; $ss++)
				{
					$ss_part_str .= "<span>".($ss_part[$ss])."</span>";
				}
			}

			$deal_ar[$i]['year'] = $year;
			$deal_ar[$i]['month'] = $month;
			$deal_ar[$i]['day'] = $day;
			$deal_ar[$i]['hour'] = $hour;
			$deal_ar[$i]['min'] = $min;
			$deal_ar[$i]['sec'] = $sec;

			$deal_ar[$i]['timeDiff'] = $timeDiff;
			$deal_ar[$i]['timeDiff_day'] = $dd_part_str;
			$deal_ar[$i]['timeDiff_hrs'] = $hh_part_str;
			$deal_ar[$i]['timeDiff_min'] = $mm_part_str;
			$deal_ar[$i]['timeDiff_sec'] = $ss_part_str;

			$deal_ar[$i]['day_part_length'] = $dd_part_len;

			///////////////////////////////////////////////////////

			$i++;
		}

            	return $deal_ar;
	}
	return "noResult";
    }
    //End to Get Group by featured deal OR Any one Group By Type Other deal


    //Start to Get Group by featured deal OR Any one Group By Type Other deal
    function getCountGroupByAllOtherDeals()
    {
	global $date;

	$l_gByDlOth="";

	$i=0;
	
	$tbl_gByDlOth="tbl_deal as d";
	$cnd_gByDlOth="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 3";
	
	$arr_gByDlOth=$this->gj($tbl_gByDlOth,"d.*",$cnd_gByDlOth,"d.sizeorder DESC","","",$l_gByDlOth,"");
	$count_gByDlOth=@mysql_num_rows($arr_gByDlOth);

	return $count_gByDlOth;
    }

    function getGroupByAllOtherDeals()
    {
	global $date;

	$l_gByDlOth="";

	$i=0;
	
	$tbl_gByDlOth="tbl_deal as d, tbl_dealtype as dt";
	$cnd_gByDlOth="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = dt.typeid and price_option = 'groupbuy'";
	
	$arr_gByDlOth=$this->gj($tbl_gByDlOth,"d.*",$cnd_gByDlOth,"d.sizeorder DESC","","",$l_gByDlOth,"");
	
	if($arr_gByDlOth != 'n')
	{
		while($deal=@mysql_fetch_assoc($arr_gByDlOth))
		{
			$deal_ar_oth[]=$deal;

			if($deal['deal_currency'] == 'euro')
				$curr_type = '&#8364;';
			else
				$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');

			$deal_ar_oth[$i]['deal_currency_type'] = $curr_type;
	
			$deal_ar_oth[$i]['groupbuy_price']=round($deal['groupbuy_price']);
			$deal_ar_oth[$i]['orignal_price']=round($deal['orignal_price']);
			$deal_ar_oth[$i]['discount']=$deal['quantity'];
			$deal_ar_oth[$i]['saving']=round($deal['orignal_price']-$deal['groupbuy_price']);
	
			$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
			$qry_contri2 = @mysql_query($sql_contri2);
			$arr_contri2 = @mysql_fetch_assoc($qry_contri2);
			$image1=$deal['small_image'];
			$image=explode(",",$image1);
			$deal_ar_oth[$i]['small_image']=$image[0];
			
			$bimage1=$deal['big_image'];
			$bimage=explode(",",$bimage1);
			$deal_ar_oth[$i]['big_image']=$bimage[0];
			$test=$arr_contri2['sum_contribute']+$deal['fake_user'];
			if($test >= $deal['max_buyer'])
			{
				$test2=$test-$deal['max_buyer'];
				$total_contribution2=$test-$test2;
			}
			else
			{
				$total_contribution2=$arr_contri2['sum_contribute']+$deal['fake_user'];
			}
		
			if($total_contribution2 >= $deal['min_buyer'])
			{
				$deal_ar_oth[$i]['total_buy']=1;
			} 
			if($total_contribution2 >= $deal['max_buyer'])
			{	
				$deal_ar_oth[$i]['deal_flag1']=2;
			}
			$deal_ar_oth[$i]['bought1']=$total_contribution2;
			/*$orignal_bucket_value2=$deal['max_buyer'];
			$complete2=($total_contribution2/$orignal_bucket_value2)*100;
			$total2=(100*$deal['min_buyer'])/$deal['max_buyer'];
			//$leftside=($total/100);
			$deal_ar_oth[$i]['progress']=@round($complete2);
	
			$prog2 = ($deal_ar_oth[$i]['progress']/100)*286;
			$left2 = ($total2/100)*286;
			$proleft2 = $left2-8;
			$deal_ar_oth[$i]['min_bar']=$proleft2;
			$deal_ar_oth[$i]['proleft3']=$left2;
			$deal_ar_oth[$i]['proleft2']=$prog2;
			$pwidth2 = ($deal_ar_oth[$i]['progress']/100)*286;
			$prowidth2 = 0+$pwidth1;
			$deal_ar_oth[$i]['prowidth']=$prowidth2;*/
	
			$tbl2="tbl_forum f";
			$sf2="f.*";
			$wf2 = array("f.categoryid","f.deal_id");
			$wv2 = array(1,$deal['deal_unique_id']);
			$rs2 = $this->cgs($tbl2, $sf2, $wf2, $wv2, "", "", "");
			$row2=@mysql_fetch_assoc($rs2);
	
			$deal_ar_oth[$i]['forumid']=$row2['forumid'];
			$deal_ar_oth[$i]['end_date']=date("Y-m-d H:i:s",strtotime($deal['end_date']));

			//assign total deal purchased and no. of. deal can purchase.

// 			$sql = "select sum(deal_quantity) as totalQty from tbl_deal_payment where deal_id = ".$dealData['deal_unique_id'];
// 			$qry = @mysql_query($sql);
// 			$ar = @mysql_fetch_assoc($qry);
			
			if($deal['range_1'] == 'true'){
				if($deal['range_2'] == 'true'){
					if($deal['range_3'] == 'true'){
						if($deal['range_4'] == 'true'){
							if($deal['range_5'] == 'true'){
								$max_buyer = $deal['max_buyer_5'];
							}else
								$max_buyer = $deal['max_buyer_4'];
						}else
							$max_buyer = $deal['max_buyer_3'];
					}else
						$max_buyer = $deal['max_buyer_2'];
				}else
					$max_buyer = $deal['max_buyer_1'];
			}else
				$max_buyer = $deal['max_buyer'];


			$totalPurQty = ($arr_contri2['sum_contribute']?$arr_contri2['sum_contribute']:0);

			$deal_ar_oth[$i]['maxQty'] = $max_buyer;
			$deal_ar_oth[$i]['totalPurQty'] = $totalPurQty;
			if(($max_buyer-$totalPurQty)>0)
				$deal_ar_oth[$i]['buyStatus'] = 'not sold';
			else
				$deal_ar_oth[$i]['buyStatus'] = 'sold';

			/////////////////////////////////////////////////////////

			$i++;
		}
		return $deal_ar_oth;
	}
	return "noResult";
    }
    //End to Get Group by featured deal OR Any one Group By Type Other deal

   //----------------------------------------------------------------------

    //Start to Get Daily Deal featured deal OR Any one Daily Deal Type Other deal
    function getCountDailyMainDeals($isFeaturedDailyDlOnly = 'yes')
    {
	global $date;

	$l_dailyDl= ""; //1;
	$ordBy= "d.sizeorder";
	
	$tbl_dailyDl="tbl_deal as d";

	if($isFeaturedDailyDlOnly == 'yes')
	{
		//Start to Get Daily featured deal
		//$cnd_dailyDl="(start_date <='$date' AND end_date >= '$date') AND d.featured = 1 AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 1";
		$cnd_dailyDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 1";

		$ordBy=" d.featured DESC";
	}else
	{
		//if there is no any featured deal is set then show any other deal of Daily Deal type
		$cnd_dailyDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 1";
	}
	
	$arr_dailyDl=$this->gj($tbl_dailyDl,"d.*",$cnd_dailyDl,$ordBy,"","",$l_dailyDl,"");
	$count_dailyDl=@mysql_num_rows($arr_dailyDl);
	return $count_dailyDl;
    }

    function getDailyMainDeals($isFeaturedDailyDlOnly = 'yes')
    {
	global $date;

	$l_dailyDl= ""; //1;
	$ordBy= "d.sizeorder";
	
	$tbl_dailyDl="tbl_deal as d, tbl_dealtype as dt";

	if($isFeaturedDailyDlOnly == 'yes')
	{
		//Start to Get Daily featured deal
		$cnd_dailyDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type != 2 and d.deal_main_type = dt.typeid and dt.price_option != 'groupbuy'";

		$ordBy = " d.featured DESC";
	}else
	{
		//if there is no any featured deal is set then show any other deal of Daily Deal type
		$cnd_dailyDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type != 2 and d.deal_main_type = dt.typeid and dt.price_option != 'groupbuy'";
	}
	
	$arr_dailyDl=$this->gj($tbl_dailyDl,"d.*",$cnd_dailyDl,$ordBy,"","",$l_dailyDl,"");
	
	if($arr_dailyDl != 'n')
	{
		$i=0;
		while($deal=@mysql_fetch_assoc($arr_dailyDl))
		{
		
			$deal_ar[]=$deal;
	
			if($deal['deal_currency'] == 'euro')
				$curr_type = '&#8364;';
			else
				$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');
		
			$deal_ar[$i]['deal_currency_type'] = $curr_type;
		
			$deal_ar[$i]['groupbuy_price']=round($deal['groupbuy_price']);
			$deal_ar[$i]['orignal_price']=round($deal['orignal_price']);
			$deal_ar[$i]['discount']=$deal['quantity'];
			$deal_ar[$i]['saving']=round($deal['orignal_price']-$deal['groupbuy_price']);
		
			$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
			$qry_contri2 = @mysql_query($sql_contri2);
			$arr_contri2 = @mysql_fetch_assoc($qry_contri2);

			$totalPurQty = ($arr_contri2['sum_contribute']?$arr_contri2['sum_contribute']:0);

			$image1=$deal['small_image'];
			$image=explode(",",$image1);
			$deal_ar[$i]['small_image']=$image[0];
			
			$bimage1=$deal['big_image'];
			$bimage=explode(",",$bimage1);
			$deal_ar[$i]['big_image']=$bimage[0];
			$test=$arr_contri2['sum_contribute']+$deal['fake_user'];
			if($test >= $deal['max_buyer'])
			{  
				$test2=$test-$deal['max_buyer'];
				$total_contribution2=$test-$test2;
			}
			else
			{
				$total_contribution2=$arr_contri2['sum_contribute']+$deal['fake_user'];
			}
		
			if($total_contribution2 >= $deal['min_buyer'])
			{
				$deal_ar[$i]['total_buy']=1;
			} 
			if($total_contribution2 >= $deal['max_buyer'])
			{	
				$deal_ar[$i]['deal_flag1']=2;
			}
			$deal_ar[$i]['bought1']=$total_contribution2;
			/*$orignal_bucket_value2=$deal['max_buyer'];
			$complete2=($total_contribution2/$orignal_bucket_value2)*100;
			$total2=(100*$deal['min_buyer'])/$deal['max_buyer'];
			//$leftside=($total/100);
			$deal_ar[$i]['progress']=@round($complete2);
		
			$prog2 = ($deal_ar[$i]['progress']/100)*286;
			$left2 = ($total2/100)*286;
			$proleft2 = $left2-8;
			$deal_ar[$i]['min_bar']=$proleft2;
			$deal_ar[$i]['proleft3']=$left2;
			$deal_ar[$i]['proleft2']=$prog2;
			$pwidth2 = ($deal_ar[$i]['progress']/100)*286;
			$prowidth2 = 0+$pwidth1;
			$deal_ar[$i]['prowidth']=$prowidth2;*/
		
			$tbl2="tbl_forum f";
			$sf2="f.*";
			$wf2 = array("f.categoryid","f.deal_id");
			$wv2 = array(1,$deal['deal_unique_id']);
			$rs2 = $this->cgs($tbl2, $sf2, $wf2, $wv2, "", "", "");
			$row2=@mysql_fetch_assoc($rs2);
		
			$deal_ar[$i]['forumid']=$row2['forumid'];
			$deal_ar[$i]['end_date']=date("Y-m-d H:i:s",strtotime($deal['end_date']));

			///////////////////////////////////////////////////////
			$clossingdate = $deal['end_date'];
			$clossingdate_array = explode(" ",$clossingdate);
			$date_array = explode("-",$clossingdate_array[0]);
			$time_array = explode(":",$clossingdate_array[1]);
			
			$year = $date_array[0];
			$month = $date_array[1];
			$day = $date_array[2];
		
			$hour = $time_array[0];
			$min = $time_array[1];
			$sec = $time_array[2];
		
			$timeDiff = "00:00:00:00";

			if($clossingdate){
				
				$timeDiff = getMyTimeDiff(date("j:H:i:s",$currTime),date("j:H:i:s",strtotime($clossingdate)));				
				$exp_timeDiff = explode(":",$timeDiff);

				$timeDiff_day = $exp_timeDiff[0];
				$timeDiff_hrs = $exp_timeDiff[1];
				$timeDiff_min =  $exp_timeDiff[2];
				$timeDiff_sec =  $exp_timeDiff[3];

				$dd_part_str = "";
				$dd_part = "$timeDiff_day";
				$dd_part_len = strlen($dd_part);
				for ($dd=0; $dd<$dd_part_len; $dd++)
				{
					$dd_part_str .= "<span>".($dd_part[$dd])."</span>";
				}

				$hh_part_str = "";
				$hh_part = "$timeDiff_hrs";
				$hh_part_len = strlen($hh_part);
				for ($hh=0; $hh<$hh_part_len; $hh++)
				{
					$hh_part_str .= "<span>".($hh_part[$hh])."</span>";
				}

				$mm_part_str = "";
				$mm_part = "$timeDiff_min";
				$mm_part_len = strlen($mm_part);
				for ($mm=0; $mm<$mm_part_len; $mm++)
				{
					$mm_part_str .= "<span>".($mm_part[$mm])."</span>";
				}

				$ss_part_str = "";
				$ss_part = "$timeDiff_sec";
				$ss_part_len = strlen($ss_part);
				for ($ss=0; $ss<$ss_part_len; $ss++)
				{
					$ss_part_str .= "<span>".($ss_part[$ss])."</span>";
				}
			}

			$deal_ar[$i]['year'] = $year;
			$deal_ar[$i]['month'] = $month;
			$deal_ar[$i]['day'] = $day;
			$deal_ar[$i]['hour'] = $hour;
			$deal_ar[$i]['min'] = $min;
			$deal_ar[$i]['sec'] = $sec;

			$deal_ar[$i]['timeDiff'] = $timeDiff;
			$deal_ar[$i]['timeDiff_day'] = $dd_part_str;
			$deal_ar[$i]['timeDiff_hrs'] = $hh_part_str;
			$deal_ar[$i]['timeDiff_min'] = $mm_part_str;
			$deal_ar[$i]['timeDiff_sec'] = $ss_part_str;

			$deal_ar[$i]['day_part_length'] = $dd_part_len;

			///////////////////////////////////////////////////////
			$maxBuyer = $deal['max_buyer'];
			//assign total deal purchased and no. of. deal can access.
			$deal_ar[$i]['maxQty'] = $maxBuyer;
			$deal_ar[$i]['totalPurQty'] = $totalPurQty;
			if(($maxBuyer-$totalPurQty)>0)
				$deal_ar[$i]['buyStatus'] = 'not sold';
			else
				$deal_ar[$i]['buyStatus'] = 'sold';
			/////////////////////////////////////////////////////////
			
			$i++;
		}
            	return $deal_ar;
	}
	return "noResult";
    }
    //End to Get Daily Deal featured deal OR Any one Daily Deal Type Other deal

    function getAffiliateMainDeals($isFeaturedDailyDlOnly = 'yes')
    {
	global $date;

	$l_dailyDl= "0,2"; //1;
	$ordBy= "d.added_date";
	
	$tbl_dailyDl="tbl_deal_affiliate as d";

	if($isFeaturedDailyDlOnly == 'yes')
	{
		//Start to Get Daily featured deal
		$cnd_dailyDl="(dValidFrom <='$date' AND dValidTo >= '$date') AND d.status='Active'";

		$ordBy = " d.featured DESC";
	}else
	{
		//if there is no any featured deal is set then show any other deal of Daily Deal type
		$cnd_dailyDl="(dValidFrom <='$date' AND dValidTo >= '$date') and d.status='Active'";
	}
	
	$arr_dailyDl=$this->gj($tbl_dailyDl,"d.*",$cnd_dailyDl,$ordBy,"","",$l_dailyDl,"");
	
	if($arr_dailyDl != 'n')
	{
		$i=0;
		while($deal=@mysql_fetch_assoc($arr_dailyDl))
		{
		
			$deal_ar[]=$deal;
	
			if($deal['sCurrency'] == 'euro')
				$curr_type = '&#8364;';
			else
				$curr_type = (($deal['sCurrency'] == 'GBP') ? '&#163;' : '$');
		
			$deal_ar[$i]['deal_currency_type'] = $curr_type;
		
			$deal_ar[$i]['groupbuy_price']=round($deal['fPrice']);
			$deal_ar[$i]['orignal_price']=round($deal['fRrpPrice']);
			$deal_ar[$i]['discount']=round(100-(round($deal['fPrice'])*100/round($deal['fRrpPrice'])));
			$deal_ar[$i]['saving']=round($deal['fRrpPrice']-$deal['fPrice']);

			$deal_ar[$i]['small_image']=$deal['sAwImageUrl'];
			$deal_ar[$i]['big_image']=$deal['sMerchantImageUrl'];
			
			///////////////////////////////////////////////////////
			$clossingdate = $deal['dValidTo'];
			$clossingdate_array = explode(" ",$clossingdate);
			$date_array = explode("-",$clossingdate_array[0]);
			$time_array = explode(":",$clossingdate_array[1]);
			
			$year = $date_array[0];
			$month = $date_array[1];
			$day = $date_array[2];
		
			$hour = $time_array[0];
			$min = $time_array[1];
			$sec = $time_array[2];
		
			$timeDiff = "00:00:00:00";

			if($clossingdate){
				
				$timeDiff = getMyTimeDiff(date("j:H:i:s",$currTime),date("j:H:i:s",strtotime($clossingdate)));				
				$exp_timeDiff = explode(":",$timeDiff);

				$timeDiff_day = $exp_timeDiff[0];
				$timeDiff_hrs = $exp_timeDiff[1];
				$timeDiff_min =  $exp_timeDiff[2];
				$timeDiff_sec =  $exp_timeDiff[3];

				$dd_part_str = "";
				$dd_part = "$timeDiff_day";
				$dd_part_len = strlen($dd_part);
				for ($dd=0; $dd<$dd_part_len; $dd++)
				{
					$dd_part_str .= "<span>".($dd_part[$dd])."</span>";
				}

				$hh_part_str = "";
				$hh_part = "$timeDiff_hrs";
				$hh_part_len = strlen($hh_part);
				for ($hh=0; $hh<$hh_part_len; $hh++)
				{
					$hh_part_str .= "<span>".($hh_part[$hh])."</span>";
				}

				$mm_part_str = "";
				$mm_part = "$timeDiff_min";
				$mm_part_len = strlen($mm_part);
				for ($mm=0; $mm<$mm_part_len; $mm++)
				{
					$mm_part_str .= "<span>".($mm_part[$mm])."</span>";
				}

				$ss_part_str = "";
				$ss_part = "$timeDiff_sec";
				$ss_part_len = strlen($ss_part);
				for ($ss=0; $ss<$ss_part_len; $ss++)
				{
					$ss_part_str .= "<span>".($ss_part[$ss])."</span>";
				}
			}

			$deal_ar[$i]['year'] = $year;
			$deal_ar[$i]['month'] = $month;
			$deal_ar[$i]['day'] = $day;
			$deal_ar[$i]['hour'] = $hour;
			$deal_ar[$i]['min'] = $min;
			$deal_ar[$i]['sec'] = $sec;

			$deal_ar[$i]['timeDiff'] = $timeDiff;
			$deal_ar[$i]['timeDiff_day'] = $dd_part_str;
			$deal_ar[$i]['timeDiff_hrs'] = $hh_part_str;
			$deal_ar[$i]['timeDiff_min'] = $mm_part_str;
			$deal_ar[$i]['timeDiff_sec'] = $ss_part_str;

			$deal_ar[$i]['day_part_length'] = $dd_part_len;


			///////////////////////////////////////////////////////

			$boughtCount = 0;
			$bought_res = $this->customqry("select sum(count) countsum from tbl_affiliate_deal_user_count where d_c_id = (select d_c_id from tbl_affiliate_deal_count where iId=".$deal['iId'].")", "");
			if($bought_row = @mysql_fetch_assoc($bought_res))
			{
				$boughtCount = $bought_row['countsum'];
			}

			///////////////////////////////////////////////////////

			///////////////////////////////////////////////////////

			$deal_ar[$i]['totalPurQty'] = $totalPurQty;
			$deal_ar[$i]['buyStatus'] = 'not sold';
			$deal_ar[$i]['dealFormat'] = 'Affiliate';
			$deal_ar[$i]['qr_code_link'] = $deal['sAwDeepLink'];
			$deal_ar[$i]['subtitle'] = "<br>".$deal['sName'];
			$deal_ar[$i]['bought1'] = $boughtCount;

			///////////////////////////////////////////////////////

			$i++;
		}
		return $deal_ar;
	}
	return "noResult";
    }
    //End to Get Affiliate Deal featured deal OR Any one Affiliate Deal Type Other deal

    //Start to Get Group by featured deal OR Any one Group By Type Other deal
    function getCountDailyAllOtherDeals()
    {
	global $date;

	$l_dailyDlOth="";

	$i=0;
	
	$tbl_dailyDlOth="tbl_deal as d";
	$cnd_dailyDlOth="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type = 1";
	
	$arr_dailyDlOth=$this->gj($tbl_dailyDlOth,"d.*",$cnd_dailyDlOth,"d.sizeorder DESC","","",$l_dailyDlOth,"");
	$count_dailyDlOth=@mysql_num_rows($arr_dailyDlOth);

	return $count_dailyDlOth;
    }

    function getDailyAllOtherDeals()
    {
	global $date;

	$l_dailyDlOth="";

	$i=0;
	
	$tbl_dailyDlOth="tbl_deal as d, tbl_dealtype as dt";
	$cnd_dailyDlOth="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and d.deal_main_type != 2 and d.deal_main_type = dt.typeid and dt.price_option != 'groupbuy'";
	
	$arr_dailyDlOth=$this->gj($tbl_dailyDlOth,"d.*",$cnd_dailyDlOth,"d.sizeorder DESC","","",$l_dailyDlOth,"");
	
	if($arr_dailyDlOth != 'n')
	{
		while($deal=@mysql_fetch_assoc($arr_dailyDlOth))
		{
			$deal_ar_oth[]=$deal;

			if($deal['deal_currency'] == 'euro')
				$curr_type = '&#8364;';
			else
				$curr_type = (($deal['deal_currency'] == 'pound') ? '&#163;' : '$');

			$deal_ar_oth[$i]['deal_currency_type'] = $curr_type;
	
			$deal_ar_oth[$i]['groupbuy_price']=round($deal['groupbuy_price']);
			$deal_ar_oth[$i]['orignal_price']=round($deal['orignal_price']);
			$deal_ar_oth[$i]['discount']=$deal['quantity'];
			$deal_ar_oth[$i]['saving']=round($deal['orignal_price']-$deal['groupbuy_price']);
	
			$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
			$qry_contri2 = @mysql_query($sql_contri2);
			$arr_contri2 = @mysql_fetch_assoc($qry_contri2);

			$totalPurQty = ($arr_contri2['sum_contribute']?$arr_contri2['sum_contribute']:0);

			$image1=$deal['small_image'];
			$image=explode(",",$image1);
			$deal_ar_oth[$i]['small_image']=$image[0];
			
			$bimage1=$deal['big_image'];
			$bimage=explode(",",$bimage1);
			$deal_ar_oth[$i]['big_image']=$bimage[0];
			$test=$arr_contri2['sum_contribute']+$deal['fake_user'];
			if($test >= $deal['max_buyer'])
			{  
				$test2=$test-$deal['max_buyer'];
				$total_contribution2=$test-$test2;
			}
			else
			{
				$total_contribution2=$arr_contri2['sum_contribute']+$deal['fake_user'];
			}
		
			if($total_contribution2 >= $deal['min_buyer'])
			{
				$deal_ar_oth[$i]['total_buy']=1;
			} 
			if($total_contribution2 >= $deal['max_buyer'])
			{	
				$deal_ar_oth[$i]['deal_flag1']=2;
			}
			$deal_ar_oth[$i]['bought1']=$total_contribution2;
			/*$orignal_bucket_value2=$deal['max_buyer'];
			$complete2=($total_contribution2/$orignal_bucket_value2)*100;
			$total2=(100*$deal['min_buyer'])/$deal['max_buyer'];
			//$leftside=($total/100);
			$deal_ar_oth[$i]['progress']=@round($complete2);
	
			$prog2 = ($deal_ar_oth[$i]['progress']/100)*286;
			$left2 = ($total2/100)*286;
			$proleft2 = $left2-8;
			$deal_ar_oth[$i]['min_bar']=$proleft2;
			$deal_ar_oth[$i]['proleft3']=$left2;
			$deal_ar_oth[$i]['proleft2']=$prog2;
			$pwidth2 = ($deal_ar_oth[$i]['progress']/100)*286;
			$prowidth2 = 0+$pwidth1;
			$deal_ar_oth[$i]['prowidth']=$prowidth2;*/
	
			$tbl2="tbl_forum f";
			$sf2="f.*";
			$wf2 = array("f.categoryid","f.deal_id");
			$wv2 = array(1,$deal['deal_unique_id']);
			$rs2 = $this->cgs($tbl2, $sf2, $wf2, $wv2, "", "", "");
			$row2=@mysql_fetch_assoc($rs2);
	
			$deal_ar_oth[$i]['forumid']=$row2['forumid'];
			$deal_ar_oth[$i]['end_date']=date("Y-m-d H:i:s",strtotime($deal['end_date']));

			///////////////////////////////////////////////////////
			$maxBuyer = $deal['max_buyer'];
			//assign total deal purchased and no. of. deal can access.
			$deal_ar_oth[$i]['maxQty'] = $maxBuyer;
			$deal_ar_oth[$i]['totalPurQty'] = $totalPurQty;
			if(($maxBuyer-$totalPurQty)>0)
				$deal_ar_oth[$i]['buyStatus'] = 'not sold';
			else
				$deal_ar_oth[$i]['buyStatus'] = 'sold';
			/////////////////////////////////////////////////////////

			$i++;
		}
		return $deal_ar_oth;
	}
	return "noResult";
    }
    //End to Get Group by featured deal OR Any one Group By Type Other deal

    //Get the total rating of deal/////
        function getTotalrating($deal_id)
        {
                $sqlrat_tot="SELECT rating_id FROM tbl_rating where deal_id=$deal_id";
                $rowrat_tot=mysql_query($sqlrat_tot)or die(mysql_error());
                $countRatQues = 0;
                $totalRatMark = 0;
                while($recrat_tot=mysql_fetch_assoc($rowrat_tot))
                {
                     $sqlavg ="SELECT sum(rating_mark) as ratmrksum,count(id) as quecount FROM tbl_detailed_rating WHERE rating_id =".$recrat_tot['rating_id'];
                     $rowavg=mysql_query($sqlavg)or die(mysql_error());
                     $recavg=mysql_fetch_assoc($rowavg);
                     $countRatQues += $recavg['quecount'];
                     $totalRatMark += $recavg['ratmrksum'];
                }
                $avgRating = 0;
                if($countRatQues > 0)
                {
                    $avgRating = round($totalRatMark/$countRatQues);
                }
                return $avgRating;
        }
   //----------------------------------------------------------------------

	function getDealById($dealId = 0)
	{
		global $date;
		
		$l_gByDl=1;
		
		$tbl_gByDl="tbl_deal as d";
		
		$cnd_gByDl="(start_date <='$date' AND end_date >= '$date') AND admin_approve ='yes' and deal_status = 1 and d.status='Active' and deal_unique_id =".$dealId;
		
		$arr_gByDl=$this->gj($tbl_gByDl,"d.*",$cnd_gByDl,"","","",$l_gByDl,"");
		$count_gByDl=@mysql_num_rows($arr_gByDl);
		if($count_gByDl > 0)
		{
			$row_gByDl=@mysql_fetch_assoc($arr_gByDl);

			if($row_gByDl['deal_currency'] == 'pound')
			{
				$row_gByDl['currency_type'] = '&#163;';
			}else if($row_gByDl['deal_currency'] == 'euro')
			{
				$row_gByDl['currency_type'] = '&#8364;';
			}else
			{
				$row_gByDl['currency_type'] = '&#x24;';
			}

			$row_gByDl['groupbuy_price_with_delivery_cost'] = number_format(((double)$row_gByDl['groupbuy_price']) + ((double)$row_gByDl['sub_delivery_cost']), 2, '.', '');
		}

		return $row_gByDl;
	}
}
$dealsObj = new deals();
?>