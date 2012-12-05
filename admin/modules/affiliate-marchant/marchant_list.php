<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}

if($_POST['submit'] == "Go")
{
    $mid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "active")
   {
      $id = $dbObj->customqry("update tbl_deal_affiliate_marchant set status = '1' where id in (".$mid.")","");
      $s=$msobj->showmessage(255);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate")
   {
      $id = $dbObj->customqry("update tbl_deal_affiliate_marchant set status = '0' where id in (".$mid.")","");
            $s=$msobj->showmessage(254);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_deal_affiliate_marchant where id in (".$mid.")","");
            $s=$msobj->showmessage(256);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


#----------------Get all categories--------------#

if($_GET["act"] == "setDef" && $_GET["mid"])
{
	$id = $dbObj->customqry("update tbl_deal_affiliate_marchant set is_defaulter = '1' where id=".$_GET['mid'],"");
	$id1 = $dbObj->customqry("update tbl_deal_affiliate_marchant set is_defaulter = '0' where id!=".$_GET['mid'],"");
	$s=$msobj->showmessage(259);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

	header("location:".SITEROOT."/admin/modules/affiliate-marchant/marchant_list.php");
	exit;
}

/*------------Pagination Part-1------------*/
$page=1;
if(!isset($_GET['page']))
{
	$page =1;
}
else
{
	$page=$_GET['page'];
	$page = $page;
}
$adsperpage =20;
$StartRow = $adsperpage * ($page-1);
$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

$rs_marchant = $dbObj->gj("tbl_deal_affiliate_marchant", "*" , "id!=0", "is_defaulter desc, marchant_name asc", "", "",  $l, "");

if($rs_marchant != 'n')
{
	$i=0;
	while($row=@mysql_fetch_assoc($rs_marchant))
	{
		$marchantResult[$i]=$row;
		$i++;
	}
	$smarty->assign("marchantResult",$marchantResult);
}

/*-----------------------Pagination Part2--------------------*/
$rs_marchant1 = $dbObj->gj("tbl_deal_affiliate_marchant", "*" , "id!=0", "is_defaulter desc, marchant_name", "", "",  "", "");
$nums =@mysql_num_rows($rs_marchant1);

$smarty -> assign("recordsFound",$nums);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;

$firstlink = "marchant_list.php";
$seperator = '?page=';
$baselink  = $firstlink;

$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);

#----------------Get all categories--------------#

 if($_SESSION['msg'])
 {
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
 }

$smarty->display(TEMPLATEDIR . '/admin/modules/affiliate-marchant/marchant_list.tpl');

$dbObj->Close();
?>