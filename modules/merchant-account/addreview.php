<?php
@session_start();
@ob_start();
@include_once("../../include.php");
//include_once("../../includes/libs/plugins/function.getrating.php");
$merchantid=$_GET['merchantid']; 
        $sqluser="SELECT * FROM tbl_users WHERE userid=".$merchantid;
		$retress = $dbObj->customqry($sqluser);
        $resultuser=mysql_fetch_array($retress);
		$merchantname=$resultuser['business_name'];
        $sqluser_use="SELECT * FROM tbl_users WHERE userid=".$_SESSION['csUserId'];
        $retress_use = $dbObj->customqry($sqluser_use);
        $resultuser_user=mysql_fetch_array($retress_use);
        $username=$resultuser_user['fullname'];
        $smarty->assign("merchant",$merchantname);
        $smarty->assign("username",$username);
	$sqlre="SELECT * FROM tbl_rating WHERE user_id=".$_SESSION['csUserId']." AND merchant_id=".$_GET['merchantid']." ";
	$retres = $dbObj->customqry($sqlre, "");
	$numrets=@mysql_num_rows($retres);
	
	$smarty->assign("numrets",$numrets);
	$smarty->assign("fbid",FACEBOOKAPPID);
        
        
if($_POST['Submit']) 
{
	extract($_POST);
	$char=substr($fan_ratesel_,1,1);
	$merchantid=$_GET['merchantid'];
	$date=date("Y-m-d H:m:s");
	$prn = "";
        $rewards=0;
        $flag=1;
	$f = array("merchant_id", "user_id", "feedback","summary", "average_rating", "rating_date");
	$v = array($merchantid,$_SESSION['csUserId'],$dtlss,$summary,$char, $date);
	$res = $dbObj ->cgi('tbl_rating' , $f , $v , $prn);


	$sel_review=$dbObj->customqry("select * from tbl_rating where rating_id='".$res."'","");
	$res_review=@mysql_fetch_assoc($sel_review);
	$review=$res_review['feedback'];
	$review_1=substr($review,0,150);

	$user_name=$dbObj->customqry("select * from tbl_users where userid='".$_SESSION['csUserId']."'","");
	$res_user_name=@mysql_fetch_assoc($user_name);
	$uname='<a style="color:#044EA2;"  href="'.SITEROOT.'/my-account/'.$_SESSION['csUserId'].'/my_profile" target="_blank">'.$res_user_name['first_name']." ".$res_user_name['last_name'].'</a>';
	
	$business_name=$dbObj->customqry("select * from tbl_users where userid='".$merchantid."'","");
	$res_business_name=@mysql_fetch_assoc($business_name);
	$business_name='<a style="color:#044EA2;" href="'.SITEROOT.'/merchant-account/'.$merchantid.'/merchant_profile" target="_blank">'. $res_business_name['business_name'].'</a>';

	$msg_review=$uname."  wrote a review on  ".$business_name."<br>".'<a href="'.SITEROOT.'/my-account/'.$_SESSION['csUserId'].'/my_review">'.wordwrap($review_1, 80, "\n", true).'...</a>'; 

	$date=Date("Y:m:d H:i:s");
	$insert_activity=$dbObj->customqry("insert into tbl_activity(msg,vault_t,timestamp,wall,uid,fid)values('".$msg_review."','status','".$date."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."')","");
        //.....................adding reward points..............................//
        
        
	$select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=".$flag,"");
        $rsltset=@mysql_fetch_assoc($select);
        
        $select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=4","");
        $total=@mysql_fetch_assoc($select);
        
        if($rsltset['reward']!=""){
            
            
            $rewards=$rsltset['reward']+5;
            $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=".$flag,"");
            $rsltset=@mysql_fetch_assoc($select);
        }
        else{
            $rewards=5;
            $variables = array("userid", "rewardpoints","flag");
            $datava = array($_SESSION['csUserId'],$rewards,$flag);
            $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
        }
 
      if($total['reward']!=""){
                $rewards=$total['reward']+5;
                $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=4","");
                $rsltset=@mysql_fetch_assoc($select);
      }
      
      else{
          $rewards= 5;
          $variables = array("userid", "rewardpoints","flag");
          $datava = array($_SESSION['csUserId'],$rewards,4);
          $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
      }
        
        
        
	$mar_name=$dbObj->cgs("tbl_users","*","userid","$merchantid","","","");
	$mar_fetch=@mysql_fetch_assoc($mar_name);
	$mar_fetch['business_name'];
	$mast_id =$dbObj->cgs("mast_emails","*","emailid","85","","","");
	$mast_mail = @mysql_fetch_object($mast_id);
			
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $mast_mail->subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($mast_mail->message),$email_message);
			
		   $email_message = str_replace("[[Merchant_name]]",$mar_fetch['business_name'],$email_message);
			$email_message = str_replace("[[Name]]",$_SESSION['csFullName'],$email_message);
		
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[TODAYS_DATE]]",$today,$email_message);
			
			//$email_message = str_replace("[[fname]]",$user1['first_name'],$email_message);
			$email_message = str_replace("[[email]]",$mar_fetch['email'],$email_message);
			//$email_message = str_replace("[[password]]",$pass,$email_message);
			//echo $email_message;

			$email = $mar_fetch['email'];
			$from = SITE_EMAIL;
			@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			$_SESSION['msg_succ']="Your Review message has been sent to the marchant email account.";
// 			echo "email==".$email;
// 			echo "<br>subjects==".$email_subject;
// 			echo $email_message;exit;
	           
                   
	?>
		<script type="text/javascript" language="javascript">
			window.parent.location.reload();
		</script>

	<?php

    
}
$smarty->display(TEMPLATEDIR."/modules/merchant-account/addreview.tpl");
$dbObj->Close();
?>