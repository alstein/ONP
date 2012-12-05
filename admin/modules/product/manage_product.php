<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
#--------------actions---------------#
if($_POST['action'])
	{
		extract($_POST);
		$prod_ids = @implode(", ", $prod_id);
		if($prod_ids)
		{
			if($_POST['action'] == "delete")
			{

	                         $sel= $dbObj->customqry("SELECT * FROM `tbl_products` WHERE `product_id` IN (".$prod_ids.")","");
        	                   $munrs=mysql_num_rows($sel);
$delall = $dbObj->customqry("delete from `tbl_products` where product_id in (".$prod_ids.")","");
                                $id = $dbObj->customqry("delete from tbl_products where product_id in (".$prod_ids.")","");
				$_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
			}
			elseif($_POST['action'] == "active")
			{
                            $temp = $dbObj->customqry("update tbl_products set status = 'Active' where product_id IN (".$prod_ids.")","");
                            $_SESSION['msg']="<span class='success'>Deal has been Activated successfully</span>";
			}
			elseif($_POST['action'] == "inactive")
			{
                            $temp = $dbObj->customqry("update tbl_products set status = 'Inactive' where product_id IN (".$prod_ids.")","");
                            $_SESSION['msg']="<span class='success'>Deal has been Inactivated successfully</span>";
			}
		}
		else
		{
			$_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
		}
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
#-----end---------#

#----------Success message=--------------#
	if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}
	#--------------End-----------------------#

$smarty->display(TEMPLATEDIR.'/admin/modules/product/manage_product.tpl');
?>