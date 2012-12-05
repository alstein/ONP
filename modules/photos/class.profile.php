<?php
include_once("mail_func.php");
Class Profile extends DBTransact
{
	function editProfile($user_id)
	{
		$quest = $this->gj("tbl_question","*","1","","","","","");//exit;
		if(is_resource($quest))
		{
			$h=0;
			while($arrque = mysql_fetch_assoc($quest))
			{
				$question[$h]=$arrque;
				$h++;
			}
		}
		
		extract($_POST);		
		$birth_date = $year."-".$month."-".$day;
		$date_added = date("Y-m-d H:i:s");
		$lang=@implode(",",$testid);		
		if($first_name || $last_name)
		{
			$fl = array("first_name","last_name","gender","birth_date ");
			$val = array($first_name,$last_name,$gender,$birth_date);
			$updt=$this->cupdt("users",$fl,$val,"userid",$user_id,"");

		}

		$fields = array(  "userid" , "height" , "weight" , "ethinicity" , "religion" , "haircolor" ,"eyecolor" , "smoke", "drink" , "service" , "city" , "hometown" , "language" , "education" , "occupation" , "music" , "book" , "tvshow" , "movie", "quatation" , "food" , "drinks" , "sports" , "other","aboutme" ,"date_added" );
 		$values =  array( $user_id , $height , $weight , $ethnicity , $religion, $hair , $eye, $smoke, $drink, $service , $city , $hometown , $lang , $edu , $occupation , $music , $book , $tvshow , $movie , $quotations , $food , $drinks , $sports , $other , $aboutme,$date_added );

		$sql = "Select userid from tbl_profile where userid = ".$user_id;
		$res=$this->customqry($sql,"");
		$row=@mysql_fetch_assoc($res);
		if(!$row)
		{
			//insert profile info 
			$insert = $this->cgi("tbl_profile",$fields,$values,"");
		}
		else
		{
			$updt=$this->cupdt("tbl_profile",$fields,$values,"userid",$user_id,"");
		}

		//insert update answers
			$cndn = "userid=".$user_id;
			$ans = $this->gj("tbl_answer","id",$cndn,"","","","","");
			if(is_resource($ans))
			{
                            $arrans = @mysql_fetch_assoc($ans);
			}

			if(is_array($arrans))	
			{		
				//update question answer
				for($i=1;$i<=count($question);$i++)
				{	
                                    $fields1 = array("answer");
                                    $values1 = array($_POST["question_".$i]);
                                    $updt1=$this->cupdt("tbl_answer",$fields1,$values1,array("userid","qust_id"),array($user_id,$_POST["qid_".$i]),"");
				}
			}
			else
			{
				//insert question answers
				for($i=1;$i<=count($question);$i++)
				{
                                    $fields2 = array("qust_id","answer","userid");
                                    $values2 = array($_POST["qid_".$i],$_POST["question_".$i],$user_id);
                                    $insert2 = $this->cgi("tbl_answer",$fields2,$values2,"");
				}
			}
	}

	function fetchProfile($userid)
	{
		$tbl="users u LEFT JOIN tbl_profile p ON u.userid = p.userid";
		$sf="p.*,u.userid,u.login_name,u.user_type,u.first_name,u.password,u.status,u.last_name,u.primary_email,u.birth_date,u.gender,u.thumbnail,u.profile_video,u.profilephoto,u.ablcover,u.verified_photo,u.icard_photo,u.id_verified,u.confirmEmail,u.credits";
		$cnd="u.userid=".$userid;
		$qry="SELECT ".$sf." FROM ".$tbl." WHERE ".$cnd;
		$res=$this->customqry($qry,"");
		$row=@mysql_fetch_assoc($res);
		$row['onlinestatus'] = $this->fetch_status($userid);
		$row['profile_video']=$this->fetchVideoById($row['profile_video']);
		
		$row['videocnt']=$this->getUserVideoCnt($userid);
		$row['photocnt']=$this->getUserPhotoCnt($userid);
		$row['frndcnt']=$this->getfriendscount($userid);
		$row['friend']=$this->getUserFriend($userid);
		//$row['pokes']=$this->getUserPoke($userid);
		$row['favorite']=$this->getUserFav($userid);
		$row['favcnt']=$this->getfavscount($userid);
		$row['favstatus']=$this->alreadyfav($_SESSION['csUserId'],$userid);
		$row['frndstatus']=$this->friendAwaited($_SESSION['csUserId'],$userid);
		return $row;
	}

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
		$res=$this->cgs("users","userid","login_name",$username,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
		return $row[0];
	}

	function fetchFirstName($userid)
	{
		$res=$this->cgs("users","first_name,last_name","userid",$userid,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
 			return $row[0];
	}
        
        function fetchUserTypeid($userid)
	{
		$res=$this->cgs("users","user_type","userid",$userid,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
		return $row[0];
	}
	//fetch username from userid
	function fetchUserName($userid)
	{
		$res=$this->cgs("users","login_name","userid",$userid,"","","");
		if(is_resource($res))
			$row=@mysql_fetch_row($res);
		return $row[0];
	}


	//check online here
	function fetch_status($userid)
	{
		$userid = $userid;
		$query = "";
		$status = "";
		$query = "SELECT * FROM online_users WHERE user_id = ".$userid."";
		$rec_status = @mysql_query($query);
		if (@mysql_num_rows($rec_status) > 0)
		{
			$resarr = @mysql_fetch_assoc($rec_status);
			$status = $resarr['onlinestatus'];
			$_SESSION['onlinestatus'] = $resarr['onlinestatus'];
		}
		return $status;
	}

	//end check online

	//set online status
		function set_status($userid,$stat)
		{
			if($stat == "offline")
				 $varstat = "online";	
			else
				 $varstat = "offline";	

			$fields = "onlinestatus ";
			$values = $varstat;
			$updt=$this->cupdt("online_users",$fields,$values,"user_id",$userid,"");
			$_SESSION['onlinestatus'] = $varstat;
		}
	//end set

	function getUserFriend($userid)
	{
		$tbl = "tbl_friends as fd,users as u";
		$sf  = "fd.verification_date,u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.thumbnail,fd.id";
		$cd  = "(fd.userid=$userid or fd.friendid IN('$userid')) and ((u.userid=fd.friendid and u.userid!=".$userid." ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' AND fd.del_status = 'no'";
		$gb  = 'fd.id';
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
				$i++;
			}
		}
		return $friends;
	}
	
	function getUserPoke($userid)
	{
		$tbl = "tbl_poke as pk LEFT JOIN users as u ON pk.userid = u.userid";
		$sf  = "pk.pokeuser,pk.userid,u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.thumbnail";
		$cd  = "pk.pokeuser =$userid";
		$l   ="0,20";
		$prn = '';
		$result	= $this-> gj($tbl, $sf , $cd, $ob, "", $ad, $l,$prn);
                while($fetchRec = @mysql_fetch_assoc($result))
                {
                        $pokes[] = $fetchRec;
                }
//                 echo "<pre>";
//                 print_r($pokes);exit;
            return $pokes;
        }

	function getUserFav($userid)
	{
		$tbl = "tbl_favorite as fd LEFT JOIN users as u on fd.favoriteid  = u.userid";
		$sf  = "u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.thumbnail,fd.id";
		$cd  = "fd.userid=".$userid;
		$gb  = 'fd.id';
		$prn = '';
		$l   ="0,12";
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		$numrow	= @mysql_num_rows($result);

		if($numrow)
		{	
			$i=0;
			while($inmessage = @mysql_fetch_assoc($result))
			{
				$favorite[$i] = $inmessage;
				$i++;
			}
		}
		return $favorite;
	}

	function getfavscount($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_favorite as fd LEFT JOIN users as u on fd.favoriteid  = u.userid";
		$sf  = "u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.thumbnail,fd.id";
		$cd  = "fd.userid=".$userid;
		$gb  = 'fd.id';
		$prn = '';
		$l   ="0,12";
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		$numrow	= @mysql_num_rows($result);

		return $numrow; 	
	}

	function getfriendscount($user_id)
	{
	$userid = $user_id;

	$tbl = "tbl_friends as fd,users as u";
	$sf = "fd.verification_date,u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,fd.id";
	$cd = "(fd.userid=$userid or fd.friendid IN('$userid')) and ((u.userid=fd.friendid and u.userid!=".$userid." ) or (u.userid=fd.userid and u.userid!='".$userid."') ) AND fd.verification = 'yes' AND fd.del_status = 'no'";
	$gb = 'fd.id';
	$prn	= '';
	$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
	$numrow	= @mysql_num_rows($result);

	return $numrow; 	
	}

	function getRequestCount($user_id)
	{
	
	$tbl = "tbl_friends as fd left join users as u on u.userid = fd.userid";
	$sf = "u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.user_type,fd.id";
	$cd = "(fd.friendid=".$user_id." AND fd.verification = 'no' AND fd.del_status = 'no')";
	$gb = '';
	$prn= '';
	$result	= $this-> gj($tbl, $sf , $cd, "", $gb, "", "", $prn);
	$numrow1= @mysql_num_rows($result);
	return $numrow1; 	
	}

	function getUserAvatar1($userid)
	{
		$tbl1 = "users as u";
		$sf1  = "u.thumbnail,u.gender";
		$cnd1 = "u.userid = $userid";
		$avt  = $this->gj($tbl1, $sf1, $cnd1, "", "", "", "", "");
		$avt_cnt = @mysql_num_rows($avt);
		$user_avatar = @mysql_fetch_assoc($avt);
		$siteroot = SITEROOT;

		if($user_avatar['thumbnail']!='')
		{
		     $image = "<img src='".$siteroot."/uploads/user_photo/189X148/".$user_avatar['thumbnail']."'   title='".$user_avatar['login_name']." Avatar'  />";
		}
		elseif($user_avatar['gender']=='Male')
		{
		     $image = "<img src='".$siteroot."/uploads/user_photo/189X148/noimage.jpeg' title='".$user_avatar['login_name']." Avatar'  />";
		}
		else
		{
			 $image = "<img src='".$siteroot."/uploads/user_photo/189X148/noimage.jpeg' title='".$user_avatar['login_name']." Avatar' />";
		}

		return $image;
	 }
	
	function getUserPhotoCnt($user_id)
	{
		$userid = $user_id;

		$tbl = "tbl_albumphotos as p";
		$sf = "p.*";
		$cd = "p.user_id=".$userid;
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
		$cd  = "v.userid=".$userid;
		$gb  = "";
		$prn = '';
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
		$numrow	= @mysql_num_rows($result);
		return $numrow; 	
	}


	function addFriends($userid,$arrpost)
	{
			$profile1 = $this->fetchProfile($userid); 

			//Insert request into friends DB and mail to requested user
			$today = date('Y-m-d H:i:s');
			$field=array("userid","friendid","req_message","request_date");
			$value=array($userid,$arrpost['friendid'],$arrpost['message'],$today);
			$this->cgi("tbl_friends",$field,$value,"");

			$comment =  " become friends with ";
			$f=array("moduleid","itemid","userid","comment","date_added");
			$v=array('14',$arrpost['friendid'],$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
			$id=$this->cgi("tbl_comments",$f,$v,"");

			//send mail to friend requisted 
			$rs = $this->cgs("mast_emails", "", array("emailid"), array(12), "", "", "");
			$mail = @mysql_fetch_assoc($rs);
			$var=$_SESSION["csEmail"];
			$msg=$arrpost['message'];
	
			$sitelink ="<a href=".SITEROOT."/friends/myrequests> Click here</a>";
			$mail['message'] = str_replace('[first_name]', $profile1['first_name'], $mail['message']);
			$mail['message'] = str_replace('[friendname]',$_SESSION['csUserName'] , $mail['message']);
			//$mail['message'] = str_replace('[comment]', "Comment Here :" , $mail['message']);
			$mail['message'] = str_replace('[message]', $msg , $mail['message']);
			$mail['message'] = str_replace('[link]',$sitelink, $mail['message']);
			
			$mail['subject'] = str_replace('[sitetitle]', SITETITLE, $mail['subject']);
		
			$mailmessage = nl2br($mail['message']);
			$mail['subject'] = nl2br($mail['subject']);
			
			#mail function
			$mail1 = new mailer();
			// mail function  format 
			$send = $mail1-> new_email($profile1['primary_email'] ,$profile1['primary_email'],$_SESSION["csEmail"], $_SESSION["csEmail"],$mailmessage,$mail['subject']);
		
		if($send)
		{
			$msg = "Friend request sent successfully.";
		}
		return $msg;
	}

	function friendAwaited($userid,$frnduserid)
	{
		$check_friend=$this->customqry("select * from `tbl_friends` where (userid='".$frnduserid."' and friendid='".$userid."') || (userid='".$userid."' and friendid='".$frnduserid."') ","");
		$cntcheck=@mysql_num_rows($check_friend);
		if($cntcheck!="")
		{
			$fetch_checkdetails=@mysql_fetch_assoc($check_friend);
			if($fetch_checkdetails["verification"]=="yes")
			{
				$friend_status="yes";
			}
			if($fetch_checkdetails["verification"]=="no")
			{
				$friend_status="waiting";
			}
		}
		else
		{
			$friend_status="notyetfriend";
		}
		return $friend_status;		
	
	}	

	function addFavorite($userid,$favid)
	{
			$profile1 = $this->fetchProfile($favid); 
			//Insert request into friends DB and mail to requested user
			$today = date('Y-m-d H:i:s');
			$field=array("userid","favoriteid","date_added");
			$value=array($userid,$favid,$today);
			$this->cgi("tbl_favorite",$field,$value,"");

			$comment =  " added favorite  ";
			$f=array("moduleid","itemid","userid","comment","date_added");
			$v=array('15',$arrpost['friendid'],$_SESSION['csUserId'],$comment,date("Y-m-d h:i:s"));
			$id=$this->cgi("tbl_comments",$f,$v,"");
	
			//send mail to friend requisted 
			$rs = $this->cgs("mast_emails", "", array("emailid"), array(14), "", "", "");
			$mail = @mysql_fetch_assoc($rs);
			$var=$_SESSION["csEmail"];
			$msg=$arrpost['message'];
	
			$sitelink ="<a href=".SITEROOT."/".$profile1['login_name']."/favorites> Click here</a>";
			$mail['message'] = str_replace('[first_name]', $profile1['first_name'], $mail['message']);
			$mail['message'] = str_replace('[friendname]',$_SESSION['csUserName'] , $mail['message']);
			//$mail['message'] = str_replace('[comment]', $msg , $mail['message']);
			$mail['message'] = str_replace('[link]',$sitelink, $mail['message']);
			
			$mail['subject'] = str_replace('[sitetitle]', SITETITLE, $mail['subject']);
		
			$mailmessage = nl2br($mail['message']);
			$mail['subject'] = nl2br($mail['subject']);
			
			//echo "==>".$mailmessage."==>".$mail['subject']."==>".$profile1['primary_email'];
			//exit; 
			
			#mail function
			$mail1 = new mailer();
			// mail function  format 
			$send = $mail1-> new_email($profile1['primary_email'] ,$profile1['primary_email'],$_SESSION["csEmail"], $_SESSION["csEmail"],$mailmessage,$mail['subject']);
		
			if($send)
			{
				$msg = "Favourite Added successfully.";
			}
			return $msg;
	}

	function fetchUserFav($getpage,$userid)
	{
		if(!isset($getpage))
		{
			$page =1;
		}
		else
		{
			$page=$getpage;
		}
		
		$adsperpage =20;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
	
		$tbl = "tbl_favorite as fd LEFT JOIN users as u on fd.favoriteid  = u.userid";
		$sf  = "u.login_name,u.userid, u.primary_email,u.first_name,u.last_name,u.thumbnail,fd.id";
		$cd  = "fd.userid=".$userid;
		$gb  = 'fd.id';
		$prn = '';
		$result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
		$nums	= @mysql_num_rows($result);
		
		$resultp= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn);
		if($nums)
		{	$i=0;
			while($inmessage = @mysql_fetch_assoc($resultp))
			{
				$contacts[$i] = $inmessage;
				$i++;
			}
		}

		$show =5;
		$total_pages = ceil($nums / $adsperpage);
		
		if($total_pages > 1)
		{
			//$showing   = !isset($_GET["id1"]) ? 1 : $id1;
			$showing   = $page;
			$firstlink = SITEROOT."/favorites/";
			$seperator = '?page=';
			$baselink  = $firstlink;
			$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		}
		$contact[0] = $contacts;
		$contact[1] = $pgnation;
		return($contact);		
	}

	
	function deleteFav($userid,$frndid)
	{
		$id=$this->customqry("delete from tbl_favorite where userid = ".$userid." and favoriteid = ".$frndid, "");
		$msg = "Favorites deleted sucessfully";
		return $msg;
	}

	function alreadyfav($userid,$frndid)
	{
		$check_friend=$this->customqry("select * from tbl_favorite where userid=".$userid." and favoriteid=".$frndid,"");
		$cntcheck=@mysql_num_rows($check_friend);
		if($cntcheck!="")
		{
			$fetch_checkdetails=@mysql_fetch_assoc($check_friend);
			if($fetch_checkdetails["status"]=="Active")
			{
				$fav_status="yes";
			}
			else
			{
				$fav_status="notyetfriend";
			}
			return $fav_status;		
		}	
	}
	
	function checkFriend($siteuserid,$userid)
	{
	       $tbl = "tbl_friends";
	       $sf = "*";
	       $cd = "(userid=$userid or friendid = $siteuserid) and (userid=$siteuserid and friendid=".$userid." ) AND verification = 'yes' AND del_status ='no'";
	       $gb = 'id';
	       $prn	= '';
	       $result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
	       $numrow	= @mysql_fetch_assoc($result); 
	       if($numrow != "")
	            return "yes";
	       else
	           return "no";        
	}
	
	function checkFav($siteuserid,$userid)
	{
	       $tbl = "tbl_favorite";
	       $sf = "*";
	       $cd = "(userid=$userid and favoriteid = $siteuserid)";
	       $gb = 'id';
	       $prn	= '';
	       $result	= $this-> gj($tbl, $sf , $cd, $ob, $gb, $ad, "", $prn);
	       $numrow	= @mysql_fetch_assoc($result); 
	       if($numrow != "")
	            return "yes";
	       else
	           return "no";        
	}
	
	#===For checking account balance======#
	function checkBal($userid)
	{
            $tbl = "users";
            $sf = "credits";
            $cd = "userid=".$userid;
            $prn	= '';
            $result	= $this->gj($tbl, $sf , $cd,"", "","", "", $prn);
            $sufBal	= @mysql_fetch_assoc($result);
            if($sufBal['credits'] !="0")
                return "yes";
            else
                return "no";
	}
	
	#===For deduct balance as donation======#
	function deductBalance($userid,$siteuserid,$dedamt)
	{
	    extract($_POST);
            $tbl = "users as u";
            $sf = "credits";
            $bal = $this->cgs($tbl,$sf,"userid",$userid,"","","");
            $credit = @mysql_fetch_assoc($bal);
            
            $Remcredit =$credit['credits']-$dedamt;
            
            #====Deduct balance from Guest===#
            $tbl1 = "users as u";
            $wf = "u.credits";
            $wv = $Remcredit;
            $Qury = $this->cupdt($tbl,$wf,$wv,"u.userid",$userid,"");
            
            #===Increase bal to host===#
            
            $tblh = "users as u";
            $sfh = "credits";
            $balh = $this->cgs($tblh,$sfh,"userid",$siteuserid,"","","");
            $credith = @mysql_fetch_assoc($balh);
            
            $Addcredit =$credith['credits']+$dedamt;
            $tblU = "users as u";
            $wfU = "u.credits";
            $wvU = $Addcredit;
            $Qury = $this->cupdt($tblU,$wfU,$wvU,"u.userid",$siteuserid,"");//exit;
            
            #====Deduct balance from Credits===#
            $tbl2 = "tbl_creadits as cr";
            $wf = "cr.credits";
            $wv = $Remcredit;
            $Qury = $this->cupdt($tbl2,$wf,$wv,"cr.guestid",$userid,"");
            
            #=====Increase Bal To Host=====#
            $tbl3 = "tbl_tip_donate";
            $fl = array("guestid","hostid","moduleid","creadits","date_addded","status");
            $vl = array($userid,$siteuserid,"2",$dedamt,date("Y-m-d H:i:s"),"pending");
            $insertDonation = $this->cgi($tbl3,$fl,$vl,"");
            
//             if($insertDonation)
//             {
//                     $msg = "Donation sent successfully.";
//                     echo $msg;exit;
//             }
            
//             return $msg;
        }
        
        #===For refund Donation=====#
        function refundDonation($userid,$siteuserid,$dedamt)
	{
	    extract($_POST);
            #====Deduct balance from host a/c===#
            $tbl = "users as u";
            $sf = "credits";
            $bal = $this->cgs($tbl,$sf,"userid",$siteuserid,"","","");
            $credit = @mysql_fetch_assoc($bal);
            $Remcredit =$credit['credits']-$dedamt;
            
            $tbl1 = "users as u";
            $wf = "u.credits";
            $wv = $Remcredit;
            $Qury = $this->cupdt($tbl,$wf,$wv,"u.userid",$siteuserid,"");
            
            #===Increase bal to guest a/c===#
            $tblh = "users as u";
            $sfh = "credits";
            $balh = $this->cgs($tblh,$sfh,"userid",$userid,"","","");
            $credith = @mysql_fetch_assoc($balh);
            
            $Addcredit =$credith['credits']+$dedamt;
            $tblU = "users as u";
            $wfU = "u.credits";
            $wvU = $Addcredit;
            $Qury = $this->cupdt($tblU,$wfU,$wvU,"u.userid",$userid,"");//exit;
        }
        
	function deductBalanceOnSms($userid,$dedamt)
	{
            $tbl = "users as u";
            $sf = "credits";
            $bal = $this->cgs($tbl,$sf,"userid",$userid,"","","");
            $credit = @mysql_fetch_assoc($bal);
            
            $Remcredit =$credit['credits']-$dedamt;	

	    #====Deduct balance from Guest===#
            $tbl1 = "users as u";
            $wf = "u.credits";
            $wv = $Remcredit;
            $Qury = $this->cupdt($tbl,$wf,$wv,"u.userid",$userid,"");

	    #====Deduct balance from Credits===#
            $tbl2 = "tbl_creadits as cr";
            $wf = "cr.credits";
            $wv = $Remcredit;
            $Qury = $this->cupdt($tbl2,$wf,$wv,"cr.guestid",$userid,"");	
	}

        #===For checking donation======#
        function isDonated($userid,$siteUser)
        {
            $timestamp = time();
            $curr =  date("Y-m-d H:i:s", $timestamp);
            $lastsun =  date("Y-m-d H:i:s", strtotime("last sunday", $timestamp));
            $nxtsun = date("Y-m-d H:i:s", strtotime("next sunday", $timestamp));
            $tblD = "tbl_tip_donate";
            $sfD = "date_addded";
            $cnd1 = "guestid =".$userid." and hostid = ".$siteUser." and date_addded BETWEEN '".$lastsun."' and '".$nxtsun."'";
            $rsnew=$this->gj($tblD,$sfD,$cnd1,"","","","","");//exit;
            if(is_resource($rsnew))
                return "yes";
            else
                return "no";
        }
        
        #===For checking donation status======#
        function CheckStatus($userid,$siteUser)
        {
            $timestamp = time();
            $curr =  date("Y-m-d H:i:s", $timestamp);
            $lastsun =  date("Y-m-d H:i:s", strtotime("last sunday", $timestamp));
            $nxtsun = date("Y-m-d H:i:s", strtotime("next sunday", $timestamp));
            $tblS = "tbl_tip_donate";
            $sfS = "status";
            $cndS = "guestid =".$userid." and hostid = ".$siteUser." and date_addded BETWEEN '".$lastsun."' and '".$nxtsun."'";
            $Chkres=$this->gj($tblS,$sfS,$cndS,"","","","","");//exit;
            $CheckStat = @mysql_fetch_assoc($Chkres);
            if($CheckStat['status']=="Active")
                return "active";
            else if($CheckStat['status']=="Pending")
                return "pending";
            else
                return "canceled";
        }

        function notify($userid,$siteUser)
	{
	    extract($_POST);
	    $tblN = "tbl_notification_setting";
            $sf = "*";
            $sqlNot = $this->cgs($tblN,$sf,"guestid",$userid,"","","");
            $Details = @mysql_fetch_assoc($sqlNot);
            	
            $fl = array("guestid","hostid","notification_type","notify_when","date_added");
            $vl = array($_SESSION['csUserId'],$siteUser,$Details['notification_by'],$Details['notify_when'],date("Y-m-d H:i:s"));
            
            
            $sql = "Select guestid,hostid from tbl_notification where guestid=$userid and hostid=$siteUser";
            $res=$this->customqry($sql,"");//exit;
            $row=@mysql_fetch_assoc($res);
            if(!$row)
	    {
                $insertNotify=$this->cgi("tbl_notification",$fl,$vl,"");//exit;
            }
            else
            {
                $updateNotify=$this->cupdt("tbl_notification",$fl,$vl,"guestid",$userid,"");
	    }
	}

	function notifyGuest($userid)
	{
	       $tbl = "tbl_notification as n LEFT JOIN tbl_notification_setting as ns ON n.guestid = ns.guestid";
	       $sf  = "n.guestid,n.hostid,ns.notification_by,ns.notify_when";
	       $cnd = "n.hostid=".$userid." and ns.notification_by LIKE '%email%' and (ns.notify_when LIKE '%1%' or ns.notify_when LIKE '%2%')";
	       $gb  = '';
	       $prn = '';
	       $result	= $this-> gj($tbl, $sf ,$cnd, $ob, $gb, $ad, "", $prn);
	       while($row = @mysql_fetch_assoc($result))	
	       {
 		        $gstList[] = $row;

			$profile1 = $this->fetchProfile($row['guestid']); 
			$rs = $this->cgs("mast_emails", "", array("emailid"), array(16), "", "", "");
			$mail = @mysql_fetch_assoc($rs);

			$mail['message'] = str_replace('[guestname]', $profile1['first_name'], $mail['message']);
			$mail['message'] = str_replace('[hostname]',$_SESSION['csUserName'] , $mail['message']);
			$mail['message'] = str_replace('[sitetitle]',SITETITLE, $mail['message']); 
			$mail['subject'] = str_replace('[sitetitle]', SITETITLE, $mail['subject']);
			$mailmessage = nl2br($mail['message']);
			$mail['subject'] = nl2br($mail['subject']);

			//echo "==>".$mailmessage."==>".$mail['subject']."==>".$profile1['primary_email'];
			//exit; 
			
			$mail1 = new mailer();
			$send = $mail1-> new_email($profile1['primary_email'] ,$profile1['primary_email'],$_SESSION["csEmail"], $_SESSION["csEmail"],$mailmessage,$mail['subject']);
		}
	}

	function notifyGuestOnPoke($userid)
	{
	       $tbl = "tbl_notification as n LEFT JOIN tbl_notification_setting as ns ON n.guestid = ns.guestid";
	       $sf  = "n.guestid,n.hostid,ns.notification_by,ns.notify_when";
	       $cnd = "n.hostid=".$userid." and ns.notification_by LIKE '%email%' and ns.notify_when LIKE '%4%'";
	       $gb  = '';
	       $prn = '';
	       $result	= $this-> gj($tbl, $sf ,$cnd, $ob, $gb, $ad, "", $prn);
	       while($row = @mysql_fetch_assoc($result))	
	       {
 		        $gstList[] = $row;

			$profile1 = $this->fetchProfile($row['guestid']); 
			$rs = $this->cgs("mast_emails", "", array("emailid"), array(18), "", "", "");
			$mail = @mysql_fetch_assoc($rs);

			$mail['message'] = str_replace('[guestname]', $profile1['first_name'], $mail['message']);
			$mail['message'] = str_replace('[hostname]',$_SESSION['csUserName'] , $mail['message']);
			$mail['message'] = str_replace('[sitetitle]',SITETITLE, $mail['message']); 
			$mail['subject'] = str_replace('[sitetitle]', SITETITLE, $mail['subject']);
			$mailmessage = nl2br($mail['message']);
			$mail['subject'] = nl2br($mail['subject']);

			$mail1 = new mailer();
			$send = $mail1-> new_email($profile1['primary_email'] ,$profile1['primary_email'],$_SESSION["csEmail"], $_SESSION["csEmail"],$mailmessage,$mail['subject']);
		}
	}

	function notifyGuestOnMessage($userid,$arrpost)
	{
       	       $arrUserid =  @array_unique($arrpost['userid']);
	       if(is_array($arrUserid))
		{
			$strUser = @implode(",",$arrUserid);
		}

	       $tbl = "tbl_notification as n LEFT JOIN tbl_notification_setting as ns ON n.guestid = ns.guestid";
	       $sf  = "n.guestid,n.hostid,ns.notification_by,ns.notify_when";
	       $cnd = "n.hostid=".$userid." and n.guestid in (".$strUser.") and ns.notification_by LIKE '%email%' and ns.notify_when LIKE '%3%'";
	       $gb  = '';
	       $prn = '';
	       $result = $this-> gj($tbl,$sf,$cnd,$ob,$gb,$ad, "",$prn);

	       while($row = @mysql_fetch_assoc($result))	
	       {
 		        $gstList[] = $row;

			$profile1 = $this->fetchProfile($row['guestid']); 
			$rs = $this->cgs("mast_emails","",array("emailid"),array(17),"","","");
			$mail = @mysql_fetch_assoc($rs);

			$mail['message'] = str_replace('[guestname]', $profile1['first_name'], $mail['message']);
			$mail['message'] = str_replace('[hostname]',$_SESSION['csUserName'] , $mail['message']);
			$mail['message'] = str_replace('[sitetitle]',SITETITLE, $mail['message']);
			$mail['subject'] = str_replace('[sitetitle]', SITETITLE, $mail['subject']);
			$mailmessage = nl2br($mail['message']);
			$mail['subject'] = nl2br($mail['subject']);

			$mail1 = new mailer();
			$send = $mail1-> new_email($profile1['primary_email'] ,$profile1['primary_email'],$_SESSION["csEmail"], $_SESSION["csEmail"],$mailmessage,$mail['subject']);
		}
	}

	function notifyGuestBySms($userid)
	{
	       $tbl = "tbl_notification as n LEFT JOIN tbl_notification_setting as ns ON n.guestid = ns.guestid";
	       $sf  = "n.guestid,n.hostid,ns.notification_by,ns.notify_when";
	       $cnd = "n.hostid=".$userid." and ns.notification_by LIKE '%sms%' and (ns.notify_when LIKE '%1%' or ns.notify_when LIKE '%2%')";
	       $gb  = '';
	       $prn = '';
	       $result	= $this-> gj($tbl, $sf ,$cnd, $ob, $gb, $ad, "", $prn);
	       while($row = @mysql_fetch_assoc($result))	
	       {
			
			$gstList[] = $row;
			$nameG = $this->fetchFirstName($row['guestid']);
			$nameH = $this->fetchFirstName($row['hostid']);
			//$message = "Hey ".ucfirst($nameG['first_name']).", Please check host ".ucfirst($nameH['first_name'])." come online.";
			$message = "Message";
		//	print_r($message);exit;
			include("sms.class.php");
			$cls = new sms("georgeloke", "flashkit2", "3289900");
			$result = $cls->send("919860162692", $message);
			if($result)
				$this->deductBalanceOnSms($row['guestid'],'0.10');
	       }
	}

	function notifyGuestOnMessageSms($userid,$arrpost)
	{
       	       $arrUserid =  @array_unique($arrpost['userid']);
	       if(is_array($arrUserid))
	       {
			$strUser = @implode(",",$arrUserid);
	       }

	       $tbl = "tbl_notification as n LEFT JOIN tbl_notification_setting as ns ON n.guestid = ns.guestid";
	       $sf  = "n.guestid,n.hostid,ns.notification_by,ns.notify_when";
	       $cnd = "n.hostid=".$userid." and n.guestid in (".$strUser.") and ns.notification_by LIKE '%sms%' and ns.notify_when LIKE '%3%'";
	       $gb  = '';
	       $prn = '';
	       $result = $this-> gj($tbl,$sf,$cnd,$ob,$gb,$ad, "",$prn);

	       while($row = @mysql_fetch_assoc($result))	
	       {
 		        $gstList[] = $row;
			$nameG = $this->fetchFirstName($row['guestid']);
			$nameH = $this->fetchFirstName($row['hostid']);
			//$message = "Hey ".ucfirst($nameG['first_name']).", Please check your inbox host ".ucfirst($nameH['first_name'])." just sent you a message.";
			$message = "Message";
			include("sms.class.php");
			$cls = new sms("georgeloke", "flashkit2", "3289900");
			$result = $cls->send("919860162692",$message);
			if($result)
				$this->deductBalanceOnSms($row['guestid'],'0.10');
			
		}
	}

        function calculateRank()
        {
            $timestamp = time();
            $currentFullYear     = date("Y");
	    $currentMonthNumeric = date("m");
            $firstDayOfTheMonth  = date('Y-m-d',mktime(0,0,0,$currentMonthNumeric,1,$currentFullYear));
	    $lastDayOfTheMonth   = date('Y-m-d',mktime(0,0,0,$currentMonthNumeric + 1,0,$currentFullYear));
            $tblD = "users as u LEFT JOIN tbl_tip_donate as td on td.hostid =u.userid";
            $sfD = "u.first_name,u.last_name,u.userid,sum(creadits) as earn";
            $cnd1 = "date_addded BETWEEN '".$firstDayOfTheMonth."' and '".$lastDayOfTheMonth."'";
            $rsnew=$this->gj($tblD,$sfD,$cnd1,"earn","hostid","DESC","","");// exit;
	    $i=0;	
	    while($result= @mysql_fetch_assoc($rsnew))
	    {
		$res[$i] = $result;
		$res[$i]['rank'] = $i+1;
		$opt[$i]['var']=$this->calculatePoints($result['userid']);
		$res[$i]['level'] = $opt[$i]['var']['level'];
		$i++;
	    }
	return $res;
        }

	function calculatePoints($userid)
        {
	    $tblD = "users u LEFT JOIN tbl_tip_donate t ON t.hostid = u.userid";
            $sfD = "sum(creadits) as earn";
            $cnd1 = "t.hostid =".$userid;
            $rsnew=$this->gj($tblD,$sfD,$cnd1,"earn","hostid","DESC","","");	//exit;
	    $result= @mysql_fetch_assoc($rsnew);

	    //Calculate points
	    $points['points'] = $result['earn']/10;	

	   //fetch all records from  mast_points_feesdeduction
	   $res=$this->cgs("mast_points_feesdeduction","*","","","","",""); //exit;
	   while($test = @mysql_fetch_assoc($res))
	   {	
      	   	$table[]=$test;
	   }
	    //determine level
	    for($i=0; $i<=count($table); $i++)
	    {
		if(($points['points'] >= $table[$i]['cummuliatve_points']) && ($points['points'] <= $table[$i+1]['cummuliatve_points']))	
		{
			$points['level'] = $table[$i]['level'];
			$points['fees_percent'] = $table[$i]['fees_percent'];
		}	
		if($points['level']=="")
		{
			if($points['points']<=0)
			{
				$points['level'] =0;
				$points['fees_percent'] =35;
			}
			if($points['points'] >= 22000)
			{
				 $points['level'] = "PLATINUM";
				 $points['fees_percent'] = 20;
			}
		}
	   }
		return $points;
	}
}
$profObj=new Profile();
?>