<?php
/**
 *
 * Forum Class file.
 *
 * This file is intended to be used to get Forum information.
 * It defines Forum class by extending Functions, a class providing globally
 * available functionalities needed in newframework.
 *
 * By using this file, newframework can view Forums.
 * The action demanded in the request resembles the name of the handler or method in the class.
 *
 * @author Yogesh Kadam <k.yogesh@cssaglobal.com>
 * @link http://yogeshk/newframework/
 *
 * Version history:
 * 1.0
 *  Created By: Yogesh Kadam
 *  Created Date: 04 Dec 2008
 */

/**
 * Define DocBlock
 */

/**
 * Name: Forum
 *
 * Description: This class extends Functions of the framework and implements the view method.
 * This class gets the list of Forums
 * @access public
 * @package Controllers
 */
class Forum extends DBTransact
{
	
	function getCategories($admin=false)
	{
		$cnd = "c.moduleid=3";
		if($admin==false)
			$cnd .= " AND c.status='Active'";

		if($_SESSION['csUserTypeId']!=3){
			$cnd .= " AND c.user_type!=3";
		}

		$sf="c.*,(select count(*) from tbl_forum as f where f.categoryid=c.categoryid) as forums";
		$rs = $this->gj("tbl_category as c", $sf, $cnd, "c.sizeorder", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$categories[] = $row;
			
		return $categories;
	}
            function getCategoriesByAdmin($admin=false)
        {
            $cnd = "c.moduleid=3";
            if($admin==false)
                    $cnd .= " AND c.status='Active'";
            

            $sf="c.*,(select count(*) from tbl_forum as f where f.categoryid=c.categoryid) as forums";
            $rs = $this->gj("tbl_category as c", $sf, $cnd, "c.sizeorder", "", "", "", "");
            while($row = @mysql_fetch_assoc($rs))
                    $categories[] = $row;
            return $categories;
        }
 

	function getSellerCategories($admin=false)
	{
		$cnd = "c.moduleid=3";
		if($admin==false)
			$cnd .= " AND c.status='Active' AND c.user_type=3";

		$sf="c.*,(select count(*) from tbl_forum as f where f.categoryid=c.categoryid) as forums";
		$rs = $this->gj("tbl_category as c", $sf, $cnd, "", "", "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$categories[] = $row;
		return $categories;
	}
	
	function getCategory($categoryid)
	{
		$rs = $this->gj("tbl_category as c", "", "c.moduleid=3 AND c.categoryid=".$categoryid, "", "", "", "", "");
		$category = @mysql_fetch_assoc($rs);
		return $category;
	}
	
	function getSetting($settingid="")
	{
		//echo $settingid;
		if($settingid)
			$cnd = "id=".$settingid;
		else
			$cnd = "1";
			
		$rs = $this->gj('tbl_forum_setting' ,"", $cnd, "" , "" , "", "", "");
		while($row = @mysql_fetch_assoc($rs))
			$temp[] = $row;
		return $temp;
	}
	
	#  Getting Forum List Along with Pagination
	#  Variables
	#		$search		= 	Used to search forum by keyword
	#		$categoryid	=	User to get forums by 'categoryid'.
	function getForums($uname,$search='', $categoryid='', $admin)
	{

		$tbl="tbl_forum f INNER JOIN tbl_category c ON f.categoryid = c.categoryid INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";

		$sf="f.*,u.username, uc.country,c.category, (select count(*) from tbl_forum_thread as t where t.forumid=f.forumid) as threads, (select count(*) from tbl_forum_reply as r, tbl_forum_thread as t where t.forumid=f.forumid AND r.threadid=t.threadid) as replys, (select replyid from tbl_forum_reply as r where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as replyid, (select reply from tbl_forum_reply as r where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as lastreply, (select max(x.posted_date) from tbl_forum_thread as x where x.forumid = f.forumid) as lastpostedon, (select username from tbl_users as u LEFT JOIN tbl_forum_reply as r ON u.userid=r.userid where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as lastrepname";

		$cnd = "f.group_id = 0 ";

                if($search !="")
		      $cnd .= " and (f.title LIKE '%" . $search ."%' OR f.description LIKE '%" . $search ."%')";
		
                if($uname != '')
                {
		      $cnd1 = "username  = '{$uname}'";
		      $tbl1= "tbl_users";
		      $sf1="userid";
		      $rs_userid = $this->gj($tbl1,$sf1,$cnd1, "", "", "", "", "");
		      if( $rs_userid !='n')
			  $rs_name = @mysql_fetch_assoc($rs_userid);      
		          $cnd .= " and f.userid= {$rs_name['userid']}";
                }

		if($categoryid)
			$cnd .= " AND f.categoryid=".$categoryid;
		if($admin == false)
			$cnd .= " AND f.status='Active'";
			
		$ob = "f.posted_date DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
                $i=0;
		while($row=@mysql_fetch_assoc($rs))
                {
                    if( ( ($row['deal_id'] != 0) && ($row['threads']>0) ) || ($row['deal_id']==0) )
                    {
                        $forums[]=$row;
                        $l_frm=1;
                        $rs_frm = $this->gj("tbl_forum_thread", "userid,posted_date,title","forumid=".$row['forumid'],"posted_date DESC", "", "",$l_frm, "");
                        $frm=@mysql_fetch_assoc($rs_frm);
        
                        $userinfo= $this->cgs("tbl_users","*","userid",$frm['userid'],"","","");
                        $user=@mysql_fetch_assoc($userinfo);
                        $username=$user['first_name']." ".$user['last_name'];
                        $forums[$i]['thread_uname']=$username;
                        $forums[$i]['thread_date']=$frm['posted_date'];
                        $forums[$i]['thread_title']=$frm['title'];
                        $i++;
                    }  	
                }
		//echo "<pre>";print_r($forums);exit;		
		return $forums;
	}
  function getForumsByAdmin($uname,$search='', $categoryid='', $admin)
	{
	/*old query start
	$tbl="tbl_forum f INNER JOIN tbl_category c ON f.categoryid = c.categoryid INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";

		$sf="f.*,u.username, uc.country,c.category, (select count(*) from tbl_forum_thread as t where t.forumid=f.forumid) as threads, (select count(*) from tbl_forum_reply as r, tbl_forum_thread as t where t.forumid=f.forumid AND r.threadid=t.threadid) as replys, (select replyid from tbl_forum_reply as r where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as replyid, (select reply from tbl_forum_reply as r where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as lastreply, (select max(x.posted_date) from tbl_forum_thread as x where x.forumid = f.forumid) as lastpostedon, (select username from tbl_users as u LEFT JOIN tbl_forum_reply as r ON u.userid=r.userid where r.forumid = f.forumid ORDER BY replyid DESC limit 1) as lastrepname";

		$cnd = "f.group_id = 0 ";
	
	old query end*/

		$tbl="tbl_forum f INNER JOIN tbl_category c ON f.categoryid = c.categoryid INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";

		$sf="f.*,u.username, uc.country,c.category, (select count(*) from tbl_forum_thread as t where t.forumid=f.forumid) as threads";

		$cnd = "f.group_id = 0 ";

                if($search !="")
		      $cnd .= " and (f.title LIKE '%" . $search ."%' OR f.description LIKE '%" . $search ."%')";
		
                if($uname != '')
                {
		      $cnd1 = "username  = '{$uname}'";
		      $tbl1= "tbl_users";
		      $sf1="userid";
		      $rs_userid = $this->gj($tbl1,$sf1,$cnd1, "", "", "", "", "");
		      if( $rs_userid !='n')
			  $rs_name = @mysql_fetch_assoc($rs_userid); 
		      $cnd .= " and f.userid= {$rs_name['userid']}";
                }

		if($categoryid)
			$cnd .= " AND f.categoryid=".$categoryid;
		if($admin == false)
			$cnd .= " AND f.status='Active'";
			
		$ob = "f.posted_date DESC";
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
                $i=0;
		while($row=@mysql_fetch_assoc($rs))
                {		
                    $forums[]=$row;
                    $l_frm=1;
                    $rs_frm = $this->gj("tbl_forum_thread", "userid,posted_date,title","forumid=".$row['forumid'],"posted_date DESC", "", "",$l_frm, "");
                    $frm=@mysql_fetch_assoc($rs_frm);    
                    $userinfo= $this->cgs("tbl_users","*","userid",$frm['userid'],"","","");
                    $user=@mysql_fetch_assoc($userinfo);
                    $username=$user['first_name']." ".$user['last_name'];
                    $forums[$i]['thread_uname']=$username;
                    $forums[$i]['thread_date']=$frm['posted_date'];
                    $forums[$i]['thread_title']=$frm['title']; 
                    $i++;
                	
                }
		//echo "<pre>";print_r($forums);exit;		
		return $forums;
	}
	#  Getting Forum Information
	#  Variables
	#  $forumid	=	Used to forum by supplied id
	function getForumTopic($forumid)
	{
	// 		$tbl="tbl_forum f INNER JOIN tbl_category c ON f.categoryid = c.categoryid INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
	/*old query start================
	$tbl="tbl_forum f INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf="f.*, u.first_name, u.last_name, uc.country,
  		(select count(*) from tbl_forum_thread as t where t.forumid=f.forumid) as threads, (select count(*) from tbl_forum_reply as r, tbl_forum_thread as t where t.forumid=f.forumid AND r.threadid=t.threadid) as replys, (select max(x.posted_date) from tbl_forum_thread as x where x.forumid = f.forumid) as lastpostedon";
		$cnd = "f.forumid=".$forumid;
	======================old query end*/
		$tbl="tbl_forum f INNER JOIN tbl_users u ON f.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf="f.*, u.first_name, u.last_name, uc.country,
  		(select count(*) from tbl_forum_thread as t where t.forumid=f.forumid) as threads, (select max(x.posted_date) from tbl_forum_thread as x where x.forumid = f.forumid) as lastpostedon";
		$cnd = "f.forumid=".$forumid;
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
		$forum=@mysql_fetch_assoc($rs);
		return $forum;
	}
	
	#  Getting Thread List Along with Pagination
	#  Variables
	#		$file		=	Used to get currently running script. e.g. myforum.php
	#		$getpage 	=	Used to get page number in pagination
	#		$search		= 	Used to search thread by keyword
	#		$forumid	=	Getting Parent Forum details
	
	function clean_url($text)
        {
            $text=strtolower($text);
            $code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
            $code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
            $text = str_replace($code_entities_match, $code_entities_replace, $text);
            return $text;
        } 
	
	function getThreads($search='', $forumid='')
	{
	       
	/*old query=========
	 $tbl = "tbl_forum_thread t INNER JOIN tbl_users u ON t.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf = "t.*, u.first_name, u.last_name, uc.country, (select count(*) from tbl_forum_reply r where r.threadid=t.threadid) as replies";
		$cnd = "(t.title LIKE '%" . $search ."%' OR t.description LIKE '%" . $search ."%') AND t.forumid=". $forumid;
		
		$ob = "t.posted_date DESC";
	 
	===========end */
		$tbl = "tbl_forum_thread t INNER JOIN tbl_users u ON t.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf = "t.*, u.first_name, u.last_name, uc.country";
		$cnd = "(t.title LIKE '%" . $search ."%' OR t.description LIKE '%" . $search ."%') AND t.forumid=". $forumid;
		
		$ob = "t.posted_date DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");
		while($row=@mysql_fetch_assoc($rs))
			$threads[]=$row;		
		return $threads;
	}

		function getAdminThreads($file='', $getpage='',$search='', $forumid='', $forums_per_page, $admin)
	       {
		//echo $forums_per_page;
		//exit;
		#------------Pagination Part-1------------
		
			if(!isset($getpage))
				$page =1;
			else
				$page = $getpage;						
			$adsperpage = $forums_per_page;							
			$StartRow = $adsperpage * ($page-1);			
			$l =  $StartRow.','.$adsperpage;
		
		#-----------------------------------
                /*old query start==========
                $tbl = "tbl_forum_thread t INNER JOIN tbl_users u ON t.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf = "t.*,u.first_name, u.last_name,u.pic_image,u.username,uc.country, (select count(*) from tbl_forum_reply r where r.threadid=t.threadid) as replies";
		$cnd = "(t.title LIKE '%" . $search ."%' OR t.description LIKE '%" . $search ."%') AND t.forumid=". $forumid."";
		
		$ob = "t.posted_date DESC";
                ===============old query end*/
                
		$tbl = "tbl_forum_thread t INNER JOIN tbl_users u ON t.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf = "t.*,u.first_name, u.last_name,u.pic_image,u.username,uc.country";
		$cnd = "(t.title LIKE '%" . $search ."%' OR t.description LIKE '%" . $search ."%') AND t.forumid=". $forumid."";
		
		$ob = "t.posted_date DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");
		$i=0;
		while($row=@mysql_fetch_assoc($rs))
		{
			$threads[]=$row;				
// 			if($threads[$i]['threadid'])
// 			{
// 				$repthrcnd = "r.threadid = '".$threads[$i]['threadid']."'";
// 				$repthr = $this->gj("tbl_forum_reply as r LEFT JOIN tbl_users as u ON r.userid = u.userid","u.first_name,u.last_name,r.*",$repthrcnd,"","threadid","DESC","0,1","");
// 
// 				if($repthr!='')
// 				{
// 				$repthrres = @mysql_fetch_assoc($repthr);				
// 				$threads[$i]['last_first_name']=$repthrres['first_name'];
// 				$threads[$i]['last_last_name']=$repthrres['last_name'];
// 				$threads[$i]['reply']=$repthrres['reply'];
// 				$threads[$i]['last_posted_date']=$repthrres['posted_date'];
// 				}
//                                 $user_cd = "u.userid ='".$threads[$i]['userid']."'";
// 				$user_array = $this->gj("tbl_users as u","u.first_name,u.last_name",$user_cd,"","","","","");
// 
//                                 if($user_array!='')
// 				{
// 				$user_detail = @mysql_fetch_assoc($user_array);				
// 				$threads[$i]['user_first_name']=$user_detail['first_name'];
// 				$threads[$i]['user_last_name']=$user_detail['last_name'];
// 				}
// 			}
		$i++;
		}
		
		$threadArray['threads']=$threads;	

		/*----------Pagination Part-2--------------*/
		$rs = $this->gj($tbl,"", $cnd, "", "", "", "", "");
		$nums = @mysql_num_rows($rs);
		$show = 5;		
		 $total_pages = ceil($nums / $adsperpage);
		
		if($total_pages > 1)
			 $threadArray['showpaging']='yes';		
		 $showing   = !($getpage)? 1 : $getpage;
		
		if($admin != 1)
			$firstlink = SITEROOT."/forum/".$file."/?forumid=".$forumid."";
		else
			$firstlink = SITEROOT."/admin/modules/forum/".$file."?forumid=".$forumid."";
		
		/*if($admin != 1)
			$seperator = 'page/';
		else*/
                $seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$threadArray['paging']=$pgnation;
		/*-----------------------------------*/
/*print_r($threadArray);
		exit;*/
		return $threadArray;
	}
	
	
	#  Getting Thread Information
	#  Variables
	#		$threadid	=	Used to get Thread Information by supplied id
	function getThread($threadid)
	{
		$tbl = "tbl_forum_thread t INNER JOIN tbl_users u ON t.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf = "t.*, u.first_name, u.last_name, uc.country, (select count(*) from tbl_forum_reply r where r.threadid=t.threadid) as replies";
		$cnd = "t.threadid=".$threadid;
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
		
		$thread=@mysql_fetch_assoc($rs);
		
		return $thread;
	}
	
