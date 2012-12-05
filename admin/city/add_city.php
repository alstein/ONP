<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}
$cid = $_GET["cid"];

if($cid != "")
{
    // Update city
    if($_POST["task"] == "Update")
    {
      	$updateCity = $dbObj->customqry("update mast_city set city_name = '".$_POST['cname']."', state_id = '".$_POST['states']."', country_id = '".$_POST['countries']."' where city_id in (".$cid.")","");
        $s=$msobj->showmessage(60);
      	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        header("location:".SITEROOT."/admin/city/city_list.php?stateid=".$_POST['stateid']."&countryid=".$_POST['contryid']);
	exit;
   }
}
	// Select city
	$selectEditcity=$dbObj->cgs("mast_city","*","city_id",$cid,"","","");
	$city=@mysql_fetch_assoc($selectEditcity);
	$smarty->assign("cedit",$city);
	
	/* Get all states*/
   	$rs=$dbObj->cgs("mast_state","*","id ",$_GET['stateid'],"","","");
	//$rs=$dbObj->cgs("mast_country","*","status","Active","","","");
	while($row=@mysql_fetch_assoc($rs)){
		$state= $row;
	}
	$smarty->assign("state",$state);

  	/* Get all countrys*/
   	$rs=$dbObj->cgs("mast_country","*","countryid ",$_GET['contryid'],"","","");
	//$rs=$dbObj->cgs("mast_country","*","status","Active","","","");
	while($row=@mysql_fetch_assoc($rs)){
		$country = $row;
	}
	$smarty->assign("country",$country);
	//if record is edit time //newly added only active counrty wise state list
	if($city['country_id']!="")
	{
		//$rs_isContIsAct=$dbObj->cgs("mast_country","*",array('countryid','status'),array($city['country_id'],'Active'),"","","");
		$rs_isContIsAct=$dbObj->cgs("mast_country","*",array('countryid'),array($city['country_id']),"country","","");
	}
	
	if($city['country_id']!="" && $rs_isContIsAct != 'n')
	{
		$rs2=$dbObj->cgs("mast_state","*",array('country_id','active'),array($city['country_id'],1),"state_name","","");
		while($row = @mysql_fetch_assoc($rs2)){
			$state_con[] = $row;
		}
		$smarty->assign("state_con",$state_con);
	}
if($_POST["task"] == "Add")
{
    $fl = array("city_id","state_id","country_id","city_name","status");
    $vl = array("",$_POST['stateid'],$_POST['contryid'],$_POST["cname"],"Active");
    $rs = $dbObj->cgi('mast_city',$fl,$vl,'');
    $s=$msobj->showmessage(59);
    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
    header("location:".SITEROOT."/admin/city/city_list.php?stateid=".$_POST['stateid']."&countryid=".$_POST['contryid']);
    exit;
}
  	/* Get all countrys*/
   	$rs=$dbObj->cgs("mast_country","*","","","country","","");
	//$rs=$dbObj->cgs("mast_country","*","status","Active","","","");
	while($row=@mysql_fetch_assoc($rs)){
		$country[] = $row;
	}
	$smarty->assign("country",$country);

if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/city/add_city.tpl');

$dbObj->Close();
?>