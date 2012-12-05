<?php
	include_once("../../include.php");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}


	if($_POST['cityid'] > 0){
		$cnd = "city_id =".$_POST['cityid'];	
		$dbres = $dbObj->gj('mast_city', "*" , $cnd, "", "","", "", "");
		$row1 = @mysql_fetch_assoc($dbres);
	}
	
if(isset($_POST['submit'])){
	$time = "";	
	$time = time();
				
	if($_POST['cityid']){

			if($_FILES['city_image']['name']){

				if($row1['city_image']){
					@unlink("../../uploads/city/".$row1['city_image']);
					@unlink("../../uploads/city/".$row1['landing_page_image']);
				}
				$_FILES['city_image']['name'] = $time."-".trim(strtolower($_FILES['city_image']['name']));
				$_FILES['city_image']['name'] = str_replace(" ","-",$_FILES['city_image']['name']);
				$image = generalfileupload($_FILES['city_image'],"../../uploads/city","");

				$rs=$dbObj->cupdt("mast_city",array("state_id", "con_id", "city_name", "city_image","color", "landing_page_color", "active"),array($_POST['states'],$_POST['countries'], $_POST['city_nm'], trim($image),$_POST['color'], $_POST['landing_page_color'], $_POST['status']), "city_id",$_POST['cityid'],"");
			}

			elseif($_FILES['landing_page_image']['name']){

				$_FILES['landing_page_image']['name'] = $time."-".trim(strtolower($_FILES['landing_page_image']['name']));
				$_FILES['landing_page_image']['name'] = str_replace(" ","-",$_FILES['landing_page_image']['name']);
				$landingimage = generalfileupload($_FILES['landing_page_image'],"../../uploads/city","");


				$rescityName = mysql_query("select city_name from mast_city where city_id=".$_POST['cityid']);
				$rowCityName = @mysql_fetch_assoc($rescityName);
				$lastCityName  = $rowCityName['city_name'];

				$rs=$dbObj->cupdt("mast_city",array("state_id", "con_id", "city_name", "color", "landing_page_image", "landing_page_color", "active"),array($_POST['states'],$_POST['countries'], trim($_POST['city_nm']), $_POST['color'],trim($landingimage), $_POST['landing_page_color'], $_POST['status']), "city_id",$_POST['cityid'],"");

				$query = "update tbl_product set product_city = '".trim($_POST['city_nm'])."' where product_city = '".trim($lastCityName)."'";
				$res = mysql_query($query);

				//$_SESSION['default_city_name'] = $_POST['city_nm'];

			}else{

				$rescityName = mysql_query("select city_name from mast_city where city_id=".$_POST['cityid']);
				$rowCityName = @mysql_fetch_assoc($rescityName);
				$lastCityName  = $rowCityName['city_name'];

				$rs=$dbObj->cupdt("mast_city",array("state_id", "con_id", "city_name","color", "landing_page_color", "active"), array($_POST['states'], $_POST['countries'], trim($_POST['city_nm']), $_POST['color'], $_POST['landing_page_color'], $_POST['status']), "city_id",$_POST['cityid'],"");

				$query = "update tbl_product set product_city = '".trim($_POST['city_nm'])."' where product_city = '".trim($lastCityName)."'";
				$res = mysql_query($query);

				//$_SESSION['default_city_name'] = $_POST['city_nm'];

			}
			$_SESSION['msg'] = "<span class='success'>".getErrorMessage(76)."</span>";
	}else{
	
			$_FILES['city_image']['name'] = $time."-".trim(strtolower($_FILES['city_image']['name']));
			$_FILES['city_image']['name'] = str_replace(" ","-",$_FILES['city_image']['name']);

			$_FILES['landing_page_image']['name'] = $time."-".trim(strtolower($_FILES['landing_page_image']['name']));
			$_FILES['landing_page_image']['name'] = str_replace(" ","-",$_FILES['landing_page_image']['name']);

			$image = generalfileupload($_FILES['city_image'],"../../uploads/city","");
			$landingimage = generalfileupload($_FILES['landing_page_image'],"../../uploads/city","");

			$rs=$dbObj->cgi("mast_city",array("state_id", "con_id", "city_name","city_image", "color", "landing_page_image", "landing_page_color", "active"),array($_POST['states'],$_POST['countries'], $_POST['city_nm'], trim($image), $_POST['color'],trim($landingimage), $_POST['landing_page_color'], $_POST['status']),"");

			$_SESSION['msg'] = "<span class='success'>".getErrorMessage(75)."</span>";
	}
	header("location:city_list.php");
}

/* Get all countrys*/
	$rs=$dbObj->cgs("mast_countryname","*","","","","","");
	while($row=@mysql_fetch_assoc($rs)){
		$country[] = $row;
	}
	$smarty->assign("country",$country);

/* Get state*/
	$rs1=$dbObj->cgs("mast_city","*","city_id",$_GET['cityid'],"","","");
	$city=@mysql_fetch_assoc($rs1);
	$smarty->assign("city",$city);


/* Get states*/

	$rs2=$dbObj->cgs("mast_state","*","country_id",$city['con_id'],"","","");
	while($row = @mysql_fetch_assoc($rs2)){
		$state_con[] = $row;
	}
	$smarty->assign("state_con",$state_con);

	$smarty->display(TEMPLATEDIR.'/admin/mastermanagement/edit_city.tpl');
	$dbObj->Close();
?>