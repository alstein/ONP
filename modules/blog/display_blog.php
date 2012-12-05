<?php
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
// include_once('../../includes/classes/class.blog.php');

//    $blogObj= new Blogs();
//    $blog = $blogObj->getBlogs("display_blog.php",true);
//--------paging---------------
                if(!isset($_GET['page']))
                     $page =1;	
                else
                     $page = $_GET['page'];
                     $newsperpage =20;
                     $StartRow = $newsperpage * ($page-1);
                     
                     $l =  $StartRow.','.$newsperpage;
                     $tbl="tbl_blog b INNER JOIN  tbl_users u ON b.userid = u.userid";
		     $sf = "b.*, u.first_name, u.last_name";
		     //$cnd = "(b.title LIKE '%" . $search ."%' OR b.description LIKE '%" . $search ."%' OR b.status='Active')";		
                     $cnd = "b.status='1'"; 
		     $ob = "b.id DESC";		
		     $rs1 = $dbObj->gj($tbl, $sf, $cnd, $ob, "", "", $l, '');		
                     $i=0;
		while($row = @mysql_fetch_assoc($rs1))
		{
                     $city = $dbObj->customqry("select city_name from mast_city where city_id = ".$row['city_id'], '');
                     $row1 = @mysql_fetch_assoc($city);
                     $row['city_name'] = $row1['city_name'];

                     $rs2 = $dbObj->customqry("select count(userid) 'count' from tbl_blog_comment where blog_id = ".$row['id'], '');
                     $row1 = @mysql_fetch_assoc($rs2);
                     $row['comment_count'] = $row1['count'];
                     $blogs[$i] = $row;
                     $i++;
                }
                     $blog['blogs']=$blogs;
                     $rs1 =$dbObj->gj($tbl,"*", "id", "", "", "", "", "");
                     $nums =@mysql_num_rows($rs1);
                     $smarty -> assign("recordsFound",$nums);
                     $show = 20;
                     $total_pages = ceil($nums / $newsperpage);
               if($total_pages > 1)
                {
                     $smarty->assign("showpgnation","yes");
                     $showing   = !isset($_GET["page"]) ? 1 : $page;
	             $firstlink = "display_blog";
                     $seperator = '?page='; 
                     $baselink  = $firstlink;
                     $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);
                     $smarty-> assign("pagenation",$pagenation);
                }
                     $smarty->assign("blog", $blog['blogs']);
                     $smarty->assign("blogp", $blog['paging']); 
                     $smarty->assign("pgName","content");
                     
//Get meta tags of the page as per id
//print_r($blog);exit;
$call_meta=$dbObj->meta_SEO(18);
$smarty->assign("row_meta",$call_meta);

$smarty->display(TEMPLATEDIR . '/modules/blog/display_blog.tpl');
$dbObj->Close();
?>