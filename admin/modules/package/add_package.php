<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}
 if(isset($_POST["submit"]))
 {
	extract($_POST);
//             $doller = "";
//             $per = "";
//             if($_POST['signmark'] == "$")
//             {
//                 $doller = $_POST['costper'];
//                // $per = "";
//             }
//             else
//             {
//                 $per = $_POST['costper'];
//                // $doller = "";
//             }

          $field = array(
                            "pack_name"=>$_POST['pacname'],
                            "allow_deals_per_month"=>$_POST['deals'],
                            "pack_price"=>$_POST['packprice'],
                            "cost_per_success_deal"=>$_POST['costper'], //$per,
                            "cost_per_success_deal_percent_doller"=>$_POST['signmark'],// $doller,
                            "cost_sms_deal"=>$_POST['costperdeal'],
                            "pack_duration"=>$_POST['packduration'],
                            "status"=>$_POST['action']
                        );
          $subcat_id = $dbObj->cgii("tbl_subscription_package",$field,"");
            //$id=$dbObj->cgi($tbl, $f, $v, "");
	    $s=$msobj->showmessage(193);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	    $smarty->assign("msg",$s);
	    header("Location: package_list.php");
	   exit;
}
$smarty->display(TEMPLATEDIR . '/admin/modules/package/add_package.tpl');
$dbObj->Close();
?>