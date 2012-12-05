<?php
$PATH_PREFIX = "../";
include_once('../../include.php');

$smarty->display(TEMPLATEDIR.'/modules/success/success.tpl');

$dbObj->Close();
?>