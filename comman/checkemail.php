<?php
include_once('../includes/DBTransact.php');
$result = 'true';
if(trim($_REQUEST['email']) != "")
{

    $cnd = "email ='".trim($_REQUEST['email'])."' and isDeleted <> 1";
    $rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
    if($rs != 'n')
    {
        if($row =@mysql_fetch_assoc($rs))
        {
            $result='false';
        }
    }
}
echo $result;
?>
