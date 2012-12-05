<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}

// 	$s=$msobj->showmessage(7);
//       	echo "<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; exit; 



//<!--faqid 	faq_cat_id 	faqquestion 	faqanswer 	addeddt 	del_status 	faq_cat-->
if($_POST['submit'] == "Go")
{
    $categoryid = @implode(",",$_POST["catid"]);
   if($_POST["action"] == "Active" && $categoryid!="")
   {
      $id = $dbObj->customqry("update tbl_faqs set del_status = '1' where faqid in (".$categoryid.")","");
      //$_SESSION['msg'] = "record actived.";
$s=$msobj->showmessage(94);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate" && $categoryid!="")
   {
      $id = $dbObj->customqry("update tbl_faqs set del_status = '0' where faqid in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(95);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete" && $categoryid!="")
   {
      $id = $dbObj->customqry("delete from tbl_faqs where faqid in (".$categoryid.")","");
            $s=$msobj->showmessage(93);
	   $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

$sql_list="select fl.*,l.faq_cat from faq_cat as l inner join tbl_faqs as fl on l.faq_cat_id = fl.faq_cat_id ";
$res = $dbObj->customqry($sql_list,0);//exit;
  //$selectfaq = $dbObj->cgs("tbl_faqs","*","" ,"", "" ,"" ,""); 

      while($row=@mysql_fetch_array($res))
      {
         $faqst[]=$row;
      }

   $smarty->assign("faqst",$faqst);


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/faq/faq_list.tpl');

$dbObj->Close();
?>