	#  Getting Replies List of Thread along with Pagination
	#  Variables
	#		$file		=	Used to get currently running script. e.g. myforum.php
	#		$getpage 	=	Used to get page number in pagination
	#		$search		= 	Used to search thread by keyword
	#		$threadid	=	Getting Parent Thread details
	function getReplies1($search='', $threadid='')
	{
		$tbl = "tbl_users u LEFT JOIN mast_country uc ON u.countryid = uc.countryid INNER JOIN tbl_forum_reply r ON r.userid = u.userid";
		$sf = "u.first_name, u.last_name, uc.country, r.*";
		$cnd = "(r.reply LIKE '%" . $search ."%') AND r.threadid=". $threadid;
		
		$ob = "r.posted_date DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");
		while($row=@mysql_fetch_assoc($rs))
			$reply[]=$row;
		print_r($reply);
		return $reply;
	}

	function getReplies($file='',$getpage='',$search='', $forumid = '', $threadid='',$forums_per_reply, $admin)
	{

		#------------Pagination Part-1------------
		
		if(!isset($getpage))
			$page =1;
		else
		$page = $getpage;						
		$adsperpage = $forums_per_reply;							
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;
		
		#-----------------------------------

		$tbl = "tbl_users u LEFT JOIN mast_country uc ON u.countryid = uc.countryid INNER JOIN tbl_forum_reply r ON r.userid = u.userid";
		$sf = "u.first_name, u.last_name, uc.country, r.*";
		$cnd = "(r.reply LIKE '%" . $search ."%') AND r.threadid=". $threadid;
		
		$ob = "r.posted_date DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");
		while($row=@mysql_fetch_assoc($rs))
		{
			$reply[]=$row;
		
                }
                $reply['replies']=$reply;
		/*----------Pagination Part-2--------------*/
		$rs = $this->gj($tbl,"", $cnd, "", "", "", "", "");
		$nums = @mysql_num_rows($rs);
		$show = 5;		
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 1)
			$reply['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;

	
		if($admin != 1)
			$firstlink = SITEROOT."/forum/".$file."/?threadid=".$threadid."";
	
		else
			$firstlink = SITEROOT."/admin/modules/forum/".$file."?&threadid=".$threadid."";
		
		$seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$reply['paging']=$pgnation;
		/*-----------------------------------*/
                //echo "<pre>";print_r($reply);exit;
		return $reply;
		
	}
	
	function getReply($replyid)
	{
		$tbl = "tbl_users u LEFT JOIN mast_country uc ON u.countryid = uc.countryid INNER JOIN tbl_forum_reply r ON r.userid = u.userid";
		$sf = "u.first_name, u.last_name, uc.country, r.*";
		$cnd = "r.replyid = ". $replyid;
		$rs = $this->gj($tbl, $sf, $cnd, "", "", "", "", "");
		$reply = @mysql_fetch_assoc($rs);
		return $reply;
	}
	
	function addForum()
	{
		extract($_POST);

		#------bad words-----#
		$rs_bad = $this->cgs("tbl_bad_words", "*", "", "", "", "", "");
		while($bad = @mysql_fetch_assoc($rs_bad))
		{
			$bad_word[] = $bad;
			$title=@str_ireplace($bad['bad_word'],"",$title);
			$description=@str_ireplace($bad['bad_word'],"",$description);
		} 
		#-------end----------#	

		$fl = array("categoryid", "title", "description", "userid", "posted_date");
		$vl = array($categoryid, preg_replace('/<[^>]*>/','',html_entity_decode($title)), preg_replace('/<[^>]*>/','',html_entity_decode($description)), $_SESSION['csUserId'], date("Y-m-d H:i:s"));
		$id = $this->cgi('tbl_forum' , $fl , $vl , "");
		
		$_SESSION['msg']="<span class='success'>Discussion topic added successfully.</span>";
		return($id);
	}
	
	function addThread()
	{
		extract($_POST);

		#------bad words-----#
// 		$rs_bad = $this->cgs("tbl_bad_words", "*", "", "", "", "", "");
// 		while($bad = @mysql_fetch_assoc($rs_bad))
// 		{
// 			$bad_word[] = $bad;
// 			$title=@str_ireplace($bad['bad_word'],"",$title);
// 		} 
		#-------end----------#	

		$f = array("title", "description", "userid", "posted_date", "forumid");
		$v = array(preg_replace('/<[^>]*>/','',html_entity_decode($title)),preg_replace('/<[^>]*>/','',html_entity_decode($description)), $_SESSION['csUserId'], date("Y-m-d H:i:s"), $forumid);
		$id = $this->cgi("tbl_forum_thread", $f, $v, "");
		
		$_SESSION['msg']="<span class='success'>Post added successfully.</span>";		
		return $id;
	}
	
	function addReply()
	{
		extract($_POST);
		$f = array("threadid", "userid", "reply", "posted_date", "forumid");
		$v = array($threadid, $_SESSION['csUserId'] , $description , date("Y-m-d H:i:s"), $forumid);
		$id = $this->cgi('tbl_forum_reply' , $f , $v , "");
		$_SESSION['msg']="<span class='success'>Reply added successfully.</span>";
		
		return $id;
	}
	function addForumByAdmin()
	{
		extract($_POST);
		$fl = array("categoryid", "title", "description", "userid", "posted_date", "status", "verification","deal_id");
		$vl = array($categoryid, trim($title) , trim($description), $_SESSION['duAdmId'], date("Y-m-d H:i:s"), "Active", "yes",$dealname);
		$id = $this->cgi('tbl_forum' , $fl , $vl , "");
		
		$_SESSION['msg']="<span class='success'>Discussion added successfully.</span>";
		return($id);
	}
	
	function addThreadByAdmin()
	{
		extract($_POST);
		
		
		$f = array("title", "description", "userid", "posted_date", "forumid");
		$v = array(trim($title), trim($description), $_SESSION['duAdmId'], date("Y-m-d H:i:s"), $forumid);
		$id = $this->cgi("tbl_forum_thread", $f, $v, "");
		
		$_SESSION['msg']="<span class='success'>Thread added successfully.</span>";
		
		return $id;
	}
	
	function addReplyByAdmin()
	{
		extract($_POST);
		$f = array("threadid", "userid", "reply", "posted_date","forumid");
		$v = array($threadid, $_SESSION['duAdmId'] , $description , date("Y-m-d H:i:s"),$forumid);
		$id = $this->cgi('tbl_forum_reply' , $f , $v , "");
		$_SESSION['msg']="<span class='success'>Reply added successfully.</span>";
		
		return $id;
	}
	
	function updateForum()
	{
		extract($_POST);

		$fl = array("title", "description","deal_id");
		$vl = array(trim($title) , trim($description),$dealname);
		$id = $this->cupdt('tbl_forum' , $fl , $vl , "forumid", $forumid, "");
		
		$_SESSION['msg']="<span class='success'>Discussion updated successfully.</span>";
		return($id);
	}
	
	function updateThread()
	{
		extract($_POST);

		$f = array("title", "description");
		$v = array(trim($title), trim($description));
		$id = $this->cupdt("tbl_forum_thread", $f, $v, "threadid", $threadid, "");
		
		$_SESSION['msg']="<span class='success'>Thread updated successfully.</span>";
		
		return $id;
	}
	
	function updateReply()
	{
		extract($_POST);
		$f = array("reply");
		$v = array($description);
		$id = $this->cupdt('tbl_forum_reply' , $f , $v , "replyid", $replyid, "");
		$_SESSION['msg']="<span class='success'>Reply updated successfully.</span>";
		
		return $id;
	}

 	function getForumInfo($forumid)
 	{
 		$rs_forum = $this->gj("tbl_forum", "view_count", "forumid = '".$forumid."'", "", "", "", "", "");
 		$forumres = mysql_fetch_assoc($rs_forum); 		
 		return $forumres;
 	}

	function updateForumView($forumid)
	{
		$forumdet = $this->getForumInfo($forumid);
		$number_of_views_forum = $forumdet['view_count'] + 1;
		$result = $this->cupdt("tbl_forum", "view_count", $number_of_views_forum, "forumid", $forumid, "");
		
		return $result;	
	}

	function getThreadInfo($threadid)
	{
		$rs_thread = $this->gj("tbl_forum_thread", "view_count", "threadid = '".$threadid."'", "", "", "", "", "");
		$threadres = mysql_fetch_assoc($rs_thread);
		return $threadres;
	}

	function updateThreadView($threadid)
	{
		$threaddet = $this->getThreadInfo($threadid);
		$number_of_views_thread = $threaddet['view_count'] + 1;
		$result = $this->cupdt("tbl_forum_thread", "view_count", $number_of_views_thread, "threadid", $threadid, "");
		
		return $result;	
	}

	function getReplyInfo($replyid)
	{
		$rs_reply = $this->gj("tbl_forum_reply", "*", "replyid = '".$replyid."'", "", "", "", "", "");
		$replyres = mysql_fetch_assoc($rs_reply);
		return $replyres;
	}

	function updateReplyView($replyid)
	{
		$replydet = $this->getReplyInfo($replyid);
		$number_of_views_reply = $replydet['view_count'] + 1;
		$result = $this->cupdt("tbl_forum_reply", "view_count", $number_of_views_reply, "replyid", $replyid, "");
		
		return $result;	
	}
	
	function deleteForum($forumid)
	{
		$_SESSION['msg']="<span class='success'>Discussion deleted successfully.</span>";
		return true;
	}
	
	function deleteThread($threadid)
	{
		$_SESSION['msg']="<span class='success'>Thread deleted successfully.</span>";
		return true;
	}
	
	function deleteReply($forumid)
	{
		$_SESSION['msg']="<span class='success'>Reply deleted successfully.</span>";
		return true;
	}


	function getAllUserName()
	{
	    $u_name=array();

// 	    $cnd = "isverified  = 'yes'";
	    $cnd = "1";
	    $tbl= "tbl_users";
	    $sf="first_name,last_name,username";
	    $rs_user = $this->gj($tbl,$sf,$cnd, "username", "", "", "", "");
  
	    if( $rs_user !='n')
	    {
		while($rs_name = @mysql_fetch_assoc($rs_user))
		{
		    $u_name[]['fullname']=$rs_name['first_name']." ".$rs_name['last_name'];
		    $u_name[]['username']=$rs_name['username'];
		}
	    }
	    return $u_name;
        }
}
?>
