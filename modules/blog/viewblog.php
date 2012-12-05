<?php
include_once('../../include.php');
include_once('../../includes/class.message.php');
$msobj= new message();

 
#----------Getting Blog Details---------------
    $tbl="tbl_blog b INNER JOIN  tbl_users u ON b.userid = u.userid";
    $sf = "b.*, u.first_name, u.last_name";
    $cnd = "id=".$_GET['blogid'];
    $ob = "b.id DESC";
    $rs = $dbObj->gj($tbl, $sf, $cnd, $ob, "", "", "", '');
    $row = @mysql_fetch_assoc($rs);
    
    $smarty->assign("row",$row);

    $tbl2="tbl_blog_comment c INNER JOIN  tbl_users u ON c.userid = u.userid";
    $sf2 = "c.*, u.first_name, u.last_name";
    $cnd2 = "c.blog_id=".$_GET['blogid'];
    $ob2 = "c.id DESC";
    $rs2 = $dbObj->gj($tbl2, $sf2, $cnd2, $ob2, "", "", "", '');

    while($row2 = @mysql_fetch_assoc($rs2))
    {
    $comments[]=$row2;
    }	
 $smarty->assign("comments",$comments);
//  echo "<pre>";print_r($comments);exit;


$smarty->assign("pgName","content");
$smarty->display(TEMPLATEDIR . '/modules/blog/viewblog.tpl');
$dbObj->Close();
?>
