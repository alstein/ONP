<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}
if($_POST['submit'] == "Go")
{
    $cityid = @implode(" ,",$_POST["cityid"]);
   if($_POST["action"] == "active")
   {
      $id = $dbObj->customqry("update mast_city set status = 'Active' where city_id in (".$cityid.")","");
      $s=$msobj->showmessage(96);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate")
   {
      $id = $dbObj->customqry("update mast_city set status = 'Inactive' where city_id in (".$cityid.")","");
            $s=$msobj->showmessage(97);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from mast_city where city_id in (".$cityid.")","");
            $s=$msobj->showmessage(98);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}
if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];						
	$adsperpage =20;							
	$StartRow = $adsperpage * ($page-1);			
	$l= $StartRow.','.$adsperpage;

                $stateid=$_GET['stateid'];
                $sql_state = "Select c.* from mast_state c where id=".$_GET['stateid'];
		$res_state = $dbObj->customqry($sql_state,0);
		$row_state = @mysql_fetch_assoc($res_state);
		$smarty->assign("state",$row_state);
		
		if(!(@mysql_num_rows($res_state) > 0))
                {
                   header("location:".SITEROOT . "/admin/country/country_list.php");
                    exit;
                }		
		$sql_country = "Select c.* from mast_country c where countryid=".$row_state['country_id'];
		$res_country = $dbObj->customqry($sql_country,0);
		$row_country = @mysql_fetch_assoc($res_country);
		$smarty->assign("country",$row_country);
		
               // $selectCity = $dbObj->cgs('mast_city',"*","state_id",$_GET['stateid'], "" ,"" ,""); 
                $selectCity=$dbObj->gj("mast_city","*","state_id=".$_GET['stateid'], "", "", "", $l, "");
      while($row=@mysql_fetch_array($selectCity))
      {
               $cityResult[]=$row;
      }
   $smarty->assign("cityResult",$cityResult);

/*----------Pagination Part-2--------------*/

$rs=$dbObj->gj("mast_city","*","state_id=".$_GET['stateid'], "", "", "", "", "");
$nums = @mysql_num_rows($rs);
$show = 5;		
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1){
	$smarty -> assign("showpgnation", 'yes');
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	if(!empty($_GET['search']))
		$firstlink = "city_list.php?search=" . $_GET['search']."&contryid=".$_GET['stateid'];
	else
		$firstlink = "city_list.php?contryid=".$_GET['stateid'];
		$seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$smarty -> assign("pgnation",$pgnation);
}
if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}
$smarty->display(TEMPLATEDIR . '/admin/city/city_list.tpl');

$dbObj->Close();
?>