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
 if($_POST["submit"] || $_POST["Submit"])
 {
	extract($_POST);
 

		if($cid != "")
		{
			$fl = array("faq_cat_id","faqquestion","faqanswer");
			$vl = array($catname,$qes,$ans);
			$rs = $dbObj->cupdt("tbl_faqs", $fl, $vl, "faqid", $cid, "");//exit;
				$s=$msobj->showmessage(92);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		else
		{
			$fl = array("faq_cat_id","faqquestion","faqanswer","addeddt");
			$vl = array($catname,$qes,$ans,date("Y-m-d H:i:s"));
			$rs = $dbObj->cgi('tbl_faqs',$fl,$vl,'');//exit;
				$s=$msobj->showmessage(91);
				$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		}
		
			header("location:".SITEROOT."/admin/modules/faq/faq_list.php");
		
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
$smarty->display(TEMPLATEDIR . '/admin/modules/faq/add_faq.tpl');

$dbObj->Close();
?>