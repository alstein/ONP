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
if(!(in_array("20", $arr_modules_permit)))
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
       $id = $dbObj->customqry("update tbl_nl_content set del_status = '1' where nl_id in (".$categoryid.")","");//exit;
       //$_SESSION['msg'] = "record actived.";
       $s=$msobj->showmessage(102);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate")
   {
      $id = $dbObj->customqry("update tbl_nl_content set del_status = '0' where nl_id in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(103);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_nl_content where nl_id in (".$categoryid.")","");
            $s=$msobj->showmessage(104);
	   $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

$sql_list="select * from tbl_nl_content";
$res = $dbObj->customqry($sql_list,0);//exit;

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



$smarty->display(TEMPLATEDIR . '/admin/globalsettings/message-center/nlcontent.tpl');

$dbObj->Close();
?>