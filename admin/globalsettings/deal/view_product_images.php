<?php
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/paging.php");
	
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");
	
	#-----------Delete Articles--------------#
extract($_POST);
extract($_GET);


$product_id=$_GET['id'];
	
	if($_POST['action'])
	{

		$deal_ids = @implode(", ", $deal_id);
		if($deal_ids)
		{
			if($_POST['action'] == "delete")
			{
                               ////// unlink the images asociated with the deal //////////////////
                               $sel= $dbObj->customqry("SELECT * FROM `tbl_product_image` WHERE `product_id` IN (".$deal_ids.")","");
                               $munrs=mysql_num_rows($sel);
				if($munrs>0)
				{
					while($rest=mysql_fetch_assoc($sel))
					{
						$img="../../../uploads/".$rest['product_image'];
						$imgcrop="../../../uploads/product/thumbnail/".$rest['thumbnail'];
                                               if($rest['product_image']!="")
						unlink($img);

                                               if($rest['thumbnail']!="")
						unlink($imgcrop);
					}
				}
                               
                                 ///////////////////////entry remove from database //////////////////////////

				$id = $dbObj->customqry("delete from tbl_product_image where image_id in (".$deal_ids.")","");
				$_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
			}
			
		}
		else
		{
			$_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
		}
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	#--------------End-----------------------#
////// images

$cd = "product_id = '".$product_id."'";
$dbres = $dbObj->gj('tbl_product_image', "*" , $cd, "", "","", "", "");	
	
	while($row_results = @mysql_fetch_assoc($dbres))
		$row_result1[]=$row_results;
	$smarty->assign("row_result1", $row_result1);
	$smarty->assign("allimages", $row_result1);
//////////
	#----------------------------------------#
	#----------Success message=--------------#
	if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}
	#--------------End-----------------------#
	
	$smarty->display(TEMPLATEDIR.'/admin/sitemodules/deal/view_product_images.tpl');
?>
