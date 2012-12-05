<?php

	include_once("../../../include.php");


	$cityid = ($_REQUEST['cityid']?$_REQUEST['cityid']:0);

	if($cityid > 0){
		$query = "select * from tbl_newsletter_users where city_id=".$cityid;
		$res = mysql_query($query);
		$del = "";
		while($row = mysql_fetch_object($res)){
			$u = $del.$row->nuemail;
			$del = ", ";
			echo $u;
	}
}

?>

