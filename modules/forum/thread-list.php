<?php
include_once("../../include.php");
include_once("../../includes/paging.php");
//include_once("../../includes/paging_forum.php");
include_once('../../includes/classes/class.forum.php');
//Imp
 $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
 $url=$protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $_SESSION['url']=$url;

if(isset($_GET['red']) && isset($_GET['forumid']))
{
    $_SESSION['previous_page']=SITEROOT."/forum/thread-list/?forumid=".$_GET['forumid'];
    header("location:".SITEROOT."/signin");
    exit;
}

#------user photo----------------#

        $user_pic=$dbObj->cgs("tbl_users","pic_image,first_name,last_name,username","userid",$_SESSION['csUserId'],"","","");
        $pic=@mysql_fetch_assoc($user_pic);
        $smarty->assign("pic",$pic);
        $smarty->assign("picture",$pic['pic_image']);
#-------------------------------#

$forumObj = new Forum();
#----For display sub tool-------#
$subtool = "yes";
$smarty->assign("subtool",$subtool);
#---End of display sub tool-----------#


#---Update the view number of thread table----#
// if($_GET['forumid'])
// {
//   $forumidc=$_GET['forumid']; 
//   $forumid=$forumObj->clean_url($forumidc);
//   //$forumObj->updateForumView($forumid);
// }
#---End of update the view number of thrad table----#

#-------GEtting Forum Details-------------
if($_GET['forumid'])
{
    $forumidc=$_GET['forumid']; 
    $forumid=$forumObj->clean_url($forumidc);
    $forum = $forumObj->getForumTopic($forumid);

///////////Get the Deal_Name And Seller_Name Details start////////////////
                        $rs=$dbObj->cgs("tbl_deal","*","deal_unique_id",$forum['deal_id'],"","","");
                        $rec_dealid=@mysql_fetch_assoc($rs);		
                        $deal_title=$rec_dealid['title'];
                        $deal_seller_name= getDealSellerFromId($rec_dealid['deal_unique_id']); //$rec_dealid['deal_from_seller_name'];
                        $description=$rec_dealid['description'];
                        $big_image=$rec_dealid['big_image'];
                        $smarty->assign("deal_title",$deal_title);
                        $smarty->assign("deal_seller_name",$deal_seller_name);
                        $smarty->assign("big_image",$big_image);
                        $smarty->assign("description",$description);
///////////Get the Deal_Name And Seller_Name end////////////////

}
$smarty->assign("forum", $forum);

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(24);
$smarty->assign("row_meta",$call_meta);

if($_GET['forumid'])
{
    $forumidc=$_GET['forumid']; 
    $forumid=$forumObj->clean_url($forumidc);	
    $threadArray = $forumObj->getAdminThreads("thread-list",$_GET['page'],$_GET['search'],$forumid,4, '');
    $smarty->assign("threads", $threadArray['threads']);
    $smarty->assign("showpaging", $threadArray['showpaging']);
    $smarty->assign("pagination", $threadArray['paging']);
}
#---------END--------------
if($_SESSION['msg']!='')
{
	$smarty->assign('msg',$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);

$smarty->display(TEMPLATEDIR . '/modules/forums/thread_list.tpl');
$dbObj->Close();
?>
