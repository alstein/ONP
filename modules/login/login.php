<?php

$PATH_PREFIX = "../";
include_once('../../include.php');

if(isset($_SESSION['login_error'])){
	$lerror=$_SESSION['login_error'];
	unset($_SESSION['login_error']);
	$smarty->assign("lerror",$lerror);
}

$row_meta=$dbObj->getseodetails(27);
$smarty->assign("row_meta",$row_meta);



if(isset($_POST['submit_login'])){
      if(isset($_POST['lemail']) && isset($_POST['lpassword'])){
         
              $query = "select * from tbl_users where email='".trim($_POST['lemail'])."' and password = '".trim(md5($_POST['lpassword']))."' and isverified ='yes' and status='active' and isDeleted=0 and usertypeid!=1";
         
         $res = @mysql_query($query);
         $num = @mysql_num_rows($res);
         if($num>0){
         
            $usersInfo = mysql_fetch_object($res);
		$usersInfo->usertypeid;
            if($usersInfo->usertypeid == 2){
               if($_POST['isremember'] == 1){
                  setcookie("lemail", $_POST['lemail'],time()+3600);
                  setcookie("lpassword", $_POST['lpassword'],time()+3600);
                  setcookie("isremember", 1);
               }else{
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
   
               $f_array = array("userid"     => $usersInfo->userid,
                           "login_date"      => date("Y-m-d H:i:s"),
                           "ipaddress"       => $_SERVER['REMOTE_ADDR']);
   
               $dbObj->cgii("tbl_login_log",$f_array,"");


 		$_SESSION['sign-in-message']="<span>".getFrontErrorMessage(1)."</span>";
		$previous_page=$_SESSION['previous_page'];
		if($_SESSION['previous_page']!="")
		{
			$previoue_page="";
			header("Location:".$_SESSION['previous_page']);
			exit;
		}
		else{

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
        else{
            }
         }
         else{
             $login_error = "The email id or password you entered is incorrect.";
            
         }
         
      }else{
	
         $login_error = "Please provide username or password";
      }

      $smarty->assign("login_error",$login_error);
   }
$smarty->display(TEMPLATEDIR.'/modules/login/login.tpl');

$dbObj->Close();
?>
