<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =10;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

#------------Check For access----------#
if(!(in_array("24", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

//<!--faqid 	faq_cat_id 	faqquestion 	faqanswer 	addeddt 	del_status 	faq_cat-->
if($_POST['submit'] == "Go")
{
    $categoryid = implode(",",$_POST["catid"]);
   if($_POST["action"] == "Active")
   {
      $id = $dbObj->customqry("update tbl_tooltip set status = 'Active' where tooltip_id in (".$categoryid.")","");
      //$_SESSION['msg'] = "record actived.";
$s=$msobj->showmessage(176);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   elseif($_POST["action"] == "Suspended")
   {
      $id = $dbObj->customqry("update tbl_tooltip set status = 'Inactive' where tooltip_id in (".$categoryid.")","");
	//$_SESSION['msg'] = "record inactived.";
           $s=$msobj->showmessage(177);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
  }
   elseif($_POST["action"] == "delete")
   {
      $id = $dbObj->customqry("delete from tbl_tooltip where tooltip_id in (".$categoryid.")","");
            $s=$msobj->showmessage(178);
	   $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
   }
   header("location:".$_SERVER['HTTP_REFERER']);
   exit;
}

//$sql_list="select tooltip_title,description,module_name,status,tooltip_id from tbl_tooltip ";
//$res = $dbObj->customqry($sql_list,0);//exit;
  //$selectfaq = $dbObj->cgs("tbl_faqs","*","" ,"", "" ,"" ,""); 
$selectF="*";
$tablename="tbl_bring_back";
$dealid=$_GET['dealid'];
$conition="deal_id=$dealid";
$res=$dbObj->gj($tablename, $selectF, $conition, "", "", "", $l, "");

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



/*-----------------------Pagination Part2--------------------*/
$rs1 =$dbObj->gj($tablename, $selectF, $conition, "", "", "", "", "");
$nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 20;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
			$smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if($_GET['searchuser']!='')
    {
	    $firstlink = "emaillist.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "emaillist.php";
	  $seperator = '?page=';
    }
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/





$smarty->display(TEMPLATEDIR . '/admin/modules/bringdeal/emaillist.tpl');

$dbObj->Close();
?>
