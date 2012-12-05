<?php
include_once('../../includes/SiteSetting.php');
//include_once('../../includes/class.message.php');
//$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


   //SMS
   $rs1 = $dbObj->gj("sitesetting", "*", "id=34","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("sms",$array);

   //Email
   $rs2 = $dbObj->gj("sitesetting", "*", "id=35","","", "", "", "");
   $twitter=@mysql_fetch_array($rs2);
   
   $smarty->assign("email",$twitter);

   if($_POST['Update'])
   {
      //SMS
      $sms_value=$_POST['sms'];
      $dbObj->cupdt("sitesetting",array("value"),array($sms_value),"id","34","");

      //Email
      $email_value=$_POST['email'];
      $dbObj->cupdt("sitesetting",array("value"),array($email_value),"id","35","");

      // $s=$msobj->showmessage(240);
       $_SESSION['msg']="<span class='success'>Cost per sms and email updated successfully.</span>";
      // $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/mastermanagement/cost_per_sms.php");
       exit;
      
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/cost_per_sms.tpl');

   $dbObj->Close();
?>