<?php
class feed Extends DBTransact
{
    public function __construct()
    {
        $this->p = new Profile;
        $this->s = new Security;
    }

	function stud_friend_feed($userid, $friendid)
	{
		$tbl = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN users l ON a.location =l.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id
			LEFT JOIN tbl_category c ON a.catid = c.catid
			LEFT JOIN tbl_subcategory sc ON a.subcatid = sc.subcatid
			LEFT JOIN tbl_student_security s ON u.userid = s.userid";
		$sf = "a.*, u.first_name, u.last_name, u.login_name, u.role_id, u.thumbnail, u.activities, e.title, w.award_title, c.category, sc.subcategory, s.share_name, l.first_name as location";
		$cnd = "a.status = 'Active' AND u.status = 'active' ";
		if($friendid != "")
		$cnd .= " AND u.userid IN (".$friendid.")";
		else 
		$cnd .= " AND u.userid IN ( 0 )";
		$ob = "a.added_date";
		$obc = "DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", $obc,"","");
		$i= 0;
		while($row = @mysql_fetch_assoc($rs))
		{

			$feed[$i] = $row;
			$feed[$i]['start_date'] = $this->p->customDate($row['start_date']);
			$feed[$i]['end_date'] = $this->p->customDate($row['end_date']);
			$feed[$i]['isReport'] = $this->isReportedFeed($row['acc_id'],$row['userid']);
			if($_SESSION['csRoleId'] == 3)
			$feed[$i]['isUrl'] = $this->s->isLinktoProfile($row['userid'], $_SESSION['csUserID']);
			else $feed[$i]['isUrl'] = 'yes';
			$feed[$i]['school'] = $this->p->getCurrentEducation($row['userid']);
			$feed[$i]['activities'] = $this->p->getActivities($row['activities']);
			$feed[$i]['recentAccom'] = $this->p->getrecentAccomp($row['userid']);
			$feed[$i]['trophy_case'] = $this->p->getTrophyCasePhoto($row['acc_id']);
// 			$cndition = "acc_id = '".$row['acc_id']."' AND trophy_case ='1' AND status='Active'";
// 			$rs1 = $dbObj->gj("tbl_accomplishment_photo", "album_id, image" , $cndition, "", "", "", "", "");
// 			if(is_resource($rs))
// 				$trophy_case = @mysql_fetch_assoc($rs);
// 			$feed[$i]['trophy_case'] = $trophy_case['iamge'];
			$i ++;
		}
		return $feed;
	}
	
	function stud_friend_feed_count($userid, $friendid)
	{
		$tbl = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id
			LEFT JOIN tbl_category c ON a.catid = c.catid
			LEFT JOIN tbl_subcategory sc ON a.subcatid = sc.subcatid
			LEFT JOIN tbl_student_security s ON u.userid = s.userid";
		$sf = "a.*, u.first_name, u.last_name, u.login_name, u.role_id, u.thumbnail, e.title, w.award_title, c.category, sc.subcategory, s.share_name";
		$cnd = "a.status = 'Active' AND u.status = 'active' ";
		if($friendid != "")
		$cnd .= " AND u.userid IN (".$friendid.")";
		else 
		$cnd .= " AND u.userid IN ( 0 )";
		$ob = "a.added_date";
		$obc = "DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", $obc,"","");
		$cnt = @mysql_num_rows($rs);
		return $cnt;
	}

	function parent_friend_feed($userid, $friendid)
	{
		$tbl = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN users l ON a.location =l.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id
			LEFT JOIN tbl_category c ON a.catid = c.catid
			LEFT JOIN tbl_subcategory sc ON a.subcatid = sc.subcatid
			LEFT JOIN tbl_student_security s ON u.userid = s.userid
			LEFT JOIN users p ON p.userid = u.parentid ";

		$sf = "a.*, u.first_name, u.last_name, u.login_name, u.role_id, u.thumbnail,u.activities, e.title, w.award_title, s.share_name, c.category, sc.subcategory";
		$cnd = "p.status = 'active' AND p.role_id='4' AND u.status = 'active' ";
		//$frnd_arr = $this->getUserFriends($userid);
		if($friendid !="") {
			//$frnd_arr = @implode(",",$frnd_arr);
			$cnd .= " AND p.userid IN (".$friendid.")";
		}
		else $cnd .= " AND p.userid IN (0)";
		$ob = "a.added_date";
		$obc = "DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", $obc,"","");
		$i= 0;
		while($row = @mysql_fetch_assoc($rs))
		{
			$feed[$i] = $row;
			$feed[$i]['start_date'] = $this->p->customDate($row['start_date']);
			$feed[$i]['end_date'] = $this->p->customDate($row['end_date']);
			$feed[$i]['isReport'] = $this->isReportedFeed($row['acc_id'],$row['userid']);
			$feed[$i]['school'] = $this->p->getCurrentEducation($row['userid']);
			$feed[$i]['activities'] = $this->p->getActivities($row['activities']);
			$feed[$i]['recentAccom'] = $this->p->getrecentAccomp($row['userid']);
			$feed[$i]['trophy_case'] = $this->p->getTrophyCasePhoto($row['acc_id']);

			$i ++;
		}
		return $feed;
	}

	function parent_friend_feed_count($userid, $friendid)
	{
		$tbl = "tbl_accomplishment a LEFT JOIN users u ON a.userid = u.userid
			LEFT JOIN users l ON a.location =l.userid
			LEFT JOIN tbl_events e ON a.event_name = e.eventid
			LEFT JOIN tbl_awards w ON a.award = w.award_id
			LEFT JOIN tbl_category c ON a.catid = c.catid
			LEFT JOIN tbl_subcategory sc ON a.subcatid = sc.subcatid
			LEFT JOIN tbl_student_security s ON u.userid = s.userid
			LEFT JOIN users p ON p.userid = u.parentid ";

		$sf = "a.*, u.first_name, u.last_name, u.login_name, u.role_id, u.thumbnail, e.title, w.award_title, s.share_name, c.category, sc.subcategory";
		$cnd = "p.status = 'active' AND p.role_id='4' AND u.status = 'active' ";
		//$frnd_arr = $this->getUserFriends($userid);
		if($friendid !="") {
			//$frnd_arr = @implode(",",$frnd_arr);
			$cnd .= " AND p.userid IN (".$friendid.")";
		}
		else $cnd .= " AND p.userid IN (0)";
		$ob = "a.added_date";
		$obc = "DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", $obc,"","");
		$cnt = @mysql_num_rows($rs);
		return $cnt;
	}

	function isReportedFeed($id, $userid)
	{
		$tbl = "tbl_reports";
		$sf = "*";
		$cnd = "userid = '".$_SESSION['csUserId']."' AND comment_userid = '".$userid."' AND moduleid = '2' AND commentid = '".$id."'";
		$rs = $this->gj($tbl, $sf , $cnd, "", "", "", "", "");
		if(is_resource($rs))
		{
			$rep = 'Yes';
		}
		else $rep = 'no';
		return $rep;
	}

	function getUserFriends($userid)
	{
		$tbl="tbl_friends as f INNER JOIN users u ON u.userid=f.userid INNER JOIN users ua ON ua.userid=f.friendid";
		$cnd= "f.user_type = '4' AND (f.userid = '".$userid."' OR f.friendid = '".$userid."') AND f.verification = 'yes'";
		$sf="f.*,u.first_name as ufirst_name,u.last_name as ulast_name,ua.first_name as ffirst_name,ua.last_name as flast_name";
		$rs = $this->gj($tbl,$sf,$cnd, "", "", "", "", "");
		$frnd = array(); $frnd_userid = array();
		while($row = @mysql_fetch_assoc($rs))
		{
			//$frnd[] = $row;
			if($row['userid'] == $userid)
			$frnd_userid[] = $row['friendid'];
			else
			$frnd_userid[] = $row['userid'];
		}
		return $frnd_userid;
	}

}
$feedObj = new feed;
?>