<?php
include_once("mail_func.php");
Class Profile extends DBTransact
{
	function fetchProfile($userid)
	{
		$tbl="tbl_users as u left join mast_city as m ON m.city_id=u.city left join mast_state as s ON s.id=u.state_id";
		$sf="u.*";
		$cd = "userid=".$userid;
		$result = $this ->gj($tbl,$sf,$cd,$ob,$gb,$ad,$l,"");
		$profileinfo=@mysql_fetch_assoc($result);
		$count=@mysql_num_rows($result);
		$ress = $this->cgs("tbl_profile_images", "*", array("userid","status"),  array($userid,'active'), "", "","");
		$row=@mysql_fetch_assoc($ress);
		$profileinfo['profimg']=$row['big_image'];

/*		echo "<pre>";
		print_r($profileinfo);exit;*/			


		//fetch login time
		$res = $this->cgs("tbl_login_log", "*", array("userid"),  array($userid), "", "","");
		$row=@mysql_fetch_assoc($res);
		$profileinfo['log']=$row['logout_date'];

		$restest = $this->cgs("tbl_profile_images", "*", array("userid"),  array($userid), "", "","");
		$rowcnt=@mysql_num_rows($restest);
		$profileinfo['rowcnt']=$rowcnt;


		$rest = $this->cgs("tbl_profile_images", "*", array("userid","status"),  array($userid,"active"), "", "","");
		$rowpic=@mysql_fetch_assoc($rest);
		
		$profileinfo['age']= $this->getage($profileinfo['bdate']);

		$today = strtotime(date("Y/m/d"));
		$myBirthDate = strtotime($profileinfo['bdate']);
		$profileinfo['YearAge']=round(($today-$myBirthDate)/(365.25*60*60*24));
		$profileinfo['friendsinfo']=$this->getuserfriends($userid);
		$profileinfo['cnt']=$this->getfriendscount($userid);
// 		$profileinfo['mess']=$this->getinboxcount($userid);
		return $profileinfo;

	}


	/*
	function getage($bdate)
	{
		if($bdate == '')
			return 0;
		else
			return floor((time() - strtotime($bdate))/31556926);

	}*/

function getuserfriends($userid)
{

   	$tblfriend = "tbl_friends as fd,tbl_users as u";
		$sffriend  = "u.userid,u.fullname,u.photo,u.username";
		$cndfriend  = "fd.userid='".$userid."' AND ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' ";
		$obfriend   = 'u.fullname';
		$getresult  = $this->gj($tblfriend, $sffriend , $cndfriend, $obfriend, "", "", "", ""); 
			$i=0;
			while($inmessage = @mysql_fetch_assoc($getresult))
			{
				 $friendsinfo[$i] = $inmessage;
                                 $friendsinfo[$i]['frndcnt']=$this->getfriendscount($inmessage['userid']);
				 $i++;
			}
	return $friendsinfo;
}

function getage($bdate)
{
                if($bdate == '')
		          return 0;
		else

		return floor((time() - strtotime($bdate))/31556926);

}
/*	function otherDetails($userid)
	{
		//fetch login time
		$res = $this->cgs("tbl_login_log", "*", array("userid"),  array($userid), "", "","");
		$row=@mysql_fetch_assoc($res);
		$other['log']=$row['logout_date'];

		$restest = $this->cgs("tbl_profile_images", "*", array("userid"),  array($userid), "", "","");
		$rowcnt=@mysql_num_rows($restest);
		$other['rowcnt']=$rowcnt;


		$rest = $this->cgs("tbl_profile_images", "*", array("userid","status"),  array($userid,"active"), "", "","");
		$rowpic=@mysql_fetch_assoc($rest);
		$other['image']=$rowpic['thumb_image'];

		return $other;
		
	}*/




	function getInformation($tbl,$cnd,$ob="order_id")
	{
		$rs=$this->gj($tbl,"*",$cnd,$ob,"","","","");
		if(is_resource($rs))
		{
		while($row=@mysql_fetch_array($rs))
			$res_row[]=$row;
		return $res_row;
		}
	}

	function fetchVideoById($videoid)
	{
		$res=$this->cgs("tbl_video","code,filename,thumbnail,video_type,video_id","video_id",$videoid,"","","");
		if(is_resource($res))
		$row=@mysql_fetch_assoc($res);
		return $row;
	}
	//check online here

	//fetch userid from username
	function fetchUserid($username)
	{
		$res=$this->cgs("tbl_users","userid","username",$username,"","",""); 
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
		return $row[0];
	}

	function fetchFirstName($userid)
	{
		$res=$this->cgs("tbl_users","first_name,last_name","userid",$userid,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
 			return $row[0];
	}

  //fetch username from userid
	function fetchUserName($userid)
	{
		$res=$this->cgs("tbl_users","fullname","userid",$userid,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
		return $row[0];
	}

     function getuserage($birthday)
      {
               list($year,$month,$day) = explode("-",$birthday);
               $year_diff  = date("Y") - $year;
               $month_diff = date("m") - $month;
               $day_diff   = date("d") - $day;
               if ($day_diff < 0 || $month_diff < 0)
                  $year_diff--;
               return $year_diff;
      }

	function getUserFriend($userid)
	{
		$tbl = "tbl_friends as fd,tbl_users as u";
		$sf  = "fd.req_send,fd.verification,fd.verification_date,u.fullname,u.userid, u.email,u.first_name,u.last_name,u.photo,fd.id";
		$cd  = "(fd.userid='".$userid."' or fd.friendid IN('".$userid."')) and ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' ";
		$ob  = 'u.fullname';
		$prn = '';
		$l   ="0,20";
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		$numrow	= @mysql_num_rows($result);

		if($numrow)
		{	
			$i=0;
			while($inmessage = @mysql_fetch_assoc($result))
			{
				$friends[$i] = $inmessage;
				$friends[$i]['cnt']=$numrow;
				$i++;
			}
		}
		return $friends;
	}
	function getnotVerifiedUser($userid)
	{
		$tbl = "tbl_friends as fd,tbl_users as u";
		$sf  = "fd.req_send,fd.verification,fd.verification_date,u.fullname,u.userid, u.email,u.first_name,u.last_name,u.photo,fd.id";
		$cd  = "(fd.userid='".$userid."' or fd.friendid IN('".$userid."')) and ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'no' ";
		$ob  = 'u.fullname';
		$prn = '';
		$l   ="0,20";
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		$numrow	= @mysql_num_rows($result);

		if($numrow)
		{	
			$i=0;
			while($inmessage = @mysql_fetch_assoc($result))
			{
				$friends[$i] = $inmessage;
				$friends[$i]['cnt']=$numrow;
				$i++;
			}
		}
		return $friends;
	}

	function getUserFriendId($userid)
	{
		$tbl = "tbl_friends as fd,tbl_users as u";
		$sf  = "u.userid";
		$cd  = "(fd.userid='".$userid."' or fd.friendid IN('".$userid."')) and ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' ";
		$ob  = 'u.fullname';
		$prn = '';
		//$l   ="0,20";
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		$numrow	= @mysql_num_rows($result);

		if($numrow)
		{
			$i=0;
			while($inmessage = @mysql_fetch_assoc($result))
			{
				$friends[] = $inmessage['userid'];
				$i++;
			}
		}
		return $friends;
	}


   function getFriendIdReq($userid)
   {
      $tbl = "tbl_friends as fd,tbl_users as u";
      $sf  = "u.userid";
      $cd  = "(fd.userid='".$userid."' or fd.friendid IN('".$userid."')) and ((u.userid=fd.friendid and u.userid!='".$userid."' ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'no'";
      $ob  = 'u.fullname';
      $prn = '';
      //$l   ="0,20";
      $result  = $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
      $numrow  = @mysql_num_rows($result);

      if($numrow)
      {
         $i=0;
         while($inmessage = @mysql_fetch_assoc($result))
         {
            $friends[] = $inmessage['userid'];
            $i++;
         }
      }
      return $friends;
   }
	
	function getfriendscount($user_id)
	{
	$userid = $user_id;

	$tbl = "tbl_friends as fd,tbl_users as u";
	$sf = "fd.verification_date,u.fullname,u.userid, u.email,u.first_name,u.last_name,fd.id";
	$cd = "(fd.userid=$userid or fd.friendid IN('$userid')) and ((u.userid=fd.friendid and u.userid!=".$userid." ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' ";
	$gb = 'fd.id';
	$prn	= '';
	$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
	$numrow	= @mysql_num_rows($result);

	return $numrow; 	
	}

	function getnfriendscount($user_id)
	{
		$user_id=$_SESSION['csUserId'];
	      	$tbluser = "tbl_friends as fd,tbl_users as u";
		$sfuser  = "fd.req_send,fd.friendid,fd.verification,fd.verification_date,u.fullname,u.userid, u.email,u.first_name,u.last_name,u.thumbnail,fd.id,u.username";
		$cnduser  = "(fd.userid='".$user_id."' or fd.friendid IN('".$user_id."')) and ((u.userid=fd.friendid and u.userid!='".$user_id."' ) or (u.userid=fd.userid and u.userid!='".$user_id."'  AND (fd.friendid!=fd.userid)) ) AND fd.verification = 'no' ";
		$obuser  = 'u.fullname';

		$resuser=$this->gj($tbluser,$sfuser,$cnduser,$obuser,"","","" ,""); 
		while($checkrow=@mysql_fetch_assoc($resuser))
		{
		
                if($checkrow['friendid']==$user_id)
		{
                   $userinfo[$t]=$checkrow;
                   $t++;
		}
		else
		{
		   
		}
		
		}

		$numrow=count($userinfo);
		return $numrow; 	
	}

	function getrequestcount($user_id)
	{
      $userid = $user_id;
		$tbl = "tbl_friends";
		$sf = "*";
		$cd = "friendid=".$_SESSION['csUserId']." and verification='no'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

		return $numrow;
	}
	
	function getmygroupscount($user_id)
	{
		$userid = $user_id;

		$tbl=" tbl_groups as g LEFT JOIN tbl_group_members as m ON g.group_id=m.group_id LEFT JOIN tbl_interest as i ON i.id=g.group_category_id";
		$sf="g.*,i.*,m.user_id";
		$cnd = "g.status='1' and (g.group_owner_id=".$userid." or m.user_id = ".$userid.")";
		$ob = "g.created_date";
		$order = "DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "group_id", $order, $l, "");

		$numrow=@mysql_num_rows($rs);
	//	echo $count;
				
		return $numrow;
	}


	function getphotoalbumcount($user_id)
	{
		//$userid = $user_id;

		$tbl = "tbl_albumphotos";
		$sf = "*";
		$cd = "user_id=".$user_id." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}
	function getalbumcount($user_id)
	{
		//$userid = $user_id;

		$tbl = "tbl_album";
		$sf = "*";
		$cd = "user_id=".$user_id." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}

	function getvideoalbumcount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_video";
		$sf = "*";
		$cd = "userid=".$userid." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}
//notes count
  	function getnotescount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_Notes";
		$sf = "*";
		$cd = "userid=".$userid;
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$notecount	= @mysql_num_rows($result);

				
		return $notecount;
	}

//notification count
// function getnotificationcount($user_id)
// {
//       $userid = $user_id;
//       $tbl = "tbl_comments";
//       $sf  = "*";
//       $cd  = "itemid =".$userid." and notify = '1' and itemid <> userid and moduleid in (17,18,19,20,21,22,23,24,25,26,27,28)";
//       $result2 = $this->gj($tbl,$sf,$cd,"","","","","");
//       $noticount  = @mysql_num_rows($result2);
//       return  $noticount;
// }



	function getblogcount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_blogs";
		$sf = "*";
		$cd = "userid=".$userid." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}

	function getpollcount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_polls";
		$sf = "*";
		$cd = "user_id=".$userid." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}


	function getsocialcount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_social";
		$sf = "*";
		$cd = "userid=".$userid;
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}


	function getsocialphotocount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_socialphotos";
		$sf = "*";
		$cd = "user_id=".$userid." and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}
	
/*
	function getinboxcount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_pmessages";
		$sf = "*";
		$cd = "touserid=".$userid." and msgfolder='0' and msgstat='u' and status='Active'";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$numrow	= @mysql_num_rows($result);

				
		return $numrow;
	}*/

	function getuserstatus($user_id)
	{
		$userid = $user_id;

		$check_online=$this->cgs("se_chat_users","chat_user_status","chat_user_id",$userid,"","","");
		$check_present=@mysql_num_rows($check_online);
		$get_status=@mysql_fetch_assoc($check_online);
		if($check_present == '0' || $check_present == '')
		{
			$numrow="offline";
		}
		elseif($check_present > 0 && $get_status['chat_user_status'] == '0')
		{
			$numrow="offline";
		}
		else
		{
			$numrow="online";
		}
				
		return $numrow;
	}

	function getawaitingrequest($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_friends";
		$sf = "verification";
		$cd = "(userid=".$_SESSION['csUserId']." and friendid =".$userid." and verification='no') or (userid=".$userid." and friendid =".$_SESSION['csUserId']." and verification='no')";
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$await	= @mysql_num_rows($result);

		if($await>0)
		{
			$await_req="yes";
		}
		else
		{
			$await_req="no";
		}
		return $await_req;
	}
	
	function getprogressbar($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_users";
		$sf = "*";
		$cd = "userid=".$userid;
		$result	= $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		$prog = @mysql_fetch_assoc($result);
		if($prog['interest']!='' || $prog['playlist']!='' || $prog['reading']!='' || $prog['films']!='' || $prog['food']!='' || $prog['drinks']!='' || $prog['sports']!='' || $prog['going']!='')
		{
			$progress='3';
		}
		elseif($prog['about_me']!='')
		{
			$progress='2';
		}
		else
		{
			$progress='1';
		}
		
		return $progress;
	}
	
	function getUserAvatar1($userid)
	{
		$tbl1 = "tbl_users as u";
		$sf1  = "u.thumbnail,u.gender";
		$cnd1 = "u.userid = $userid";
		$avt  = $this->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
		$avt_cnt = @mysql_num_rows($avt);
		$user_avatar = @mysql_fetch_assoc($avt);
		$siteroot = SITEROOT;

		if($user_avatar['thumbnail']!='')
		{
		     $image = "<img src='".$siteroot."/uploads/user_photo/189X148/".$user_avatar['thumbnail']."'   title='".$user_avatar['fullname']." Avatar'  />";
		}
		elseif($user_avatar['gender']=='Male')
		{
		     $image = "<img src='".$siteroot."/uploads/user_photo/189X148/noimage.jpeg' title='".$user_avatar['fullname']." Avatar'  />";
		}
		else
		{
			 $image = "<img src='".$siteroot."/uploads/user_photo/189X148/noimage.jpeg' title='".$user_avatar['fullname']." Avatar' />";
		}

		return $image;
	 }
	
	function getUserPhotoCnt($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_albumphotos as p";
		$sf = "p.*";
		$cd = "p.user_id=".$userid." and status ='Active'";
		$gb = " p.photo_id";
		$prn	= '';
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
		$numrow	= @mysql_num_rows($result);
		return $numrow; 
	}

	function getUserVideoCnt($user_id)
	{
		$userid = $user_id;
	
		$tbl = "tbl_video as v";
		$sf  = "v.*";
		$cd  = "v.userid=".$userid." and status ='Active'";
		$gb  = "";
		$prn = '';
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
		$numrow	= @mysql_num_rows($result);
		return $numrow; 	
	}
	
	function privacy_setting($sess_userid, $userid)
	{
		$ress = $this->cgs("tbl_privacy","*", "userid", $userid,"","","");
		$privacy = @mysql_fetch_assoc($ress);
		//print_r($privacy);
		if($privacy['profile_visibility'] == '1' || $sess_userid != "")
			return 'yes';
		else
		{
			$tbl = "tbl_friends as fd";
			$sf  = "fd.id";
			$cd  = "fd.verification = 'yes'  AND (fd.userid = '".$sess_userid."' AND fd.friendid ='".$userid."') OR (fd.friendid = '".$sess_userid."' AND fd.userid ='".$userid."') " ;
			$is_frnd = $this-> gj($tbl, $sf , $cd, "", "", "", "", "");
		
			if(is_resource($is_frnd))
			{
				return 'yes';
			}
			else	return 'no';
		}
	}

	function send_notification_mail($gr_id, $userid, $fullname, $activity, $msg)
	{
	//send mail to subscribed users
	$rs = $dbObj->gj("tbl_group_members m JOIN tbl_users u JOIN tbl_groups g",array("m.user_id, u.fullname, g.group_title"),"m.group_id ='".$gr_id."' AND m.user_id = u.userid AND m.group_id = g.group_id","","","","","");
	$member = array();
	while($res=@mysql_fetch_assoc($rs)) {
		$member[] = $res;
	}
	
	foreach($member as $k=>$v)
	{
		$note = $dbObj->cgs("tbl_notification", "*", "userid", $v['user_id'], "","", "");
		$notification_set = @mysql_fetch_assoc($note);
		
		if($notification_set['join_group'] == '1')
		{
			$rs_mast_emails=$dbObj->cgs("mast_emails","*","emailid",31,"","","");
			$sub_mesg=@mysql_fetch_assoc($rs_mast_emails);

			$rs_emails_sel=$dbObj->cgs("mast_emails_from","*","","","","","");
			$emailfrom=@mysql_fetch_assoc($rs_emails_sel);
			
		// 	$email_subject = str_replace("[eventname]", $eventname, $subject);
			$email_subject = $sub_mesg['subject'];
			$email_message = $sub_mesg['message'];
			$email_subject = str_replace("[[name]]",ucfirst($v['fullname']),$email_subject);
			// $email_message = file_get_contents(ABSPATH."/email/email.html");
			$email_message = str_replace("[[name]]",ucfirst($v['fullname']),$email_message);
			$email_message = str_replace("[[friend]]",ucfirst($fullname),$email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[activity]]",$activity, $email_message);
			$email_message = str_replace("[[groupname]]",$v['group_title'], $email_message);
			$email_message = str_replace("[[message]]",$msg, $email_message);
			$email_message = str_replace("[url]",$url, $email_message);
			//$email_subject = str_replace("[subject]",$subject, $email_subject);
			$from = $emailfrom['fromemail'];

			//echo $from."==>".$strsplit[$m]."==>".$email_subject."==>".$email_message; exit;
			
			@mail($strsplit[$m],$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
		}
	}
		return true;
	}


	function chkFriendStatus($userid)
	{
	        $check_friend=$this->customqry("select * from tbl_friends where (userid='".$userid."' and friendid='".$_SESSION["csUserId"]."') || (userid='".$_SESSION["csUserId"]."' and friendid='".$userid."') ","");
           
		     $cntcheck=@mysql_num_rows($check_friend);
		     if($cntcheck!="")
		     { 
			      $fetch_checkdetails=@mysql_fetch_assoc($check_friend);
			      if($fetch_checkdetails["verification"]=="yes")
			      {
			         //friends	
			         $friend_status['state']="0";
			      }
		            elseif($fetch_checkdetails["verification"]=="no")
			      {
			         //requested	
			         $friend_status['state']="1";
                     if($_SESSION["csUserId"] == $fetch_checkdetails['userid'])
                     {
                       $friend_status['flagp'] = "Send";
                      }
                     else
                     {
                        $friend_status['flagp'] = "Pending";
                     }
			      }	
			
		}
		return $friend_status;
	}


function fetchevents($userid)
{
  $currentdate=date("Y-m-d H:i:s");
  $tbl="tbl_event as e LEFT JOIN tbl_event_attend as att ON e.id=att.event_id";
  $sf="e.*";
	
	if($_GET['searchevent']!="")
	{
	$cnd .=" e.end_date !='".$currentdate."' AND e.end_date >'".$currentdate."' AND (e.title LIKE '%" .$_GET['searchevent']."%' )  AND e.userid!=".$userid."  AND e.userid!=1 AND att.user_attendee_id=".$userid;
	}
	else
	{
	$cnd="e.end_date !='".$currentdate."' AND e.end_date >'".$currentdate."' AND e.userid!=".$userid."  AND e.userid!=1 AND att.user_attendee_id=".$userid;
	}
	$ob  = 'e.id DESC';
	$gb="";
	$prn = '';
	$l   ="0,20";
		$result  = $this-> gj($tbl, $sf , $cnd, $ob, $gb, $ad, $l, "");
		$numrow  = @mysql_num_rows($result);
		
		if($numrow)
		{
			$i=0;
			while($row = @mysql_fetch_assoc($result))
			{
			$events[$i] =$row;
			$i++;
			}
		}
		return $events;

}
//recent search for event



function fetchrecentsearchevents($userid)
{
  $currentdate=date("Y-m-d H:i:s");
  $tbl="tbl_event as e , tbl_recenteventsearch as r ";
  $sf="e.*,r.recent_id,r.userid";
	
	if($_GET['searchevent']!="")
	{
	$cnd .=" e.end_date !='".$currentdate."' AND e.end_date >'".$currentdate."' AND (e.title LIKE '%" .$_GET['searchevent']."%' )  AND e.userid!=".$userid."  AND e.userid!=1  AND  r.userid=".$userid;
	}
	else
	{
	$cnd=" e.end_date !='".$currentdate."' AND e.end_date >'".$currentdate."' AND e.userid!=".$userid."  AND e.userid!=1  AND  r.userid=".$userid;
	}

	$ob  = ' r.recent_id DESC ';
	$gb=" e.id ";
	$prn = '';
	$l   ="0,20";
		$result  = $this-> gj($tbl, $sf , $cnd, $ob, $gb, $ad, $l, "");
		$numrow  = @mysql_num_rows($result);
		
		if($numrow)
		{
			$i=0;
			while($row = @mysql_fetch_assoc($result))
			{
			$events[$i] =$row;
			$i++;
			}
		}
		return $events;

}
//recent seacrch insert

function insertrecentsearch($eventtype,$eventcountry,$eventstate,$eventcity,$eventlocation,$eventzipcode)
{

	//check recent search
	$cnd="userid=".$_SESSION['csUserId']." AND status='1'";
	$resprevsearch=$this->gj("tbl_recenteventsearch","*",$cnd,"","","","","");
	$numcheck =@mysql_num_rows($resprevsearch);
	if($numcheck > 0)
	{

		while($rowcheck=@mysql_fetch_assoc($resprevsearch))
		{
			//update recent search
			
				//check for same search
				$cndcheck=" eventtype='".$eventtype."' AND eventcountry='".$eventcountry."' AND eventstate='".$eventstate."' AND eventcity='".$eventcity."' AND eventlocation='".$eventlocation."' AND eventzipcode='".$eventzipcode."'";

				$checkresprevsearch=$this->gj("tbl_recenteventsearch","*",$cndcheck,"","","","","");

				$checkresultprevsearch=@mysql_fetch_assoc($checkresprevsearch);

				$numresprevsearch =@mysql_num_rows($checkresprevsearch);
				if($numresprevsearch>0)
				{
				$num_view=$checkresultprevsearch['num_view']+1;
				$resinsertrecentsearchup=$this->cupdt("tbl_recenteventsearch","num_view",$num_view,array("userid","recent_id"),array($_SESSION['csUserId'],$checkresultprevsearch['recent_id']),"");
				}
				else
				{
					//add recent search
						
						$resinsertrecentsearch=$this->cgi("tbl_recenteventsearch",array("eventtype","eventcountry","eventstate","eventcity","eventlocation","eventzipcode","userid","date_added"),array($eventtype,$eventcountry,$eventstate,$eventcity,$eventlocation,$eventzipcode,$_SESSION['csUserId'],date("Y-m-d H:i:s")),"");
	
				}
			}//while
		
	}//num check
	else
	{
	//add recent search
		$resinsertrecentsearch=$this->cgi("tbl_recenteventsearch",array("eventtype","eventcountry","eventstate","eventcity","eventlocation","eventzipcode","userid","date_added"),array($eventtype,$eventcountry,$eventstate,$eventcity,$eventlocation,$eventzipcode,$_SESSION['csUserId'],date("Y-m-d H:i:s")),"");
	}
		
		
}
/***************** Rating Calculation for Photo and Video *************************************/

   function calculateRating($rating)
   {
      $rateval = @explode(".",$rating);
      for($i=0;$i<5;$i++)
         {
            if($i==0)
               $ratingstar[$p][$i]= "<img src=".SITEROOT."/templates/default/images/icons/star-yellow1.png id=img1 style= border:none;/>";
            else
               $ratingstar[$p][$i].= "<img src=".SITEROOT."/templates/default/images/icons/star-empty2.png id=img1 style= border:none;/>";
         }
         
         if($rateval[0] == '0' && $rateval[1] == '0')  
         {
            for($i=0;$i<5;$i++)
            {
               $ratingstar[$p][$i]= "<img src=".SITEROOT."/templates/default/images/icons/star-empty2.png id=img1 style= border:none;/>";
            }
         }
         elseif($rateval[0] >= '1')
         {
            for($i=0; $i<5 && $i<$rateval[0];$i++)
            {  
                 $ratingstar[$p][$i] = "<img src=".SITEROOT."/templates/default/images/icons/star-yellow1.png id=img1 style= border:none;/>";
            }
         }
         if($rateval[1] > 2 && $rateval[1] <= 5)
          {
              $ratingstar[$p][$i]= "<img src=".SITEROOT."/templates/default/images/icons/star-half-yellow1.png id=img1 style= border:none;/>";
          }
         elseif($rateval[1] > 5)
         {
             $ratingstar[$p][$i]= "<img src=".SITEROOT."/templates/default/images/icons/star-yellow1.png id=img1 style= border:none;/>";
         }
//           else
//           {
//             echo "==>".$i." ";
//              if($rateval[0]!=5)
//                     $ratingstar[$p][$i]= "<img src=".SITEROOT."/templates/default/images/icons/star_green.gif id=img1 style= border:none;/>";
//            }
         $result['ratingstar'] = $ratingstar[$p];
         return $result;
   }

//calculate rating for both photos and videos
   function calPhotoAlbumRating($albumid,$modid,$userid)
   {
      //calculate total rating for album
      if($modid == '1')
      {
            $qrypid = $this->cgs("tbl_albumphotos", "photo_id", array("album_id","user_id"), array($albumid,$userid), "", "", "");
            $i=0;
            while($fetchids=@mysql_fetch_array($qrypid))
            {
               $phtids[$i] = $fetchids['photo_id'];
               $i++;
            }
      }
      else
      {
            $qrypid = $this->cgs("tbl_video", "video_id", array("album_id","user_id"), array($albumid,$userid), "", "", "");
            $i=0;
            while($fetchids=@mysql_fetch_array($qrypid))
            {
               $phtids[$i] = $fetchids['video_id'];
               $i++;
            }
      }

         $arrpid = @implode(",",$phtids);
         if($arrpid=="")
               $arrpid = "0";

//          $tbl  = 'tbl_rating';
//          $sf   = 'sum(average_rating)/count(average_rating), count(average_rating)';
//          $cd   = "itemid in (".$arrpid.") and moduleid=".$modid;
//          $ob   = '';
//          $ad   = '';
//          $prn  = '';
//          $result  = $this -> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
//          $row=@mysql_fetch_array($result);
// 
//          $rating = number_format($row[0],'1','.','');
//          $albumrate['average_rating'] = $rating;
//          $albumrate['ratecnt'] =$row[1];
//          $rateval = @explode(".",$rating);
// 
//          $starRate = $this->calculateRating($rating);
//          $albumrate['ratingstar'] = $starRate['ratingstar'];
//          return $albumrate;
   }

   function calPrivacyRating($privacy,$modid,$userid)
   {
      if($modid =='1')
      {
            //fetch allpublic/private albums
            $qrypid = $this->cgs("tbl_album", "album_id", array("privacy","user_id"), array($privacy,$userid), "", "", "");
            $i=0;
            while($fetchids=@mysql_fetch_array($qrypid))
            {
               $albids[$i] = $fetchids['album_id'];
               $i++;
            }


            $arralb = @implode(",",$albids);
            if($arralb=="")
                  $arralb = "0";
   
            //fetch all video/photo ids from private or public albums
            $tbl  = 'tbl_albumphotos';
            $sf   = 'photo_id';
            $cd   = "album_id in (".$arralb.") and status = 'Active'";
            $result  = $this -> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l,  "");
            while($row=@mysql_fetch_array($result))
            {
               $phtids[] = $row['photo_id'];
            }
      }
      else
      {
            $qrypid = $this->cgs("tbl_video_album", "album_id", array("privacy"), array($privacy), "", "", ""); 
            $i=0;
            while($fetchids=@mysql_fetch_array($qrypid))
            {
               $vidid[$i] = $fetchids['album_id'];
               $i++;
            }

            $arrvid = @implode(",", $vidid);
            if($arrvid=="")
                  $arrvid = "0";
   
            $tbl  = 'tbl_video';
            $sf   = 'video_id';
            $cd   = "album_id =".$arrvid." and  userid=".$userid." and status = 'Active'";
            $result  = $this -> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, "");   //exit;
            while($row=@mysql_fetch_array($result))
            {
               $phtids[] = $row['video_id'];
            }
      }

//        print_r($phtids);
      //fetch all calculate ratning
        $itemCount = count($phtids);
        $arrpid = @implode(",",$phtids);
         if($arrpid=="")
               $arrpid = "0";

//          $tbl  = 'tbl_rating';
//          $sf   = 'sum(average_rating)/count(average_rating), count(average_rating)';
//          $cd   = "itemid in (".$arrpid.") and moduleid=".$modid;
//          $ob   = '';
//          $ad   = '';
//          $prn  = '';
//          $result  = $this -> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
//          $row=@mysql_fetch_array($result);
// 
//          $rating = number_format($row[0],'1','.','');
//          $albumrate['average_rating'] = $rating;
//          $albumrate['ratecnt'] =$row[1];
//          $rateval = @explode(".",$rating);
// 
//          $starRate = $this->calculateRating($rating);
//          $albumrate['ratingstar'] = $starRate['ratingstar'];
//          $albumrate['itemCount'] = $itemCount;
//          return $albumrate;
   }



	function suggestfriendsort($userid)
	{	
		//fetch activities
		$tblgetactvities="tbl_activities ";
		$sfgetactvities="activities_id,activities";
		$cndactvities="userid=".$userid;
		$resactvities=$this->gj($tblgetactvities,$sfgetactvities,$cndactvities,"","","","",""); 
		$a=0;
		while($getactvities=@mysql_fetch_assoc($resactvities))
		{
			$activitesarray[$a]=$getactvities;
			$a++;
		}
		
		//make 2 d array into single array
		for($v=0;$v<count($activitesarray);$v++)
		{
			$arractivities[$v]=$activitesarray[$v]['activities'];
		}
		
		//fetch user for interest
		$tblgetinterests="tbl_userinterest ";
		$sfgetinterests="userinterestid,interests";
		$cndinterests="userid=".$userid;
		$resinterests=$this->gj($tblgetinterests,$sfgetinterests,$cndinterests,"","","","","");
		$b=0;
		while($getinterests=@mysql_fetch_assoc($resinterests))
		{
			$interestsarray[$b]=$getinterests;
			$b++;
		}
		//make 2 d array into single array
		for($w=0;$w<count($interestsarray);$w++)
		{
			$arrinterests[$w]=$interestsarray[$w]['interests'];
		}
		
		//check req value whose friendship request already send

		$tblgetfriendreqsend="tbl_friends ";
		$sfgetfriendreqsend="friendid,verification";
		$cndfriendreqsend="userid=".$userid." AND verification='no'";
		$resfriendreqsend=$this->gj($tblgetfriendreqsend,$sfgetfriendreqsend,$cndfriendreqsend,"","","","","");
		$c=0;
		while($getfriendreqsend=@mysql_fetch_assoc($resfriendreqsend))
		{
			$friendreqsendarray[$c]=$getfriendreqsend;
			$c++;
		}
		//make 2 d array into single array
		for($q=0;$q<count($friendreqsendarray);$q++)
		{
			$arrfriendreqsend[$q]=$friendreqsendarray[$q]['friendid'];
		}


	       //check users of same company

		$tblgetcompany="tbl_work ";
		$sfgetcompany="userid,companyname";
		$cndcompany="userid=".$userid;
		$rescompany=$this->gj($tblgetcompany,$sfgetcompany,$cndcompany,"","","","","");
		$ci=0;
		while($getcompany=@mysql_fetch_assoc($rescompany))
		{
			$companyarray[$ci]=$getcompany;
			$ci++;
		}
		//make 2 d array into single array
		for($qc=0;$qc<count($companyarray);$qc++)
		{
			$arrcompany[$qc]=$companyarray[$qc]['companyname'];
		}

		//check users of same college

		$tblgetcollege="tbl_college ";
		$sfgetcollege="userid,collegename ";
		$cndcollege="userid=".$userid;
		$rescollege=$this->gj($tblgetcollege,$sfgetcollege,$cndcollege,"","","","","");
		$cj=0;
		while($getcollege=@mysql_fetch_assoc($rescollege))
		{
			$collegearray[$cj]=$getcollege;
			$cj++;
		}
		//make 2 d array into single array
		for($qj=0;$qj<count($collegearray);$qj++)
		{
			$arrcollege[$qj]=$collegearray[$qj]['collegename'];
		}

		//check users of same school

		$tblgetschool="tbl_school ";
		$sfgetschool="userid,schoolname ";
		$cndschool="userid=".$userid;
		$resschool=$this->gj($tblgetschool,$sfgetschool,$cndschool,"","","","","");
		$ck=0;
		while($getschool=@mysql_fetch_assoc($resschool))
		{
			$schoolarray[$ck]=$getschool;
			$ck++;
		}
		//make 2 d array into single array
		for($qk=0;$qk<count($schoolarray);$qk++)
		{
			$arrschool[$qk]=$schoolarray[$qk]['schoolname'];
		}

		//check users of common sports
		$tblgetfavsports="tbl_favsports ";
		$sfgetfavsports="userid,sportsname ";
		$cndfavsports="userid=".$userid;
		$resfavsports=$this->gj($tblgetfavsports,$sfgetfavsports,$cndfavsports,"","","","","");
		$cfs=0;
		while($getfavsports=@mysql_fetch_assoc($resfavsports))
		{
			$favsportsarray[$cfs]=$getfavsports;
			$cfs++;
		}
		//make 2 d array into single array
		for($qkf=0;$qkf<count($favsportsarray);$qkf++)
		{
			$arrfavsports[$qkf]=$favsportsarray[$qkf]['sportsname'];
		}


             	//check users of common teams

		$tblgetfavteam="tbl_favteam ";
		$sfgetfavteam="userid,teams ";
		$cndfavteam="userid=".$userid;
		$resfavteam=$this->gj($tblgetfavteam,$sfgetfavteam,$cndfavteam,"","","","","");
		$cft=0;
		while($getfavteam=@mysql_fetch_assoc($resfavteam))
		{
			$favteamarray[$cft]=$getfavteam;
			$cft++;
		}
		//make 2 d array into single array
		for($qkt=0;$qkt<count($favteamarray);$qkt++)
		{
			$arrfavteam[$qkt]=$favteamarray[$qkt]['teams'];
		}


		//check users of common athletes
		$tblgetfavathletes="tbl_favathletes ";
		$sfgetfavathletes="userid,athletes ";
		$cndfavathletes="userid=".$userid;
		$resfavathletes=$this->gj($tblgetfavathletes,$sfgetfavathletes,$cndfavathletes,"","","","","");
		$cfa=0;
		while($getfavathletes=@mysql_fetch_assoc($resfavathletes))
		{
			
			$favathletesarray[$cfa]=$getfavathletes;
			$cfa++;
		}
		//make 2 d array into single array
		for($qka=0;$qka<count($favathletesarray);$qka++)
		{
			$arrfavathletes[$qka]=$favathletesarray[$qka]['athletes'];
		}
// 		echo "<pre>";
// 		print_r($arrfavteam);
// 		exit;
		//fetch friends
		$friendlist= $this->getUserFriendId($userid);
		if(count($friendlist) >0)
		{
		      $friendliststr=implode(",",$friendlist);
		}

      $friendreqstr1= $this->getFriendIdReq($userid);
      if(count($friendreqstr1) >0)
      {
            $friendreqstr=implode(",",$friendreqstr1);
      }

      //Build a query here
		$tbl_getotheruserrecord=" tbl_users u LEFT JOIN tbl_activities as a ON u.userid=a.userid LEFT JOIN tbl_userinterest as ui ON u.userid=ui.userid LEFT JOIN tbl_friends as f ON u.userid=f.userid LEFT JOIN tbl_work as c ON u.userid=c.userid LEFT JOIN tbl_college as cc ON u.userid=cc.userid LEFT JOIN tbl_school as sc ON u.userid=sc.userid LEFT JOIN tbl_favsports as fvs ON u.userid=fvs.userid LEFT JOIN tbl_favteam as fvt ON u.userid=fvt.userid LEFT JOIN tbl_favathletes as fva ON u.userid=fva.userid";
		$sf_getotheruserrecord="u.userid,u.username,u.first_name,u.fullname,u.thumbnail";
      		$cnd_getotheruserrecord="u.userid !=".$userid." AND u.userid !='1' AND u.status !='inactive' AND isverified='yes' AND isDeleted='0'";

		$arrcntfriendreqsend = count($arrfriendreqsend);
		$arrcntcompany = count($arrcompany);
     		$arrcntcollege = count($arrcollege);
 		$arrcntschool = count($arrschool);
    		$arrcntfavsports = count($arrfavsports);
      		$arrcntfavteam = count($arrfavteam);
 		$arrcntfavathletes = count($arrfavathletes);
		$arrcntactivities = count($arractivities);
		$arrcntinterests= count($arrinterests);

      //       if($arrcntfriendreqsend>0 || $arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0 || $arrcntfavteam>0 || $arrcntfavathletes>0 || $arrcntactivities>0 || $arrcntinterests>0)
      //           $cnd_getotheruserrecord .= " OR 1";

		if($friendliststr!="")
			$cnd_getotheruserrecord.=" AND u.userid not in (".$friendliststr.")"; 
		
		if($friendreqstr!="")
			$cnd_getotheruserrecord.=" AND u.userid not in (".$friendreqstr.")"; 
		
		if(is_array($_SESSION['ses_friendid']))
		{
			$matchres = @implode(",",$_SESSION['ses_friendid']);
			if($matchres!="")
			$cnd_getotheruserrecord .= " AND u.userid not in (".$matchres.")";
		}

// 		//same company
// 		if($arrcntcompany>0)
// 		{
// 				for($k=0;$k<count($arrcompany);$k++)
// 				{
// 						if(is_array($arrcompany))
// 						{
//  							$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrcompany[$k]."',c.companyname)";	
// 		
// 						
// 							if($k==$arrcntcompany-1)
// 							   	$cnd_getotheruserrecord .= ")";
// 						}
// 				
// 				}
// 		}
// 
// 		//same college
// 		if($arrcntcollege>0)
// 		{
// 				for($kc=0;$kc<count($arrcollege);$kc++)
// 				{
// 					if(is_array($arrcollege))
// 					{
// 						if($kc == '0')
// 						{
// 							if($arrcntcompany>0)
// 							{
// 								$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrcollege[$kc]."',cc.collegename)";	
// 							}
// 							else
// 							{
// 								$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrcollege[$kc]."',cc.collegename)";
// 							}
// 						}
// 						else
// 							$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrcollege[$kc]."',cc.collegename)";
// 					
// 						if($kc==$arrcntcollege-1)
// 						   	$cnd_getotheruserrecord .= ")";
// 					}
// 				
// 				}
// 		}
// 
// 		//same school
// 		if($arrcntschool>0)
// 		{
// 				for($ks=0;$ks<count($arrschool);$ks++)
// 				{
// 						if(is_array($arrschool))
// 						{
// 							if($ks == '0')
//                      {
// 							   if($arrcntcompany>0 || $arrcntcollege>0)
// 							   {
// 								   $cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrschool[$ks]."',sc.schoolname)";
// 							   }
// 							   else
// 							   {
// 								   $cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrschool[$ks]."',sc.schoolname)";
// 							   }
//                      }
// 
// 							else
// 								$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrschool[$ks]."',sc.schoolname)";
// 						
// 							if($ks==$arrcntschool-1)
// 								   $cnd_getotheruserrecord .= ")";
// 						}
// 				
// 				}
// 		}
// 
// 		//common sports
// 		if($arrcntfavsports>0)
// 		{
// 				for($ksf=0;$ksf<count($arrfavsports);$ksf++)
// 				{
// 						if(is_array($arrfavsports))
// 						{
// 							if($ksf == '0'){
// 								if( $arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0)
// 								{
// 									$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrfavsports[$ksf]."',fvs.sportsname)";
// 								}
// 								else
// 								{
// 									$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrfavsports[$ksf]."',fvs.sportsname)";
// 								}
// 							}
// 							else
// 								$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrfavsports[$ksf]."',fvs.sportsname)";
// 						
// 							if($ksf==$arrcntfavsports-1)
// 							   	$cnd_getotheruserrecord .= ")";
// 						}
// 				
// 				}
// 		}
// 
// 		//common teams
// 		if($arrcntfavteam>0)
// 		{
// 		
// 				for($kst=0;$kst<count($arrfavteam);$kst++)
// 				{
// 						if(is_array($arrfavteam))
// 						{
// 							if($kst == '0')
// 							{
// 									if($arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0)
// 									{
// 										$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrfavteam[$kst]."',fvt.teams)";
// 									}
// 									else
// 									{
// 										$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrfavteam[$kst]."',fvt.teams)";
// 									}
// 							}
// 							else
// 								$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrfavteam[$kst]."',fvt.teams)";
// 						
// 							if($kst==$arrcntfavteam-1)
// 								   $cnd_getotheruserrecord .= ")";
// 						}
// 				
// 				}
// 
// 		}
// 		//common athletes
// 		if($arrcntfavathletes>0)
// 		{
// 		
// 				for($ksa=0;$ksa<count($arrfavathletes);$ksa++)
// 				{
// 						if(is_array($arrfavathletes))
// 						{
// 							if($ksa == '0')
// 							{
// 									if($arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0 || $arrcntfavteam>0)
// 									{
// 										$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrfavathletes[$ksa]."',fva.athletes)";
// 									}
// 									else
// 									{
// 										$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrfavathletes[$ksa]."',fva.athletes)";
// 									}
// 							}
// 							else
// 								$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrfavathletes[$ksa]."',fva.athletes)";
// 						
// 							if($ksa==$arrcntfavathletes-1)
// 							   	$cnd_getotheruserrecord .= ")";
// 						}
// 				
// 				}
// 		}
// 
// 		//common activites
// 		if($arrcntactivities>0)
// 		{
// 			for($t=0;$t<count($arractivities);$t++)
// 			{
// 					if(is_array($arractivities))
// 					{
// 						if($t == '0')
// 						{
// 								if( $arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0 || $arrcntfavteam>0 || $arrcntfavathletes>0)
// 								{
// 									$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arractivities[$t]."',a.activities)";
// 								}
// 								else
// 								{
// 									$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arractivities[$t]."',a.activities)";
// 								}
// 						}
// 						else
// 							$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arractivities[$t]."',a.activities)";
// 					
// 						if($t==$arrcntactivities-1)
// 						   	$cnd_getotheruserrecord .= ")";
// 					}
// 			  }
// 		}
// 		//common interest
// 		if($arrcntinterests>0)
// 		{
// 			for($s=0;$s<count($arrinterests);$s++)
// 			{
// 					if(is_array($arrinterests))
// 					{
// 						if($s == '0')
// 						{
// 								if($arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0 || $arrcntfavteam>0 || $arrcntfavathletes>0 || $arrcntactivities>0)
// 								{
// 									$cnd_getotheruserrecord .=" OR (FIND_IN_SET('".$arrinterests[$s]."',ui.interests)";
// 								}
// 								else
// 								{
// 									$cnd_getotheruserrecord .=" AND ((FIND_IN_SET('".$arrinterests[$s]."',ui.interests)";
// 								}
// 						}
// 						else
// 							$cnd_getotheruserrecord .=" OR FIND_IN_SET('".$arrinterests[$s]."',ui.interests)";
// 					
// 						if($s==$arrcntinterests-1)
// 						   	$cnd_getotheruserrecord .= ")";
// 					}
//    		  }
// 		}
//$arrcntfriendreqsend>0 ||
// 		if( $arrcntcompany>0 || $arrcntcollege>0 || $arrcntschool>0 || $arrcntfavsports>0 || $arrcntfavteam>0 || $arrcntfavathletes>0 || $arrcntactivities>0 || $arrcntinterests>0)
// 		{
// 			$cnd_getotheruserrecord .= ")";
// 		}
// 		else
// 		{
// 			$cnd_getotheruserrecord .="";
// 		}

		$res_getotheruserrecord=$this->gj($tbl_getotheruserrecord,$sf_getotheruserrecord,$cnd_getotheruserrecord,"","u.userid","","",""); 
		$row=0;
		while($getresult_getotheruserrecord=@mysql_fetch_assoc($res_getotheruserrecord))
		{
			$members[$row]=$getresult_getotheruserrecord;
			$row++;
		}
  		return $members;
	}
}
$profObj=new Profile();
?>