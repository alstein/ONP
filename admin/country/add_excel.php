<?php
set_time_limit(500000);
ini_set("memory_limit","1000M");

include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
    header("location:".SITEROOT . "/admin/login/index.php");
}

if(isset($_GET['view']) && $_GET['view'] == "test_excel")
{
	header('Content-disposition: attachment; filename=testCountryFile.csv');
	header('Content-type: application/excel');
	readfile('testCountryFile.csv');
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
			header("location:".SITEROOT."/admin/country/country_list.php");
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
						$row_vat = '';
						//for ($col = 0; $col <= $highestColumnIndex; ++$col) 
						//{
							//echo $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
						//}
						$row_name = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue(); //Name		
						$row_vat = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue(); //Vat

						$rs=$dbObj->cgs("mast_country","*","country",$row_name,"","","");
						if(@mysql_num_rows($rs) == 0)
						{
							if(strlen(trim($row_name)) > 0)
							{
								$rs=$dbObj->cgi("mast_country",array("country","vat", "status"),array($row_name,$row_vat, "Active"),"");
	
								$num_records_import++;
							} //if rows value is greater than 0
						}
					} //for loop
					unlink($target_path);
					$_SESSION['msg']="<span class='success'>(".$num_records_import.") Records data imported successfully</span>";
				}else
				{
					unlink($target_path);
					$_SESSION['msg']="<span class='success'>Import file is empty.</span>";
				}
				header("location:".SITEROOT."/admin/country/country_list.php");
				exit;
			}
		}
	}
}

if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/country/add_excel.tpl');

$dbObj->Close();
?>