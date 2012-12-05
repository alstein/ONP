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
    $packageid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "active")
   {
      $id = $dbObj->customqry("update tbl_subscription_package set status = '1' where id in (".$packageid.")","");
      //$_SESSION['msg'] = "record actived.";
	$s=$msobj->showmessage(196);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate")
   {
      $id = $dbObj->customqry("update tbl_subscription_package set status = '0' where id in (".$packageid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(197);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_subscription_package where id in (".$packageid.")","");
          $s=$msobj->showmessage(195);
	//$_SESSION['msg'] = "record deldeted.";
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


   $selectpackage = $dbObj->cgs("tbl_subscription_package","*","" ,"", "" ,"" ,""); 
      while($row=@mysql_fetch_array($selectpackage))
      {
         $categoryResult[]=$row;
      }
      //print_r($categoryResult);die();
   $smarty->assign("packageResult",$categoryResult);


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/package/package_list.tpl');

$dbObj->Close();
?>