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
if($_POST['userid']!="")
{
$userid=$_POST['userid'];
}else
{
$userid=$_SESSION['csUserId'];
}

// $userid = $_SESSION['csUserId'];
$profileinfo = $profObj->fetchProfile($userid);
$smarty->assign("profileinfo",$profileinfo);



//    if($_SESSION['csUserTypeId'] == '2' && $profileinfo['user_type']=='3')
//    {
//          if($CheckStatus != 'active' && $IsDonated != 'yes')
//          {
//                header("Location:".SITEROOT."/".$profileinfo['username']."/donation-request/");
//                exit;  
//          }
//    }

$getpage=$_POST["page"];
#------------Pagination Part-1------------
	if($getpage=="")
	$page = 1;	
	else
	$page = $getpage;	

	$adsperpage = 1;	
		
	$StartRow = $adsperpage * ($page-1);
	$l =  $StartRow.','.$adsperpage;
	$startingnumber = ($StartRow+1);	
	$endingnumber = ($StartRow+$adsperpage);

#-----------------------------------
$albumid=$_POST["albumid"];
$photoid=$_POST["photoid"];

$res=$dbObj-> customqry("select a.*,u.username from tbl_albumphotos a LEFT JOIN tbl_users u on a.user_id=u.userid where a.album_id=".$albumid." and a.user_id=".$userid." and a.status = 'Active' order by a.photo_id ASC","");	
while($row_p = @mysql_fetch_assoc($res))
{
	$row_arr[]=$row_p;
   $smarty->assign("itemid",$row_p['photo_id']);
   $smarty->assign("itemUserId",$row_p['user_id']);
   //update view count
   $tbl2 = "tbl_albumphotos";
   $wf = "view_cnt";
   $wv = $row_p['view_cnt']+1;
   $Qury = $dbObj->cupdt($tbl2,$wf,$wv,"photo_id",$row_p['photo_id'],"");   

   $flag = $dbObj->cgs("tbl_abuse","*",array('itemid','userid'),array($row_p['photo_id'],$userid),"","","");
   if(is_resource($flag))
   $flagged = @mysql_fetch_assoc($flag);
   $smarty->assign("flag",$flagged);
}
for($k=0;$k<count($row_arr);$k++)
{
	if($row_arr[$k]['photo_id']==$photoid)
		$sliceid = $k;
}
if($sliceid!="")
{
$row_arr_new1 = array_slice($row_arr,$sliceid);
$row_arr_new2 = array_slice($row_arr,0,$sliceid);
$row_arr_final = array_merge($row_arr_new1,$row_arr_new2); 
$smarty->assign("photo_details",$row_arr_final);
}
else
{
$smarty->assign("photo_details",$row_arr);
}
//print_R($row_arr_final);

// end for countries names in regions
$smarty->assign("moduleid",'1');


/*----------Pagination Part-2--------------*/
	$rs = $dbObj-> customqry("select a.*,u.username from tbl_albumphotos a LEFT JOIN tbl_users u on a.user_id=u.userid where a.album_id=".$albumid." and a.user_id=".$userid." and a.status = 'Active' order by a.photo_id ASC","");
	$nums = @mysql_num_rows($rs);
	$show =1;		
	$total_pages = ceil($nums / $adsperpage);
	if($total_pages > 1)
		$smarty->assign("showpgnation", 'yes');
			$showing   = !($getpage)? 1 : $getpage;
			$firstlink = basename($_SERVER['PHP_SELF'])."?albumid=$albumid&userid=$userid&photoid=$photoid&page=";
	
		$baselink  = $firstlink;
		$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums,'',$startingnumber,$endingnumber);
		
		$smarty->assign("paging", $pgnation);
/*-----------------------------------*/

// ablbum details
$get_albumdetails=$dbObj->cgs("tbl_album","user_id,album_id,album_title,url_title","album_id",$albumid,"","","");
$fetch_albumdetails=@mysql_fetch_assoc($get_albumdetails);
$smarty->assign("album_details",$fetch_albumdetails);
// album details end

