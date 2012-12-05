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
            "dealid"=>$_GET['id'],
            "seller_id"=>$_POST['sellerid'],
            "start_date"=>$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'].":00",
	    "end_date"=>$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'].":00",
            "final_value"=>$_POST['estimatedfees'],
            "listing_value"=>$_POST['listingfees'],
            "charged_percentage"=>$_POST['chargepercentage'],
            "posted_date"=>date('Y-m-d')
        );
        $dbObj->cgii("tbl_dealquate",$field,"");

        $mail_rs = $dbObj->cgs("mast_emails","","emailid",4,"","","");
        if($mail_rs != "n")
        {
            $mail = mysql_fetch_assoc($mail_rs);
            
            $user_rs = $dbObj->cgs("tbl_users","first_name,last_name,email","userid",$_POST['sellerid'],"","","");
            $user = @mysql_fetch_assoc($user_rs);

            $message = str_replace("[firstname]",$user['first_name'],$mail['message']);
            $message = str_replace("[lastname]",$user['last_name'],$message);
            $message = str_replace("[sdate]",$_POST['dob1']." ".$_POST['start_hour'].":".$_POST['start_min'],$message);
            $message = str_replace("[edate]",$_POST['dob2']." ".$_POST['end_hour'].":".$_POST['end_min'],$message);
            $message = str_replace("[final_fees]",$_POST['estimatedfees'],$message);
            $message = str_replace("[listing_fees]",$_POST['listingfees'],$message);
            $message = str_replace("[charge_percentage]",$_POST['chargepercentage'],$message);
            $message = nl2br($message);

            $from = "info@groupbuyit.com";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From:'.$from . "\r\n";
    
            @mail($user['email'],$mail['subject'],$message,$headers);
        }

        $field = array(
            "from_id"=>$_SESSION['duAdmId'],
            "user_id"=>$_POST['sellerid'],
            "subject"=>$mail['subject'],
            "message"=>$message,
            "posted_date"=>date('Y-m-d H:i:s')
        );
        $dbObj->cgii("tbl_message",$field,"");

        $s=$msobj->showmessage(151);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

        header("Location:".SITEROOT."/admin/globalsettings/deal/view-deal.php");
        exit;
    }

    $i = 0;
    $hr = array();	
    for($hh = 0; $hh <=23; $hh++) 
    {
            if($hh<10)
                    $hh = "0$hh"; 
            else
                    $hh = $hh;
            $hr[$i] = $hh;
            $i++;
    }
    $rev_hr = array_reverse($hr);
    $smarty->assign("rev_hr",$rev_hr);
    $smarty->assign("hr",$hr);

    $i = 0;
    $min = array();	
    for($mm = 0; $mm <=59; $mm++) 
    {
            if($mm<10)
                    $mm = "0$mm"; 
            else
                    $mm = $mm;
            $min[$i] = $mm;
            $i++;
    }
    $rev_min = array_reverse($min);
    $smarty->assign("rev_min",$rev_min);
    $smarty->assign("min",$min);

    if(isset($_GET[id]))
    {
        $rs = $dbObj->gj("tbl_dealquate","*","dealid = '".$_GET['id']."'","","","","","");
        if($rs != "n")
        {
            $deal_info = mysql_fetch_assoc($rs);
            $smarty->assign("deal_info",$deal_info);
            $sdate = explode(" ",$deal_info['start_date']);
            $edate = explode(" ",$deal_info['end_date']);
            $smarty->assign("start_date",$sdate[0]);
            $smarty->assign("end_date",$edate[0]);
            $stime = explode(":",$sdate[1]);
            $etime = explode(":",$edate[1]);
            $smarty->assign("s_hr",$stime[0]);
            $smarty->assign("s_min",$stime[1]);
            $smarty->assign("e_hr",$etime[0]);
            $smarty->assign("e_min",$etime[1]);
        }
        else
        {
            $sf = "start_date,end_date,final_value,listing_value,seller_id";
            $cnd = "deal_unique_id = '".$_GET['id']."'";
            $rs = $dbObj->gj("tbl_deal",$sf,$cnd,"","","","","");
            if($rs != "n")
            {
                $deal_info = mysql_fetch_assoc($rs);
            }
            $smarty->assign("deal_info",$deal_info);
            $sdate = explode(" ",$deal_info['start_date']);
            $edate = explode(" ",$deal_info['end_date']);
            $smarty->assign("start_date",$sdate[0]);
            $smarty->assign("end_date",$edate[0]);
            $stime = explode(":",$sdate[1]);
            $etime = explode(":",$edate[1]);
            $smarty->assign("s_hr",$stime[0]);
            $smarty->assign("s_min",$stime[1]);
            $smarty->assign("e_hr",$etime[0]);
            $smarty->assign("e_min",$etime[1]);
        }
    }

    $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/deal-quate.tpl'); 
    $smarty->Close();
?>