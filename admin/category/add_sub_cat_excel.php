<?php
set_time_limit(500000);
ini_set("memory_limit","1000M");

include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once('../../includes/function.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}

if(isset($_GET['view']) && $_GET['view'] == "test_excel")
{
	header('Content-disposition: attachment; filename=testCatFile.csv');
	header('Content-type: application/excel');
	readfile('testCatFile.csv');
	die();
}

if(isset($_POST["Submit"]))
{

	if(strlen(trim($_FILES['category_file']['name'])) > 0)
	{
		/** PHPExcel_IOFactory */
		require_once '../../includes/PHPExcel-1.7.5/Classes/PHPExcel/IOFactory.php';
	
		$allowedExtensions = array("xls","csv","xlsx","org");

		if (!in_array(end(explode(".", strtolower($_FILES['category_file']['name']))), $allowedExtensions))
		{
			$_SESSION['msg']="<span class='error'>Import file extention should be one of them 'csv / xls / xlsx / org'.</span>";
			header("location:".SITEROOT."/admin/category/subcat.php?cat_id=".$_GET['cat_id']);
			exit;
		}else
		{
			$target_path = "../../uploads/deal-category/";
			$target_path = $target_path . basename($_FILES['category_file']['name']);
	
			if(move_uploaded_file($_FILES['category_file']['tmp_name'], $target_path))
			{
				chmod($target_path, 777);
				$objPHPExcel = PHPExcel_IOFactory::load($target_path);
	
				$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
				$cacheSettings = array( ' memoryCacheSize '  => '100MB'
								);
				PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
	
				$objWorksheet = $objPHPExcel->getActiveSheet();
			
				$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
				$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
			
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
	
	
				$num_records_import = 0;
	
				if($highestRow > 2) //is greater than 2 cause first row is with heading like Name, Email
				{
					for ($row = 2; $row <= $highestRow; ++$row) 
					{
						$row_name = '';
						//for ($col = 0; $col <= $highestColumnIndex; ++$col) 
						//{
							//echo $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						//}
						$row_name = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue(); //Name
						
						if((strlen(trim($row_name)) > 0) && (strlen(trim($_GET['cat_id'])) > 0))
						{
							$tn_sch = "mast_deal_category";
							$tf_sch = array('userid','category','parent_id','date','active');
							$tv_sch = array($_SESSION['duAdmId'],$row_name,$_GET['cat_id'],date("Y-m-d"),1);
							$impSchData = $dbObj ->cgi($tn_sch,$tf_sch,$tv_sch,"");
		
							$num_records_import++;
						} //if rows value is greater than 0
					} //for loop
					unlink($target_path);
					$_SESSION['msg']="<span class='success'>(".$num_records_import.") Records data imported successfully</span>";
				}else
				{
					unlink($target_path);
					$_SESSION['msg']="<span class='success'>Import file is empty.</span>";
				}
				header("location:".SITEROOT."/admin/category/subcat.php?cat_id=".$_GET['cat_id']);
				exit;
			}
		}
	}

/*
	extract($_POST);
	
	move_uploaded_file($_FILES["category_file"]["tmp_name"], $_FILES["category_file"]["name"]);
	$fd = fopen ($_FILES["category_file"]["name"], "r");
	while (!feof ($fd))
	{
		$buffer='';
		$buffer = fgetcsv($fd, 4096);
		// print_r(array_filter($buffer));
		if($buffer)
		{
			$cnt = count(array_filter($buffer));
			
			if($cnt==1)
			{
				$set_field = array('userid','category','parent_id','date','active');
				$set_values = array($_SESSION['duAdmId'],$buffer[$cnt-1],$_GET['cat_id'],date("Y-m-d"),1);
				$id = $dbObj->cgi("mast_deal_category",$set_field,$set_values, "");
			}
// 			else if($cnt>1)
// 			{
// 				$rs = $dbObj->cgs("mast_deal_category", "*", "category", addslashes($buffer[$cnt-2]), "", "", "");
// 				$row=@mysql_fetch_array($rs);
// 				$set_field = array('userid','category','parent_id','date','active');
// 				$set_values = array($_SESSION['duAdmId'],$buffer[$cnt-1],$row['id'],date("Y-m-d"),1);
// 				$id = $dbObj->cgi("mast_deal_category",$set_field,$set_values, "");
// 			}
			unset($buffer);
			$cnt=0;
		}
	}
	header("location:".SITEROOT."/admin/category/subcat.php?cat_id=".$_GET['cat_id']);
	exit;
*/
}

#----------------Get category info--------------#
if(isset($_GET['cid'])!="")
{
    $rs = $dbObj->cgs("mast_deal_category", "*", "id", $_GET['cid'], "", "", "");
    $row=@mysql_fetch_assoc($rs);
    $smarty->assign("result", $row);
}
#----------------Get category info--------------#

////////////////////////////////////////////////////
//START Get category level Hirarchy and it's id
if($_GET['cat_id'] > 0)
{
	$smarty->assign("categoryHirarchy",getCategoryLevelOrder(recursiveCategory($_GET['cat_id']))); //functions are written in /includes/function.php file
}
//END Get category level Hirarchy and it's id
////////////////////////////////////////////////////

if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/category/add_sub_cat_excel.tpl');

$dbObj->Close();
?>