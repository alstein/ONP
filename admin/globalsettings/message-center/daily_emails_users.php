<?php

include_once('../../../includes/SiteSetting.php');


	$cityid = ($_REQUEST['cityid']?$_REQUEST['cityid']:0);


	if($cityid != ""){
// // 		$query = "select * from tbl_newsletter where cityid = ".$cityid;
// $query = "select count(*) from tbl_newsletter where cityid = ".$cityid;
// 
// 		//echo $query;
// 		 $res =@mysql_query($query);
$res = $dbObj->customqry("SELECT * FROM tbl_newsletter WHERE cityid =".$cityid,"");
		
	$del = "";
		while($row = mysql_fetch_object($res)){
	
				$u = $del.$row->nemail;
				$del = ", ";
				echo $u;
	}
}

?>