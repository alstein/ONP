<?php
//include_once('../includes/SiteSetting.php');

$PATH_PREFIX = "../";
@include_once('include.php');

//include_once("fb.php");
@include_once("facebook-connect/lib/facebook.php");
@include_once("facebook-connect/lib/fbconfig.php");

if($_SESSION['csUserId']!="" &&  $_SESSION['csUserTypeId']==2)
{
    @header("Location:".SITEROOT."/my-account/my_profile_home");
    exit;
}
elseif($_SESSION['csUserId']!="" &&  $_SESSION['csUserTypeId']==3)
{
    @header("Location:".SITEROOT."/merchant-account/merchant_profile_home");
    exit;
}

$date=date("d-m-Y");
$arr=explode("-",$date);
$dd=$arr[0];
$mm=$arr[1];
$yy=$arr[2];
$smarty->assign("dd",$dd);
$smarty->assign("mm",$mm);
$smarty->assign("yy",$yy);

$range_result = $dbObj->customqry( " SELECT MAX(`id`) AS max_id , MIN(`id`) AS min_id FROM tbl_slide_images ","");
$range_row = @mysql_fetch_object( $range_result );
$random = mt_rand( $range_row->min_id , $range_row->max_id );

$result = $dbObj->customqry(  " SELECT * FROM tbl_slide_images WHERE `id` >= $random LIMIT 0,1 ",""); 
$row = @mysql_fetch_array($result);
$slide_image_id1=$row['id'];
$smarty->assign("slide_image_id1",$slide_image_id1);

if(isset($_POST['submit']))
{
    $result = 'true';
    if(trim($_REQUEST['email']) != "")
    {

        $cnd = "email ='".trim($_REQUEST['email'])."' and isDeleted <> 1";
        $rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
        if($rs != 'n')
        {
            if($row =@mysql_fetch_assoc($rs))
            {
                $result='false';
            }
        }
    }
    if($result == 'true') {
        $_SESSION['profilename']=$_POST['name'];
        $_SESSION['profilelname']=$_POST['lname'];
        $_SESSION['profileemail']=$_POST['email'];
        $_SESSION['profilereenter_email']=$_POST['reenter_email'];
        $_SESSION['profilepassword']=$_POST['password'];
        $_SESSION['profilesel_gender']=$_POST['sel_gender'];
        $_SESSION['profilebdate']=$_POST['sel_dd']."-".$_POST['sel_mm']."-".$_POST['sel_yy'];

        //@header("Location:".SITEROOT."/profileinfo");
        header("Location:".SITEROOT."/profilestep");
        exit;
    }
    else {
        $smarty->assign('name',$_POST['name']);
        $smarty->assign('lname',$_POST['lname']);
        $smarty->assign('email', $_POST['email']);    
        $smarty->assign('gender',$_POST['sel_gender']);
        $smarty->assign('sel_dd',$_POST['sel_dd']);
        $smarty->assign('sel_mm',$_POST['sel_mm']);
        $smarty->assign('sel_yy',$_POST['sel_yy']);
        $smarty->assign('email_exist',"1");
    }
}

if($_SESSION['msg1']!="")
{
    $msg_success=$_SESSION['msg1'];
    $smarty->assign("msg_success",$msg_success);
    unset($_SESSION['msg1']);
}

$year=date("Y")-17;
$smarty->assign("year",$year);

//login code
if(isset($_POST['submit_login']))
{
    if(isset($_POST['lemail']) && isset($_POST['lpassword']))
    {
        $query = "select * from tbl_users where email='".trim($_POST['lemail'])."' and password = '".trim(md5($_POST['lpassword']))."' and isverified ='yes' and status='active' and isDeleted=0 and usertypeid!=1";
         
        $res = @mysql_query($query);
        $num = @mysql_num_rows($res);
        if($num>0)
        {
            $usersInfo = mysql_fetch_object($res);
            $usersInfo->usertypeid;
            if($usersInfo->usertypeid == 2)
            {
                if($_POST['isremember'] == 1)
                {
                    setcookie("lemail", $_POST['lemail'],time()+3600);
                    setcookie("lpassword", $_POST['lpassword'],time()+3600);
                    setcookie("isremember", 1);
                }
                else
                {
                    setcookie("lemail", "");
                    setcookie("lpassword", "");
                    setcookie("isremember", 0);
                }
// 		echo "hello" ;exit;
                $_SESSION['usrLgn']        = "TRUE";
                $_SESSION['csUserId']      =  $usersInfo->userid;
                if($usersInfo->usertypeid == 2)
		{
                    $_SESSION['csFullName']    =  $usersInfo->fullname;
		}
		else	
		{
                    $_SESSION['csFullName']    =  $usersInfo->business_name;
		}
                $_SESSION['csEmail']    	  =  $usersInfo->email;
                $_SESSION['csUserTypeId']  =  $usersInfo->usertypeid;
                $_SESSION['csUserAvtar']   =  ((strlen(trim($usersInfo->pic_image))>0)?$usersInfo->pic_image:"noimage");
   
                $f_array = array(
                    "userid"     => $usersInfo->userid,
                    "login_date"      => date("Y-m-d H:i:s"),
                    "ipaddress"       => $_SERVER['REMOTE_ADDR']
                );
   
                $dbObj->cgii("tbl_login_log",$f_array,"");

 		$_SESSION['sign-in-message']="<span>".getFrontErrorMessage(1)."</span>";
		$previous_page=$_SESSION['previous_page'];
		if($_SESSION['previous_page']!="")
		{
                    $previoue_page="";
                    header("Location:".$_SESSION['previous_page']);
                    exit;
		}
		else
                {
                    if($_SESSION['csUserTypeId']==2)
                    {
                        @header("Location:".SITEROOT."/my-account/my_profile_home");
                        exit;
                    }
                    elseif($_SESSION['csUserTypeId']==3)
                    {
                        $res=$dbObj->customqry("select * from tbl_deal_condition where merchant_id=".$_SESSION['csUserId'],"");
                        $num=@mysql_num_rows($res);
                        if($num>0)
                            $_SESSION['alertpopup']="no";
                        else
                            $_SESSION['alertpopup']="yes";
		
			@header("Location:".SITEROOT."/merchant-account/merchant_profile_home");
			exit;
                    }
		}
            }
            else
            {
            }
        }
        else
        {
            $login_error = "The email id or password you entered is incorrect.";
        }
    }
    else
    {
        $login_error = "Please provide username or password";
    }
    $smarty->assign("login_error",$login_error);
}

//login code

$smarty->display(TEMPLATEDIR.'/index.tpl');

$dbObj->Close();
?>
