<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/common.lib.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("8", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

	$id = $_GET['id'];
#------marking all records as read-------#
// 	 $field = array(
//             "read"=>'1'
//         );
	
	//$dbObj->cupdtii('tbl_quote_comment',$field,"dealid = '{$_GET['id']}'","1");
$temp1 = $dbObj->customqry("update tbl_quote_comment set `read`=1 where dealid = ".$_GET['id'],"");
	
#-----end-----#


	$smarty->assign("dealid",$id);
	$tbl = "tbl_quote_comment";
	$cnd = "dealid = ".$id;
	$sf = "*";
	$result = $dbObj ->gj($tbl ,$sf, $cnd,"comment_id", "" , "DESC" , "", "","");
	while($row=@mysql_fetch_assoc($result))
	{
	$comment[] = $row;
	}	
	
	$smarty->assign("comment",$comment);



if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }

	$smarty->assign("right", TEMPLATEDIR .'/rightside_admin.tpl');

	$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/deal-quote-reply.tpl');
	
	$dbObj->Close();
?>
