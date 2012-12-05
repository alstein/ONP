<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
include_once("../../includes/function.php");
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


extract($_POST);
extract($_GET);

 if($_POST["submit"] == "Go"){

           $id = implode(",",$_POST["id"]);
            switch($_POST["action"])
            {
                case "active":
                    $id = $dbObj->customqry("update tbl_deal_category_images set status = '1' where id in (".$id.")","");
                     //$s=$msobj->showmessage(230);
		     $_SESSION['msg']="<span class='success'>images activated successfully</span>"; 
                break;
                case "inactivate":
                    $id = $dbObj->customqry("update tbl_deal_category_images set status = '0' where id in (".$id.")",""); 
                     //$s=$msobj->showmessage(229);
		     $_SESSION['msg']="<span class='success'>images inactivated successfully</span>";
                break;
                case "delete":
                      $id = $dbObj->customqry("delete from tbl_deal_category_images where id IN (".$id.")","");		
		     // $s=$msobj->showmessage(227);
		     $_SESSION['msg']="<span class='success'>images deleted successfully</span>";
            }//switch
        //if
    }//if
#-----------------END--------------------#

//--------paging---------------
 if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
if($_GET['view'] == 'excel')
$l="";
else
$l =  $StartRow.','.$newsperpage;

     $sql="SELECT * FROM tbl_deal_category_images where deal_cat_id=".$_GET['cat_id']." LIMIT ". $l;
//      $sql="SELECT * FROM tbl_deal_category_images LIMIT $l";
     $rs=mysql_query($sql)or die(mysql_error());
   while($row=@mysql_fetch_array($rs))
   {
      $list[]=$row;
   }
     $rs1 =$dbObj->gj("tbl_deal_category_images","*", "deal_cat_id=".$_GET['cat_id'], "", "", "", "", "");
     $nums =@mysql_num_rows($rs1);
     $smarty -> assign("recordsFound",$nums);
     $show = 20;
     $total_pages = ceil($nums / $newsperpage);

if($total_pages > 1)
{
	$smarty->assign("showpgnation","yes");
	$showing   = !isset($_GET["page"]) ? 1 : $page;
	$firstlink = "subsubsubcatimage.php?cat_id=".$_GET['cat_id'];
	$seperator = '&page=';

	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
	$smarty-> assign("pagenation",$pagenation);
}
      $smarty->assign("list", $list);

////////////////////////////////////////////////////
//START Get category level Hirarchy and it's id
if($_GET['cat_id'] > 0)
{
         $cat_idc=$_GET['cat_id']; 
         $cat_id=$msobj->clean_url($cat_idc);
	 $smarty->assign("categoryHirarchy",getCategoryLevelOrder(recursiveCategory($cat_id))); //functions are written in /includes/function.php file
}
//END Get category level Hirarchy and it's id
////////////////////////////////////////////////////

if(isset($_SESSION['msg'])){
   $smarty->assign("msg", $_SESSION['msg']);
   unset($_SESSION['msg']);
}
   $smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/category/subsubsubcatimage.tpl');

$dbObj->Close();
?>
