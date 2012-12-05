<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once('../../includes/class.user.php');
include_once("../../includes/function.php");
$msobj= new message();
$userobj= new user();
//ini_set ('magic_quotes_gpc', 1);


if(!isset($_SESSION['duAdmId']))
{
      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}

#-------------Resend verify email---------------#
if( $_GET['userid'] != '' && $_GET['act'] == "verify" )
{
	$rs=$dbObj->cgs("tbl_users", "", "userid", $_GET['userid'], "", "", "");
	$user = @mysql_fetch_assoc($rs);

	$email_query = "select * from mast_emails where emailid=20";
	$email_rs = mysql_query($email_query);
	$email_row = mysql_fetch_object($email_rs);
	$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);

	$email_message = file_get_contents(ABSPATH."/email/email.html");

	//$attach = SITEROOT."/buyer/".$user['activationcode']."/".$user['userid']."/verifyemail/";

	$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$user['userid'];
	$link = "<a href='{$attach}'>{$attach}</a>";
        $email_link="<a href='{$attach}'><strong>Verify ".$user['email']." </strong></a>";

	$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
	$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
	$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
	$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
	$email_message = str_replace("[[LINK]]", $link, $email_message);
	$date1 = date("d-m-Y");
	$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	$email_message = str_replace("[[EMAIL_LINK]]", $email_link, $email_message);
	$email_message = str_replace("[[EMAIL]]",$user['email'], $email_message);
	$email_message = str_replace("[[FIRSTNAME]]", $user['first_name'], $email_message);
	$email_message  = html_entity_decode($email_message);

	$from = SITE_EMAIL;
	@mail($user['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
         //echo "<pre>To ==".$user['email']."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; 
        // @mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	//exit;
        $s=$msobj->showmessage(260);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

        header("Location:".SITEROOT."/admin/user/users_list.php");
        exit;
}
#-------------Resend verify email---------------#

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
	if($action == "verify")
        {
		$id = $dbObj->customqry("update tbl_users set isverified = 'yes' where userid in (".$userid.")","");
		$s=$msobj->showmessage(6);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	elseif($action == "Active")
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
		$fan=$userobj->deletefan($userid);
		$friend=$userobj->deletefriend($userid);
		$cheer=$userobj->deletecheer($userid);
		$activity=$userobj->deleteactivity($userid);
		$photo=$userobj->deletephoto($userid);
		$review=$userobj->deletereview($userid);
		$coupons=$userobj->deletecoupons($userid);
		$messages=$userobj->deletemessages($userid);
		$offerdeal=$userobj->deleteofferdeal($userid);
		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

#----code for excel report----#
if($_GET['view'] == 'excel')
	{
	$out ="Buyer Information";
	$out .="\n";
	$out .="\n";
// 	$out .='Full Name,User Name,Gender,Email,City,Post Code,Address,Contact No,Registration Date,Last Login';
	$out .='Full Name,Email,City ,Registration Date,Last Login';
	$out .="\n";
	$out .="\n";
	}

#----code end-----------------#

ob_start();

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
if($_GET['view'] == 'excel')
$l="";
else
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$sf="u.*, t.usertype,mc.country,c.city_name,l.login_date as last_login";
$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid left join mast_country mc on u.countryid=mc.countryid left join mast_city c on u.city=c.city_id left join tbl_login_log  l on u.userid=l.userid";

$cnd = "u.usertypeid =2";

if($_GET['exel_id']!='')
{
$cnd .= " and u.userid =".$_GET['exel_id'];
}

if($_GET['searchuser']!='')
$search=$dbObj->sanitize($_GET['searchuser']);
$cnd .= " and ( u.username LIKE '%{$search}%' OR u.email LIKE '%{$search}%' OR u.first_name LIKE '%{$search}%' OR u.last_name LIKE '%{$search}%' OR u.fullname LIKE '%{$search}%' OR u.postalcode LIKE '%{$search}%' ) ";

   // $cnd .= " and ( u.username LIKE '%{$_GET['searchuser']}%' OR u.email LIKE '%{$_GET['searchuser']}%' OR u.first_name LIKE '%{$_GET['searchuser']}%' OR u.last_name LIKE '%{$_GET['searchuser']}%' OR u.fullname LIKE '%{$_GET['searchuser']}%' OR u.postalcode LIKE '%{$_GET['searchuser']}%' ) ";

$ob="userid"; $ot="DESC";
if($_GET['sortby'])
{
    switch($_GET['sortby'])
    {
          case fullname:
                        $ob = "u.fullname"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_name", "DESC");
                        else
                          $smarty->assign("sorttype_name", "ASC");
                        break;
          case email:
                        $ob = "u.email"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_email", "DESC");
                        else
                          $smarty->assign("sorttype_email", "ASC");
                        break;
          case fb_user_id:
                        $ob = "u.fb_user_id"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_signup", "DESC");
                        else
                          $smarty->assign("sorttype_signup", "ASC");
                        break;
          case country:
                        $ob = "mc.country"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_country", "DESC");
                        else
                          $smarty->assign("sorttype_country", "ASC");
                        break;
          case city_name:
                        $ob = "c.city_name"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_city", "DESC");
                        else
                          $smarty->assign("sorttype_city", "ASC");
                        break;
	case signup_date:
                        $ob = "u.signup_date"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_signup", "DESC");
                        else
                          $smarty->assign("sorttype_signup", "ASC");
                        break;
          case last_login:
                        $ob = "last_login"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_logout", "DESC");
                        else
                          $smarty->assign("sorttype_logout", "ASC");
                        break;
          case isverified:
                        $ob = "c.city_name"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_emailverify", "DESC");
                        else
                          $smarty->assign("sorttype_emailverify", "ASC");
                        break;
    }
}

    $rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "u.userid", $ot, $l, "");

if($rs != 'n')
{
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
        {
       
		$users[$i]=$row;
		
		
		
                #--------------Get last login---------------#
		$tmp= $dbObj->gj("tbl_login_log","login_date as last_login","userid='{$row['userid']}'","id","","DESC","0,1","");
		if($tmp !='n')
                {
		  $login=mysql_fetch_assoc($tmp);
		    $users[$i]['last_login'] =$login['last_login'];
                }
                else
		    $users[$i]['last_login'] ="";
                #--------------Get last login---------------#
 		$fullname=$row['first_name']." ".$row['last_name'];
// 		$address=$row['address1']." ".$row['address2'];


		////////////////////////country details///////////////////
		$conuntryname = '';
		if($row['countryid'] > 0)
		{
			$sql_cntry="SELECT * FROM mast_country where countryid=".$row['countryid']."";
			$rs_cntry=mysql_query($sql_cntry)or die(mysql_error());
			$row_cntry=@mysql_fetch_assoc($rs_cntry);
			$conuntryname = $row_cntry['country'];
		}
			$users[$i]['country'] = $conuntryname;
		////////////////////////country details///////////////////


		if($row['state_id'] > 0)
		{
			$sql_state="SELECT * FROM mast_state where id=".$row['state_id']."";
			$rs_state=mysql_query($sql_state)or die(mysql_error());
			$row_state=@mysql_fetch_assoc($rs_state);
			$users[$i]['state_name'] = $row_state['state_name'];
		}

// 		if($row['category_preferance'] > 0)
// 		{
// 			$row['category_preferance'];
// 			$arr=@explode(",",$row['category_preferance']);
// 			$count=count($arr);
// 
// 			for ($i=0;$i<$count;$i++)
// 			{
// 			$sql_cat="SELECT * FROM mast_deal_category where id=".$arr[$i]."";
// 			$rs_cat=mysql_query($sql_cat)or die(mysql_error());
// 			$row_cat=@mysql_fetch_assoc($rs_cat);
// 			$users[$i]['cat_name'] = $row_cat['category'];
// 			}
// 		}


		
		////////////////////////city details///////////////////
		if($row['city'] > 0)
		{
	        $cityname=getCityDetFromId($row['city']);
	        $users[$i]['city_name']=$cityname['city_name'];
	        }
 
		$Face_Book_User_Id = ($row['fb_user_id']?$row['fb_user_id']:'----');
		$Twitter_User_Id = ($row['twitter_uid']?$row['twitter_uid']:'----');
		
		if( $users[$i]['last_login']=="")
		{
		 $date="---";
		}else{
		 $date=date("d-m-Y",strtotime($users[$i]['last_login']));
		}
// 		
		if($_GET['view'] == 'excel')
		{
			#---code for csv report-----#
			//$out .= '"'.$fullname.'","'.$row['username'].'","'.$row['gender'].'","'.$row['email'].'","'.$row['city'].'","'.$row['postalcode'].'","'.$address.'","'.$row['contact_detail'].'","'.date("F j, Y, g:i a",strtotime($row['signup_date'])).'","'.$login['last_login'].'"';
			$out .= '"'.$fullname.'","'.$row['email'].'","Singapore","'.date("d-m-Y",strtotime($row['signup_date'])).'","'.$date.'"';
			$out .= "\n";
			#----code end---#
		}
 		$i++;
	}
	
	$smarty->assign("users", $users);
}
// echo "<pre>";print_r($users);echo "</pre>";
/*-----------------------Pagination Part2--------------------*/
$rs1 =$dbObj->gj($tbl, $sf, $cnd, "userid", "u.userid", "DESC", "", "");
$nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 20;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if($_GET['searchuser']!='')
    {
	    $firstlink = "users_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "users_list.php";
	  $seperator = '?page=';
    }
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

#----code for csv report-------#
	if($_GET['view'] == 'excel')
	{
		header("Content-type: text/x-csv");
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=Buyer-details.csv");	
		echo $out;
		exit;
	}
#----code end------#


if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

// $smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/users_list.tpl');

$dbObj->Close();
?>
