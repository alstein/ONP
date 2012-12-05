<?php
	function getErrorMessage($emid){
		global $dbObj;
		if($emid > 0){
			$rs = $dbObj->cgs("mast_error_messages", "emessage", "emid",$emid, "", "", "");
			$row = @mysql_fetch_object($rs);
			return $row->emessage;
		}
	}
function getFrontErrorMessage($emid){
		global $dbObj;
		if($emid > 0){
			$rs = $dbObj->cgs("mast_front_error_messages", "emessage", "emid",$emid, "", "", "");
			$row = @mysql_fetch_object($rs);
			return $row->emessage;
		}
	}

	function getDataFromTable($tableName,$selectFields,$where){
		$row = array();
		$query = "select ".$selectFields." from ".$tableName." where ".$where;
		$res = mysql_query($query);
		$row = @mysql_fetch_assoc($res);
		return $row;
	}

	function getUserData($userid=0){
		$userid = ($userid?$userid:($_SESSION['csUserId']?$_SESSION['csUserId']:0));
		if($userid > 0){
			$query = "select * from tbl_users where userid=".$userid;
			$res = mysql_query($query);
			return @mysql_fetch_object($res);
		}
	}

	function getDealFromId($dealid=0){
		if($dealid > 0){
			$query = "select * from tbl_product where product_id=".$dealid;
			$res = mysql_query($query);
			return @mysql_fetch_object($res);
		}
	}

	function defaultDealCountCityState($city=''){

		$city=($city?$city:$_SESSION['default_city_name']);

		$_query = "select count(product_id) as cnt,product_city from tbl_product where product_city='".trim($city)."' and deal_status=0 and isSoldOut=0 group by product_city";
		$_res = mysql_query($_query);
		$_result = @mysql_fetch_assoc($_res);

		$Deal_count_Default_City = $_result['cnt'];

		$__query = "select ms.code,mc.state_id,ms.state_name from mast_state as ms,mast_city as mc where mc.state_id=ms.id and mc.city_name='".trim($city)."'";
		$__res = mysql_query($__query);
		$__result = mysql_fetch_assoc($__res);

		$Deal_State = $__result['code'];
		$DealInfo=array("dealcount"=>$Deal_count_Default_City,"city"=>$city,"code"=>$Deal_State);
		return $DealInfo;
	}

	function getDealIdForTodaysBargains(){
		global $currentTime;
		if(!$_SESSION['deal_product_id']){
			if($_SESSION['default_city_name']){
				$query = "select product_id 
							from tbl_product as p where p.deal_start_date <='".$currentTime."' AND p.deal_end_date >= '".$currentTime."' and lower(p.product_city) = lower('".$_SESSION['default_city_name']."') and isDefault=1";
				$res = mysql_query($query);
				$num = @mysql_num_rows($res);
				if($num > 0){
					$row = mysql_fetch_object($res);
					$_SESSION['deal_product_id'] = $row->product_id;
				}else{
					$query = "select product_id 
							from 
									tbl_product as p 
							where p.deal_start_date <='".$currentTime."' 
									AND p.deal_end_date >= '".$currentTime."' 
									and lower(p.product_city) = lower('".$_SESSION['default_city_name']."')";

					$res = mysql_query($query);
					$row = mysql_fetch_object($res);
					$_SESSION['deal_product_id'] = $row->product_id;
				}
			}
		}
	}

	function countUserDeals($isGift=0,$product_id=0,$userid=0){
		$userid = ($userid?$userid:($_SESSION['csUserId']?$_SESSION['csUserId']:0));

		if($userid > 0 && $isGift == 0 && $product_id > 0){
			$sql = "select sum(deal_quantity) as totalQty,sum(deal_price) as totalPrice from tbl_deal_payment where deal_id = ".$product_id." and user_id = ".$userid;
			$qry = @mysql_query($sql);
			$ar = @mysql_fetch_assoc($qry);

			return $totalQty = $ar['totalQty'];
		}
		if($userid > 0 && $isGift == 1 && $product_id > 0){
			$queryCountUserGiftedDeals = "select sum(deal_quantity) as totalQty from tbl_deal_payment where deal_id = ".$product_id." and user_id = ".$userid." and isGiftDeal=1";
			$resCountUserGiftedDeals = @mysql_query($queryCountUserGiftedDeals);
			$rowCountUserGiftedDeals = @mysql_fetch_assoc($resCountUserGiftedDeals);
			return $numCountUserGiftedDeals = $rowCountUserGiftedDeals['totalQty'];
		}
	}


	function sendDailyBargainEmail($product_id,$emailid,$nuid){

		$___query = "select * from tbl_product as p where p.product_id=".$product_id;
		$___res = mysql_query($___query);
		$_row = @mysql_fetch_assoc($___res);
		if($_row){ 
			$yourPrice = ($_row['product_act_price'] - ($_row['product_act_price']*$_row['product_disc_price']/100));
			$yourPrice = round($yourPrice);
			$youSave = ($_row['product_act_price']*$_row['product_disc_price']/100);
			$youSave = round($youSave);
			$aboutDeal = html_entity_decode($_row['product_description']);
			$redeemAt = $_row['redeemat'];

			$dealCountDefaultCity = defaultDealCountCityState();

			$dealURL = SITEROOT."/deal/".$product_id;

			$deal_img_path = SITEROOT."/display_image.php?path=uploads/product/".$_row['product_image']."&height=206&width=395";

			$email_query = "select * from mast_emails where emailid=13";
			$email_rs = mysql_query($email_query);
			$email_row = mysql_fetch_object($email_rs);

			$email_subject = str_replace("[[DEAL_EMAIL_SUBJECT]]",$_row['deal_email_subject'] , $email_row->subject);

			$email_message = file_get_contents(ABSPATH."/email_section/email.html");
			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message  = str_replace("[[CONTENT]]",html_entity_decode($email_row->message),$email_message);

			$email_message = str_replace("[[BANNER]]", "today_bargain_banner.jpg", $email_message);
			$email_message = str_replace("[[QUANTITY_CITY_STATE]]", $dealCountDefaultCity['dealcount']." Live Bargains In ".$dealCountDefaultCity['city'].",".$dealCountDefaultCity['code'], $email_message);
			$email_message = str_replace("[[QUANTITY_CITY_STATE_LINK]]", SITEROOT."/all-bargains/".str_replace(" ","-",$dealCountDefaultCity['city']), $email_message);
			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[DEAL_NAME]]", $_row['product_name'], $email_message);
			$email_message = str_replace("[[DEAL_SLOGAN]]", $_row['product_slogan'], $email_message);
			$email_message = str_replace("[[DEAL_DESC_PRICE]]", round($_row['product_disc_price']), $email_message);
			$email_message = str_replace("[[DEAL_PRICE]]",round($_row['product_act_price']), $email_message);
			$email_message = str_replace("[[YOUR_PRICE]]",round($yourPrice), $email_message);
			$email_message = str_replace("[[SAVING]]",round($youSave), $email_message);
			$email_message = str_replace("[[DEAL_URL]]", $dealURL, $email_message);
			$email_message = str_replace("[[DEAL_IMAGE]]", $deal_img_path, $email_message);
			$email_message = str_replace("[[REDEEM_AT]]", nl2br($redeemAt), $email_message);
			$email_message = str_replace("[[ABOUT_DEAL]]", $aboutDeal, $email_message);
			$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
			$email_message = str_replace("[[UNSUBSCRIBE]]",SITEROOT."/unsubscribe/".base64_encode($emailid)."/".$nuid."", $email_message);

			$from = "Today's Bargain"."<deals@friendlybargains.com>";
			//print_r($email_message);
			@mail($emailid,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
		}
	}

	//get links of Free Voucher, Cashback, Travel
	//FREE VOUCHER LINK = 28, //MONEY BACK LINK = 29, //TRAVEL SERVICES = 30
	function getTabLinks($secID=0){
		if($secID > 0){
			$query = "select * from sitesetting where id=".$secID;
			$res = mysql_query($query);
			return @mysql_fetch_object($res);
		}
	}

	function getHomePageEmptyAreasDetails($section)
	{
		$returnResult = "";
		switch ($section) {
				case "nearLogo":
					$query = "select * from tbl_home_page_ads where id=1 and status=1";
					$res = mysql_query($query);
					$row = @mysql_fetch_object($res);
					
					if($row->display_by == "image")
					{
						if(strlen(trim($row->image_file)) > 0)
						{
							$returnResult = "<img src='".SITEROOT."/uploads/home/".$row->image_file."' width='160' height='90' alt='img'>";
						}
					}elseif($row->display_by == "text")
					{
						if(strlen(trim($row->text_message)) > 0)
						{
							$returnResult = html_entity_decode($row->text_message);
						}
					}
					break;
				case "nextAdvanced":
					$query = "select * from tbl_home_page_ads where id=2 and status=1";
					$res = mysql_query($query);
					$row = @mysql_fetch_object($res);
					
					if($row->display_by == "image")
					{
						if(strlen(trim($row->image_file)) > 0)
						{
							$returnResult = "<img src='".SITEROOT."/uploads/home/".$row->image_file."' width='190' height='30' alt='img'>";
						}
					}elseif($row->display_by == "text")
					{
						if(strlen(trim($row->text_message)) > 0)
						{
							$returnResult =  html_entity_decode($row->text_message);
						}
					}
					break;
				case "leftOfDD":
					$query = "select * from tbl_home_page_ads where id=3 and status=1";
					$res = mysql_query($query);
					$row = @mysql_fetch_object($res);
					
					if($row->display_by == "image")
					{
						if(strlen(trim($row->image_file)) > 0)
						{
							$returnResult = "<img src='".SITEROOT."/uploads/home/".$row->image_file."' width='90' height='50' alt='img'>";
						}
					}elseif($row->display_by == "text")
					{
						if(strlen(trim($row->text_message)) > 0)
						{
							$returnResult =  html_entity_decode($row->text_message);
						}
					}
					break;
				case "rightOfDD":
					$query = "select * from tbl_home_page_ads where id=4 and status=1";
					$res = mysql_query($query);
					$row = @mysql_fetch_object($res);
					
					if($row->display_by == "image")
					{
						if(strlen(trim($row->image_file)) > 0)
						{
							$returnResult = "<img src='".SITEROOT."/uploads/home/".$row->image_file."' width='90' height='50' alt='img'>";
						}
					}elseif($row->display_by == "text")
					{
						if(strlen(trim($row->text_message)) > 0)
						{
							$returnResult =  html_entity_decode($row->text_message);
						}
					}
					break;
				case "lightBoxTop":
					$query = "select * from tbl_home_page_ads where id=5 and status=1";
					$res = mysql_query($query);
					$row = @mysql_fetch_object($res);
					
					if($row->display_by == "image")
					{
						if(strlen(trim($row->image_file)) > 0)
						{
							$returnResult = "<img src='".SITEROOT."/uploads/home/".$row->image_file."' width='703' height='53' alt='img'>";
						}
					}elseif($row->display_by == "text")
					{
						if(strlen(trim($row->text_message)) > 0)
						{
							$returnResult =  html_entity_decode($row->text_message);
						}
					}
					break;
				default:
					$returnResult = "";
			    }
		return $returnResult;
	}

	//get details of Become a Fan and Twitter Updates
	//TWITTER_USERNAME = 32, //FB_FAN_DETAILS = 33
	function getSocialNetDetails($secID=0){
		if($secID > 0){
			$query = "select * from sitesetting where id=".$secID;
			$res = mysql_query($query);
			return @mysql_fetch_object($res);
		}
	}

	//get details from sitesetting table
	function getDetailsFromSiteSettings($secID=0){
		if($secID > 0){
			$query = "select * from sitesetting where id=".$secID;
			$res = mysql_query($query);
			return @mysql_fetch_object($res);
		}
	}
	//get category level hirarchy string using the category id i.e. from bottom to top
	function recursiveCategory($categoryId, $level=0) {
		global $dbObj;
		// Some code to get category from the database resulting in Category-array
		$res_cat= $dbObj->gj("mast_deal_category","*","id='$categoryId'","","","","","");		
		$row_cat=@mysql_fetch_assoc($res_cat);
		$content = $categoryId."|*|".$row_cat["category"];
		++$level;
		if($row_cat["parent_id"] != 0) {
			$content .= ">".recursiveCategory($row_cat["parent_id"], $level);
		}
		
		return $content;
	}
	
	//explode category level string with id and headings / title like Main category : ..... i.e. top to bottm
	function getCategoryLevelOrder($data)
	{
		global $smarty;
		$exp_data = explode(">",$data);
		$catLevelData = "";
		for($c=(count($exp_data)-1),$l=0;$c>=0; $c--,$l++)
		{
			$exp_catdata = explode("|*|",$exp_data[$c]);
	
			$catAliasName = "";
			$catAliasId = "";
			if($l==0)
			{
				$catAliasName = "Main";
				$catAliasId = "main_";	
			}else
			{
				for($i=0; $i<$l; $i++)
				{
					$catAliasName .= "Sub ";
					$catAliasId .= "sub_";
				}			
			}
			$catLevelData .= "<tr><td colspan='2'><h3>".$catAliasName." Category : ".$exp_catdata[1]."</h3></td></tr>";
			$smarty->assign($catAliasId."cat_id",$exp_catdata[0]);	
		}
		return $catLevelData;
	}	

	/*function getMyTimeDiff($t1,$t2){
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*60*60)+($a1[1]*60)+($a1[2]));
		$time2 = (($a2[0]*60*60)+($a2[1]*60)+($a2[2]));
		$diff = abs($time1-$time2);
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		$secs = floor(($diff-(($hours*60*60)+($mins*60))));

		$hours = ($hours<10?"0".$hours:$hours);
		$mins = ($mins<10?"0".$mins:$mins);
		$secs = ($secs<10?"0".$secs:$secs);

		$result = $hours.":".$mins.":".$secs;
		return $result;
	}*/	

	function getMyTimeDiff($t1,$t2){
		$a1 = explode(":",$t1);
		$a2 = explode(":",$t2);
		$time1 = (($a1[0]*24*60*60)+($a1[1]*60*60)+($a1[2]*60)+($a1[3]));
		$time2 = (($a2[0]*24*60*60)+($a2[1]*60*60)+($a2[3]*60)+($a2[3]));
		$diff = abs($time1-$time2);
		$hours = floor($diff/(60*60));
		$mins = floor(($diff-($hours*60*60))/(60));
		$secs = floor(($diff-(($hours*60*60)+($mins*60))));	

		if ($hours > 23)	
		{
			$day = ($hours/24);
			$day = intval($day);
			$hours = ($hours-($day*24));
		} else
		{
			$day = 0;
		}

		//$day = ($day<10?"0".$day:$day);
		$hours = ($hours<10?"0".$hours:$hours);
		$mins = ($mins<10?"0".$mins:$mins);
		$secs = ($secs<10?"0".$secs:$secs);

		$result = $day.":".$hours.":".$mins.":".$secs;
		return $result;
	}

	function getCityDetFromId($cityId){
	
		global $dbObj;		
		if($cityId > 0){
			$rs = $dbObj->cgs("mast_city", "*", "city_id",$cityId, "", "", "");
			$row = @mysql_fetch_assoc($rs);
			return $row;
		}
	}

	/*//get seller user first_name and last_name as per selected seller id*/
	function getDealSellerFromId($dealId){
	
		global $dbObj;
		$seller_name = "";
		if($dealId > 0){
			$rs = $dbObj->cgs("tbl_deal", "deal_unique_id, deal_from_seller_name, deal_from_seller_name_other", "deal_unique_id",$dealId, "", "", "");
			$row = @mysql_fetch_assoc($rs);
			
			if(($row['deal_from_seller_name'] != "") && ($row['deal_from_seller_name'] != "other_seller") && ($row['deal_from_seller_name'] > 0))
			{
				$sellerData = getDataFromTable('tbl_users',"userid, fullname, first_name, last_name","userid = '".$row['deal_from_seller_name']."'");
				$seller_name = $sellerData['first_name']." ".$sellerData['last_name'];
			}else
			{
				$seller_name = $row['deal_from_seller_name_other'];
			}
			return $seller_name;
		}
	}

	//Send email to deal subscriber from seller deal listing
	function sendDealEmail($deal_id,$emailid,$nuid){

		$___query = "select * from tbl_deal as d where d.deal_unique_id=".$deal_id;
		$___res = mysql_query($___query);
		$_row = @mysql_fetch_assoc($___res);
		if($_row){
			$yourPrice = ($_row['product_act_price'] - ($_row['product_act_price']*$_row['product_disc_price']/100));
			$yourPrice = round($yourPrice);
			$youSave = ($_row['product_act_price']*$_row['product_disc_price']/100);
			$youSave = round($youSave);
			$aboutDeal = html_entity_decode($_row['product_description']);
			$redeemAt = $_row['redeemat'];

			$dealURL = SITEROOT."/deal/".$product_id;
			
			//$deal_img_path = SITEROOT."/display_image.php?path=uploads/product/".$_row['product_image']."&height=206&width=395";
			
			$email_query = "select * from sitesetting where id=38";
			$email_rs = mysql_query($email_query);
			$email_row = mysql_fetch_object($email_rs);

			$email_subject = str_replace("[[DEAL_EMAIL_SUBJECT]]",$_row['deal_email_subject'] , 'Usortd Deal');

			$email_message = file_get_contents(ABSPATH."/email/email.html");
			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[TODAYS_DATE]]", date('d-m-Y'), $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->value),$email_message);

			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[DEAL_NAME]]", $_row['product_name'], $email_message);
			$email_message = str_replace("[[DEAL_SLOGAN]]", $_row['product_slogan'], $email_message);
			$email_message = str_replace("[[DEAL_DESC_PRICE]]", round($_row['product_disc_price']), $email_message);
			$email_message = str_replace("[[DEAL_PRICE]]",round($_row['product_act_price']), $email_message);
			$email_message = str_replace("[[YOUR_PRICE]]",round($yourPrice), $email_message);
			$email_message = str_replace("[[SAVING]]",round($youSave), $email_message);
			$email_message = str_replace("[[DEAL_URL]]", $dealURL, $email_message);
			$email_message = str_replace("[[DEAL_IMAGE]]", $deal_img_path, $email_message);
			$email_message = str_replace("[[REDEEM_AT]]", nl2br($redeemAt), $email_message);
			$email_message = str_replace("[[ABOUT_DEAL]]", $aboutDeal, $email_message);
			$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
			$email_message = str_replace("[[UNSUBSCRIBE]]",SITEROOT."/unsubscribe/".base64_encode($emailid)."/".$nuid."", $email_message);

			$from = "Today's Bargain"."<deals@friendlybargains.com>";
//			print_r($email_message); exit;
			@mail($emailid,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");

			return $email_message;
		}
	}

	function sendDealSms($contact_no)
	{
		$sms_query = "select * from sitesetting where id=37";
		$sms_rs = mysql_query($sms_query);
		$sms_row = mysql_fetch_assoc($sms_rs);
		$smsContent = $sms_row['value'];

		$sms = new SendSMS("7633X699","43948");
		$return_msg = "";
		if(isset($_POST['task']) && $_POST['task'] == "SMS")
		{
			if(strlen(trim($contact_no)) > 0)
			{
				//if($sms->send($contact_no,$smsContent))
				{
					$return_msg = "I have ".$sms->getCreditsRemaining()." left and I used  ".$sms->getCreditsUsed()." credits";
				}
			}
		}

		return $smsContent;
	}
?>