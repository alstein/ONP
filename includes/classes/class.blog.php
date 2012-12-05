<?php
class Blogs extends DBTransact
{
	/*----------This Function is for Only Admin Listing of blog---------*/

//  	function getBlogs($file, $getpage='1', $search='', $categoryid='')
// 	{
// 		#------------Pagination Part-1------------
// 		
// 		if(!isset($getpage))
// 			$page =1;
// 		else
// 			$page = $getpage;
// 		$adsperpage = 2;
// 		$StartRow = $adsperpage * ($page-1);			
// 		 $l =  $StartRow.','.$adsperpage;
// 		#-----------------------------------
//                 $tbl="tbl_blog b INNER JOIN  tbl_users u ON b.userid = u.userid";
// 		$sf = "b.*, u.first_name, u.last_name";
// 		$cnd = "(b.title LIKE '%" . $search ."%' OR b.description LIKE '%" . $search ."%')";		
// 		$ob = "b.id DESC";
// 		
// 		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", $l, '');
// 		$i=0;
// 		while($row = @mysql_fetch_assoc($rs))
// 		{
//                     $rs1 = $this->customqry("select count(userid) 'count' from tbl_blog_comment where blog_id = ".$row['id'], '');
//                     $row1 = @mysql_fetch_assoc($rs1);
//                     $row['comment_count'] = $row1['count'];
//                    $blogs[$i] = $row;
//                    $i++;
// 		}
// 		$blogArray['blogs']=$blogs;
// 				
// 		/*----------Pagination Part-2--------------*/
// 		$rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", "");
// 		$nums = @mysql_num_rows($rs);
// 		$show = 5;		
// 		$total_pages = ceil($nums / $adsperpage);
// 		if($total_pages > 1)
// 			$blogArray['showpaging']='yes';
// 		$showing   = !($getpage)? 1 : $getpage;
// 		if($search)
// 			$firstlink = $file . "?search=" . $search;
// 		else
// 			$firstlink = $file ."?";
// 		$seperator = '&page=';
// 		$baselink  = $firstlink; 
// 		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
// 		$blogArray['paging']=$pgnation;
// 		/*-----------------------------------*/		
// 		return $blogArray;
// 	}
	/*----------This Function is for Only Display the  of blog datails--------*/
 	function getBlogsDetails($file)
	{	
	        $tbl="tbl_blog b LEFT JOIN  tbl_users u ON b.userid = u.userid";
                $sf = "b.*, u.first_name, u.last_name";
                $cnd = "id=".$_GET['blogid'];
                $ob = "b.id DESC";
                $rs = $this->gj($tbl, $sf, $cnd, $ob, "", "", "", '');
                $i=0;
		while($row = @mysql_fetch_assoc($rs))
		{
                    $rs1 = $this->customqry("select count(userid) 'count' from tbl_blog_comment where blog_id = ".$row['id'], '');
                    $row1 = @mysql_fetch_assoc($rs1);
                    $row['comment_count'] = $row1['count'];
                   $com[$i] = $row;
                   $i++;
		}
		$blogArray['blogs']=$com;
                $comm= $blogArray['blogs'][0]['comment_count'];
               $tbl2="tbl_blog_comment c LEFT JOIN  tbl_users u ON c.userid = u.userid";
               $sf2 = "c.*, u.first_name, u.last_name";
               $cnd2 = "c.blog_id=".$_GET['blogid'];
               $ob2 = "c.id DESC";
               $rs2 = $this->gj($tbl2, $sf2, $cnd2, $ob2, "", "", "", '');
               
              while($row2 = @mysql_fetch_assoc($rs2))
             {
                   $comments[]=$row2;
             }	
	    return array($comments,$com[0],$comm);
        }
        function clean_url($text)
        {
            $text=strtolower($text);
            $code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
            $code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
            $text = str_replace($code_entities_match, $code_entities_replace, $text);
            return $text;
        } 
        

}
?>