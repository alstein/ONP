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


$rs=$dbObj->cgs("tbl_deal","seller_id,title","deal_unique_id",$_GET['id'],"","","");
$row=@mysql_fetch_assoc($rs);

$rs_seller=$dbObj->cgs("tbl_users","userid,first_name,last_name,email","userid",$_GET['id'],"","","");
$row_seller=@mysql_fetch_assoc($rs_seller);

$smarty->assign("seller",$row_seller);




if($_POST['submit']=="Send")
{
	extract($_POST);
	
	  $getuserid=$_GET['id'];

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
             $message = str_replace("[reason]",$_POST['reason'],$message);
             $message = str_replace("[firstname]",$user_rec['first_name'],$message);
             $message = str_replace("[lastname]",$user_rec['last_name'],$message);
                      
                       
            $from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
           
           
            $flag=@mail($user_rec['email'],$title,$message,$headers);
       
       $id = $dbObj->customqry("update tbl_users set verification = '2' where userid='$getuserid'","");
       $s=$msobj->showmessage(184);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

                   $field = array(
                "user_type"=>1,
                "from_id"=>1,
                "user_id"=>$getuserid,
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

$smarty->display( TEMPLATEDIR.'/admin/user/reject-popup.tpl');

?>