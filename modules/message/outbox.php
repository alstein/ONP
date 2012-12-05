<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
if($_POST['str']!="")
{
	if($_POST['str']=="outbox")
	{
	$_SESSION['str']="outbox";
	}
}

	if(isset($_POST['action']))
	{
		
		extract($_POST);
		$inboxmsgid =@implode(", ", $msgid);
	
		
		if($action == "delete")
		{
		$temp = $dbObj->customqry("update outbox set is_deleted =1 where MID in (".$del_id.") and FROM_ID='".$_SESSION['csUserId']."'","");
		$s="Message Successfully Delete Outbox";
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				
		}
	} 
	$wf=array("FROM_ID","is_deleted");
	$wv=array($_SESSION['csUserId'],0);
	$select_message=$dbObj->cgs(" outbox o left join messages m on m.MID=o.MID left join tbl_users u on o.TO_ID=u.userid", "u.first_name,u.last_name,o.*,m.*", $wf, $wv, "m.cdate desc", "", "");
	while($row_message=@mysql_fetch_assoc($select_message))
	{
	$outbox[]=$row_message;
	}
	$smarty->assign("outbox",$outbox);

$smarty->display( TEMPLATEDIR . '/modules/messages/outbox.tpl');
$dbObj->Close();
?>

