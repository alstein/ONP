<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../include.php");
include_once('../../../includes/DBTransact.php');
$result = 'true';

if($_REQUEST['nemail'] != "")
{
   $cnd = "nemail = '".$_REQUEST['nemail']."' ";
//    if(isset($_REQUEST['userid']))
//    {
//       $cnd .= "  AND userid !=".$_REQUEST['userid'];
//    }
   $rs = $dbObj->gj("tbl_newsletter","nemail",$cnd,"","","","","");
   if($rs != 'n')
   {
      if($row =@mysql_fetch_assoc($rs))
      $result='false';
   }
}

echo $result;


?>