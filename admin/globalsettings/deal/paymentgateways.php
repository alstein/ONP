<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#


#-----------Delete Articles--------------#
if(isset($_POST['Save']))
{
 extract($_POST);

$getpaymentflag=$paymentmethod[0];
$temp = $dbObj->customqry("update tbl_paymentflag set selected_flag='$getpaymentflag' where  id='1'","");
 $_SESSION['msg']="<span class='success'>Payment method set successfully</span>";
     
 header("location:".$_SERVER['HTTP_REFERER']);
      exit;
     
   }
   #--------------End-----------------------#







   $res = $dbObj->gj("tbl_paymentflag","*","id='1'","","","","", "");
   $row=@mysql_fetch_assoc($res);
   $smarty->assign("paymentvalue",$row['selected_flag']);
  
   
 #----------Success message=--------------#
   if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }
   #--------------End-----------------------#

   $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/paymentgateways.tpl'); 
    $dbObj->Close();
?>
