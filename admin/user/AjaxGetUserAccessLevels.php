<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/JSON.php");

#----------Getting Modules---------------
$rs=$dbObj->cgs("tbl_global_settings", "", array("moduleid", "usertypeid"), array($_GET['moduleid'], $_GET['usertypeid']), "", "", "");
while($row=@mysql_fetch_assoc($rs))
$access = $row;
#----------------END---------------------
if($access['allow_post']=='yes')
	$value = 'true';

$response	= array("checkboxid"=>$_GET['checkboxid'], "value"=>$value);
$json = new Services_JSON();
echo($json->encode($response));
$dbObj->Close();
?>