$smarty->assign("albumname",$fetch_albumdetails['url_title']);
if($_GET['imageid']!="")
{
// comment on photo
// echo $_GET['imageid'];
$count_details=$dbObj->gj("tbl_comments c,tbl_users u","count(id) as cnt","c.userid=u.userid and c.moduleid=3 and c.itemid=".$_GET['imageid']." ","c.id","","DESC","","");
$fetch_countdetails=@mysql_fetch_assoc($count_details);
$smarty->assign("total_rec",$fetch_countdetails["cnt"]);

$getcomments=$dbObj->gj("tbl_comments c,tbl_users u","c.*,u.first_name,u.last_name,u.thumbnail,u.userid as postedby","c.userid=u.userid and c.moduleid=3 and c.itemid=".$_GET['imageid']." ","c.id","","ASC","0,5","");

$c=0;
while($fetch_comments=@mysql_fetch_assoc($getcomments))
{
	$result_arr[$c]=$fetch_comments;
	$result_arr[$c]['comment_time_ago'] = $fetch_comments['date_added'];
	$c++;
}
$smarty->assign("photo_comments",$result_arr);
}
$smarty->assign("albumid",$albumid);
$smarty->assign("imageid",$_GET['imageid']);
#----------------------delete photo-----------------------------------#


if($_GET['act']!="")
{
	
	if($_GET['imageid1']!="" && $_GET['act']=="delete")
	{ 	//delete comments relate to image 
		$delcomments = $dbObj->gdel("tbl_comments", array("itemid","userid"),array($_GET['imageid1'],$_SESSION['csUserId']), "");

		//delete  image 
		 $delphoto = $dbObj->gdel("tbl_albumphotos", array("photo_id","user_id","album_id"), array($_GET['imageid1'],$_SESSION['csUserId'],$_GET['albumid']), "1");
		
	}
	else if($_GET['imageid1']!="" && $_GET['act']=="tag")
	{

		if($_GET['albumid']!="" && $_GET['strcheckuser']!="" && $_GET['xpos']!="" && $_GET['ypos']!="")
		{
			$strcheck=$_GET['strcheckuser'];
			$strxpos=$_GET['xpos'];
			$strypos=$_GET['ypos'];
			 $usercheck=@explode(",",$strcheck);
				$usercheckxpos=@explode(",",$strxpos);
				$usercheckypos=@explode(",",$strypos);
				for($k=0;$k<count($usercheck);$k++)
				{

					$cndget=" photoid=".$_GET['imageid1']." AND userid=".$usercheck[$k];
					$resselecttag=$dbObj->gj("tbl_photo_tag","*",$cndget ,"","","","","");
					$linecheck=@mysql_num_rows($resselecttag);
					if($linecheck>0)
					{
					  //code to all tag user of same photo
						$cndcheckget=" photoid=".$_GET['imageid1'];
						$resselectchecktag=$dbObj->gj("tbl_photo_tag","*",$cndcheckget ,"","","","","1");
						$lineselectchecktag=@mysql_num_rows($resselectchecktag);
						$r=0;
						while($rowcheckselectchecktag=mysql_fetch_assoc($resselectchecktag))
						{
							$arrchecktag[$r]=$rowcheckselectchecktag;$r++;
						}
						//code to get only just now tag friends
						$cndcheckgettag=" photoid=".$_GET['imageid1']." AND userid IN(".$strcheck.")";
						$resselectchecktaged=$dbObj->gj("tbl_photo_tag","*",$cndcheckgettag ,"","","","","1");
						$lineselectchecktaged=@mysql_num_rows($resselectchecktaged);
						$y=0;
						while($rowcheckselectchecktaged=mysql_fetch_assoc($resselectchecktaged))
						{
							$arrchecktaged[$y]=$rowcheckselectchecktaged;$y++;
						}
						
						//flat both the array
						for($p=0;$p<$lineselectchecktag;$p++)
						{
							$arrall[$p]=$arrchecktag[$p]['userid'];
						}
						for($q=0;$q<$lineselectchecktaged;$q++)
						{
							$arrselected[$q]=$arrchecktaged[$q]['userid'];
						}

						$arrdiff=array_diff($arrall,$arrselected);
						foreach($arrdiff as $userchangeid)
						{
							//deltheuser
							$deltaguser=$dbObj->gdel("tbl_photo_tag",array("userid","photoid"),array($userchangeid,$_GET['imageid1']) , "");
							
						}
					}
					else
					{	$sf=array("photoid","userid","taged_by","xposition","yposition","added_date","status");
						$sv=array($_GET['imageid1'],$usercheck[$k],$_SESSION['csUserId'],$usercheckxpos[$k],$usercheckypos[$k],date("Y-m-d H:i:s"),"tag");
						$taginsert=$dbObj->cgi("tbl_photo_tag",$sf,$sv,"");
					}
				}
		       }
	
	       }

}//if
#---------------------------------------------------------------------#
// end for comment
   $smarty->assign("rating",TEMPLATEDIR."/modules/common/rating.tpl");
   $smarty->display(TEMPLATEDIR .'/modules/photos/ajax_show.tpl');	
   $dbObj->Close();
?>
