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
    $categoryid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_dealtype where typeid in (".$categoryid.")","");
            $s=$msobj->showmessage(190);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

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
$adsperpage =15;							
$StartRow = $adsperpage * ($page-1);			
$l =  $StartRow.','.$adsperpage;
/*-----------------------------------*/

$rs_cat = $dbObj->gj("tbl_dealtype", "*" , "1", "dealtype", "", "",  $l, "");
if($rs_cat != 'n')
   {
      while($row=@mysql_fetch_assoc($rs_cat))
         {
            $rw_cat[]=$row;
         }
         $smarty->assign("categoryResult",$rw_cat);
   }

// if($rs_cat != 'n')
// {
//     $i=0;
//     while($row=@mysql_fetch_assoc($rs_cat))
//     {
// 	$rw_cat[$i]=$row;
//         if($row['parent_id'] == 0)
//         {
// 	    $r_cnt = $dbObj->gj("mast_deal_category","count(id) as tot","parent_id = {$row['id']}","","","","","");
//             $tmp = @mysql_fetch_assoc($r_cnt);
//             if($tmp['tot'])
//               $rw_cat[$i]['tot'] = $tmp['tot'];
// 	    else
//               $rw_cat[$i]['tot'] = 0;
//         }
//         $i++;
//     }
//     $smarty->assign("categoryResult",$rw_cat);
// }

/*-----------------------Pagination Part2--------------------*/
$rs_cat1 = $dbObj->gj("tbl_dealtype", "*" , "1", "dealtype", "", "",  "", "");
$nums =@mysql_num_rows($rs_cat1);

$smarty -> assign("recordsFound",$nums);
$show = 5;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
	$smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;

$firstlink = "deal_type_list.php";
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

$smarty->display(TEMPLATEDIR . '/admin/deal/deal_type_list.tpl');

$dbObj->Close();
?>