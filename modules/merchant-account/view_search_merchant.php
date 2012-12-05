<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

	if(!isset($_SESSION['csUserId']))
	{
		header("location:".SITEROOT); exit;
	}

$row_meta=$dbObj->getseodetails(20);
$smarty->assign("row_meta",$row_meta);

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =10;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/



$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
if(strpos($url,"view_search_merchant")){
	$smarty->assign("page","1");
}else{
	$smarty->assign("page","2");
}

	$whose_profile="view_searches";
	$smarty->assign("whose_profile",$whose_profile);

$cat=$_POST['cat_ref'];
$cat1=@implode(",",$cat);


	if($_POST['name']!="" && $_POST['cat_ref']!="" && $_POST['cityid']!="")
	{
			$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%'  ) and u.deal_cat in= (".$cat1.") and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="" && $_POST['cat_ref']!="")
	{
		$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us  '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%'  ) and u.deal_cat in = (".$cat1.") and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="" && $_POST['cityid']!="")
	{
		$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%' )  and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['cat_ref']!="" && $_POST['cityid']!="")
	{
		$cnd_searches = "u.deal_cat in (".$cat1.") and u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	}
	elseif($_POST['name']!="")
	{

			$cnd_searches = "  (u.fullname LIKE '%".$_POST['name']."%' OR u.first_name LIKE '%".$_POST['name']."%' OR u.last_name LIKE '%".$_POST['name']."%' or u.business_name LIKE '%".$_POST['name']."%' OR u.email LIKE '%".$_POST['name']."%' OR u.title LIKE '%".$_POST['name']."%' or u.address1 LIKE '%".$_POST['name']."%' OR u.address2 LIKE '%".$_POST['name']."%' OR u.postalcode LIKE '%".$_POST['name']."%' or u.business_webURL LIKE '%".$_POST['name']."%' OR u.contact_detail LIKE '%".$_POST['name']."%' OR u.about_us LIKE '%".$_POST['name']."%' or u.specility LIKE '%".$_POST['name']."%' )  and u.usertypeid=3 ";
	}
	elseif($_POST['cat_ref']!="")
	{
		
			$cnd_searches = " u.deal_cat in  (".$cat1.") and u.usertypeid=3 ";
	}
	elseif($_POST['cityid']!="")
	{

		$cnd_searches = "u.city = '".$_POST['cityid']."' and u.usertypeid=3 ";
	
	}
	else
	{
		$cnd_searches = "u.usertypeid=3 ";
	}

	$select_search = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches limit $l", "");

	$select_search_all = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches", "");

	$i=0;
	while($res_searches=@mysql_fetch_assoc($select_search))
	{
		$searches[]=$res_searches;

		$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$res_searches['userid']."'","");
		$res_rating1=@mysql_fetch_assoc($select_rating1);
		$count1=$res_rating1['count'];
		$sum_rating1=$res_rating1['sum_rating'];
		$average_rating1=@($sum_rating1/$count1);
		$searches[$i]['rating']=$average_rating1;


		$select_from_fan=$dbObj->customqry("select f.* from  tbl_fan f  where (f.userid='".$res_searches['userid']."' and f.fan_id='".$_SESSION['csUserId']."') ", "");
		$count=@mysql_num_rows($select_from_fan);
		$searches[$i]['count']=$count;
		$i++;
	}
//echo "<pre>";print_r($searches);echo "</pre>";


/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($select_search_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;


	  $firstlink = SITEROOT."/merchant-account/view_search_merchant/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#
	
	extract($_POST);


	if($act=="Insert")
	{
	//echo $fid1."==========";exit;
	$userid=$_POST['fid1'];
	$fanid=$_SESSION['csUserId'];
	$tbl11="tbl_fan";
	$fv=array($userid,$fanid,'Active');
	$fn=array("userid","fan_id","status");
	$rs=$dbObj->cgi($tbl11,$fn,$fv,"");
				$signup_date=date("Y-m-d H:i:s");
			
				$email_query = "select * from mast_emails where emailid=83";
				$email_rs = @mysql_query($email_query);
				$email_row = @mysql_fetch_assoc($email_rs);


			$select=$dbObj->customqry("select * from tbl_users where userid='".$userid."'", "");
			$res_sel=mysql_fetch_assoc($select);
			$name=$res_sel['business_name'];
			
			$select1=$dbObj->customqry("select * from tbl_users where userid='".$fanid."'", "");
			$res_sel1=mysql_fetch_assoc($select1);
			$name1=$res_sel1['fullname'];
				
				$email_subject =$email_row['subject'];
				$email_subject =  str_replace("[[Name]]", $name1, $email_subject);
		
				$email_message = file_get_contents(ABSPATH."/email/deal_email.html");
			
				$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
				$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
				$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode(stripslashes($email_row['message'])),$email_message);
			
				$email_message = str_replace("[[Merchant_Name]]", $name, $email_message);
				$email_message = str_replace("[[Name]]",$name1,$email_message);

				$to=$res_sel['email'];
				$from = SITE_EMAIL;
				@mail($to,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			

	if($_GET['page']!="")
	{ 
	@header("location:".SITEROOT."/merchant-account/view_search_merchant/page/".$_GET['page']);
	}
	else
	{	
 	@header("location:".SITEROOT."/merchant-account/view_search_merchant");
	}
	}	



$smarty->assign("searches",$searches);
$smarty->display(TEMPLATEDIR . '/modules/merchant-account/view_search_merchant.tpl');
$dbObj->Close();
?>