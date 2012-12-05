<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$row_meta=$dbObj->getseodetails(15);
$smarty->assign("row_meta",$row_meta);

if(isset($_POST['Delete'])){
		extract($_POST);
		$inboxmsgid =@implode(", ", $msgid);
		$temp = $dbObj->customqry("delete from inbox where MID in (".$inboxmsgid.") and TO_ID='".$_SESSION['csUserId']."'","");
}


if(isset($_POST['Delete_outbox'])){
		extract($_POST);
		$inboxmsgid =@implode(", ", $msgid);
		$temp = $dbObj->customqry("delete from outbox where MID in (".$inboxmsgid.") and FROM_ID='".$_SESSION['csUserId']."'","");
}



if($_SESSION['str']!="")
{
$smarty->assign("str",$_SESSION['str']);
}


	if(isset($_POST['action']))
	{
		
		extract($_POST);
		$inboxmsgid =@implode(", ", $msgid);
	
		
		if($action == "delete")
		{
		$temp = $dbObj->customqry("update inbox set is_deleted =1 where MID in (".$del_id.") and TO_ID='".$_SESSION['csUserId']."'","");
		$s="Message Successfully Delete Inbox";
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				
		}
	} 

	$wf=array("TO_ID","is_deleted");
	$wv=array($_SESSION['csUserId'],0);
	$select_message=$dbObj->cgs(" inbox i left join messages m on m.MID=i.MID left join tbl_users u on i.TO_ID=u.userid", "u.first_name,u.last_name,i.*,m.*",$wf , $wv, "m.cdate desc", "", "");
	while($row_message=@mysql_fetch_assoc($select_message))
	{
	$message[]=$row_message;
	}
	$smarty->assign("message",$message);
$smarty->display( TEMPLATEDIR . '/modules/messages/inbox.tpl');
$dbObj->Close();
unset($_SESSION['str']);
?>

