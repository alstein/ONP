<?php
include_once('../../includes/SiteSetting.php');
//include_once('../../includes/class.message.php');
//$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


//option_1
   $rs1 = $dbObj->gj("sitesetting", "*", "id=51","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("qr_link",$array);

   //option_1
   $rs1 = $dbObj->gj("sitesetting", "*", "id=52","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("option_1",$array);
   
   //option_2
   $rs1 = $dbObj->gj("sitesetting", "*", "id=53","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("option_2",$array);
   
   //option_3
   $rs1 = $dbObj->gj("sitesetting", "*", "id=54","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("option_3",$array);
   
   //option_4
   $rs1 = $dbObj->gj("sitesetting", "*", "id=55","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("option_4",$array);
   
   //option_5
   $rs1 = $dbObj->gj("sitesetting", "*", "id=56","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("option_5",$array);

  
   if($_POST['Update'])
   {
      //SMS
      $sms_value=$_POST['qr_link'];
      $dbObj->cupdt("sitesetting",array("value"),array($sms_value),"id","51","");

    //SMS
      $sms_value=$_POST['option_1'];
      $dbObj->cupdt("sitesetting",array("value"),array($sms_value),"id","52","");
      
      //Email
      $email_value=$_POST['option_2'];
      $dbObj->cupdt("sitesetting",array("value"),array($email_value),"id","53","");
      
      //SMS
      $sms_value=$_POST['option_3'];
      $dbObj->cupdt("sitesetting",array("value"),array($sms_value),"id","54","");

      //Email
      $email_value=$_POST['option_4'];
      $dbObj->cupdt("sitesetting",array("value"),array($email_value),"id","55","");
      
      //Email
      $email_value=$_POST['option_5'];
      $dbObj->cupdt("sitesetting",array("value"),array($email_value),"id","56","");

      // $s=$msobj->showmessage(240);
       $_SESSION['msg']="<span class='success'>QR Code updated successfully.</span>";
      // $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/mastermanagement/qr_code_setting.php");
       exit;
      
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/qr_code_setting.tpl');

   $dbObj->Close();
?>