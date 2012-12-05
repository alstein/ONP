<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.user.php');
include_once('../../includes/class.message.php');
$msobj= new message();
$userobj= new user();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


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
	$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$user['userid'];
	$link = "<a href='{$attach}'>{$attach}</a>";
        $email_link="<a href='{$attach}'><strong>Verify ".$user['email']." </strong></a>";
        $email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
        $email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
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
	//$user['email']="vijendra.m.p@gmail.com";
	@mail($user['email'],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	// echo "<pre>To ==".$user['email']."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
        $s=$msobj->showmessage(167);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        header("Location:".SITEROOT."/admin/user/seller_list.php");
        exit;
}

#--------Verify for payment ------------------#
if($_GET['payment']=='yes')
{
       $getuserid=$_GET['userid'];
       $id = $dbObj->customqry("update tbl_users set verification = '1',payment_verification='1' where userid='$getuserid'","");
       $s=$msobj->showmessage(183);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
if($_GET['verifyPayment']=='yes')
{
       $getuserid=$_GET['userid'];

           $user_rs = $dbObj->gj("tbl_users","userid,first_name,last_name,address1,address2,city,postalcode,email","userid='".$getuserid."'","","","","","");
            $user_rec = @mysql_fetch_assoc($user_rs);
            #--fetching email content--#
            $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(33),"","","");
            $mail = @mysql_fetch_assoc($mail_rs);
            $mail_content=stripslashes(html_entity_decode($mail['message']));
                #--end--#     
             $title=$mail['subject'];
             $message = file_get_contents(ABSPATH."/email/email.html");
             $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);  
             $message = str_replace("[SITEROOT]",SITEROOT,$message);
             $message = str_replace("[firstname]",$user_rec['first_name'],$message);
             $message = str_replace("[lastname]",$user_rec['last_name'],$message); 
            /*  echo   $message;exit; */  
            $from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n"; 
            $flag=@mail($user_rec['email'],$title,$message,$headers);
            $id = $dbObj->customqry("update tbl_users set verification = '1' where userid='$getuserid'","");
            $s=$msobj->showmessage(182);
            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

}
if($_GET['verifyPayment']=='reject')
{
            $getuserid=$_GET['userid'];
            $user_rs = $dbObj->gj("tbl_users","userid,first_name,last_name,address1,address2,city,postalcode,email","userid='".$getuserid."'","","","","","");
            $user_rec = @mysql_fetch_assoc($user_rs); 
            #--fetching email content--#
            $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(31),"","","");
            $mail = @mysql_fetch_assoc($mail_rs);    
            $mail_content=stripslashes(html_entity_decode($mail['message']));
            #--end--#     
            $title=$mail['subject'];                      
            $message = file_get_contents(ABSPATH."/email/email.html");
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);  
            $message = str_replace("[SITEROOT]",SITEROOT,$message);
            $message = str_replace("[firstname]",$user_rec['first_name'],$message);
            $message = str_replace("[lastname]",$user_rec['last_name'],$message);                      
            /*  echo   $message;exit; */                 
            $from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";           
            $flag=@mail($user_rec['email'],$title,$message,$headers);  
            $id = $dbObj->customqry("update tbl_users set verification = '2' where userid='$getuserid'","");
            $s=$msobj->showmessage(184);
            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
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
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
		
	}
	elseif($action == "inactivate")
	{
	
	
		$id = $dbObj->customqry("update tbl_users set status = 'inactive' where userid in (".$userid.")","");
				$s=$msobj->showmessage(7);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	elseif($action == "delete")
	{
		$fan=$userobj->deletefan($userid);
		$friend=$userobj->deletefriend($userid);
		$cheer=$userobj->deletecheer($userid);
		$activity=$userobj->deleteactivity($userid);
		$photo=$userobj->deletephoto($userid);
		$review=$userobj->deletereview($userid);
 		$deal=$userobj->deletedeal($userid);
		$deal=$userobj->del_request_by_mer($userid);
		$messages=$userobj->deletemessages($userid);
		$offerdeal=$userobj->deleteofferdeal($userid);

		$id = $dbObj->customqry("delete from tbl_users where userid in (".$userid.")","");
		$s=$msobj->showmessage(8);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 		$id_delete_fan = $dbObj->customqry("delete from tbl_fan where 	userid in (".$userid.") or fan_id in (".$userid.")","");
		header("location:".$_SERVER['HTTP_REFERER']);
	exit;
	}

}
ob_start();

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

