<?php
	include_once("../../../include.php");

	extract($_POST);
	extract($_GET);

	$banner_id=$_GET['banner_id'];

	$_SESSION['current_banner_id'] = $banner_id;

	$smarty->assign("banner_id",$banner_id);


	$dbObj = new DBTransact();
	$dbObj->Connect();
	if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

	$id = ($_REQUEST['id']?$_REQUEST['id']:0);
	$smarty->assign("id",$id);

	if(strlen(trim($_POST['Submit'])) > 0){
		if($id > 0){

			$image = $_POST['h_product_image'];
			if($_FILES['product_image']['name']){
				if($row1['product_image']){
					@unlink("../../../uploads/banner/".$row1['product_image']);
					@unlink("../../../uploads/banner/thumbnail/".$row1['product_image']);
				}
			//	$image = generalfileupload($_FILES['product_image'],"../../../uploads/banner","");
/////////////////////

  				if($_FILES['product_image']['name'])
                                {
                                $photo_name=uploadandresize($_FILES['product_image'], '../../../uploads/banner', '../../../uploads/banner/thumbnail', 100, 100);$bussiness_picture=$photo_name['thumbnail'];
                                $image=$photo_name['thumbnail'];
                                }

                                if($image)
                                {
                                $image=$image;
                                }
                                else
                                {
                                $image = $row1['product_image'];
                                }




///////////////////
			}
			$set_field = array('city','banner','location_name','start_date','expired_date','product_image','banner_id','urllocation');
			$set_values =
			array($_POST['cities'],$_POST['banner'],$_POST['location_name'],$_POST['start_date']
				,$_POST['expired_date'],$image,$banner_id,$_POST['url_loc']);
			$wf="id";
			$wv=$id;
			$dbObj->cupdt("mast_banners", $set_field, $set_values, $wf, $wv, "");

			$_SESSION['msg']="<span class='success'>Banner Updated Successfully.</span>";
			header("location:".SITEROOT."/admin/modules/banner/banner_list.php");
			exit;
		}

		else{
			if($_FILES['product_image']['name'])
			{
				if($_FILES['product_image']['name'])
                                {
                                $photo_name=uploadandresize($_FILES['product_image'], '../../../uploads/banner', '../../../uploads/banner/thumbnail', 150, 150);$bussiness_picture=$photo_name['thumbnail'];
                                $image=$photo_name['thumbnail'];
                                }

                                if($image)
                                {
                                $image=$image;
                                }
                                else
                                {
                                $image = $row1['product_image'];
                                }
			}
			$f_array = array("banner"=> $_POST['banner'],
			
						"city" => $_POST['cities'],
						"location_name"=> $_POST['location_name'],
						"start_date" => $_POST['start_date'],
						"expired_date" =>($_POST['expired_date']),
						"product_image" => trim($image),
						"banner_id"=>$banner_id,
						"urllocation" => $_POST['url_loc']);

			$insertedId = $dbObj->cgii("mast_banners",$f_array,"");
			//exit;

			$_SESSION['msg']="<span class='success'>Banner Added Successfully.</span>";
			header("location:".SITEROOT."/admin/modules/banner/banner_list.php");
			exit;
		}
	}

	if($id!=''){
		$cd="id = ".$id;
		$dbres = $dbObj->gj('mast_banners', "*" , $cd, "", "","", "", "");
		$banner = @mysql_fetch_assoc($dbres);
		$smarty->assign("banner",$banner);
	}

 	

	$smarty->display(TEMPLATEDIR.'/admin/modules/banner/edit_banner.tpl');

?>
