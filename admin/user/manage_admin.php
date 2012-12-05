<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

		$mnt= $dbObj->gj("sitesetting","*","id='21'","","","","","");
		$rs_mnt=mysql_fetch_assoc($mnt);
		if($rs_mnt['value'] != 'y')
		{
		$mnt="mnt";
		}
		else
		{
		$mnt="live";
		}
	$smarty->assign("mnt",$mnt);

if($_GET['mnt_flag'] != "")
	{
	if($_GET['mnt_flag']=="mnt")
		{
			$id = $dbObj->customqry("update sitesetting set value = 'y' where id=21","");
		
			#--fetching email content--#
                	$mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(42),"","","");
                	$mail = @mysql_fetch_assoc($mail_rs);    
                	$mail_content=stripslashes(html_entity_decode($mail['message']));
			$subject=$mail['subject'];
			$email_message = file_get_contents(SITEROOT."/email/email.html");
			$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$mail_content,$email_message);
			$from =SITEMAIL;
			// echo $email_message;exit;

    			$tbl = "tbl_newsletter";
    			$selectNewsletter = $dbObj->cgs($tbl,"nemail","","","","","");
     			 while($nlrow=@mysql_fetch_array($selectNewsletter))
     			 {
         			$newsletterResult[]=$nlrow;
                   //echo $nlrow['nemail'];
      				//$sendmail = @mail($nlrow['nemail'],$subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			 }
		}
		else 
		if($_GET['mnt_flag']=="live")
		{
			$id = $dbObj->customqry("update sitesetting set value = 'n' where id=21","");

			#--fetching email content--#
                	$mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(43),"","","");
                	$mail = @mysql_fetch_assoc($mail_rs);
                	$mail_content=stripslashes(html_entity_decode($mail['message']));
			$subject=$mail['subject'];
			$email_message = file_get_contents(SITEROOT."/email/email.html");
			$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$mail_content,$email_message);
			$from =SITEMAIL;
			// echo $email_message;exit;

    			$tbl = "tbl_newsletter";
    			$selectNewsletter = $dbObj->cgs($tbl,"nemail","","","","","");
     			 while($nlrow=@mysql_fetch_array($selectNewsletter))
     			 {
         			$newsletterResult[]=$nlrow;
      				//$sendmail = @mail($nlrow['nemail'],$subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			 }

		}
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

// $json = new Services_JSON();
$user_id1=$_GET['user_id1'];	//update status active to suspended
if($user_id1!="")
{
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$user_id1.")","");
			$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
$user_id2=$_GET['user_id2']; //update status suspended to active
if($user_id2!="")
{
		$id = $dbObj->customqry("update tbl_users set status = 'active' where userid in (".$user_id2.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

}
extract($_GET);
if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
   {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['userid']) == 0 || (!isset($_POST['userid'])))
   {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	extract($_POST);
	$userid = implode(", ", $userid);	
	if($action == "Active")
   {
		$id = $dbObj->customqry("update tbl_users set status = 'active' where userid in (".$userid.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
   elseif($action == "inactivate")
   {
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$userid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
   elseif($action == "delete")
   {
		//$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		$id = $dbObj->customqry("update tbl_users set isDeleted = 1 where userid in (".$userid.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
    }
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}
// $json = new Services_JSON();

ob_start();
//$sf="u.*,  t.usertype,(select state_name from mast_state where country_id=223 and mast_state.id=u.state) as state_name";
$sf="u.*, t.usertype";
$cnd="u.usertypeid = 1 and isDeleted != 1 and (u.first_name LIKE '%". trim($_POST['searchuser'])."%' OR u.last_name LIKE '%". trim($_POST['searchuser'])."%' OR u.email LIKE '%". $_POST['searchuser'] ."%')";

$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid";

if($_GET['city']){	$cnd.=" AND u.city LIKE'%". $_GET['city']."%'";	}
if($_GET['search_zipcode']){	$cnd.=" AND u.zipcode =". $_GET['search_zipcode'];	}
if($_GET['usertypeid']){	$cnd.=" AND u.usertypeid =". $_GET['usertypeid'];	}
if($_GET['searchuser']){	$cnd.=" AND u.first_name LIKE'%". $_GET['searchuser']."%' OR u.last_name LIKE'%". $_GET['searchuser']."%'" ;	}

$ob = "userid DESC";
/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))    $page =1;	else
    $page = $page;
$newsperpage =50;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$rs=$dbObj->gj($tbl, $sf, $cnd, "userid DESC", "", "", $l, "");
 
if($rs != 'n')
{
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
        {
		$users[$i]=$row;

                #--------------Get last login---------------#
		$tmp= $dbObj->gj("tbl_admin_login_log","login_date as last_login","userid='{$row['userid']}'","id","","DESC","0,1","");
		if($tmp !='n')
                {
		  $login=mysql_fetch_assoc($tmp);
		    $users[$i]['last_login'] =$login['last_login'];
                }
                else
		    $users[$i]['last_login'] ="";
                #--------------Get last login---------------#

 		$i++;
	}
	$smarty->assign("users", $users);
}

$rs1="SELECT name FROM mast_levels AS l INNER JOIN tbl_users AS u ON l.levelid=u.levelid";
//$row1=$dbObj->customqry($rs1,"");
//$rs = $dbObj->gj('mast_levels l, tbl_users u', "l.*" , "l.levelid=u.levelid", "", "","", "", "");
//$rs = $dbObj->gj('tbl_users u,mast_levels l', "l.*" , "u.levelid=l.levelid", "", "","", "", "1");
while($result=mysql_fetch_assoc($rs))
{
$level[]=$result;
}
$smarty->assign("level", $level);
//print_r($level);


/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1){
	$smarty->assign("showpgnation","yes");
	$showing   = !isset($_GET["page"]) ? 1 : $page;
  if($_GET['usertypeid'])	  $firstlink = "users_list.php?usertypeid=".$_GET['usertypeid'];
  else  	  $firstlink = "users_list.php";
  if($_GET['usertypeid'])	  $seperator = '&page=';
  else	  $seperator = '?page=';
	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);	
	$smarty -> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

//$smarty->display(TEMPLATEDIR . '/admin/user/ajax_user_list.tpl');
// $searchcontent=ob_get_contents();
// ob_end_clean();
// 
// $response	= array("searchcontent"=>stripcslashes($searchcontent));
// echo($json->encode($response));

if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}/*
	$sf1=array("id","state_name");
	$result1 = $dbObj->cgs('mast_state',$sf1,"" ,"", "" ,"" ,""); 
		while($row1=@mysql_fetch_assoc($result1))
		{
			$state1[]=$row1;
		}
	$smarty->assign("state",$state1);*/

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/manage_admin.tpl');

$dbObj->Close();
?>
