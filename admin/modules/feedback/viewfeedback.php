<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
$smarty->assign("msobj",$msobj);
//print_r($_GET);
if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}

// if(!$_SESSION['duAdmId'])
// 	header("location:". SITEROOT . "/admin/login/index.php");




/*----Fetch feedback of user-------------*/

$sf = "f.*,u.first_name,(select first_name from tbl_users uu where f.userid = uu.userid) as buyer";
$tbl = "feedback as f LEFT JOIN tbl_users as u ON u.userid = f.userid";
$cnd = "f.fid=".$_GET['id'];

$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", "", "");
$i = 0;
$row = @mysql_fetch_assoc($rs);
$row['grey']= 5 -$row['rating'];
$row['delivery_grey']= 5 -$row['delivery'];
$row['item_grey']= 5 -$row['item'];

$smarty->assign("feedback", $row);
// echo "<pre>";
//print_r($row);
/*------End of Fetch feedback of user--------*/

//strength

$rs11=$dbObj->customqry("select * from strength where id in (".$row['strength'].")","");
		if($rs11!='n')
		{
			$str = array();
			while($row11 = @mysql_fetch_assoc($rs11))
			{
				$str[]=$row11['strength'];
			}
			//$row['str'] = $str;
					$stregthstr = implode(',',$str);
					//$row['skstr'] = $stregthstr;
		}
//print_r($stregthstr);
$smarty->assign("stregthstr", $stregthstr);
if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
	
}
/*
if(isset(($_GET['search'] != "")))
{
	$s=$msobj->showmessage(407);	// new id message with search criterioa
}
else
{
	$s=$msobj->showmessage(337);
}*/

//$smarty->assign("norecord",$s['msgtext']);
// echo hi;

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/modules/feedback/viewfeedback.tpl');

$dbObj->Close();
?>