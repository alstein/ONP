<?php
include_once('../../includes/SiteSetting.php');





if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}



$smarty->display(TEMPLATEDIR .'/modules/photos/testgallery.tpl');
?>