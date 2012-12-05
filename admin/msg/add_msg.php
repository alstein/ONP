<?php
include_once('../../includes/SiteSetting.php');
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

$cid = $_GET["cid"];
 if($_POST["submit"])
 {
	extract($_POST);
 

		if($cid != "")
		{
			$fl = array("msgtext","msgtype");
			$vl = array($catdec,$msgtype);
			$rs = $dbObj->cupdt("mast_errmsg", $fl, $vl, "msgid", $cid, "");
				$s=$msobj->showmessage(122);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		else
		{
			$fl = array("msgtext","msgtype");
			$vl = array($catdec,$msgtype);
			$rs = $dbObj->cgi('mast_errmsg',$fl,$vl,'');//exit;
			//$_SESSION['msg'] = "Category added.";
				$s=$msobj->showmessage(121);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		
			?><script type="text/javascript">window.setTimeout('parent.location.reload();', 10);</script><?
	exit;
		
}

if($cid)
	{
		$selectCategory = $dbObj->customqry("SELECT * FROM mast_errmsg WHERE msgid=".$cid,"");
      		$row=@mysql_fetch_array($selectCategory);
		$smarty->assign("row",$row);
	}




$smarty->display(TEMPLATEDIR . '/admin/msg/add_msg.tpl');

$dbObj->Close();
?>