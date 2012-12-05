<?php
include_once('../../include.php');

include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.myaccount.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
include('../../includes/paging.php');
$msobj= new message();

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}


#------------Pagination Part-1--------------------------------

if(!isset($_GET['page']))
		{
			$getpage='';
			$page =1;
		}
		else
		{
			$getpage = $_GET['page'];
			$page = $getpage;
		}

			$adsperpage = 10;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
#-------------------------------------------------------------------------------#


 if($_POST['action'])
   {
      extract($_POST);
      $offer_deal_ids = @implode(", ", $offer_deal_id);
      if($offer_deal_ids)
      {
         if($_POST['action'] == "delete")
         {
				//delete all deal cities from reference table
		
		  $temp = $dbObj->customqry("delete from tbl_offer_deal where offer_deal_id IN (".$offer_deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Offer deal request deleted successfully</span>";

         }
      	/*
	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Active' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_friends set status = 'Inactive' where id IN (".$friendids.")","");
               $_SESSION['msg']="<span class='success'>Friend inactivated successfullly </span>";
         }		*/			
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }

#===================End====================#

if($_GET['id2']!="")
{
	$status=$_GET['id2'];
	$fl=array('status');
	$vl=array($status);

// Set request-specific fields.
echo "authorised==".$authorizationID = urlencode($_GET['id1']);
$note = urlencode('example_note');
 
// Add request-specific fields to the request string.
$nvpStr="&AUTHORIZATIONID=$authorizationID&NOTE=$note";
 
// Execute the API operation; see the PPHttpPost function above.
$httpParsedResponseAr = PPHttpPost('DOVoid', $nvpStr);
 exit;
if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
	exit('Void Completed Successfully: '.print_r($httpParsedResponseAr, true));
} else  {
	exit('DoVoid failed: ' . print_r($httpParsedResponseAr, true));
}
 



function PPHttpPost($methodName_, $nvpStr_) {
	global $environment;
 
	// Set up your API credentials, PayPal end point, and API version.
	$API_UserName = urlencode('board_api1.alsteincorp.com');
	$API_Password = urlencode('JYH8KM554R5DK9J5');
	$API_Signature = urlencode('A05y3X32QcZ.U7JswX4GQDZROIPwALb2Mm2Z5GFBWsyRyTKXT0x0nuEZ');
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
	}
	$version = urlencode('61.0');
 
	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
 
	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
 
	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
 
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
 
	// Get response from the server.
	$httpResponse = curl_exec($ch);
 
	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}
 
	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);
 
	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}
 
	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}
 
	return $httpParsedResponseAr;
}
 









// 	  $rs = $dbObj->cupdt('tbl_offer_deal',$fl,$vl,'offer_deal_id',$_GET['id3'],'1');
// 	 header("location:".SITEROOT."/merchant-account/".$_GET['id1']."/offer_deal_request");
//          exit;
}
if(isset($_GET['search'])!="")
{

	$cnd .= "  (u.fullname LIKE '%".$_GET['search']."%' OR u1.fullname LIKE '%".$_GET['search']."%') and";
}

	//$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	$res = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.offer_deal_id  order by d.offer_deal_id  DESC limit $l", "");
//die();
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {  
	  $bid_validity=explode(" ",$row['bid_validity']);
	  $todays_date=date("Y-m-d");
	  if(strtotime($bid_validity[0]) >= strtotime($todays_date)){ 
			$row['allow']='yes';
	  }else if(strtotime($bid_validity[0]) < strtotime($todays_date)){ 
			$row['allow']='no';
	  }

      $offer_deal[] = $row;
	$i++;	
   }
	//echo "<pre>";print_r($offer_deal);echo "</pre>";
   $smarty->assign("offer_deal",$offer_deal);





/*----------Pagination Part-2-------------------------------------------------------*/
$result = $dbObj->customqry("select d.*,u.fullname from tbl_offer_deal d left join tbl_users u on d.user_id=u.userid where   d.merchant_id='".$_GET['id1']."' group by d.offer_deal_id order by d.offer_deal_id  DESC", "");
		$nums = @mysql_num_rows($result);
		$show = 10;
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 0)
		$groupArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		$seperator = '&page=';
		$baselink  = $firstlink;

		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$groupArray['paging']=$pgnation;
		$smarty->assign("pagination",$pgnation);
		$smarty->assign("count_record",$nums);
		$smarty->assign("total_page",$total_pages);

#----------------------delete photo-----------------------------------#









  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }


   #----------Success message=--------------#
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/incoming_deal.tpl');

$dbObj->Close();

?>
