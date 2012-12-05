<?php
class Blogs extends DBTransact
{
	/*----------This Function is for Only Admin Listing of blog---------*/

 	function getBlogs($file, $getpage='', $search='', $categoryid='', $admin=false)
	{
		$ratingObj = new Rating();
		
		#------------Pagination Part-1------------
		if(!isset($getpage))
			$page =1;
		else
			$page = $getpage;
		$adsperpage = 20;
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;
		#-----------------------------------

		$tbl="tbl_blogs b INNER JOIN  tbl_users u ON b.userid = u.userid INNER JOIN tbl_blogcategory c ON c.categoryid = b.categoryid ";

		$sf = "b.*,c.category, u.first_name, u.last_name, u.thumbnail as userphoto";
		$cnd = "(b.title LIKE '%" . $search ."%' OR b.description LIKE '%" . $search ."%')";
		
		if($categoryid)
			$cnd .= " AND b.categoryid=".$categoryid;
		if($admin == false)
			 $cnd .= " AND b.status='Active'";
			 
		$ob = "b.blogid DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, '');
		$i=0;
		while($row = @mysql_fetch_assoc($rs))
		{
			$blogs[$i] = $row;
// 			$blogs[$i]['rating'] = $ratingObj->getRating(2, $blogs[$i]['blogid']);
			$i++;
		}
		$blogArray['blogs']=$blogs;
		
		/*----------Pagination Part-2--------------*/
		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
		$nums = @mysql_num_rows($rs);
		$show = 5;		
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 1)
			$blogArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		if($search)
			$firstlink = $file . "?search=" . $search;
		else
			$firstlink = $file ."?";
		$seperator = '&page=';
		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$blogArray['paging']=$pgnation;
		/*-----------------------------------*/
		
