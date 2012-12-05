<?
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
}



if($_POST['submit'] == "Go")
{
    $nid = @implode(" ,",$_POST["nid"]);
   if($_POST["action"] == "Active")
   {
      $id = $dbObj->customqry("update tbl_newsletter set status = '1' where nid in (".$nid.")","");
      $s=$msobj->showmessage(99);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
   {
      $id = $dbObj->customqry("update tbl_newsletter set status = '0' where nid in (".$nid.")","");
            $s=$msobj->showmessage(100);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_newsletter where nid in (".$nid.")","");
            $s=$msobj->showmessage(101);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


    $tbl = "tbl_newsletter n inner join mast_city c ON n.cityid = c.city_id ";
    $selectNewsletter = $dbObj->cgs($tbl,"*","","","","","");
      while($nlrow=@mysql_fetch_array($selectNewsletter))
      {
         $newsletterResult[]=$nlrow;
      }
   $smarty->assign("newsletterResult",$newsletterResult);



if($_SESSION['msg'])
{
   $smarty->assign("msg",$_SESSION['msg']);
   $_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/globalsettings/newsletter/newsletter.tpl');

$dbObj->Close();
?>