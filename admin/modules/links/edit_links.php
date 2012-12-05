<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
$msobj= new message();

   if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


   //NOTIFICATION FREE VOUCHER LINK
   $rs1 = $dbObj->gj("sitesetting", "*", "id=28","","", "", "", "");
   $array=@mysql_fetch_array($rs1);
 
   $smarty->assign("freevoucher",$array);

   //MONEY BACK LINK
   $rs2 = $dbObj->gj("sitesetting", "*", "id=29","","", "", "", "");
   $manyback=@mysql_fetch_array($rs2);
   
   $smarty->assign("manyback",$manyback);

   //TRAVEL LINK
   $rs3 = $dbObj->gj("sitesetting", "*", "id=30","","", "", "", "");
   $travel=@mysql_fetch_array($rs3);
   $smarty->assign("travel",$travel);

   //SERVICES LINK
   $rs4 = $dbObj->gj("sitesetting", "*", "id=31","","", "", "", "");
   $services=@mysql_fetch_array($rs4);
   $smarty->assign("services",$services);

   if($_POST['Update'])
   {
      //NOTIFICATION FREE VOUCHER LINK
      $value=$_POST['freevoucher'];
      $dbObj->cupdt("sitesetting",array("value"),array($value),"id","28","");

      //MONEY BACK LINK
      $log_value=$_POST['monyback'];
      $dbObj->cupdt("sitesetting",array("value"),array($log_value),"id","29","");

     //TRAVEL LINK
      $url_value=$_POST['travel'];
      $dbObj->cupdt("sitesetting",array("value"),array($url_value),"id","30","");

     //SERVICES LINK
      $ser_value=$_POST['services'];
      $dbObj->cupdt("sitesetting",array("value"),array($ser_value),"id","31","");

       $s=$msobj->showmessage(206);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/admin/modules/links/edit_links.php");
       exit;
      
   }
   if(isset($_SESSION['msg'])){
      $smarty->assign("msg", $_SESSION['msg']);
      unset($_SESSION['msg']);
   }
  
  $smarty->display(TEMPLATEDIR . '/admin/modules/links/edit_links.tpl');

   $dbObj->Close();
?>