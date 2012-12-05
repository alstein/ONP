<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

	if(!isset($_SESSION['csUserId']))
	{
		header("location:".SITEROOT); exit;
	}

	$whose_profile="view_searches";
	$smarty->assign("whose_profile",$whose_profile);
/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
   $page =1;
else
   $page = $_GET['page'];
   $adsperpage =6;
   $StartRow = $adsperpage * ($page-1);
   $l= $StartRow.','.$adsperpage;

/*-----------------------End Part1--------------------*/
$arr=explode("-",$_GET['id2']);
if(count($arr)>0)
{
$search=$arr[0]." ".$arr[1];
}
else
{
$search=$_GET['id2'];
}
	$cnd_searches = "  (u.fullname LIKE '%".$search."%' OR u.first_name LIKE '%".$search."%' OR u.last_name LIKE '%".$search."%' OR u.fullname  LIKE '%".$search."%') and u.usertypeid=2  and u.userid!='".$_SESSION['csUserId']."' and u.status='active'";

	$select_search = $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches limit $l", "");

	$res_all= $dbObj->customqry("select u.*,mc.city_name from  tbl_users u left join mast_city mc on u.city=mc.city_id where $cnd_searches", "");

	$i=0;
	while($res_searches=@mysql_fetch_assoc($select_search))
	{
		$searches[]=$res_searches;
		$select_from_friend=$dbObj->customqry("select f.* from  tbl_friends f  where (f.userid='".$res_searches['userid']."' and f.friendid='".$_SESSION['csUserId']."') or (f.userid='".$_SESSION['csUserId']."' and f.friendid='".$res_searches['userid']."')", "");
		$res_from_friend=mysql_fetch_assoc($select_from_friend);
		$searches[$i]['verification']=$res_from_friend['verification'];
		$searches[$i]['friendid']=$res_from_friend['friendid'];
		$i++;
	}



/*----------Pagination Part-2--------------*/

    $nums = @mysql_num_rows($res_all);

    $show = 5;

    $total_pages = ceil($nums / $adsperpage);



if($total_pages > 1){

   $showing   = !isset($_GET["page"]) ? 1 : $page;

      $firstlink = SITEROOT."/friend/".$_GET['id1']."/".$_GET['id2']."/view_all_search/";

   $seperator = 'page/';

   $baselink  = $firstlink;

   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);

   $smarty -> assign("pgnation",$pgnation);

}

#-----------------------------------#

//----------------
	extract($_POST);
	if($act=="Insert")
	{
	$friendid=$_POST['fid1'];
	$userid=$_SESSION['csUserId'];
	$sel=$dbObj->customqry("select * from tbl_friends where (userid=".$friendid." and friendid=".$userid.") or (userid=".$userid." and friendid=".$friendid.")","");
	$cnt=@mysql_num_rows($sel);
	if($cnt==0)
	{
	
	$tbl11="tbl_friends";
	$fv=array($userid,$friendid,date('Y-m-d H:m:s'),'pending');
	$fn=array("userid","friendid","request_date","verification");
	$rs=$dbObj->cgi($tbl11,$fn,$fv,"");


	$gname=$dbObj->customqry("select fullname,email from tbl_users where userid=".$friendid,"");
	$grow=@mysql_fetch_assoc($gname);
	$name=$grow['fullname'];
	$to_email=$grow['email'];

										$email_query = "select * from mast_emails where emailid=80";
										$email_rs = mysql_query($email_query);
										$email_row = mysql_fetch_object($email_rs);
										$email_message = file_get_contents(ABSPATH."/email/email.html");
										
										$email_subject=str_replace('[[FROM_NAME]]',ucfirst($_SESSION['csFullName']), $email_row->subject);
										$email_message = str_replace("[[EMAIL_CONTENT]]",nl2br(html_entity_decode($email_row->message)), $email_message);
										$email_message = str_replace("[[TO_NAME]]",ucfirst($name),$email_message);
										$email_message = str_replace("[[FROM_NAME]]",ucfirst($_SESSION['csFullName']),$email_message);
										
										
										$email_message = str_replace("[[EMAIL_HEADING]]", $email_subject,$email_message);
										//$email_message  = ($email_row->message);
										$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
										$email_message = str_replace("[[TODAYS_DATE]]", date("Y-m-d H:i:s"), $email_message);
										$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
// 										echo "=====>".$name;;
// 										echo "=====>".ucfirst($_SESSION['fullname']);
// 										echo "to=====>".$to_email);
// 										echo "=====>".$email_message;exit;


										$from = SITE_EMAIL;
										$ssmail = @mail($to_email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// echo "msg==".$email_message;exit;





	}
	header('Location: '.SITEROOT.'/friend/'.$_GET['id1'].'/'.$_GET['id2'].'/view_all_search');
	exit;	
	}

	$smarty->assign("searches",$searches);
	$smarty->display(TEMPLATEDIR . '/modules/friend/view_all_search.tpl');
	$dbObj->Close();
?>