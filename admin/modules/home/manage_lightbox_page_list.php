<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId'])){
   header("location:".SITEROOT . "/admin/login/index.php");
   exit;
   }

#----------------Action----------------#

 if($_POST["submit"] == "Go"){

          $id = implode(",",$_POST["id"]);
            switch($_POST["action"])
            {
                case "active":
                    $id = $dbObj->customqry("update tbl_lightbox_page set status = '1' where id in (".$id.")","");
                     $s=$msobj->showmessage(242);
		     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>"; 
                break;
                case "inactivate":
                    $id = $dbObj->customqry("update tbl_lightbox_page set status = '0' where id in (".$id.")",""); 
                     $s=$msobj->showmessage(241);
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
        $newsperpage =20;
        $StartRow = $newsperpage * ($page-1);
        $l =  $StartRow.','.$newsperpage;

      $sql="SELECT * FROM tbl_lightbox_page LIMIT $l";
     $rs=mysql_query($sql)or die(mysql_error());
     while($row=@mysql_fetch_array($rs))
     {
       $list[]=$row;
     }   
     $rs1 =$dbObj->cgs("tbl_lightbox_page","*", "", "", "", "", "", "");
     $nums =@mysql_num_rows($rs1);
     $smarty -> assign("recordsFound",$nums);
     $show = 20;
     $total_pages = ceil($nums / $newsperpage);
     if($total_pages > 1)
     {
       $smarty->assign("showpgnation","yes");
       $showing   = !isset($_GET["page"]) ? 1 : $page;
	  $firstlink = "manage_lightbox_page_list.php";
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
   
  $smarty->display(TEMPLATEDIR . '/admin/modules/home/manage_lightbox_page_list.tpl');

   $dbObj->Close();
?>