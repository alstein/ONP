<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}


$nid = $_GET["nid"];
if($_POST['submit'])
{
if($nid)
{
			$fl = array("nemail","cityid");
			$vl = array($_POST['nemail'],$_POST['cname']);
			$rs = $dbObj->cupdt("tbl_newsletter", $fl, $vl, "nid", $nid, "1");exit;		
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".SITEROOT."/admin/globalsettings/newsletter/newsletter.php");
}
else
{
print_r($_POST);exit;
}


 }






$cd = "active_city = '1'";
$selectCity2 = $dbObj->gj('mast_city',"*",$cd,"","","","","");
      while($row=@mysql_fetch_array($selectCity2))
      {
         $cityResult[]=$row;
      }

  $smarty->assign("cityResult",$cityResult);


  $tbl = "tbl_newsletter";
   $selectEditNewsletter = $dbObj->cgs($tbl,"*","nid",$nid,"","","");
   $nlEdit=@mysql_fetch_array($selectEditNewsletter);
   $smarty->assign("nlEdit",$nlEdit);




if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}




$smarty->display(TEMPLATEDIR . '/admin/globalsettings/newsletter/addnewsletter.tpl');

$dbObj->Close();
?>