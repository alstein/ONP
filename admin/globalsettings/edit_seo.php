<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();
set_time_limit(500000);
ini_set("memory_limit","1000M");

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

    //------update  SEO-------------
 if($_POST["Update"])
    {   
                 $id=$_GET['editid'];
                      $field = array("page_name"=>$_POST['pagename'],
                            "meta_title"=>$_POST['metatitle'], 
                            "meta_tag_description"=>$_POST['metatagdesc'],
                             "meta_tag_keyword"=>$_POST['metatagkeyword']); 
             $dbObj->cupdtii("mast_seo",$field,"id=".$id,"");
             $s=$msobj->showmessage(218);
	     $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             header("location:". SITEROOT . "/admin/globalsettings/seo_list.php");exit;
    }
    //----Get the updated id here and display record to seo_list.tpl file-----
   if($_GET['editid'])
      {
        $id=$_GET['editid'];
	$sql="select * from mast_seo where id='$id'";
	$productrow=mysql_query($sql)or die(mysql_error());
	$results = array();
        $i=0;
       while ($r=mysql_fetch_array($productrow))
       {
                $id=$r['id'];
                $pagename=$r['page_name'];
                $metatitle=$r['meta_title'];
                $metatagdesc=$r['meta_tag_description'];
                $metatagkeyword=$r['meta_tag_keyword'];
                
        }
  
        $smarty->assign('id', $id);
         $smarty->assign('pagename',$pagename);
          $smarty->assign('metatitle',$metatitle);
           $smarty->assign('metatagdesc',$metatagdesc);
            $smarty->assign('metatagkeyword',$metatagkeyword);
            
      }
  
if(isset($_SESSION['msg']))
{
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
}
	$smarty->display(TEMPLATEDIR.'/admin/globalsettings/edit_seo.tpl');
	$dbObj->Close();
?>