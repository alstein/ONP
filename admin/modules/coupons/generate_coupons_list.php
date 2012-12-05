<?php 
include_once("../../../include.php");
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
//include_once('../../../includes/class.message.php');


if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


#--------Action-----------#
if(isset($_POST['action']))
{
	extract($_POST);
	$coupon_id = implode(", ", $coupon_id);

	if($action == "delete")
		{
			$temp = $dbObj->customqry("delete from tbl_coupon_master where coupon_id in (".$coupon_id.")","");
			$_SESSION['msg']="<span class='success'>Promotional Code Deleted Successfully.</span>";
		}

		header("Location:generate_coupons_list.php");
		exit;
	
}
#---------END-----------#

#------------Pagination Part-1------------#

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];
	$adsperpage =20;
	$StartRow = $adsperpage * ($page-1);
	$l= $StartRow.','.$adsperpage;
/*-----------------------------------*/

	$cnd= "1";
	$sf="c.*";
	$ob="coupon_id";
	$rs=$dbObj->gj("tbl_coupon_master c",$sf,$cnd, $ob, "", "", $l, "");

while($row=@mysql_fetch_array($rs))
{
	$coupondet[]=$row;
}

$smarty->assign("coupondet",$coupondet);

/*----------Pagination Part-2--------------*/

	$rs=$dbObj->gj("tbl_coupon_master c",$sf,$cnd, $ob, "", "", "", "");
	$nums = @mysql_num_rows($rs);
	$show = 5;
	$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1){
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = "generate_coupons_list.php";

	$seperator = '?page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}

#-----------------------------------#

if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}


	$smarty->display(TEMPLATEDIR.'/admin/modules/coupons/generate_coupons_list.tpl');

	$dbObj->Close();
?>