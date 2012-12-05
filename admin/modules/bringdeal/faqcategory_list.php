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

if($_POST['submit'] == "Go")
{
    $categoryid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "Active")
   {
      $id = $dbObj->customqry("update faq_cat set del_status = '1' where faq_cat_id in (".$categoryid.")","");
      //$_SESSION['msg'] = "record actived.";
	$s=$msobj->showmessage(86);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
   {
      $id = $dbObj->customqry("update faq_cat set del_status = '0' where faq_cat_id in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(87);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from faq_cat where faq_cat_id in (".$categoryid.")","");
          $s=$msobj->showmessage(90);
	//$_SESSION['msg'] = "record deldeted.";
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


   $selectCategory = $dbObj->cgs("faq_cat","faq_cat_id,faq_cat,cat_descr,del_status","" ,"", "" ,"" ,""); 

      while($row=@mysql_fetch_array($selectCategory))
      {
         $categoryResult[]=$row;
      }
   $smarty->assign("categoryResult",$categoryResult);


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/faq/faqcategory_list.tpl');

$dbObj->Close();
?>