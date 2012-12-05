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
    $blogid = implode(",",$_POST["blogid"]);
   if($_POST["action"] == "Active")
   {
		$id = $dbObj->customqry("update tbl_blog set status = '1' where id in (".$blogid.")","");
		$s=$msobj->showmessage(209);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "inactivate")
   {
		$id = $dbObj->customqry("update tbl_blog set status = '0' where id in (".$blogid.")","");
		$s=$msobj->showmessage(210);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
		$id = $dbObj->customqry("delete from tbl_blog where id in (".$blogid.")","");
		$s=$msobj->showmessage(211);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}


   $selectBlog = $dbObj->customqry("select tb.*,mc.city_name from tbl_blog tb left join mast_city mc on tb.city_id = mc.city_id order by date DESC",""); 

      while($row=@mysql_fetch_array($selectBlog))
      {
         $blogResult[]=$row;
      }
   $smarty->assign("blogResult",$blogResult);


if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}



$smarty->display(TEMPLATEDIR . '/admin/modules/blogs/blog_list.tpl');

$dbObj->Close();
?>