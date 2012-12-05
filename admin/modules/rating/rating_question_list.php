<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");

#----------------Action----------------#

 if($_POST["submit"] == "Go"){

          $id = implode(",",$_POST["id"]);
            switch($_POST["action"])
            {
                case "active":
                    $id = $dbObj->customqry("update rating_question set status = 'active' where id in (".$id.")","");
                     $s=$msobj->showmessage(235);
		     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; 
                break;
                case "inactivate":
                    $id = $dbObj->customqry("update rating_question set status = 'inactive' where id in (".$id.")",""); 
                     $s=$msobj->showmessage(236);
		     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                break;
                case "delete":
                      $id = $dbObj->customqry("delete from rating_question where id IN (".$id.")","");		
		      $s=$msobj->showmessage(232);
		     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
            }//switch
        //if
    }//if
#-----------------END--------------------#
//--------paging---------------
 if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =10;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;


   //$rs=$eventc_video_obj->getSearchVideo($_REQUEST,$l);
  $sql=$sql = "SELECT * FROM rating_question order by added_date desc LIMIT $l";

    $rs=mysql_query($sql)or die(mysql_error());
   while($row=@mysql_fetch_array($rs))
   {
      $list[]=$row;

   }
   
   $rs1 =$dbObj->gj("rating_question","*", "id", "", "", "", "", "");
$nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 20;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
   
	  $firstlink = "rating_question_list.php";
	  $seperator = '?page=';
   
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}   
      $smarty->assign("list", $list);


if(isset($_SESSION['msg'])){
   $smarty->assign("msg", $_SESSION['msg']);
   unset($_SESSION['msg']);
}
   $smarty->assign("inmenu", "user");
   
  $smarty->display(TEMPLATEDIR . '/admin/modules/rating/rating_question_list.tpl');

   $dbObj->Close();
?>