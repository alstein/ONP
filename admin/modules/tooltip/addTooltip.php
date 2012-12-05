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
if(!(in_array("24", $arr_modules_permit)))
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
			$fl = array("description");
			$vl = array($desc);
			$rs = $dbObj->cupdt("tbl_tooltip", $fl, $vl, "tooltip_id", $cid, "");//exit;
				$s=$msobj->showmessage(92);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		else
		{
			$fl = array("tooltip_title","module_name","description","added_date");
			$vl = array($title,$module,$desc,date("Y-m-d H:i:s"));
			$rs = $dbObj->cgi('tbl_tooltip',$fl,$vl,'');//exit;
				$s=$msobj->showmessage(174);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		
			header("location:".SITEROOT."/admin/modules/tooltip/tooltipList.php");
		
}

if($cid)
	{
		$selectfaqq = $dbObj->customqry("SELECT * FROM tbl_faqs WHERE faqid =".$cid,"");
      		$row=@mysql_fetch_array($selectfaqq);
		$smarty->assign("row",$row);
	}

#-----------------------------------------------------------------------------------------------------------
//   $selectCategory = $dbObj->cgs("faq_cat","faq_cat_id,faq_cat,cat_descr,del_status","" ,"", "" ,"" ,""); 

if($cid){
$selectCategory = $dbObj->customqry("SELECT * FROM faq_cat","");
}
else{
$selectCategory = $dbObj->customqry("SELECT * FROM faq_cat WHERE del_status = 1","");
     }
 while($row=@mysql_fetch_array($selectCategory))
      {
         $category[]=$row;
      }
   $smarty->assign("category",$category);
#------------------------------------------------------------------------------------------------------------
$smarty->display(TEMPLATEDIR . '/admin/modules/tooltip/addTooltip.tpl');

$dbObj->Close();
?>