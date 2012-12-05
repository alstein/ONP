<?php 
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/common.lib.php');
include_once('../../../includes/classes/class.profile.php');
include_once('../../../includes/classes/class.security.php');
include_once('../../../includes/classes/class.general.php');
include_once('../../../includes/classes/class.feed.php');
//ini_set('upload_max_filesize', '8M');
if(!$_SESSION['duAdmId'])
{
	header("location:".SITEROOT . "/admin/login/home.php");
	exit();
}

$userid = $_GET['userid'];
$roleid = $_GET['roleid'];
# get album id from url
$album_url = $_GET['album_url'];
$smarty->assign("album_url", $album_url);

$album = $generalObj->getAlbumId($_GET['album_url']);
$smarty->assign('album', $album);
$smarty->assign("albumid", $album['album_id']);

$view = $_GET['view'];
$smarty->assign("view",$view);

if(strlen($_POST['submit'])> 0)
{
	extract($_POST);
// print_r($_POST);


	if(sizeof($delete)>0)
	{
		foreach($delete as $k=>$v)
		{
			@unlink('../../uploads/post_accomplish/52X52/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/90X90/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/145X145/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/400X400/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/600X600/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/413X270/'.$image[$v]);
			@unlink('../../uploads/post_accomplish/thumbnail/'.$image[$v]);
			$del = $dbObj->customqry("DELETE FROM tbl_accomplishment_photo where photoid = '".$v."'", "");
			$del = $dbObj->customqry("DELETE FROM tbl_reports where itemid = '".$v."' AND moduleid='3'", "");
			$del = $dbObj->customqry("DELETE FROM tbl_comments where itemid = '".$v."' AND moduleid='1'", "");
			$del = $dbObj->customqry("DELETE FROM tbl_photo_tag where photoid = '".$v."'", "");
			$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET trophy_case=0 WHERE trophy_case = '".$v."'","");
			$cupdt = $dbObj->customqry("UPDATE tbl_accomplishment SET accomplishment_cover=0 WHERE accomplishment_cover = '".$v."'","");

		}
	}
	if($view == 'acc')
	{
		$set = $dbObj->customqry("UPDATE tbl_accomplishment SET accomplishment_cover='' , trophy_case='' WHERE acc_id = '".$_GET['accid']."'", "");
	}
	if($view != "old" && $view != "acc") // to list recent uploaded photo
	{
		foreach($photoid as $k =>$v)
		{
			$res = $dbObj->gj("tbl_accomplishment_photo_temp", "*", "photoid = '".$v."'", "", "","", "", "");
			if(is_resource($res))
			{
			   $field = array("album_id", "acc_id", "image", "description", "tag","album_cover", "added_by", "added_date", "status", "recent");
			   $row = @mysql_fetch_assoc($res);
			   $value = array($row['album_id'], $row['acc_id'], $row['image'], $row['description'], $row['tag'], $row['album_cover'], $row['added_by'], $row['added_date'], $row['status'], $row['recent']);
			   $id = $new_photoid[] = $dbObj->cgi('tbl_accomplishment_photo', $field, $value, "");
			}
			if($album_cover[0] == $v)
			$album_cover[0] = $id;
		}
		$photoid = $new_photoid;
		$res = $dbObj->customqry("TRUNCATE TABLE `tbl_accomplishment_photo_temp`","");
	}
	foreach($photoid as $k =>$v)
	{
		$fieldp = array("acc_id","description", "recent");
		$acc = $_POST['acc_'.$k];
// 		$valuep = array(@implode(",", $acc),$description[$k], "0");
		$valuep = array($acc, $description[$k], "0");
		$updtid = $dbObj->cupdt('tbl_accomplishment_photo', $fieldp , $valuep, 'photoid' , $v, "");
		
		if($view == 'acc')
		{
			if($accomplishment_cover[0] == $v)
			{
				$set = $dbObj->customqry("UPDATE tbl_accomplishment SET accomplishment_cover='".$v."' WHERE acc_id = '".$_GET['accid']."'", "");
			}
			# update trophy case photo
			if($trophy_case == $v)
			{
				$set = $dbObj->customqry("UPDATE tbl_accomplishment SET trophy_case='".$v."' WHERE acc_id = '".$_GET['accid']."'", "");
			}
		}
		else
		{
			if($album_cover[0] == $v) $al = 1; else $al =0;
			$updttrid = $dbObj->cupdt('tbl_accomplishment_photo', 
				array("album_cover") , 
				array( $al), 
				'photoid' , $v, "");
			
		}
		//for tag
		$del = $dbObj->customqry("DELETE FROM tbl_photo_tag where photoid = '".$v."' AND taged_by='".$_SESSION['csUserId']."'", "");
		# tag friends
		$tag = $_POST['tag_'.$k];
		if($tag != "")
		{
			$tag_field = array("photoid","userid","taged_by","added_date", "visited");
			foreach($tag as $key=>$val)
			{
				$url = "Not visited";
				$tag_value = array($v, $val, $_SESSION['csUserId'], date("Y-m-d H:i:s"), $url);
				$tagid = $dbObj->cgi("tbl_photo_tag", $tag_field, $tag_value,"");
			}
		}
	}
	foreach($photoid as $k =>$v)
	{
		if($other_album[$k] != "")
		{
			$al_field = array("album_id");
			$al_value = array($other_album[$k]);
			$updtid = $dbObj->cupdt('tbl_accomplishment_photo', $al_field , $al_value, 'photoid' , $v, "");
		}
	}
	$_SESSION['msg'] = "<span class='successMsg'>Photos Updated Successfully.</span>";
	if($view != 'acc')
	{
		header("Location:".SITEROOT."/admin/sitemodules/albums/view-album.php?id=".$album['album_id']);
		exit();
	}
	else
	{
		header("Location:".SITEROOT."/admin/sitemodules/post_accomplish/view_award.php?id=".$_GET['accid']);
		exit();
	}
}//end submit


