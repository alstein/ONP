<?php

$PATH_PREFIX = "../";
include_once('../../include.php');

if(isset($_POST['submit_login'])){
      if(isset($_POST['lemail']) && isset($_POST['lpassword'])){
         
            $query = "select * from tbl_users where email='".trim($_POST['lemail'])."' and password = '".trim(md5($_POST['lpassword']))."' and isverified ='yes' and status='active' and isDeleted=0";
         
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
               $_SESSION['csFullName']    =  $usersInfo->fullname;
               $_SESSION['csEmail']    	  =  $usersInfo->email;
               $_SESSION['csUserTypeId']  =  $usersInfo->usertypeid;
               $_SESSION['csUserAvtar']   =  ((strlen(trim($usersInfo->pic_image))>0)?$usersInfo->pic_image:"noimage");
   
               $f_array = array("userid"     => $usersInfo->userid,
                           "login_date"      => date("Y-m-d H:i:s"),
                           "ipaddress"       => $_SERVER['REMOTE_ADDR']);
   
               $dbObj->cgii("tbl_login_log",$f_array,"");
// 		$default_city=$dbObj->customqry("select * from mast_city where default_city='1'","");
// 		$redirect_default=@mysql_fetch_assoc($default_city);
// 
// 		$redirect_city=strtolower($redirect_default['city_name']);
// 		$new_city=str_replace(" ","-",$redirect_city);

 		$_SESSION['sign-in-message']="<span>".getFrontErrorMessage(1)."</span>";
		$previous_page=$_SESSION['previous_page'];
		if($_SESSION['previous_page']!="")
		{
			$previoue_page="";
			header("Location:".$_SESSION['previous_page']);
			exit;
		}
		else{

			header("Location:".SITEROOT."/myaccount");
			exit;

		}	

            }
        else{
            }
         }
         else{
             $login_error = "Your email and or password is incorrect. Please try again.";
            
         }
         
      }else{
	
         $login_error = "Please provide username or password";
      }

      $smarty->assign("login_error",$login_error);
   }
$smarty->display(TEMPLATEDIR.'/modules/login/login.tpl');

$dbObj->Close();
?>