<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');



if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
$msobj= new message();
$smarty->assign("news_id",$_GET['news_id']);

if(isset($_POST['news_title']))
{
	extract($_POST);
        $count=count($modules);
        if($count == 0 )
        {
        $_SESSION['msg']="<span class='error'>Please select module.</span>";
        header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
        }
        else
        if($user_type == "")
        {
        $_SESSION['msg']="<span class='error'>Please select user type.</span>";
        header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
        }
        else
        if($news_title == "")
        {
        $_SESSION['msg']="<span class='error'>Please enter news title.</span>";
        header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
        }
        else
        if($description == "")
        {
        $_SESSION['msg']="<span class='error'>Please enter description.</span>";
        header("Location:".$_SERVER['HTTP_REFERER']);
	exit;
        }


        $module_list=implode(",",$modules);
	$description = addslashes($description);

        $tbl= "tbl_news";
        $f = array("news_title","start_date","end_date","description","user_type","module");
        $v = array($news_title,$dob1,$dob2,$description,$user_type,$module_list);

	if($_GET['news_id'] != "")
	{
	    $id=$dbObj->cupdt($tbl,$f ,$v , "news_id", $_GET['news_id'], "");
/*
	    $s=$msobj->showmessage(159);
	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";*/
            $_SESSION['msg']="<span class='error'>News updated successfully.</span>";    

        }
	else
        {
	    $id=$dbObj->cgi($tbl, $f, $v, "");

// 	    $s=$msobj->showmessage(158);
// 	    $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
             $_SESSION['msg']="<span class='error'>News added successfully.</span>";    
        }

	header("Location: news-list.php");
	exit;
}




#--------------Get Page Content---------------#
if(isset($_GET['news_id'])!="")
{
$rs = $dbObj->cgs("tbl_news", "*", "news_id", $_GET['news_id'], "", "", "");
$news=mysql_fetch_assoc($rs);
$smarty->assign("news", $news);
$module_array=explode(",",$news['module']);
// print_r($module_array);exit;
$smarty->assign("module_array",$module_array);

}

#------------Set SESSION msg-------------#
if(isset($_SESSION['msg']))
{ 
    $smarty->assign("msg", $_SESSION['msg']); 
    unset($_SESSION['msg']);
}
#------------End SESSION msg-------------#

$smarty->assign("inmenu","content");

$smarty->display(TEMPLATEDIR . '/admin/modules/news/edit-news.tpl');

$dbObj->Close();
?>