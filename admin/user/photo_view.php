<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


$sf="*";
$tbl="tbl_accomplishment_photo ";
$cnd="photoid=".$_GET['photoid'];

    $rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "","", "");
    if($rs != 'n')
    {
	$row=@mysql_fetch_assoc($rs);
       	$photo=$row;
	$smarty->assign("photo", $photo);
    }




/*-------------------------------------Remove Comments By Admin----------------------------------------*/
if($_GET['remove_id']!="")
{
$id = $dbObj->customqry("delete from tbl_comment where comment_id in (".$_GET['remove_id'].")","");
$s=$msobj->showmessage(264);
$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
@header("Location:".SITEROOT."/admin/user/photo_view.php?photoid=".$_GET['photoid']."");

}

/*-------------------------------------Completed-------------------------------------*/

/*-----------------------------------Active/Inactive Comments------------------------------------*/
	if($_GET['comment_id']!="")
	{
		if($_GET['act']=='active')
		{
		$table="tbl_comment";
					$fields=array("status");
					$values=array("active");
					$search_field="comment_id";
					$search_value=$_GET['comment_id'];
				$res=$dbObj->cupdt($table,$fields,$values,$search_field,$search_value,"");
		@header("Location:".SITEROOT."/admin/user/photo_view.php?photoid=".$_GET['photoid']."");
	
		}
		if($_GET['act']=='inactive')
		{
		$table="tbl_comment";
					$fields=array("status");
					$values=array("inactive");
					$search_field="comment_id";
					$search_value=$_GET['comment_id'];
				$res=$dbObj->cupdt($table,$fields,$values,$search_field,$search_value,"");
		@header("Location:".SITEROOT."/admin/user/photo_view.php?photoid=".$_GET['photoid']."");
		
		}
	}
/*---------------------------------------Completed---------------------------------------*/

/*-----------------------------------Select comments of perticular testimonial------------------------------------*/

	$qry=$dbObj->customqry("select t.*,u.fullname from tbl_comment t left join tbl_users u on t.posted_by =u.userid where   t.photo_id='".$_GET['photoid']."'","");

	 $count=@mysql_num_rows($qry);
	while($photo=@mysql_fetch_assoc($qry))
	{
		$photo_comment[]=$photo;

	}
	$smarty->assign("photo_comment",$photo_comment);
	
	$smarty->assign("user",$user);
/*-------------------------------------Completed-------------------------------------------*/


/*-------------------------------Add Comment By Admin On Testimonial------------------------------*/
if(isset($_POST["submit"]))
{
	$comment=trim(addslashes($_POST['comment']));
	$loc_date=date("Y-m-d");
	$fl = array("photo_id","comment","posted_on","posted_by","status");
	$vl = array($_GET['photoid'],$comment,$loc_date,$_SESSION['duAdmId'],'active');
	$rs = $dbObj->cgi('tbl_comment',$fl,$vl,'');
	$s=$msobj->showmessage(214);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	
@header("Location:".SITEROOT."/admin/user/photo_view.php?photoid=".$_GET['photoid']."");

}




if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/photo_view.tpl');
$dbObj->Close();
?>
