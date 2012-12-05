<?php
// include_once('../DBTransact.php');

class contentpages extends DBTransact
{

	function addcontentpages()
	{
		
 //echo 1; exit;
 		extract($_POST);

//print_r($_POST);exit;
	$description = addslashes($editor2);
	$descriptionare = addslashes($editor3);
        $tbl= "tbl_pages";
        $f = array("title","title_arebic","description","arebic_description", "status");
        $v = array($title,$titleare,$description,$descriptionare,$status);
	
	$id=$this->cgi($tbl, $f, $v, "");
        return $id;
        }
	function editcontentpages()
	{
		
 		extract($_POST);

		$description = addslashes($editor2);
		$descriptionare = addslashes($editor3);
		$tbl= "tbl_pages";
		$f = array("title","title_arebic","description","arebic_description", "status");
        	$v = array($title,$titleare,$description,$descriptionare,$status);
	        $id=$this->cupdt($tbl,$f ,$v , "pageid", $_GET['pageid'], "");
	        return $id;
        }

}
$pageObj= new contentpages();
?>