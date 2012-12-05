<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}

if($_POST['submit'] == "Go")
{
   $categoryid = @implode(",",$_POST["catid"]);
   if($_POST["action"] == "active" && $categoryid!="")
   {
      $id = $dbObj->customqry("update mast_deal_category set active = '1' where id in (".$categoryid.")","");
      $s=$msobj->showmessage(21);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate" && $categoryid!="")
   {
      $id = $dbObj->customqry("update mast_deal_category set active = '0' where id in (".$categoryid.")","");
            $s=$msobj->showmessage(22);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "delete" && $categoryid!="")
   {
      $id = $dbObj->customqry("delete from mast_deal_category where id in (".$categoryid.")","");
            $s=$msobj->showmessage(20);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

#----code for excel report----#
if($_GET['view'] == 'excel')
{
	$out ="Deal Categories";
	$out .="\n";
	$out .="\n";
	$out .='Category Name,No of Category,Add Date,Status';
	$out .="\n";
	$out .="\n";
}
#----code end-----------------#

#----------------Get all categories--------------#

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
if($_GET['view'] == 'excel')
	$l="";
else
	$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

$rs_cat = $dbObj->gj("mast_deal_category", "*" , "parent_id =0", "category", "", "",  $l, "");
if($rs_cat != 'n')
{
    $i=0;
	
    while($row=@mysql_fetch_assoc($rs_cat))
    {
		$cat=array();
		$res1=$dbObj->customqry("select userid from tbl_users where deal_cat=".$row['id'],""); //echo "<br>";
		while($row1=mysql_fetch_assoc($res1)){
				$cat[]=$row1['userid'];
		}	
		$ue=@implode(",",$cat);
		
		$c=$dbObj->customqry("select count(*) as cnt from tbl_deals where merchant_id 	in (".$ue.")","");//echo "<br>";
		$crow=@mysql_fetch_assoc($c);

		$rw_cat[$i]=$row;

		if($crow['cnt']=="")
			$crow['cnt']=0;

		$rw_cat[$i]['cat_cnt']=$crow['cnt'];
		//echo "==>".$crow['cnt'];echo "<br>";

		if($row['parent_id'] == 0)
		{
			$r_cnt = $dbObj->gj("mast_deal_category","count(id) as tot","parent_id = {$row['id']}","","","","","");
			$tmp = @mysql_fetch_assoc($r_cnt);
			if($tmp['tot'])
				$rw_cat[$i]['tot'] = $tmp['tot'];
			else
				$rw_cat[$i]['tot'] = 0;
		}
		////////////STRAT getting count of deal category images//////////
		$r_imgCnt = $dbObj->gj("tbl_deal_category_images","count(id) as tot","deal_cat_id = {$row['id']}","","","","","");
			$row_img = @mysql_fetch_assoc($r_imgCnt);
			if($row_img['tot'])
				$rw_cat[$i]['imgTot'] = $row_img['tot'];
			else
				$rw_cat[$i]['imgTot'] = 0;
		////////////END getting count of deal category images//////////

		if($_GET['view'] == 'excel')
		{
			#---code for csv report-----#
			$out .= '"'.$row['category'].'","'.$rw_cat[$i]['tot'].'","'.$row['date'].'","'.($row['active']?'Active':'Inactive').'"';
			$out .= "\n";
			#----code end---#
		}
		$i++;
	}
    $smarty->assign("categoryResult",$rw_cat);
}
//echo "<pre>";print_r($rw_cat);echo "</pre>";
/*-----------------------Pagination Part2--------------------*/
$rs_cat1 = $dbObj->gj("mast_deal_category", "*" , "parent_id =0", "category", "", "",  "", "");
$nums =@mysql_num_rows($rs_cat1);

$smarty -> assign("recordsFound",$nums);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;

$firstlink = "category_list.php";
$seperator = '?page=';
$baselink  = $firstlink; 

$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pgnation",$pgnation);

#----------------Get all categories--------------#

#----code for csv report-------#
if($_GET['view'] == 'excel')
{
	header("Content-type: text/x-csv");
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=Buyer-details.csv");	
	echo $out;
	exit;
}
#----code end------#

 if($_SESSION['msg'])
 {
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
 }

$smarty->display(TEMPLATEDIR . '/admin/category/category_list.tpl');

$dbObj->Close();
?>