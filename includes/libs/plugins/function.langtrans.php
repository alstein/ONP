<?
function smarty_function_langtrans($param)
{
	if(empty($param))
	{
		echo "Error";
	}
	$db = new database();
	$db->connect_db();
	$rs=$db->cgs("tbl_lang_trans","*",array("langid","refid"),array($param['langid'], $param['refid']),"","","");
	$row=@mysql_fetch_assoc($rs);
	echo $row['trans'];
}
?>