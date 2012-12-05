<?
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
if(!$_SESSION['duAdmId'])
header("location:".SITEROOT . "/admin/login/index.php");

if($_GET['ad_id'])
{
	$rs2 = $dbObj->customqry("select * from tbl_ads where ad_id=".$_GET['ad_id']."","");
	$del_image=@mysql_fetch_array($rs2);
	@unlink('../../uploads/ad/thumbnail/'.$del_image['ad_image']);	
    	@unlink('../../uploads/ad/big'.substr($del_image['ad_image'],5));
	$rs1 = $dbObj->customqry("delete from tbl_ads where ad_id=".$_GET['ad_id']."","");
        $s=$msobj->showmessage(40);
        $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
    	//$_SESSION['msg']="<span>Ad Deleted Successfully.</span>";
	header("Location:Ads.php");
	exit;
}
$dbObj->Close();
?>
