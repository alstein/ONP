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
      $id = $dbObj->customqry("update tbl_nl_content set del_status = '1' where nl_id in (".$categoryid.")","");//exit;
      //$_SESSION['msg'] = "record actived.";
$s=$msobj->showmessage(102);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
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

$sql_list="select fl.*,l.city_name from mast_city as l inner join tbl_nl_content as fl on l.city_id = fl.city_id";
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



$smarty->display(TEMPLATEDIR . '/admin/globalsettings/newsletter/nlcontent.tpl');

$dbObj->Close();
?>