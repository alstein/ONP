<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}
if($_POST['submit'] == "Go")
{
    $categoryid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "Active")
   {
      $id = $dbObj->customqry("update tbl_business set active = '1' where bcid in (".$categoryid.")","");
      //$_SESSION['msg'] = "record actived.";
$s=$msobj->showmessage(83);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
   {
      $id = $dbObj->customqry("update tbl_business set active = '0' where bcid in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(82);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_business where bcid in (".$categoryid.")","");
            $s=$msobj->showmessage(17);
	   $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

// $sql_list="select fl.*,l.faq_cat from faq_cat as l inner join tbl_faqs as fl on l.faq_cat_id = fl.faq_cat_id ";
// $res = $dbObj->customqry($sql_list,0);//exit;
  $selectfaq = $dbObj->cgs("tbl_business","*","" ,"", "" ,"" ,""); 
      while($row=@mysql_fetch_array($selectfaq))
      {
         $faqst[]=$row;
      }

   $smarty->assign("faqst",$faqst);



if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/business/buseness.tpl');

$dbObj->Close();
?>