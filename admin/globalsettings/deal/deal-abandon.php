<?php
    include_once('../../../includes/SiteSetting.php');
    include_once('../../../includes/class.message.php');

    $msobj= new message();
    if(!$_SESSION['duAdmId'])
    {
        header("location:".SITEROOT . "/admin/login/index.php");
        exit;
    }

    if(isset($_POST['submit']))
    { 
        $field = array(
            "dealid"=>$_GET['dealid'],
            "seller_id"=>$_GET['userid'],
            "start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
	    "end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
            "final_value"=>$_POST['estimatedfees'],
            "listing_value"=>$_POST['listingfees'],
            "charged_percentage"=>$_POST['chargepercentage'],
            "posted_date"=>date('Y-m-d')
        );
       

        
         $user_rs = $dbObj->cgs("tbl_users","first_name,last_name,email","userid",$_GET['userid'],"","","");
             $user = @mysql_fetch_assoc($user_rs);


              $email_query = "select * from mast_emails where emailid=46";
	$email_rs = mysql_query($email_query);
	$email_row = mysql_fetch_object($email_rs);

	$email_message = file_get_contents(ABSPATH."/email/deal_notification.html");
	$email_message  = str_replace("[[EMAIL_HEADING]]",html_entity_decode($email_row->subject),$email_message);
	$email_message  = str_replace("[[CONTENT]]",html_entity_decode($email_row->message),$email_message);
	$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
	$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
	$email_message = str_replace("[[DEALNAME]]", ucwords($rs_dealinfo['title']), $email_message);
	$email_message = str_replace("[firstname]", $user['first_name'], $email_message);
  $email_message = str_replace("[lastname]",$user['last_name'],$email_message);
 $email_message = str_replace("[[content]]",$_POST['gbi_comment'],$email_message);
//echo $email_message;exit;
	$from ="GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";	
	@mail($user['email'],$email_row->subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");




//             $mail = mysql_fetch_assoc($mail_rs);
//             
//             $user_rs = $dbObj->cgs("tbl_users","first_name,last_name,email","userid",$_GET['userid'],"","","");
//             $user = @mysql_fetch_assoc($user_rs);
// 
//             $message = str_replace("[firstname]",$user['first_name'],$mail['message']);
//             $message = str_replace("[lastname]",$user['last_name'],$message);
//             $message = str_replace("[sdate]",$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'],$message);
//             $message = str_replace("[edate]",$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'],$message);
//             $message = str_replace("[final_fees]",$_POST['estimatedfees'],$message);
//             $message = str_replace("[listing_fees]",$_POST['listingfees'],$message);
//             $message = str_replace("[[content]]",$_POST['gbi_comment'],$message);
//             $message = nl2br($message);
// 
//             $from = "info@groupbuyit.com";
// 
//             $headers  = 'MIME-Version: 1.0' . "\r\n";
//             $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//             $headers .= 'From:'.$from . "\r\n";
//     
//             @mail($user['email'],$mail['subject'],$message,$headers);

    

        $field = array(
            "from_id"=>$_SESSION['duAdmId'],
            "user_id"=>$_GET['userid'],
            "subject"=>$mail['subject'],
            "message"=>$email_message,
            "posted_date"=>date('Y-m-d H:i:s')
        );
        $dbObj->cgii("tbl_message",$field,"");

        $s=$msobj->showmessage(151);
    $msgs="Message sent Successfuly ";
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$msgs."</span>";

        header("Location:".SITEROOT."/admin/globalsettings/deal/abandoneddeal.php");
        exit;
    }

   
    
        $rs = $dbObj->gj("tbl_deal","*","deal_unique_id = '".$_GET['dealid']."'","","","","","");
         $row=@mysql_fetch_assoc($rs);
        $smarty->assign("dealname",$row['title']);
        

    $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/deal-abandon.tpl'); 
    $smarty->Close();
?>