#----code for excel report----#
    if($_GET['view'] == 'excel')
    {
        $out ="Seller Information";		
        $out .="\n";
        $out .="\n";
/*        $out .='Full Name,Email,City,Country,Post Code,Address,Contact No,Business Name,Website URL,Registration Date,Last Login,Package Name,Subscription Status,Added By,Type of Package,Pack Price,Cost Per Success Deal,Cost Per SMS Deal,Pack Duration,Seller Unique URL';*/

        $out .='A/C No & Name,Business Name,Email,City,Registration Date,Last Login,';

        $out .="\n";
        $out .="\n";
        $l="";
    }
#----code end-----------------#
$sf="u.*, t.usertype,mc.country,c.city_name,l.login_date as last_login,dc.category";
$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid left join mast_country mc on u.countryid=mc.countryid left join mast_city c on u.city=c.city_id left join tbl_login_log  l on u.userid=l.userid left join mast_deal_category  dc on u.deal_cat=dc.id";
$cnd = "u.usertypeid =3 ";
if($_GET['exel_id']!='')
{
    $cnd .= " and u.userid =".$_GET['exel_id'];
}

if(isset($_GET['searchuser']))
$search=$dbObj->sanitize($_GET['searchuser']);
$cnd .= " and (u.business_name 	LIKE '%{$search}%' OR u.username LIKE '%{$search}%' OR u.email LIKE '%{$search}%' OR u.first_name LIKE '%{$search}%' OR u.last_name LIKE '%{$search}%' OR u.fullname LIKE '%{$search}%' OR u.postalcode LIKE '%{$search}%' OR c.city_name  LIKE '%{$search}%' OR u.signup_date LIKE '%{$search}%') ";

    //$cnd .= " and ( u.username LIKE '%{$_GET['searchuser']}%' OR u.email LIKE '%{$_GET['searchuser']}%' OR u.first_name LIKE '%{$_GET['searchuser']}%' OR u.last_name LIKE '%{$_GET['searchuser']}%' OR u.fullname LIKE '%{$_GET['searchuser']}%' OR u.postalcode LIKE '%{$_GET['searchuser']}%' ) ";
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
         
    }
}
    $rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "u.userid", $ot, $l, "");
	 $rs_all=$dbObj->gj($tbl, $sf, $cnd, $ob, "u.userid", $ot, "", "");

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
                else{
		    $users[$i]['last_login'] ="";}
                #--------------Get last login---------------#
	
                    $fullname=$row['first_name']." ".$row['last_name'];
                    $address=$row['address1']." ".$row['address2'];		

			
					$sql_cd="SELECT count(*) as dealcnt FROM tbl_deals where merchant_id=".$row['userid'];
					$rs_cd=mysql_query($sql_cd)or die(mysql_error());
					$row_cd=@mysql_fetch_assoc($rs_cd);
					$users[$i]['dealcnt'] = $row_cd['dealcnt'];
			
					$sql_od="SELECT count(*) as dealncnt FROM tbl_offer_deal where merchant_id=".$row['userid']." and status='yes'";
					$rs_od=mysql_query($sql_od)or die(mysql_error());
					$row_od=@mysql_fetch_assoc($rs_od);
					$users[$i]['dealncnt'] = $row_od['dealncnt'];



				if($row['deal_cat'] > 0)
				{
					$sql_cat="SELECT category FROM mast_deal_category where id=".$row['deal_cat'];
					$rs_cat=mysql_query($sql_cat)or die(mysql_error());
					$row_cat=@mysql_fetch_assoc($rs_cat);
					$users[$i]['cat_name'] = $row_cat['category'];
				}
		
		
				if($row['deal_subcat'] > 0)
				{
					$sql_cat1="SELECT category FROM mast_deal_category where id=".$row['deal_subcat'];
					$rs_cat1=mysql_query($sql_cat1)or die(mysql_error());
					$row_cat1=@mysql_fetch_assoc($rs_cat1);
					$users[$i]['sub_cat_name'] = $row_cat1['category'];
				}
		

	
		//-------------------Get added by user name start------------------------//
		 		if($row['userid'] != 0 )
                 {
                    $sql_ad = "Select u.usertypeid,u.userid, u.fullname,u.first_name as ad_firstname, u.last_name as ad_lastname,username from tbl_users u where userid =".$row['added_by'];
                    $res_ad = $dbObj->customqry($sql_ad,0);
                    $row_ad = @mysql_fetch_assoc($res_ad);
                    $usname= $users[$i]['ad_name'] = $row_ad['ad_firstname']." ".$row_ad['ad_lastname'];
                    $users[$i]['ad_userid'] = $row_ad['userid'];
                    $users[$i]['userType'] = (($row_ad['usertypeid'] == '3')?"Seller":"Admin");
                 }		
		//-------------------Get added by user name end------------------------//		
		  #------------Get County name start ----------#
                    $rs_coutry= $dbObj->gj("mast_country","*","countryid='{$row['countryid']}'","","","","","");
                    $rs_f=@mysql_fetch_assoc($rs_coutry);
                    //$row['countryid'] = $rs_f['countryid'];
                    $row['country_name'] = $rs_f['country'];
      
                $rs_subscription = $dbObj->customqry("select * from tbl_user_subscription_details where subs_id ={$row['last_subs_id']}", "");
                $row_subscription = @mysql_fetch_assoc($rs_subscription);
				 $users[$i]['pack_name'] = $row_subscription['subs_pack_name'];
                $users[$i]['allow_deals_per_month'] = $row_subscription['subs_pack_allow_deals_per_month'];
                $users[$i]['pack_price'] = $row_subscription['subs_pack_price'];
                $users[$i]['cost_per_success_deal'] = $row_subscription['subs_pack_cost_per_success_deal'];
                $users[$i]['cost_per_success_deal_percent_doller'] = $row_subscription['subs_pack_cost_per_success_deal_percent_doller'];
                $users[$i]['cost_sms_deal'] = $row_subscription['subs_pack_cost_sms_deal'];
                $users[$i]['pack_duration'] = $row_subscription['subs_pack_duration'];
