<?php
include_once("../../../includes/common.lib.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

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


$rs=$dbObj->cgs("tbl_deal","seller_id,title","deal_unique_id",$_GET['id'],"","","");
$row=@mysql_fetch_assoc($rs);

$rs_seller=$dbObj->cgs("tbl_users","userid,first_name,last_name,email","userid",$row['seller_id'],"","","");
$row_seller=@mysql_fetch_assoc($rs_seller);

$smarty->assign("seller",$row_seller);




if($_POST['submit']=="Send")
{
	extract($_POST);
	
	$temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes', deal_status = 2, reject_by_id=".$_SESSION['duAdmId']." where deal_unique_id=".$_GET['id'], "");
	$_SESSION['msg']="<span class='success'>Deal rejected successfully.</span>";
       

         #--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(15),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));
                
                #--end--#     
            $title=$mail['subject'];

        
                ob_start();
                include('../../../email/deal-reject.html');
                $filedata = ob_get_contents();
                ob_end_clean();

            $message = str_replace("[SITEROOT]",SITEROOT,$filedata);
            $message = str_replace("[SUBJECT]", $mail['subject'],$message);
            $message = str_replace("[[EMAIL_HEADING]]",$mail_content,$message);    
            $message = str_replace("[userid]",$row_seller['userid'],$message);
            $message = str_replace("[firstname]",$row_seller['first_name'],$message);
            $message = str_replace("[lastname]",$row_seller['last_name'],$message);
            $message = str_replace("[in_date]",date('m-d-Y'),$message);
            $message = str_replace("[dealname]",$row['title'],$message);
            $message = str_replace("[reason]",$reason,$message);    
            
            //echo   $message;  
                
             $from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
            $flag=@mail($row_seller['email'],$title,$message,$headers);
            $flag=@mail("s.prakash@agiletechnosys.com",$title,$message,$headers);    
            

            $field = array(
                "user_type"=>1,
                "from_id"=>1,
                "user_id"=>$row_seller['userid'],
                "subject"=>$title,
                "message"=>$message,
                "posted_date"=>date('Y-m-d H:i:s')
            );
            $dbObj->cgii("tbl_message",$field,"");


        
	
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

$smarty->display( TEMPLATEDIR.'/admin/globalsettings/deal/reject-popup.tpl');

?>
