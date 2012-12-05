<?php
include_once('../../include.php');
include_once('../../includes/classes/class.frontregister.php');

if(isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT . "/my-account-view");
}

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(14);
$smarty->assign("row_meta",$call_meta);


    if(isset($_SESSION['msg']))
    {
        $smarty->assign("msg", $_SESSION['msg']);
        unset($_SESSION['msg']);
    }
    
    if(isset($_SESSION['msg_succ']))
    {
        $smarty->assign("msg_succ", $_SESSION['msg_succ']);
        unset($_SESSION['msg_succ']);
    }

$smarty->display(TEMPLATEDIR . '/modules/registration/registration.tpl');
$dbObj->Close();
?>