<?php
include_once("../../includes/common.lib.php");
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("8", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


$rs_user=$dbObj->cgs("tbl_users","userid,first_name,last_name,email","userid",$_GET['id'],"","","");
$row_user=@mysql_fetch_assoc($rs_user);

$smarty->assign("user_rs",$row_user);




if($_POST['submit']=="Send")
{
	extract($_POST);
	
	
       

         #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(41),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));
                
                #--end--#     
            $title=$mail['subject'];

        
                ob_start();
                include('../../email/email.html');
                $filedata = ob_get_contents();
                ob_end_clean();

            $message = str_replace("[SITEROOT]",SITEROOT,$filedata);
            $message = str_replace("[SUBJECT]", $mail['subject'],$message);
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);    
            $message = str_replace("[userid]",$row_user['userid'],$message);
            $message = str_replace("[firstname]",$row_user['first_name'],$message);
            $message = str_replace("[lastname]",$row_user['last_name'],$message);
            $message = str_replace("[in_date]",date('m-d-Y'),$message);
          
            $message = str_replace("[message]",$reason,$message);    
            
            //echo   $message; exit; 
                
             $from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
            $flag=@mail($row_user['email'],$title,$message,$headers);
            
            

           
		$temp = $dbObj->customqry("Delete from tbl_users where userid =".$_GET['id'], "");
		//$temp = $dbObj->customqry("Delete from tbl_deal_payment where user_id =".$_GET['id'], "");
		$temp = $dbObj->customqry("Delete from tbl_forum where userid =".$_GET['id'], "");
		$temp = $dbObj->customqry("Delete from tbl_forum_thread where userid =".$_GET['id'], "");
		$temp = $dbObj->customqry("Delete from tbl_wish_list where userid =".$_GET['id'], "");
		$temp = $dbObj->customqry("Delete from tbl_suggest_deal where user_id =".$_GET['id'], "");
		$temp = $dbObj->customqry("Delete from tbl_billing_info where user_id =".$_GET['id'], "");
		//$temp = $dbObj->customqry("Delete from tbl_billing_address where userid =".$_GET['id'], "");

		$_SESSION['msg']="<span class='success'>Account deleted successfully.</span>";	
        
	
//         $s = $msobj->showmessage(157);
// 	$_SESSION['msg'] = "<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        
?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
}

if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }

$smarty->display( TEMPLATEDIR.'/admin/user/remove-account.tpl');

?>