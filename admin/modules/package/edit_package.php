<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

$msobj= new message(); 	
 	if(isset($_GET['editid']))
        {
           $sql="select * from tbl_subscription_package where id=".$_GET['editid'];
           $rs=mysql_query($sql) or die(mysql_error());
           $page=mysql_fetch_assoc($rs);
        }
          $smarty->assign("page", $page);
if(isset($_POST['submit']))
{
  $editid=$_GET['editid'];
  extract($_POST);
//             $doller = "";
//             $per = "";
//             if($_POST['signmark'] == "$")
//             {
//                 $doller = $_POST['costper'];
//                 $per = "";
//             }
//             else
//             {
//                 $per = $_POST['costper'];
//                 $doller = "";
//             }

          $field = array(
                            "pack_name"=>$_POST['pacname'],
                            "allow_deals_per_month"=>$_POST['deals'],
                            "pack_price"=>$_POST['packprice'],
                            "cost_per_success_deal"=>$_POST['costper'],//$per,
                            "cost_per_success_deal_percent_doller"=>$_POST['signmark'],//$doller,
                            "cost_sms_deal"=>$_POST['costperdeal'],
                            "pack_duration"=>$_POST['packduration'],
                            "status"=>$_POST['action']
                        );
             $dbObj->cupdtii("tbl_subscription_package",$field,"id=".$editid,"");
             $s=$msobj->showmessage(194);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	     $smarty->assign("msg",$s);
	     header("Location: package_list.php");
	     exit;
}
$smarty->display(TEMPLATEDIR . '/admin/modules/package/edit_package.tpl');
$dbObj->Close();
?>