		return $blogArray;
	}

	/*----------------This is for user side-------------------*/
	function getBlogsUserSide($file, $getpage='', $search='',$type='')
	{
		include_once('class.user_profile.php');

		$ObjProfile = new UserProfile();

		$tbl="tbl_blogs b INNER JOIN tbl_blogcategory c ON b.categoryid = c.categoryid INNER JOIN tbl_users u ON b.userid = u.userid";

		$sf = "(select count(*) from tbl_comments as cm1 where b.blogid = cm1.moduleid and cm1.status='active') as total_count,b.*, c.category, u.first_name, u.last_name, u.thumbnail as userphoto";
        
                $cnd = "b.status = 'Active' and c.status = 'Active'";
		if($search)
                {
		      $cnd = "(b.title LIKE '%" . $search ."%' OR b.description LIKE '%" . $search ."%' OR b.tags LIKE '%".$search."%') AND b.status='Active'";
                }
		
		if($type!='')
		{
		    if($type == 'my')
			$cnd .= " AND b.userid=".$_SESSION['user_id'];
		}
			 
		$ob = "b.blogid DESC";
		
		$rs = $this->gj($tbl, $sf, $cnd, "posted_date", "", "DESC", 4, "");
		$i=0;
		while($row = @mysql_fetch_assoc($rs))
		{
			$blogs[$i] = $row;
			$pr = $ObjProfile->GetProfileDetailById($blogs[$i]['userid']);

			$blogs[$i]['username'] = $pr['username'];
			$blogs[$i]['first_name'] = $pr['first_name'];
			$blogs[$i]['last_name'] = $pr['last_name'];
			$blogs[$i]['gender'] = $pr['gender'];
			$blogs[$i]['email'] = $pr['email'];
			$blogs[$i]['country'] = $pr['country'];
			//$blogs[$i]['rating'] = $ratingObj->getRating(2, $blogs[$i]['blogid']);
			$i++;
		}
		$blogArray['blogs']=$blogs;
		
		return $blogArray;
	}


	function getPopulerBlogsUserSide($file, $getpage='', $search='',$type='')
	{
		include_once('class.user_profile.php');
		$ObjProfile = new UserProfile();
		$ratingObj = new Rating();
		
		#------------Pagination Part-1------------
		if(!isset($getpage))
			$page =1;
		else
			$page = $getpage;
		$adsperpage = 20;
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;
		#-----------------------------------
		
		$tbl="tbl_blogs b INNER JOIN tbl_category c ON b.categoryid = c.categoryid INNER JOIN tbl_users u ON b.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid, tbl_rating r";

		$sf = "b.*, c.category, u.first_name, u.last_name, uc.country, u.thumbnail as userphoto, r.*, sum(r.rating) AS Avg";
		$cnd = "(b.title LIKE '%" . $search ."%' OR b.description LIKE '%" . $search ."%' OR b.tags LIKE '%".$search."%') AND b.status='Active'";
		
		if($type!='')
		{
			if($type == 'populer')
			$cnd .= " AND r.moduleid=2 AND b.blogid = r.itemid";
		}
			 
		$ob = "Avg";
		$ad = "DESC";
		$gp = "r.itemid";
		
		$rs = $this->gj($tbl, $sf, $cnd, $ob, $gp, $ad, $l, false);
		$i=0;
		while($row = @mysql_fetch_assoc($rs))
		{
			$blogs[$i] = $row;
			$pr = $ObjProfile->GetProfileDetailById($blogs[$i]['userid']);

			$blogs[$i]['username'] = $pr['username'];
			$blogs[$i]['first_name'] = $pr['first_name'];
			$blogs[$i]['last_name'] = $pr['last_name'];
			$blogs[$i]['gender'] = $pr['gender'];
			$blogs[$i]['email'] = $pr['email'];
			$blogs[$i]['country'] = $pr['country'];
			$blogs[$i]['rating'] = $ratingObj->getRating(2, $blogs[$i]['blogid']);
			$i++;
		}
		$blogArray['blogs']=$blogs;
		
		/*----------Pagination Part-2--------------*/
		$rs = $this->gj($tbl, $sf, $cnd, $ob, $gp, $ad, "", "");
		$nums = @mysql_num_rows($rs);
		$show = 5;		
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 1)
			$blogArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		if($search)
			$firstlink = $search."/".$file;
		else
			$firstlink = $file;

		$baselink  = $firstlink; 
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $nums, 'blogs');
		$blogArray['paging']=$pgnation;
		/*-----------------------------------*/
		
		return $blogArray;
	}

	function GetBlogById($blogid)
	{
		include_once('class.user_profile.php');
		$ObjProfile = new UserProfile();

		$tbl = "tbl_blogs b ";
		$sf = "b.*";
		$cd = "b.blogid=".$blogid;
		
		$rs = $this->gj($tbl,$sf,$cd,"","","","","");
		if($rs!="n")
		{	$frch = mysql_fetch_assoc($rs);

			$pr = $ObjProfile->GetProfileDetailById($frch['userid']);

			$frch['username'] = $pr['username'];
			$frch['first_name'] = $pr['first_name'];
			$frch['last_name'] = $pr['last_name'];
			$frch['gender'] = $pr['gender'];
			$frch['email'] = $pr['email'];
			//$frch['country'] = $pr['country'];
		}

	return $frch;
	}
	
	function getBlog($loginname, $admin=false)
	{
		$tbl="tbl_blogs b INNER JOIN tbl_blogcategory c ON b.categoryid = c.categoryid INNER JOIN tbl_users u ON b.userid = u.userid LEFT JOIN mast_country uc ON u.countryid = uc.countryid";
		$sf="b.*, c.category, u.first_name, u.last_name, uc.country, u.thumbnail as userphoto";
		//$cnd = "u.login_name = '".$loginname . "'";
		$cnd=1;
		if($admin == false)
			 $cnd .= " AND b.status='Active'";
		
		$rs = $this->gj($tbl, $sf, $cnd, "", "", "", "", "");//exit;
		$blog = @mysql_fetch_assoc($rs);
		
		return $blog;
	}
	
	function updateBlogViewCounter($blogid)
	{
		$rs = $this->customqry("update tbl_blogs set view_count = view_count+1 where blogid=".$blogid, "");
		return true;
	}
	
	function addBlogByUser()
	{
		extract($_POST);

		$cdate = date('Y-m-d h:i:s');
		/*------Allow Comment and Rating----------*/
		if(!$_POST['alloecm'])
		{	$alloecm = 'no';	}
		if(!$_POST['allort'])
		{	$allort = 'no';		}
		
		if($_FILES['file']['name']!='')
		{
			$photo = uploadandresize($_FILES['file'], "../../uploads/blogs", "../../uploads/blogs/thumbnail", 100, 100);
		}
	
		$sf = array("userid","categoryid","title","tags","description","posted_date","status","thumbnail","allow_comment","allow_ratings");
		$sv = array($_SESSION['user_id'],$category,$blogtitle,$blogtag,$description,$cdate,"Active",$photo['thumbnail'],$alloecm,$allort);
		$res = $this ->cgi('tbl_blogs', $sf, $sv, ""); 

		return $res;
	}
	
	function updateBlogByUser($blogid)
	{
		extract($_POST);
		/*------Allow Comment and Rating----------*/
		if(!$_POST['alloecm'])
		{	$alloecm = 'no';	}
		if(!$_POST['allort'])
		{	$allort = 'no';		}

		if($_FILES['photo']['name']!='')
		{
			$photo = uploadandresize($_FILES['photo'], "../../uploads/blogs", "../../uploads/blogs/thumbnail", 100, 100);
			@unlink("../../uploads/blogs/". $_POST['old_photo']);
			@unlink("../../uploads/blogs/thumbnail/". $_POST['old_photo']);
		}
		
		if($photo['thumbnail'])
		{
			$sf = array("categoryid","title","tags","description","thumbnail","allow_comment","allow_ratings");
			$sv = array($category,$blogtitle,$blogtag,$description,$photo['thumbnail'],$alloecm,$allort);
		}
		else
		{
			$sf = array("categoryid","title","tags","description","allow_comment","allow_ratings");
			$sv = array($category,$blogtitle,$blogtag,$description,$alloecm,$allort);
		}
		
		$insert=$this->cupdt("tbl_blogs", $sf, $sv, "blogid", $blogid, "");
		
		return true;
	}
	function DeleteBlogByUserBlogId($blogid)
	{
		$blgdtl = $this->GetBlogById($blogid);

		include_once("class.comments.php");	
		$cmtObj = new Comments();
		$cmtObj->delCommentByItem($blgdtl['blogid'], 2);
		
		include_once("class.rating.php");
		$rtnObj = new rating();	
		$rtnObj->delRatingsByItem($blgdtl['blogid'], 2);
		
		@unlink("../../uploads/blogs/thumbnail/".$blgdtl['thumbnail']);
		@unlink("../../uploads/blogs/".$blgdtl['thumbnail']);
		
		$insert=$this->gdel("tbl_blogs", "blogid", $blgdtl['blogid'], "");
	return true;
	}
	
	function deleteBlogByUser()
	{
		$blog = $this->getBlog($_SESSION['csLoginName']);
		
		include_once("class.comments.php");	
		$cmtObj = new Comments();
		$cmtObj->delCommentByItem($blog['blogid'], 2);
		
		include_once("class.rating.php");
		$rtnObj = new rating();	
		$rtnObj->delRatingsByItem($blog['blogid'], 2);
		
		@unlink("../../uploads/blogs/thumbnail/".$blog['thumbnail']);
		
		$insert=$this->gdel("tbl_blogs", "blogid", $blog['blogid'], "");	
		
		$_SESSION['msg']="<span class='success'>Blog Deleted Successfully.</span>";
		return true;
	}
	
	function isMyBlogPresent()
	{
		$blog = $this->getBlog($_SESSION['csLoginName'],"");
		
		if($blog)
			return true;
		else
			return false;
	}
	function AddBlogByAdmin()
	{
		extract($_POST);

		$cdate = date('Y-m-d');
		/*------Allow Comment and Rating----------*/
		if(!$_POST['alloecm'])
		{	$alloecm = 'no';	}
		if(!$_POST['allort'])
		{	$allort = 'no';		}
		
		if($_FILES['file1'])
		{
			$photo = uploadandresize($_FILES['file1'], "../../../uploads/blogs", "../../../uploads/blogs/thumbnail", 80, 80);
		}
	
		$sf = array("userid","categoryid","title","tags","description","posted_date","status","thumbnail","allow_comment");
		$sv = array($_SESSION['duAdmId'],$cat_id,$blogtitle,$blogtag,$descriptn,$cdate,"Active",$photo['thumbnail'],$alloecm);
		$res = $this ->cgi('tbl_blogs', $sf, $sv, ""); 

	return true;
	}
	function UpdateBlogByAdmin($blogid)
	{
		extract($_POST);
		/*------Allow Comment and Rating----------*/
		if(!$_POST['alloecm'])
			$alloecm = 'no';

		if($_FILES['file1']['name'])
		{
		  $photo = uploadandresize($_FILES['file1'], "../../../uploads/blogs", "../../../uploads/blogs/thumbnail", 80, 80);
  
		  @unlink('../../../uploads/blogs/thumbnail/'.$_POST['thumbnail']);
		  @unlink('../../../uploads/blogs/'.$_POST['thumbnail']);
  
		  $sf = array("categoryid","title","tags","description","thumbnail","allow_comment");
		  $sv = array($cat_id,$blogtitle,$blogtag, $descriptn,$photo['thumbnail'],$alloecm);
		}
		else
		{
		  $sf = array("categoryid","title","tags","description","allow_comment");
		  $sv = array($cat_id,$blogtitle,$blogtag, $descriptn,$alloecm);
		}
		$id = $this->cupdt("tbl_blogs",$sf,$sv,"blogid",$blogid,"");
		return true;
	}
	function DeleteBlofByAdmin($blogid)
	{
		$blgdtl = $this->GetBlogById($blogid);
		
		@unlink("../../../uploads/blogs/thumbnail/".$blgdtl['thumbnail']);
		@unlink("../../../uploads/blogs/".$blgdtl['thumbnail']);
		
		$insert=$this->gdel("tbl_blogs", "blogid", $blgdtl['blogid'], "");
	       return true;
	}
	function UpdateBlogViewCount($blogid)
	{	
		$rs = $this->cgs("tbl_blogs","","blogid",$blogid,"","","");
		if($rs!="n")
		{
			$frch = mysql_fetch_assoc($rs);
			$lst = $frch['view_count']+1;
			$insert=$this->cupdt("tbl_blogs", "view_count", $lst, "blogid", $blogid, "");
		}
	       return true;
	}
	function AddBlogCategory()
	{
		extract($_POST);
	
		$sf =array("category","status");
		$sv =array($category,$status);
		$res = $this ->cgi('tbl_blogcategory', $sf, $sv, ""); 
		return true;
	}
	function UpdateBlogCategory($blogid)
	{
		extract($_POST);
	
		$sf =array("category","status");
		$sv =array($category,$status);
		$res = $this ->cupdt('tbl_blogcategory', $sf, $sv, "categoryid",$blogid,""); 
		return true;
	}
 	function getCategory()
	{
		//$cnd = "status='Active'";		
                $cnd=1;
		$rs = $this->gj("tbl_blogcategory", "*",$cnd, "category", "", "", "", "");
		$i=0; $blogs=array();
  
		while($row = @mysql_fetch_assoc($rs))
		{
			$blogs[$i] = $row;
			$i++;
		}
		return $blogs;
	}

 	function getBlogCateogry()
	{
		$cnd = "status='Active'";		
		$rs = $this->gj("tbl_blogcategory", "*",$cnd, "category", "category", "", "", "");
		$i=0; $blogs=array();
                if( $rs != 'n')
                {
                    $blogs['total'] = mysql_num_rows($rs);
                    $blogs['total1'] = ((int)( ($blogs['total'] )/2));
		    while($row = @mysql_fetch_assoc($rs))
		    {
			    $blogs[$i] = $row;
			    $i++;
		    }
		    return $blogs;
		}
	}

	function getBlogCategoryById($blogid)
	{

		$tbl = "tbl_blogcategory b";
		$sf = "b.*";
		$cd = "b.categoryid=".$blogid;
		
		$rs = $this->gj($tbl,$sf,$cd,"","","","","");
		if($rs!="n")
                     $frch = mysql_fetch_assoc($rs);

        	return $frch;
	}
	function getPopularBlog()
	{

	    $tbl="tbl_comments";
	    $rs=$this->customqry("select moduleid,count(moduleid)as cnt from tbl_comments where status = 'active' group by moduleid","");
	    $mid='';$tmp=0;
	    if($rs!='n')
	    {
		while($frch = mysql_fetch_assoc($rs))
		{
		    if($frch['cnt']> $tmp)
		    {
			$tmp=$frch['cnt'];$mid=$frch['moduleid'];
		    }
		}

	    }
    
            if($mid)
            {
		$brs = $this->gj("tbl_blogs","blogid,description,title,thumbnail","blogid =".$mid,"","","","","");
		if($rs!="n")
		      $frch = mysql_fetch_assoc($brs);
    
		return $frch;
            }
	}

	function getBlogArchiveDate()
	{
	    $rs = $this->gj("tbl_blogs","blogid,posted_date","status ='active'","posted_date","posted_date","DESC","0,10","");
	    $frch = array();
	    if($rs!="n")
            { 
		$i=0;
		while($row = mysql_fetch_assoc($rs))
		{
		    $frch[$i]['posted_date']=$row['posted_date'];$i++;
		}
		return $frch;
            }
	}

	function getArchives($dt)
	{		

		#------------Pagination Part-1------------
		if(!isset($getpage))
			$page =1;
		else
			$page = $getpage;
		$adsperpage = 3;
		$StartRow = $adsperpage * ($page-1);			
		$l =  $StartRow.','.$adsperpage;
		#-----------------------------------

		$tbl_a="tbl_blogs b INNER JOIN tbl_blogcategory c ON b.categoryid = c.categoryid";
		$sf_a= "b.*";
		$cnd_a = " b.status='Active'";
	        if($dt !='all')
		    $cnd_a .= " and b.posted_date LIKE '{$dt}%' ";
	 
		
		$rs_a = $this->gj($tbl_a, $sf_a, $cnd_a, "blogid", "", "DESC", $l, "");

		$i=0;
		while($row = @mysql_fetch_assoc($rs_a))
		{
			$archives[$i] = $row;
			$i++;
		}	
		$arcArray['archives']=$archives;

		/*----------Pagination Part-2--------------*/
		$rs = $this->gj($tbl_a, $sf_a, $cnd_a, "blogid", "", "DESC", "", "");
		$nums = @mysql_num_rows($rs);
		$show = 5;		
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 1)
			$arcArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		if($search)
			$firstlink = $search."/".$file;
		else
			$firstlink = $file;

		$firstlink = SITEROOT . "/blog/archives/all/?";
                $seperator = '?id1=';
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
		$arcArray['paging']=$pgnation;
		/*-----------------------------------*/
	
		return $arcArray;
	}
}
?>