if($view != "old" && $view != "acc") // to list recent uploaded photo
{
	$tbl = "tbl_accomplishment_photo_temp";
	$sf = "*";
	$cnd = "added_by = '".$userid."' AND album_id='".$album['album_id']."' AND recent='1'";
	$row= $dbObj->gj($tbl, $sf, $cnd , "", "", "", "", "");
	$photo_cnt = @mysql_num_rows($row);
	$i=0;
	while($rec = @mysql_fetch_assoc($row))
	{
		$photos[$i] = $rec;
		$photos[$i]['accomp'] = $rec['acc_id']; //@explode(",",$rec['acc_id']);
		if($rec['acc_id'] != "")
		{
			$tbla = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id";
			$sfa = "a.*, u.first_name, u.last_name, u.login_name, e.title, w.award_title";
			$cnda = "a.acc_id = '".$rec['acc_id']."' ";
			$ares = $dbObj->gj($tbla,$sf,$cnda, "","","","","");
			$rowa = @mysql_fetch_assoc($ares);
			$rowa['edate'] = $profObj->customDate($rowa['end_date']);
			$photos[$i]['acc_detail'] = $rowa;
		}
		$i++;
	}
}
elseif($view == "old") // when condition to edit album photos
{
	$tbl = "tbl_accomplishment_photo";
	$sf = "*";
	$cnd = "album_id='".$album['album_id']."'";
	if($album['album_id'] == 1)
	$cnd .= "AND added_by = '".$userid."'";
	$row= $dbObj->gj($tbl, $sf, $cnd , "", "", "", "", "");
	$photo_cnt = @mysql_num_rows($row);
	$i=0;
	while($rec = @mysql_fetch_assoc($row))
	{
		$photos[$i] = $rec;
		$photos[$i]['accomp'] = $rec['acc_id']; // @explode(",",$rec['acc_id']);
		if($rec['acc_id'] != "")
		{
			$tbla = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id";
			$sfa = "a.*, u.first_name, u.last_name, u.login_name, e.title, w.award_title";
			$cnda = "a.acc_id = '".$rec['acc_id']."' ";
			$ares = $dbObj->gj($tbla,$sf,$cnda, "","","","","");
			$rowa = @mysql_fetch_assoc($ares);
			$rowa['edate'] = $profObj->customDate($rowa['end_date']);
			$photos[$i]['acc_detail'] = $rowa;
		}

		$res1 = $dbObj->gj("tbl_photo_tag t LEFT JOIN users u ON t.userid = u.userid", "t.*", "t.photoid='".$rec['photoid']."'", "","","","","");
		if(is_resource($res1))
		{
			$photos[$i]['tag'] = array();
			while($row1 = @mysql_fetch_assoc($res1))
			{
				$photos[$i]['tag'][] = $row1['userid'];
			}
		}
		$i++;
	}
}
elseif($view == "acc") // when condition to edit Accomplishment photos
{
	$i = 0;
	$tbl = "tbl_accomplishment_photo";
	$cnd = "find_in_set(".$_GET['accid'].", acc_id) ";
	$row = $dbObj->gj($tbl, "*", $cnd, "", "", "", "", "");
	$photo_cnt = @mysql_num_rows($row);
	while($rec = @mysql_fetch_assoc($row))
	{
		$photos[$i] = $rec;
		$photos[$i]['accomp'] = $rec['acc_id']; //@explode(",",$rec['acc_id']);
		if($rec['acc_id'] != "")
		{
			$tbla = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id";
			$sfa = "a.*, u.first_name, u.last_name, u.login_name, e.title, w.award_title";
			$cnda = "a.acc_id = '".$rec['acc_id']."' ";
			$ares = $dbObj->gj($tbla,$sf,$cnda, "","","","","");
			$rowa = @mysql_fetch_assoc($ares);
			$rowa['edate'] = $profObj->customDate($rowa['end_date']);
			$photos[$i]['acc_detail'] = $rowa;
		}

		$res1 = $dbObj->gj("tbl_photo_tag t LEFT JOIN users u ON t.userid = u.userid", "t.*", "t.photoid='".$rec['photoid']."'", "","","","","");
		if(is_resource($res1))
		{
			$photos[$i]['tag'] = array();
			while($row1 = @mysql_fetch_assoc($res1))
			{
				$photos[$i]['tag'][] = $row1['userid'];
			}
		}
		$i++;
	}
	$tbl = "tbl_accomplishment";
	$cnd = "  acc_id = '".$_GET['accid']."'";
	$row = $dbObj->gj($tbl, "trophy_case, accomplishment_cover", $cnd, "", "", "", "", "");
	$res = @mysql_fetch_assoc($row);
	$tr_case = $res['trophy_case'];
	$smarty->assign('tr_case', $tr_case);
	$acc_cover = $res['accomplishment_cover'];
	$smarty->assign('acc_cover', $acc_cover);
}
$smarty->assign("photo_cnt", $photo_cnt);
$smarty->assign("record", $photos);

	# fetch Albums created by that user
	$tbl = "tbl_album";
	$sf = "*";
	$cnd = " status = 'Active' AND url_title != '".$album_url."'";
	$cnd .= " AND user_id IN (".$userid;
	if($student_arr != "") $cnd .= " , ". @implode(",",$student_arr);
	if($children_arr != "") $cnd .= " , ". @implode(",",$children_arr);
	$cnd .= ")"; 
	$row= $dbObj->gj($tbl, $sf, $cnd , "album_title", "", "ASC", "", "");
	while($rec = @mysql_fetch_assoc($row))
	{
		$other_album[] = $rec;
	}
	$smarty->assign("other_album", $other_album);

	# fetch Childs Accomplishment
