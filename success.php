<?php
$PATH_PREFIX = "../";
include_once('include.php');



$smarty->display(TEMPLATEDIR.'/success.tpl');

$dbObj->Close();
?>