//                 $users[$i]['status'] = $row_subscription['status'];
                
                if($row['subscribe_status']=="Expired")
                {
                     $subscribe_status="Deleted";
                }else{
                     $subscribe_status=$row['subscribe_status'];
                }	
#--------------END Get subscription data--------------#
					if( $users[$i]['last_login']=="")
					{
							$date="---";
				    }
					else
					{
						$date=date("d-m-Y",strtotime($users[$i]['last_login']));
					}		
				 if($_GET['view'] == 'excel')
                 {
                    #---code for csv report-----#
								if($row_ad['userid']==$row['userid'])
								{
								$user_type="Self";
								}
								else
								{
								$user_type=$row_ad['fullname'];
								}
								
								
								if($row['subscribe_status']=='Expired')
								{
								$user_subscription_status="Deleted";
								}
								else
								{
								$user_subscription_status=$row['subscribe_status'];
								}
								
								
								$out .= '"'."#".$row['userid']."  ". $row['username'].'","'.$row['business_name'].'","'.$row['email'].'","'.$row['city_name'].'","'.date("d-m-Y",strtotime($row['signup_date'])).'","'.$date.'"';
								
													$out .= "\n";
													#----code end---#
               	 }
            	$i++;
	}
	$smarty->assign("users", $users);
    }


/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "userid", "", "DESC", "", "");
$nums =@mysql_num_rows($rs_all);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$newsperpage;
$total_pages = ceil($nums / $newsperpage);

if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "seller_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "seller_list.php";
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
            header("Content-Disposition: attachment; filename=Seller-details.csv");	
            echo $out;
            exit;
	}
	#----code end------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/seller_list.tpl');
$dbObj->Close();
?>
