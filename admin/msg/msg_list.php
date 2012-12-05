<?php
include_once("../../include.php");
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("7", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

#--------Perform Action--------------#
if($_POST['submit'] == "Go")
{
      $categoryid = implode(",",$_POST["catid"]);

      if($_POST["action"] == "Active")
      {
	    $id = $dbObj->customqry("update mast_errmsg set del_status = '1' where msgid in (".$categoryid.")","");
	    $s=$msobj->showmessage(132);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      elseif($_POST["action"] == "Suspended")
      {
	    $id = $dbObj->customqry("update mast_errmsg set del_status = '0' where msgid in (".$categoryid.")","");
	    $s=$msobj->showmessage(133);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      elseif($_POST["action"] == "delete")
      {
	    $id = $dbObj->customqry("delete from mast_errmsg where msgid in (".$categoryid.")","");
	    $s=$msobj->showmessage(134);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
}

#-----------------END--------------------#


/*--------------Pagination Part-1-------------*/
$orderby ="1";

if(!isset($_GET['page']))
	$page =1;
else
	$page = $_GET['page'];

$adsperpage = 25;
$StartRow = $adsperpage * ($page-1);
$l= $StartRow.','.$adsperpage;
/*----------End Pagination Part-1------------*/

$rs=$dbObj->gj("mast_errmsg","*","1", "msgid", "", "DESC", $l, "");
if($rs != 'n')
{
    $city= array();
    while($row=@mysql_fetch_array($rs))
	    $city[]=$row;
    $smarty->assign("categoryResult",$city);
}

/*--------------Pagination Part-2-------------*/
$rs1 = $dbObj->gj("mast_errmsg","*","1", "msgid", "", "DESC", "", "");
$nums = @mysql_num_rows($rs1);
$show = 50;
$total_pages = ceil($nums / $adsperpage);
if($total_pages > 1)
{
	$showing   = !isset($_GET["page"]) ? 1 : $page;
        $firstlink = "msg_list.php";
	$seperator = '?page=';
	$baselink  = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	$smarty -> assign("pgnation",$pgnation);
}
/*----------End Pagination Part-2------------*/


#-----------Set set msg into session-----------#
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
#-----------End set msg into session-----------#

$smarty->display(TEMPLATEDIR . '/admin/msg/msg_list.tpl');

$dbObj->Close();
?>