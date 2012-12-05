<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


   //Facebook
   $rs1 = $dbObj->gj("sitesetting", "*", "id=33","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("facebook",$array);

   //Twitter
   $rs2 = $dbObj->gj("sitesetting", "*", "id=32","","", "", "", "");
   $twitter=@mysql_fetch_array($rs2);
   
   $smarty->assign("twitter",$twitter);

   if($_POST['Update'])
   {
      //facebook
      $facebook_value=$_POST['facebook'];
      $dbObj->cupdt("sitesetting",array("value"),array($facebook_value),"id","33","");

      //Twitter
      $twitter_value=$_POST['twitter'];
      $dbObj->cupdt("sitesetting",array("value"),array($twitter_value),"id","32","");

       $s=$msobj->showmessage(240);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/mastermanagement/social_net_setting.php");
       exit;
      
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/social_net_setting.tpl');

   $dbObj->Close();
?>