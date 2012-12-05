<?php
include_once('../../includes/SiteSetting.php');
//include_once('../../includes/class.message.php');
//$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


   //Group Buy Deals Setting
   $rs1 = $dbObj->gj("sitesetting", "*", "id=43","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("group_scroll",$array);

   //Group Buy Deals Setting
   $rs1 = $dbObj->gj("sitesetting", "*", "id=44","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("group_speed",$array);

   //Daily Deals setting
   $rs1 = $dbObj->gj("sitesetting", "*", "id=45","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("daily_scroll",$array);

   //Daily Deals setting
   $rs2 = $dbObj->gj("sitesetting", "*", "id=46","","", "", "", "");
   $setting=@mysql_fetch_array($rs2);
   
   $smarty->assign("daily_speed",$setting);
   
   //Free coupans setting
   $rs1 = $dbObj->gj("sitesetting", "*", "id=47","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("free_scroll",$array);

  //Free coupans setting
   $rs2 = $dbObj->gj("sitesetting", "*", "id=48","","", "", "", "");
   $setting=@mysql_fetch_array($rs2);
   
   $smarty->assign("free_speed",$setting);
   
   //Travel bar setting
   $rs1 = $dbObj->gj("sitesetting", "*", "id=49","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
   $smarty->assign("travel_scroll",$array);

  //Travel bar setting
   $rs2 = $dbObj->gj("sitesetting", "*", "id=50","","", "", "", "");
   $setting=@mysql_fetch_array($rs2);
   
   $smarty->assign("travel_speed",$setting);

   if($_POST['Update'])
   {
      //Group Buy Deals Setting
      $refer_value=$_POST['group_scroll'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","43","");

      //Group Buy Deals Setting
      $refer_value=$_POST['group_speed'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","44","");

      //Daily Deals setting
      $refer_value=$_POST['daily_scroll'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","45","");

     //Daily Deals setting
      $setting_value=$_POST['daily_speed'];
      $dbObj->cupdt("sitesetting",array("value"),array($setting_value),"id","46","");
      
        //Free coupans setting
      $refer_value=$_POST['free_scroll'];
      $dbObj->cupdt("sitesetting",array("value"),array($refer_value),"id","47","");

      //Free coupans setting
      $setting_value=$_POST['free_speed'];
      $dbObj->cupdt("sitesetting",array("value"),array($setting_value),"id","48","");

      //Travel setting
      $travel_value=$_POST['travel_scroll'];
      $dbObj->cupdt("sitesetting",array("value"),array($travel_value),"id","49","");

      //Travel setting
      $travel_value=$_POST['travel_speed'];
      $dbObj->cupdt("sitesetting",array("value"),array($travel_value),"id","50","");
      // $s=$msobj->showmessage(240);
       $_SESSION['msg']="<span class='success'>scroll settings updated successfully.</span>";
      // $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/mastermanagement/scroll_setting.php");
       exit; 
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/mastermanagement/scroll_setting.tpl');

   $dbObj->Close();
?>