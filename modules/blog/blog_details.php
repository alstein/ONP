<?php
include_once('../../include.php');
include_once('../../includes/class.message.php');
include_once('../../includes/classes/class.blog.php');
$msobj= new message();
$blogObj= new Blogs();

$bid = $_GET["bid"];
if($_POST["submit"] == "Post")
{
	extract($_POST);

		$fl = array("userid","blog_id","name","comment");
		$vl = array($_SESSION['csUserId'],$bid,$_SESSION['csFullName'],$comment);
		$rs = $dbObj->cgi('tbl_blog_comment',$fl,$vl,'');//exit;
		$s=$msobj->showmessage(214);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
                header("location:".SITEROOT . "/modules/blog/blog_details.php?blogid=".$_GET['blogid']);
		exit;
} 
 if(isset($_GET['blogdelete']))
{
$_GET['bolgid'];

      $delcom ="DELETE FROM  tbl_blog_comment WHERE id = ".$_GET['blogdelete'];
       mysql_query($delcom)or die(mysql_error());
       $s=$msobj->showmessage(219);
       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
       header("location:".SITEROOT . "/modules/blog/blog_details.php?blogid=".$_GET['blogid']);
      exit;
}
if($_GET['blogid'] > 0)
{
  $blog = $blogObj->getBlogsDetails($_GET['blogid'],$row,$comments);
  
    if(count($blog[1]) > 0)
    {
        $smarty->assign("blogdet",$blog);
        
        $sqlcity="select * from mast_city where city_id=".$blog[1]['city_id'];
        $cityrow=@mysql_query($sqlcity)or die(mysql_error());
        $cityname = @mysql_fetch_assoc($cityrow);
        $smarty->assign("cityname",$cityname);
        $smarty->assign("comments",$blog[0]);
        $smarty->assign("row",$blog[1]);
        $smarty->assign("commentcount",$blog[2]);
        $smarty->assign("blog",$_GET['blogid']);
    
        //Get meta tags of the page as per id
        $call_meta = array();
        $call_meta['meta_title'] = $blog[1]['title'];
        $call_meta['meta_tag_description'] = $blog[1]['meta_description'];
        $call_meta['meta_tag_keyword'] = $blog[1]['meta_keyword'];
        $smarty->assign("row_meta",$call_meta);
    }
} //end if($_GET['blogid'] > 0)
 

if(!isset($_SESSION['csUserId']))
{
	if($_GET['blogid'] > 0)
	{
		  $_SESSION['previous_page'] = SITEROOT."/blog_details?blogid=".$_GET['blogid'];
	}
}

if(isset($_SESSION['msg'])){
   $smarty->assign("msg", $_SESSION['msg']);
   unset($_SESSION['msg']);
}

$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/blog/blog_details.tpl');
$dbObj->Close();
?>
