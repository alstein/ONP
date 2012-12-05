<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../include.php');

$hits=array();
$total_credit=array();

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}
extract($_GET);
$affiliate=$dbObj->cgs("sitesetting","value","type","affiliate","","","");
$row=mysql_fetch_assoc($affiliate);
$credit=$row['value'];

$pre=$dbObj->cgs("tbl_affiliate","","id",$id,"","","");
$pre_credit=mysql_fetch_assoc($pre);
$fl=array("affiliate_id","user_id");
$rs=$dbObj->cgs("tbl_banner", "", "","", "", "", "");
while($row=mysql_fetch_array($rs))
{
 $banner_id[]=$row;

}
$count=count($banner_id);
for($i=0;$i<$count;$i++)
{
 $vl=array($banner_id[$i]['id'],$id);
 $rs1=$dbObj->cgs("tbl_affiliate_credit", "",$fl,$vl, "", "", "");
 $record=@mysql_num_rows($rs1);
 if($record>0)
 { 
  $hits[]=$record;
  $total_credit[]=$record*$credit;
  $description[]=$banner_id[$i]['description'];
 }
}
 
$sum=array_sum($total_credit);
$used=$sum - $pre_credit['credit'];
$smarty->assign("hits",$hits);
$smarty->assign("totalcredit",$total_credit);
$smarty->assign("title",$description);
$smarty->assign("credit",$credit);
$smarty->assign("sum",$sum);
$smarty->assign("totalavailable",$pre_credit);
$smarty->assign("used",$used);
if($_POST['back'])
{
 header("location:".SITEROOT."/admin/sitemodules/affilite/manage_affilite.php");
 exit;
}
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/affilite/credit.tpl');
$dbObj->Close();
?>