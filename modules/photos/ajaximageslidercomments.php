<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/classes/class.profile.php');
include_once('../../includes/classes/class.photos.php');
include_once('../../includes/common.lib.php');
 include('../../includes/paging.php');

if(!$_SESSION['csUserId'])
{
	header("Location:".SITEROOT."/");
}
$whose_profile="album";
$smarty->assign("whose_profile",$whose_profile);

$userid = $_SESSION['csUserId'];
$profileinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$profileinfo);
if($_POST['imageid']!="")
{
// comment on photo
// echo $_GET['imageid'];
#------------Pagination Part-1--------------------------------

if(!isset($_GET['page']))
		{
			$getpage='';
			$page =1;
		}
		else
		{
			$getpage = $_GET['page'];
			$page = $getpage;
		}

			$adsperpage = 2;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
#-------------------------------------------------------------------------------#
$count_details=$dbObj->gj("tbl_comment c,tbl_albumphotos a","count(c.comment_id) as cnt,c.comment","c.photo_id=a.photo_id  and a.photo_id=".$_POST['imageid']."","","","","","");
$fetch_countdetails=@mysql_fetch_assoc($count_details);
$smarty->assign("total_rec",$fetch_countdetails["cnt"]);

$tbl="tbl_comment c LEFT JOIN tbl_albumphotos a ON c.photo_id=a.photo_id LEFT JOIN tbl_users as u ON u.userid=c.posted_by";
$cnd="c.photo_id=".$_POST['imageid'];
$od="c.comment_id DESC";
$getcomments=$dbObj->gj($tbl,"c.*,u.fullname,u.photo,u.userid",$cnd,$od,"","","" ,"");
$c=0;
while($fetch_comments=@mysql_fetch_assoc($getcomments))
{
	$result_arr[$c]=$fetch_comments;
// 	$result_arr[$c]['comment_time_ago'] = $fetch_comments['posted_on'];
	$result_arr[$c]['posted_on']=getunfiddenhours($fetch_comments['posted_on']);;
	$c++;
}
$smarty->assign("photo_comments",$result_arr);
$smarty->assign("imageid",$_POST['imageid']);
/*----------Pagination Part-2-------------------------------------------------------*/
	       $result  = $dbObj-> gj($tbl,"c.*,u.fullname,u.photo,u.userid",$cnd,$od,"","","" ,"");	
		$nums = @mysql_num_rows($result);
		$show = 3;
		$total_pages = ceil($nums / $adsperpage);
		if($total_pages > 0)
		$groupArray['showpaging']='yes';
		$showing   = !($getpage)? 1 : $getpage;
		$seperator = '&page=';
		$baselink  = $firstlink;

		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
		$groupArray['paging']=$pgnation;
		$smarty->assign("pagination",$pgnation);
		$smarty->assign("count_record",$nums);
		$smarty->assign("total_page",$total_pages);
}
#----------------------delete photo-----------------------------------#
if($_POST['act']!="")
{
	
        if($_POST['imageid']!="" && $_POST['act']=="add"  && $_POST['comment']!=="")
	{ 	
		//add comments
		$rescommentinsert= $dbObj->cgi("tbl_comment",array("photo_id","comment","posted_on","posted_by"),array($_POST['imageid'],$_POST['comment'],date("Y-m-d H:i:s"),$userid),"");
		
	}
	else if($_POST['commentid']!="" && $_POST['act']=="delete")
	{ 	//delete comments relate to image 
		$delcomments = $dbObj->gdel("tbl_comment", array("comment_id","posted_by"),array($_POST['commentid'],$_SESSION['csUserId']), "");
	}
	else
	{
		// $delphoto = $dbObj->gdel("tbl_albumphotos", array("photo_id","user_id","album_id"), array($_POST['imageid'],$_SESSION['csUserId'],$_POST['albumid']), "");
	}	     
}//if
#---------------------------------------------------------------------#
// end for comment
   $smarty->assign("rating",TEMPLATEDIR."/modules/common/rating.tpl");
   $smarty->display(TEMPLATEDIR .'/modules/photos/ajaximageslidercomments.tpl');	
   $dbObj->Close();

function getunfiddenhours($feedtime)

    {     

             $datetime   = explode(" ",$feedtime);

             $date       = explode("-",$datetime[0]);
             $time       = explode(":",$datetime[1]);
        
            

             $dd     = $date[2];

             $mm     = $date[1];

             $yy     = $date[0];

             $h      = $time[0];

             $m      = $time[1];

             $s      = $time[2]; 
           
         $diff  = round((time()-@mktime($h,$m,$s,$mm,$dd,$yy))/60);


             if($diff<=0)

             {

                $result = "1 min ago";

             }

             elseif($diff > 60)

             {

                  $diff       = round($diff/60);
                  
                
			if($diff > 24)
			{

				$diff   = round($diff/24);

					  
						if($diff==1)
						{
						
						$result = "1 day"; 

						}
						elseif($diff>=2 && $diff<=360)
						{      
						 	$res = strtotime($feedtime); 
							$result=date("M d Y | g:i a",$res);
                                                        
                                                       
						}
						else
						{
			
											  $res = strtotime($feedtime);
											  $result=date("M d Y | g:i a",$res);
                                         
						}
			}
			else
			{
				$result     = $diff." hrs";

			}
                 // $result     = $diff." hrs";

                  
          }
	else
	{
	 $result  = $diff." min ago";

	}
       


              return($result);

    }
?>
