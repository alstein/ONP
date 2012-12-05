<?php
/**
* Project:     Outsourced2Earth
* File:        class.myaccount.php
*
* @author Yogesh Kadam <k dot yotesh at agiletechnosys dot com>
* @package includes.classes
* @version 1.0
*/
Class MyAccount extends DBTransact
{
	function getUserdetails($userid)
	{
		$tbl 	=	"tbl_users AS u LEFT JOIN mast_country AS c ON u.countryid=c.countryid LEFT JOIN mast_status as s on u.statusid=s.statusid";
		$sf	=	"u.*, c.country, s.status";
		$rs	=	$this->customqry("SELECT $sf FROM $tbl WHERE u.userid=".$userid);
		$user = 	mysql_fetch_assoc($rs);
		$tmp = $this->getCurrentStatus($user['userid']);
		$user['current_status'] = $tmp['message'];
		$user['profile_progress'] = $this->getProfileProgress($userid);
		return $user;
	}

	function getPersonalInfo($userid)
	{
		$sf = "p.*, pc.country, bc.country as bz_country";
		$tbl = "tbl_users_personal_info AS p LEFT JOIN mast_country AS pc ON p.countryid=pc.countryid LEFT JOIN mast_country AS bc ON p.bz_countryid=bc.countryid";
		$rs = $this->customqry("SELECT $sf FROM $tbl WHERE p.userid=".$userid, '');
		$row = @mysql_fetch_assoc($rs);
		return $row;
	}

	function getReferences($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_references WHERE userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$references[] = $row;
		return $references;
	}

	function getExperiences($userid)
	{
		$tbl 	=  "tbl_users_experience as e LEFT JOIN mast_industries as i on e.industryid=i.industryid LEFT JOIN mast_status as s on e.statusid=s.statusid LEFT JOIN mast_career_level as cl on e.career_levelid=cl.career_levelid LEFT JOIN mast_company_size as cz on e.company_sizeid=cz.company_sizeid LEFT JOIN mast_org_types as o on e.orgtypeid=o.orgtypeid";
		$sf 	=	"e.*, i.industry, s.status, cz.company_size, o.orgtype, cl.career_level";
		$rs = $this->customqry("SELECT ".$sf." FROM ".$tbl." WHERE e.userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
		{
			$year = 0;
			$month = 0;
			if($row['current_position']=='yes')
			{
				$year += (date("Y") - $row['from_year']);
				$month += (date("m") -$row['from_month']);
			}
			else
			{
				$year += ($row['to_year'] - $row['from_year']);
				$month += ($row['to_month'] -$row['from_month']);
			}
			$row['experience']=$year." years, ".$month." month";;
			$experiences[] = $row;
		}
		return $experiences;
	}

	function getTotalExperience($userid)
	{
		$year = 0;
		$month = 0;
		$exps = $this->getExperiences($userid);
		if(is_array($exps))
		{
			foreach($exps as $exp)
			{
				if($exp['current_position']=='yes')
				{
					$year += (date("Y") - $exp['from_year']);
					$month += (date("m") -$exp['from_month']);
				}
				else
				{
					$year += ($exp['to_year'] - $exp['from_year']);
					$month += ($exp['to_month'] -$exp['from_month']);
				}
			}
		}
		return $year." years, ".$month." month";
	}

	function getAwards($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_award WHERE userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$awards[] = $row;
		return $awards;
	}

	function getEducations($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_education WHERE userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$educations[] = $row;
		return $educations;
	}

	function getQualifications($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_qualification WHERE userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$qualifications[] = $row;
		return $qualifications;
	}

	function getUserLanguages($userid)
	{
		$rs = $this->customqry("SELECT ul.*, l.language, sl.skill_level FROM tbl_users_language AS ul INNER JOIN mast_language AS l ON ul.langid=l.langid INNER JOIN mast_skill_level as sl ON sl.skillid=ul.skillid WHERE ul.userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$userlangs[] = $row;
		return $userlangs;
	}

	function getEmails($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_email where userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$emails[] = $row;
		return $emails;
	}

	function getMessangerIds($userid)
	{
		$rs = $this->customqry("SELECT u.*, m.msgr FROM tbl_users_messanger as u INNER JOIN mast_messanger as m on m.msgr_typeid=u.msgr_typeid where u.userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$messangerids[] = $row;
		return $messangerids;
	}
	function getExtraActivities($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_extra_activity where userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$extra_activities[] = $row;
		return $extra_activities;
	}
	function getCurrentOrganization($userid)
	{
		$tbl 	= 	"tbl_users_experience as e LEFT JOIN mast_industries as i on e.industryid=i.industryid LEFT JOIN mast_status as s on e.statusid=s.statusid LEFT JOIN mast_career_level as cl on e.career_levelid=cl.career_levelid LEFT JOIN mast_company_size as cz on e.company_sizeid=cz.company_sizeid LEFT JOIN mast_org_types as o on e.orgtypeid=o.orgtypeid";
		$sf 	=	"e.*, i.industry, s.status, cz.company_size, o.orgtype, cl.career_level";
		$cnd	=	"e.current_position='yes' AND e.userid=".$userid;
		$rs = $this->customqry("SELECT ".$sf." FROM ".$tbl." WHERE ".$cnd);
		$experience = @mysql_fetch_assoc($rs);
		return $experience;
	}

	function getMotivation($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_motivation WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		return $row;
	}

	function getCurrentStatus($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_user_status WHERE userid=".$userid." ORDER BY posted_date DESC");
		$row = @mysql_fetch_assoc($rs);
		return $row;
	}

	function getMemoList($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_memo WHERE to_userid=".$userid);
		while($row = @mysql_fetch_assoc($rs))
			$memos[] = $row;
		return $memos;
	}

	function getMemo($userid, $to_userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_users_memo WHERE userid=".$userid." AND to_userid=".$to_userid);
		$memo = @mysql_fetch_assoc($rs);
		return $memo;
	}

	function getPersonalTags($userid, $to_userid)
	{
	$rs = $this->customqry("SELECT * FROM tbl_users_personal_tags WHERE userid=".$userid." AND to_userid=".$to_userid);
	$tags = @mysql_fetch_assoc($rs);
	return $tags;
	}

	
	function getGuestBookEntries($userid)
	{
		$sf 	= 	"g.*, u.first_name, u.last_name, u.username, u.thumbnail";
		$tbl	=	"tbl_guestbook_entries as g INNER JOIN tbl_users as u ON g.fromuserid=u.userid";
		$cnd 	= 	"g.userid=".$userid;
		$rs = $this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$entries[] = $row;
		return $entries;
	}

	function getFriends($userid, $limit='')
	{
		$tbl  =  "tbl_users u, tbl_friends as f";
		$sf   =  "u.*";
		$cnd  =  "((f.friendid = u.userid AND  f.userid=".$userid.") OR (f.userid = u.userid AND f.friendid=".$userid.")) AND (f.verification='yes')";
		$rs=$this->gj($tbl, $sf, $cnd, "", "", "", $limit, "");
      while($row = @mysql_fetch_assoc($rs))
		{
			$row['friends'] 	=  $this->getFriendsCount($row['userid']);
			$row['memo']		= 	$this->getMemo($userid, $row['userid']);
			$row['personaltags']=$this->getPersonalTags($userid, $row['userid']);
			$row['profilesettings']=$this->getProfileSetting($row['userid']);
			$row['orgnization']=$this->getCurrentOrganization($row['userid']);
			$friends[] = $row;
		}
		return $friends;
	}

	
	function getFriendsCount($userid)
	{
		$tbl  =  "tbl_users u, tbl_friends as f";
		$sf   =  "count(u.userid)";
		$cnd  =  "((f.friendid = u.userid AND  f.userid=".$userid.") OR (f.userid = u.userid AND
					f.friendid=".$userid.")) AND (f.verification='yes')";
		$rs=$this->gj($tbl, $sf, $cnd, "", "", "", $limit, "");
		$row = @mysql_fetch_array($rs);
		return $row[0];
	}
	
	function getProfileSetting($userid)
	{
		$rs = $this->customqry("SELECT * FROM tbl_profile_page_setting WHERE userid = ".$userid);
		$row = @mysql_fetch_assoc($rs);
		if(!$row)
		{
			$rs = $this->customqry("INSERT INTO tbl_profile_page_setting(userid) values (".$userid.")");
			$rs = $this->customqry("SELECT * FROM tbl_profile_page_setting WHERE userid = ".$userid);
			$row = @mysql_fetch_assoc($rs);
		}
		return $row;
	}

	function isMyFriend($userid, $friendid)
	{
		if($userid==$friendid)
			return;
		$tbl  =  "tbl_users u, tbl_friends as f";
		$sf   =  "f.request_date, f.verification, f.verification_date";
		$cnd  =  "((f.friendid = ".$friendid." AND  f.userid=".$userid.") OR (f.userid = ".$friendid." AND f.friendid=".$userid."))";
		$rs=$this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		$row = @mysql_fetch_assoc($rs);
		if($row['verification']=="yes")
			return "yes";
		elseif($row['verification']=="no")
			return "requested";
		else
			return "no";
   }

	function updateVisit($profileid, $userid=0)
	{
		$rs = $this->customqry("insert into tbl_profile_visitor(userid, profileid, visited_date, ipaddress) values ($userid, $profileid, NOW(), '".$_SERVER['REMOTE_ADDR']."')");
	}

	function getRecentVisitor($userid, $limit='')
	{
		$tbl 	=	"tbl_profile_visitor AS p INNER JOIN tbl_users AS u on u.userid=p.userid";
		$sf	=	"u.*, max(p.visited_date) as last_visit";
		$cnd 	=	"p.profileid=".$userid;
		$gb	=	"p.userid";
		$rs = $this->gj($tbl, $sf, $cnd, "last_visit", $gb, "DESC", $limit, "");
		while($row = @mysql_fetch_assoc($rs))
			$users[]	=	$row;
		return $users;
	}

   function getContactsBirthday($userid, $limit='')
	{
		$tbl  =  "view_birthday u, tbl_friends as f";
		$sf   =  "u.*";
		$cnd  =  "((f.friendid = u.userid AND  f.userid=".$userid.") OR (f.userid = u.userid AND f.friendid=".$userid.")) AND (f.verification='yes') AND u.birthday >= curdate() and u.birthday <= date_add(curdate(), interval 10 day)";
		$rs=$this->gj($tbl, $sf, $cnd, "u.birth_date", "", "ASC", $limit, "");
		while($row = @mysql_fetch_assoc($rs))
		{
			$row['friends'] 			=  $this->getFriendsCount($row['userid']);
			$row['memo']				= 	$this->getMemo($userid, $row['userid']);
			$row['personaltags']		=	$this->getPersonalTags($userid, $row['userid']);
			$row['profilesettings']	=	$this->getProfileSetting($row['userid']);
			$friends[] = $row;
		}
		return $friends;
	}
	
	function getRecommendations($email){
		$tbl = "tbl_recommendations as r INNER JOIN tbl_users as u on r.userid=u.userid INNER JOIN mast_career_level as l on r.career_levelid=l.career_levelid INNER JOIN mast_status as s on r.statusid=s.statusid";
		$sf = "r.*, u.first_name, u.last_name, u.email, l.career_level, s.status";
		$cnd = "r.email = '".$email."' AND approval='yes'";

		$rs = $this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$recmd[] = $row;

		return $recmd;
	}

	function getProfileProgress($userid)
	{
		$meter = 0;
		$rs = $this->customqry("SELECT * FROM tbl_users_personal_info WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row['professional'])
			$meter += 2;
		if($row['accomplishments'])
			$meter += 2;
		if($row['organizations'])
			$meter += 2;

		if($row['bz_address'])
			$meter += 1;
		if($row['bz_city'])
			$meter += 1;
		if($row['bz_countryid'])
			$meter += 1;
		if($row['bz_state'])
			$meter += 1;
		if($row['bz_phone_number'])
			$meter += 2;
		if($row['bz_fax_number'])
			$meter += 2;
		if($row['bz_mobile_number'])
			$meter += 2;

		if($row['address'])
			$meter += 1;
		if($row['city'])
			$meter += 1;
		if($row['countryid'])
			$meter += 1;
		if($row['state'])
			$meter += 1;
		if($row['phone_number'])
			$meter += 2;
		if($row['fax_number'])
			$meter += 2;
		if($row['mobile_number'])
			$meter += 2;

		$rs = $this->customqry("SELECT * FROM tbl_users_references WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 4;

		$rs = $this->customqry("SELECT * FROM tbl_users_experience WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 20;

		$rs = $this->customqry("SELECT * FROM tbl_users_education WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 15;

		$rs = $this->customqry("SELECT * FROM tbl_users_extra_activity WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 5;

		$rs = $this->customqry("SELECT * FROM tbl_user_status WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 5;

		$rs = $this->customqry("SELECT * FROM tbl_users_award WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row)
			$meter += 5;
		
		$rs = $this->customqry("SELECT * FROM tbl_users WHERE userid=".$userid);
		$row = @mysql_fetch_assoc($rs);
		if($row['aboutme'])
			$meter += 5;
		if($row['thumbnail']!="default.gif")
			$meter += 5;
		if($this->getFriendsCount($userid) > 0)
			$meter += 10;

		return $meter;
	}

	function getSecondDegreeContactsId($userid)
	{
		$tbl  =  "tbl_users u, tbl_friends as f";
		$sf   =  "u.userid";
		$cnd  =  "((f.friendid = u.userid AND  f.userid=".$userid.") OR (f.userid = u.userid AND f.friendid=".$userid.")) AND (f.verification='yes')";
		$rs=$this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
		{
			$myfriends[] = $row['userid'];
		}
		if(is_array($myfriends))
		{
			$myfriends = array_unique($myfriends);
			$myfriends_list = implode(", ", $myfriends) . ", ". $userid;
			foreach($myfriends as $friendid)
			{
			$tbl1  =  "tbl_users u, tbl_friends as f";
				$sf1   =  "u.userid";
				$cnd1  =  "((f.friendid = u.userid AND  f.userid=".$friendid.") OR (f.userid = u.userid AND f.friendid=".$friendid.")) AND (f.verification='yes') AND u.userid not in ($myfriends_list)";
				$rs1=$this->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
				while($row1 = @mysql_fetch_assoc($rs1))
				{
					$contactids[] = $row1['userid'];
				}
				if(is_array($contactids))
					$contactids = array_unique($contactids);
					
			}
		}
		return $contactids;
	}

	function getThirdDegreeContactsId($userid)
	{
		$tbl  =  "tbl_users u, tbl_friends as f";
		$sf   =  "u.userid";
		$cnd  =  "((f.friendid = u.userid AND  f.userid=".$userid.") OR (f.userid = u.userid AND f.friendid=".$userid.")) AND (f.verification='yes')";
		$rs=$this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
		{
			$myfriends[] = $row['userid'];
		}
		if(is_array($myfriends))
		{
			$myfriends = array_unique($myfriends);
			$myfriends_list = implode(", ", $myfriends) . ", ". $userid;
			foreach($myfriends as $friendid)
			{
				$tbl1  =  "tbl_users u, tbl_friends as f";
				$sf1   =  "u.userid";
				$cnd1  =  "((f.friendid = u.userid AND  f.userid=".$friendid.") OR (f.userid = u.userid AND f.friendid=".$friendid.")) AND (f.verification='yes') AND u.userid not in ($myfriends_list)";
				$rs1=$this->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
				while($row1 = @mysql_fetch_assoc($rs1))
				{
					$contactids[] = $row1['userid'];
				}
				if(is_array($contactids))
				{
					$contactids = array_unique($contactids);
					foreach($contactids as $friendid)
					{
						$tbl1  =  "tbl_users u, tbl_friends as f";
						$sf1   =  "u.userid";
						$cnd1  =  "((f.friendid = u.userid AND  f.userid=".$friendid.") OR (f.userid = u.userid AND f.friendid=".$friendid.")) AND (f.verification='yes') AND u.userid not in ($myfriends_list)";
						$rs1=$this->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
						while($row1 = @mysql_fetch_assoc($rs1))
						{
							$new_contacts[] = $row1['userid'];
						}
						if(is_array($new_contacts))
							$new_contacts = array_unique($new_contacts);
					}
				}
			}
		}
		return $new_contacts;
	}

	function getMyGroups($userid, $limit='')
	{
		$tbl	= "tbl_group as g inner join tbl_group_members as m on g.group_id=m.group_id";
		$sf 	= "g.*, m.member_id, m.approve_date, (select count(member_id) from tbl_group_members as x where x.group_id=g.group_id) as members";
		$cnd 	= "g.admin_approval='yes' AND g.status='Active' AND m.status='Approved' and m.userid=$userid";
		$rs = $this->gj($tbl, $sf, $cnd, "m.approve_date", "", "DESC", $limit, "");
		while($row = @mysql_fetch_assoc($rs))
		{
			$groups[] = $row;
		}
		return $groups;
	}
}
?>