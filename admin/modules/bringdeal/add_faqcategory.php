<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("25", $arr_modules_permit)))
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

			$sqlcat = $dbObj->customqry("SELECT * FROM faq_cat WHERE faq_cat_id !=".$cid." and faq_cat = '".$faqcname."'","");
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}

			$fl = array("faq_cat","cat_descr");
			$vl = array($faqcname,$catdec);
			$rs = $dbObj->cupdt("faq_cat", $fl, $vl, "faq_cat_id", $cid, "");
				$s=$msobj->showmessage(89);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				header("location:".SITEROOT."/admin/modules/faq/faqcategory_list.php");
exit;
		}
		else
		{
			
			$sqlcat = $dbObj->customqry("SELECT * FROM faq_cat WHERE faq_cat = '".$faqcname."'","");
			$chkcat=mysql_num_rows($sqlcat); 
			//echo $chkcat;exit; 
			if($chkcat != "")
			{
			$s=$msobj->showmessage(125);
			$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
			header("location:".$_SERVER['HTTP_REFERER']);
			exit;
			}


			$fl = array("faq_cat","cat_descr");
			$vl = array($faqcname,$catdec);
			$rs = $dbObj->cgi('faq_cat',$fl,$vl,'');//exit;
			//$_SESSION['msg'] = "Category added.";
				$s=$msobj->showmessage(88);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
header("location:".SITEROOT."/admin/modules/faq/faqcategory_list.php");
exit;
		}
		
			
		
}

if($cid)
{
	$selectCategory = $dbObj->customqry("SELECT * FROM faq_cat WHERE faq_cat_id=".$cid,"");
	$row=@mysql_fetch_array($selectCategory);
	$smarty->assign("row",$row);
}

if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}

$smarty->display(TEMPLATEDIR . '/admin/modules/faq/add_faqcategory.tpl');

$dbObj->Close();
?>