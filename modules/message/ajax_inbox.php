<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
if($_POST['str']!="")
{
	if($_POST['str']=="inbox")
	{
	$_SESSION['str']="inbox";
	}

}

if($_POST['mun']){
	$dbObj->customqry("update inbox set flag=1 where mid=".$_POST['mun'],"");
}

if(isset($_POST['Delete']))
	{
		
		extract($_POST);
		$inboxmsgid =@implode(", ", $msgid);
	
		
		//if($action == "delete")
		//{
		$temp = $dbObj->customqry("update inbox set is_deleted =1 where MID in (".$del_id.") and TO_ID='".$_SESSION['csUserId']."'","");
		$s="Message Successfully Delete Inbox";
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
				
		//}
	} 

	//$wf=array("TO_ID","is_deleted");
	//$wv=array($_SESSION['csUserId'],0);

	$wf=array("TO_ID","is_deleted");
	$wv=array($_SESSION['csUserId'],0);

	$select_message=$dbObj->cgs(" inbox i left join messages m on m.MID=i.MID left join tbl_users u on i.FROM_ID=u.userid", "u.first_name,u.last_name,i.*,m.*",$wf , $wv, "m.cdate desc", "", "");
	while($row_message=@mysql_fetch_assoc($select_message))
	{
	$message[]=$row_message;
	}
	$smarty->assign("message",$message);
	
$smarty->display( TEMPLATEDIR . '/modules/messages/ajax_inbox.tpl');
$dbObj->Close();
?>
