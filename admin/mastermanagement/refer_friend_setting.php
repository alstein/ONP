<?php
include_once('../../includes/SiteSetting.php');
//include_once('../../includes/class.message.php');
//$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


   //Refer Amount pound
   $rs1 = $dbObj->gj("sitesetting", "*", "id=39","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("refer_amount_pound",$array);

   //Refer Amount Euro
   $rs1 = $dbObj->gj("sitesetting", "*", "id=40","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("refer_amount_euro",$array);

   //Refer Amount Dollar
   $rs1 = $dbObj->gj("sitesetting", "*", "id=41","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("refer_amount_dollar",$array);

   //setting
   $rs2 = $dbObj->gj("sitesetting", "*", "id=42","","", "", "", "");
   $setting=@mysql_fetch_array($rs2);
   
   $smarty->assign("setting",$setting);

   if($_POST['Update'])
   {
      //Refer amount Pound
      $refer_value=$_POST['refer_amount_pound'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","39","");

      //Refer amount Euro
      $refer_value=$_POST['refer_amount_euro'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","40","");

      //Refer amount Dollar
      $refer_value=$_POST['refer_amount_dollar'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","41","");

      //setting
      $setting_value=$_POST['setting'];
      $dbObj->cupdt("sitesetting",array("value"),array($setting_value),"id","42","");

      // $s=$msobj->showmessage(240);
       $_SESSION['msg']="<span class='success'>Refer friend settings updated successfully.</span>";
      // $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/mastermanagement/refer_friend_setting.php");
       exit;
      
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/refer_friend_setting.tpl');

   $dbObj->Close();
?>