<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
// $smarty->assign("msobj",$msobj);
if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/_welcome.php");
}

#--------Action-----------#
if(isset($_POST['action']))
{
      extract($_POST);
 $userid=@implode(",",$_POST['id']);
    

      if($userid!='')
      {
	      if($action == "Delete")
	      {
		      $temp = $dbObj->customqry("delete from tbl_bad_words where id in (".$userid.")","");
		      $_SESSION['msg'] = "Records Deleted Successfully";
                
	      }	
                  if($_POST['action'] == "Active")
              {
                              
                  $id=$dbObj->customqry("update tbl_bad_words set status='Active' where id in(".$userid.") ","");
                  $_SESSION['msg'] = "Records Activated Successfully";
              }
              
              if($_POST['action'] == "Inactive")
              {
                              
                  $id=$dbObj->customqry("update tbl_bad_words set status='Inactive' where id in(".$userid.") ","");
                  $_SESSION['msg'] = "Records Inactivated Successfully";
              }
              header("Location:".SITEROOT."/admin/modules/badword/badword-list.php");
	     // header("Location:".$_SERVER['HTTP_REFERER']);
	      exit;
      }
}
#---------END-------------#

/*-------------Pagination Part1--------------------*/
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
/*-----------------End Part1--------------------*/

extract($_POST);
 $tbl="tbl_bad_words";
$sf="*";
$cnd="1";

if (isset($_GET['search']))
{
        $cnd = ("bad_word like '%".($_GET['search'])."%' OR rep_word like '%".($_GET['search'])."%'");
}
$ob="bad_word"; $ot="ASC";

$user=array();
$rs = $dbObj->gj($tbl, $sf , $cnd, $ob, "", $ot, $l, "");
while($row = @mysql_fetch_assoc($rs))
    $user[] = $row;

$smarty->assign("user", $user);

/*-----------------------Pagination Part2--------------------*/
$rs1 = $dbObj->gj($tbl, $sf , $cnd, $ob, "", $ot, "", "");
if ($rs1 != 'n')
	$nums = mysql_num_rows($rs1);
$show =20;		
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
{
	$showing= !isset($_GET["page"]) ? 1 : $page;
      $firstlink = basename($_SERVER['PHP_SELF'])."?";
        if(isset($_GET['search']) and $_GET['search'] != "")
	      {
               $seperator = 'search='.$_GET['search'].'&page='; 
              }
	else
              {
		$seperator = 'page=';
              }


   
        $baselink  = $firstlink; 
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg']))
{
    $smarty->assign("msg",$_SESSION['msg']);
    unset($_SESSION['msg']); 
}
// $smarty->assign("norecord",$s['msgtext']);
$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR.'/admin/modules/badword/badword-list.tpl');
$dbObj->Close();
?>