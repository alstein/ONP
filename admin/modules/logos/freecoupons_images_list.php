<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
   header("location:".SITEROOT . "/admin/login/index.php");


extract($_POST);
extract($_GET);

if($_POST['sort_ords']=='Update')
{

//$cd = "type='$type'";
	$dbres = $dbObj->gj('tbl_freecoupons_images', "*" , "1", "", "","", "", "");	
	
	while($row_results = @mysql_fetch_assoc($dbres))
	{
// echo "update tbl_freecoupons_images set sort_no=".$_POST[$row_results['id']]." where id=".$row_results['id'];
		@mysql_query("update tbl_freecoupons_images set sort_no=".$_POST[$row_results['id']]." where id=".$row_results['id'] );
	}
	
        $_SESSION['msg']="<span class='success'>Freecoupons images order has been updated successfully</span>";
	@header("Location:".SITEROOT."/admin/modules/logos/freecoupons_images_list.php");
	exit;
}
#----------------Action----------------#

 if($_POST["submit"] == "Go"){

           $id = implode(",",$_POST["id"]);
            switch($_POST["action"])
            {
                case "active":
                    $id = $dbObj->customqry("update tbl_freecoupons_images set status = '1' where id in (".$id.")","");
                     //$s=$msobj->showmessage(230);
		     $_SESSION['msg']="<span class='success'>Freecoupons images activeted successfully</span>"; 
                break;
                case "inactivate":
                    $id = $dbObj->customqry("update tbl_freecoupons_images set status = '0' where id in (".$id.")",""); 
                     //$s=$msobj->showmessage(229);
		     $_SESSION['msg']="<span class='success'>Freecoupons images deactiveted successfully</span>";
                break;
                case "delete":
                      $id = $dbObj->customqry("delete from tbl_freecoupons_images where id IN (".$id.")","");		
		     // $s=$msobj->showmessage(227);
		     $_SESSION['msg']="<span class='success'>Freecoupons images deleted successfully</span>";
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

     $sql="SELECT * FROM tbl_freecoupons_images  order by sort_no LIMIT $l";
     $rs=mysql_query($sql)or die(mysql_error());
   while($row=@mysql_fetch_array($rs))
   {
      $list[]=$row;
   }
     $rs1 =$dbObj->gj("tbl_freecoupons_images","*", "1", "sort_no", "", "", "", "");
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
	    $firstlink = "freecoupons_images_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "freecoupons_images_list.php";
	  $seperator = '?page=';
    }
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

   $smarty->display(TEMPLATEDIR . '/admin/modules/logos/freecoupons_images_list.tpl');

   $dbObj->Close();
?>