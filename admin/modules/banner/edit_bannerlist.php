<?php
	include_once("../../../include.php");

	extract($_POST);

	$dbObj = new DBTransact();
	$dbObj->Connect();
	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");

	$banner_id = ($_REQUEST['banner_id']?$_REQUEST['banner_id']:0);
	$smarty->assign("banner_id",$banner_id);

	
	
	
	if(strlen(trim($_POST['Submit'])) > 0){
		if($banner_id > 0){
			$image = $_POST['h_product_image'];
			if($_FILES['product_image']['name']){
				if($row1['product_image']){
					@unlink("../../../uploads/banner/".$row1['product_image']);
				}
				$image = generalfileupload($_FILES['product_image'],"../../../uploads/banner","");
			}
			//print_r($_POST);
			$set_field = array('name');
			$set_values =
			array($_POST['name']);
			$wf="banner_id";
			$wv=$banner_id;
			$dbObj->cupdt("mast_bannerlist", $set_field, $set_values, $wf, $wv, "");

			$_SESSION['msg']="<span class='success'>Banner Updated Successfully.</span>";
			header("location:".SITEROOT."/admin/modules/banner/banner_list.php");
			exit;
		}

		else{
			

			if($_FILES['product_image']['name'])
			{
				$image = generalfileupload($_FILES['product_image'],"../../../uploads/banner","");
			}
			$f_array = array(
			
						"name" => $_POST['name']);

			$insertedId = $dbObj->cgii("mast_bannerlist",$f_array,"");

			$_SESSION['msg']="<span class='success'>Banner Added Successfully.</span>";
			header("location:".SITEROOT."/admin/modules/banner/banner_list.php");
			//exit;
		}
	}

	if($banner_id!=''){
		$cd="banner_id = ".$banner_id;
		$dbres = $dbObj->gj('mast_bannerlist', "*" , $cd, "", "","", "", "");
		$banner = @mysql_fetch_assoc($dbres);
		$smarty->assign("banner",$banner);
	}

 	

	$smarty->display(TEMPLATEDIR.'/admin/modules/banner/edit_bannerlist.tpl');

?>