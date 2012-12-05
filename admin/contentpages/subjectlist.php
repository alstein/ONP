<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
}
//subid 	subject 	status 	adddate
if($_POST['submit'] == "Go")
{
    $categoryid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "Active")
   {
      $id = $dbObj->customqry("update contactus_subject set status = '1' where subid in (".$categoryid.")","");//exit;
	
      //$_SESSION['msg'] = "record actived.";
	$s=$msobj->showmessage(109);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
   {
      $id = $dbObj->customqry("update contactus_subject set status = '0' where subid in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(110);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from contactus_subject where subid in (".$categoryid.")","");//exit;
          $s=$msobj->showmessage(111);
	//$_SESSION['msg'] = "record deldeted.";
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


   $selectCategory = $dbObj->cgs("contactus_subject","*","" ,"", "" ,"" ,""); 

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



$smarty->display(TEMPLATEDIR . '/admin/contentpages/subjectlist.tpl');

$dbObj->Close();
?>