// 	if($roleid == 4)
// 	{
// 	  $ch_userid = $profObj->getChildUserId($userid);
// 	  $feed = $feedObj->stud_friend_feed($userid, @implode(",", $ch_userid));
// 	  $ch_userid = $profObj->getChildUserId($userid);
// 	}
// 	elseif($roleid == 5)
// 	{
// 	  $teacher = $schoolObj->getTeacherDetails($userid);
// 	  $student_arr = $schoolObj->getStudentofTeacher($teacher['schoolid'], $teacher['gradeid'], $teacher['classid']);
// 	  $ch_userid = $student_arr[0];
// 	  $feed = $feedObj->stud_friend_feed($userid, @implode(",", $ch_userid));
// 	}
// 	elseif($roleid == 3)
// 	{
// 		$tbla = "tbl_accomplishment a LEFT JOIN tbl_events e ON a.event_name = e.eventid
// 			LEFT JOIN tbl_awards aw ON a.award = aw.award_id
// 			LEFT JOIN users l ON a.location = l.userid
// 			LEFT JOIN users u ON a.userid = u.userid";
// 		$sfa = "a.*, e.title, aw.award_title, l.first_name as location, u.login_name";
// 		$cnda =  "a.status = 'Active' AND a.userid = '".$userid."'";
// 		
// 		$result = $dbObj->gj($tbla, $sfa, $cnda, "", "", "DESC", "", "");
// 		while($row = @mysql_fetch_assoc($result))
// 		{
// 			$feed[] = $row;
// 		}
// 	}
// 	$smarty->assign("feed", $feed);

	// fetch Friends
	$friends = $profObj->getfriends($userid);
	if($ch_userid != "")
	foreach($ch_userid as $k=>$v)
	{
		$ch_friends = $profObj->getfriends($v);
		if($ch_friends != "")
		$friends = @array_merge($friends, $ch_friends);
	}
	$smarty->assign("friends", $friends);
	

if($_SESSION['msg'])
{
	$smarty->assign("msg",$_SESSION['msg']);
	unset($_SESSION['msg']);
}

$smarty->display(TEMPLATEDIR .'/admin/sitemodules/albums/edit-album.tpl');

?>