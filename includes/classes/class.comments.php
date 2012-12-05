<?php
#----------------------------------------------------------
#	Created By	: 	Yogesh Kadam
#	Date		:	27 Nov 2008
#	Purpose		:	To be used as centeralized commenting system
#	Example: Blogs, Forum, Video Commenting
#----------------------------------------------------------
class Comments extends DBTransact
{

	#--Function is used for storing comment in database.
	function writeComment($modid, $itemid, $userid, $comment)
	{
		$_f = array('moduleid', 'itemid', 'userid', 'comment', 'date_added');
		
		$_v = array($modid, $itemid, $userid, $comment, date('Y-m-d H:i:s'));
		
		$_id=$obj->cgi('tbl_comments', $_f, $_v, '');
		
		if($id)
			return true;
		else
			return false;
	}
	
	#---Function to fetch all comments from database---#
	function getComments($modid, $itemid, $admin=false)
	{
		if($admin == true)
			$limit = "";
		else
			$limit = 10;
		$tbl = "tbl_comments c INNER JOIN tbl_users u ON c.userid = u.userid";
		$sf = "c.*, u.first_name, u.last_name";
		$cnd = "c.itemid = ".$itemid;
		$_rs=$this->gj($tbl, $sf, $cnd, 'c.date_added DESC', '', '',  $limit, "");
		
		while($_row=@mysql_fetch_assoc($_rs))
			$_comments[] =$_row;

		return $_comments;
	}
	#---Function to fetch all comments from database---#
	function getComment( $itemid)
	{
		$tbl = "tbl_comments c ";
		$sf = "c.*";
		$cnd = "c.moduleid = ".$itemid;
		$_rs=$this->gj($tbl, $sf, $cnd, 'c.date_added DESC', '', '',  "", "");
		
		while($_row=@mysql_fetch_assoc($_rs))
			$_comments[] =$_row;

		return $_comments;
	}
	function getUserSideComment($itemid)
	{
		$tbl = "tbl_comments c ";
		$sf = "c.*";
		$cnd = " (c.moduleid = {$itemid} or c.itemid = {$itemid}) and c.status='active'";
		$_rs=$this->gj($tbl, $sf, $cnd, 'c.date_added DESC', '', '',  "", "");
		
		while($_row=@mysql_fetch_assoc($_rs))
			$_comments[] =$_row;

		return $_comments;
	}

	function getCommentsLMT($modid, $itemid, $admin=false, $limit='')
	{
		if($limit)
			$limit = $limit;
		else
			$limit = 10;

		$tbl = "tbl_comments c INNER JOIN tbl_users u ON u.userid = c.userid";
		$sf = "c.*, u.first_name, u.last_name, u.thumbnail";
		$cnd = "c.moduleid=" . $modid . " AND c.itemid = " . $itemid;
		$_rs=$this->gj($tbl, $sf, $cnd, 'c.date_added', '', 'DESC', $limit, false);
		if($_rs!="n")
		{
			while($_row=@mysql_fetch_assoc($_rs))
				
				$_comments[] =$_row;
		}

		return $_comments;
	}
	
	#---------Delete Comment-----------------#
	function delComment($id, $userid)
	{
		$_rs=$this->gdel('tbl_comments', array('id', 'userid'), array($id, $userid), '');
	}

	function DeleteCommentByAdmin($commentid)
	{
		$_rs=$this->gdel('tbl_comments', array('id'), array($commentid), '');
	}

	#---------Delete Comments By Item-----------------#
	function delCommentByItem($itemid, $moduleid)
	{
		$_rs=$this->gdel('tbl_comments', array('itemid', 'moduleid'), array($itemid, $moduleid), '');
	}
}
//$cmtObj= new Comments();
?>