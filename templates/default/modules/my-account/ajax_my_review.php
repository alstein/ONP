<?php
include_once('../../include.php');
include('../../includes/paging.php');
include_once('../../includes/classes/class.photos.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

function currentPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

$currentpage=$_SERVER["HTTP_REFERER"];
if(strpos($currentpage,"my_profile") && !strpos($currentpage,"my_profile_home")){ 
		$smarty->assign("currentpage","no");	
}else{ 
		$smarty->assign("currentpage","yes");	
}
// print_r($_GET);
$selct_setting1=$dbObj->customqry("select photo_setting,profile_feed_setting,merchant_setting from tbl_users where userid='".$_GET['userid']."'","");
$res_setting1=@mysql_fetch_assoc($selct_setting1);
$profile_feed_setting=$res_setting1['profile_feed_setting'];
$merchant_setting=$res_setting1['merchant_setting'];
$smarty->assign("profile_feed_setting",$profile_feed_setting);
$smarty->assign("merchant_setting",$merchant_setting);

$select_friend_acc=$dbObj->customqry("select count(*) as count_friend_acc from tbl_friends where (userid='".$_GET['userid']."' and friendid='".$_SESSION['csUserId']."') or (userid='".$_SESSION['csUserId']."' and friendid='".$_GET['userid']."')","");
$res_friend_acc=@mysql_fetch_assoc($select_friend_acc);
$smarty->assign("friend_acc",$res_friend_acc);

$select_fan_acc=$dbObj->customqry("select count(*) as count_fan_acc from tbl_fan where (fan_id='".$_GET['userid']."' and userid='".$_SESSION['csUserId']."') ","");
$res_fan_acc=@mysql_fetch_assoc($select_fan_acc);
$smarty->assign("fan_acc",$res_fan_acc);
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

			$adsperpage = 30;
		$StartRow = $adsperpage * ($page-1);
		$l =  $StartRow.','.$adsperpage;
#-------------------------------------------------------------------------------#



$whose_profile="Consumer";
$smarty->assign("whose_profile",$whose_profile);
//   print_r($_GET);
// echo "<br>type=".$_SESSION['csUserTypeId'];
// print_r($_SESSION);
function timediff($time1, $time2) {

  list($h,$m,$s) = explode(":",$time1);
  $t1 = $h * 3600 + $m * 60 + $s;
  list($h2,$m2,$s2) = explode(":",$time2);
  $seconds = ($h2 * 3600 + $m2 * 60 + $s2) - $t1;
  return sprintf("%02d:%02d:%02d",floor($seconds/3600),floor($seconds/60)%60,$seconds % 60);
	
}
//*****************************Find login person is friend or fan ******************************************************//
// echo "type=".$_SESSION['csUserTypeId'];
if($_SESSION['csUserTypeId']=='2')
{

$select_friend_or_not=$dbObj->customqry("select * from tbl_friends where (userid='".$_GET['userid']."' and friendid='".$_SESSION['csUserId']."') or (userid='".$_SESSION['csUserId']."' and friendid='".$_GET['userid']."' and verification='yes')","");
$count_friend_ornot=@mysql_num_rows($select_friend_or_not);
$smarty->assign("count_friend_ornot",$count_friend_ornot);
}
elseif($_SESSION['csUserTypeId']=='3')
{
$select_fan_ornot=$dbObj->customqry("select * from tbl_fan where userid='".$_SESSION['csUserId']."' and fan_id='".$_GET['userid']."'","");
$count_fan_or_not=@mysql_num_rows($select_fan_ornot);
$smarty->assign("count_fan_or_not",$count_fan_or_not);
}
//**********************************************End  Of Find login person is friend or fan**********************************//
// print_r($_GET);
if($_GET['userid']!="" )
{
$ses_user=$_GET['userid'];
}
else
{
$ses_user=$_SESSION['csUserId'];
}

$select_user_details=$dbObj->customqry("select * from tbl_users where userid='".$ses_user."'","");
$res_select_qry=@mysql_fetch_assoc($select_user_details);
$smarty->assign("user",$res_select_qry);


$select_user_friend=$dbObj->customqry("select f.*,u.photo as photo1,u1.photo as photo2 from tbl_friends f left join tbl_users u on f.userid=u.userid  left join tbl_users u1 on f.friendid=u1.userid where f.userid='".$ses_user."' or f.friendid='".$ses_user."' group by f.userid,f.friendid ","");

$i=0;
while($res_select_friend=@mysql_fetch_assoc($select_user_friend))
{

		if($res_select_friend['userid']==$ses_user)
		{
		$friend[$i]['userid']=$res_select_friend['friendid'];
		}
		elseif($res_select_friend['friendid']==$ses_user)
		{
		$friend[$i]['userid']=$res_select_friend['userid'];
		}
		
		if($friend[$i]!=0){
			$arr_friend[]=$friend[$i]['userid'];
		}
$i++;
}
// echo "<br>72634872=";
// print_r($arr_friend);
// echo "<br>";
if($_GET['moduleid']=='merchant_review')
{
		
			$select_activity=$dbObj->customqry("select r.*,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.merchant_id =u.userid  where r.user_id  ='".$_GET['userid']."'  order by rating_id  DESC ","1");
		
			$i=0;
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{
				$activity[]=$res_select_activity;
			
			}
}

if($_GET['moduleid']=='review')
{

	$cafilename=$_GET['photo'];
	$filename=$_GET['newfilename'];
	$cp=explode("/",$cafilename);
	$cpcnt=count($cp);
	$cpfilename=$cp[$cpcnt-1];
	if($cafilename!=""){
		
		

		if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/user/".$cpfilename))
		{
			if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/180X158/".$cpfilename))
			{

		         $original['name'] = $cpfilename;
                        $original['tmp_name'] = "../../uploads/album/180X158/".$cpfilename;


                        $path = "../../uploads/album/180X158/";
                        $width_array  = array(180);
                        $height = 158;
                        $path_array = array($path);
                        resize_multiple_images_new($original, $width_array, $path_array, $height);
			if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/180X158/".$cpfilename))
			{
				 $original['name'] = $cpfilename;
				$original['tmp_name'] = "../../uploads/album/photo/180X158/".$cpfilename;
	
	
				$path = "../../uploads/album/photo/180X158/";
				$width_array  = array(180);
				$height = 158;
				$path_array = array($path);
				resize_multiple_images_new($original, $width_array, $path_array, $height);
				
				if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/400X300/".$cpfilename))
				{
					 $original['name'] = $cpfilename;
					$original['tmp_name'] = "../../uploads/album/photo/400X300/".$cpfilename;
		
		
					$path = "../../uploads/album/photo/400X300/";
					$width_array  = array(400);
					$height = 300;
					$path_array = array($path);
					resize_multiple_images_new($original, $width_array, $path_array, $height);
					if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/600X600/".$cpfilename))
					{
						 $original['name'] = $cpfilename;
						$original['tmp_name'] = "../../uploads/album/photo/600X600/".$cpfilename;
			
			
						$path = "../../uploads/album/photo/600X600/";
						$width_array  = array(600);
						$height = 600;
						$path_array = array($path);
						resize_multiple_images_new($original, $width_array, $path_array, $height);
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/132X101/".$cpfilename))
						{
							 $original['name'] = $cpfilename;
							$original['tmp_name'] = "../../uploads/album/photo/132X101/".$cpfilename;
				
				
							$path = "../../uploads/album/photo/132X101/";
							$width_array  = array(132);
							$height = 101;
							$path_array = array($path);
							resize_multiple_images_new($original, $width_array, $path_array, $height);
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/bigimage/".$cpfilename))
						{
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/bigimage/".$cpfilename))
						{
						@unlink("../../uploads/user/temp/".$cpfilename);
						}
						}
						}
					}
				}
			}
		}
		}
		
	}
	if($_GET['photo']!="")
	{
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$select_album=$dbObj->customqry(" select * from tbl_album where user_id='".$_SESSION["csUserId"]."' and url_title='".$url_title."'","");
	$res_album=@mysql_fetch_assoc($select_album);
	$num_album=@mysql_num_rows($select_album);
	
	if($num_album ==0)
	{
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$sf_arr=array("user_id","album_title","album_description",'thumbnail','privacy ','url_title',"added_date");
	$sv_arr=array($_SESSION["csUserId"],'profile pictures','profile pictures',$cpfilename,'Public',$url_title,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_album",$sf_arr,$sv_arr,"1");
	$album_id=@mysql_insert_id();
	}
	else
	{
	$album_id=$res_album['album_id'];
	}
	$sf_arr=array("user_id","album_id","thumbnail","big_image","added_date");
	$sv_arr=array($_SESSION["csUserId"],$album_id,$cpfilename,$cpfilename,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"1");
	}
		
	if($_GET['txt_thinking']!="")
	{
	$loc_thinking=($_GET['txt_thinking']);
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','".$cpfilename."',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}
	if($_GET['txt_link']!="")
	{
	$loc_thinking=($_GET['txt_link']);
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','link','".$cpfilename."',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}



	if($_GET['userid']!="" )
	{
	$ses_user=$_GET['userid'];
	}
	else
	{
	$ses_user=$_SESSION['csUserId'];
	}

	$select_merchant_fan=$dbObj->customqry("select fan_id  from tbl_fan where userid='".$ses_user."'","");
	$i=0;
	while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
	{
		$merchant_fan[]=$fetch_merchant_fan;
	
		$merchant_fan_arr[]=$merchant_fan[$i]['fan_id'];
	$i++;
	}
		
	 $merchants=@implode(",",$merchant_fan_arr);
		$user=$arr_friend;

	$arr1=@implode(",",array_unique($arr_friend));
	if(count($merchants)==0 && count($arr1)>0)
	{
	$arr=$arr1;
	}
	elseif(count($merchants)>0 && count($arr1)==0)
	{
	$arr=$merchants;
	}
	elseif(count($merchants)>0 && count($arr1)>0)
	{
	$arr=$merchants.",".$arr1;
	}
	$count=count($arr);


			$user=$arr[$j];
			$select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid in('".$arr."') ","");
			$res_select_profile=@mysql_fetch_assoc($select_user_profile);
			$smarty->assign("user_profile",$res_select_profile);
			
			$select_activity=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid ='".$user."' and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid ='".$arr."')  or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or (a.vault_t='buy_deal' and (a.uid ='".$_GET['userid']."' or a.fid='".$_GET['userid']."')))  and a.parent_id='0'  order by msg_id DESC limit $l","");

			$res_all=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in(".$arr.") and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in(".$arr.")  or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or (a.vault_t='buy_deal' and (a.uid ='".$_GET['userid']."' or a.fid='".$_GET['userid']."')))  and a.parent_id='0'  order by msg_id DESC","");
			$i=0;
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{
				$activity[]=$res_select_activity;
 				
				$sel_cheer=$dbObj->customqry("select c.*,u.userid,u.business_name,u.usertypeid,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$res_select_activity['msg_id']."' group by cheer_id","");
				while($res_cheer=@mysql_fetch_assoc($sel_cheer))
				{
				$activity['cheer'][$i][]=$res_cheer;
				}
				$count=	mysql_num_rows($sel_cheer);
				$activity[$i]['count_cheer']=$count;

				$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	activity_id='".$res_select_activity['msg_id']."' and userid='".$_SESSION['csUserId']."'","");
				$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
				$count1=	$res_cheer1['count'];
				$activity[$i]['count_cheer1']=$count1;

				$sel_subcomment=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in(".$arr.") and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in(".$arr."))  or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."')) and a.parent_id='".$res_select_activity['msg_id']."' group by a.msg_id order by a.msg_id ASC ","");
				$count_sub=@mysql_num_rows($sel_subcomment);
				$count_sub1=$count_sub-1;
				$activity[$i]['count_sub']=$count_sub;
				$activity[$i]['count_sub1']=$count_sub1;
				while($res_sel_subcomment=@mysql_fetch_assoc($sel_subcomment))
				{
				$activity['sub'][$i][]=$res_sel_subcomment;
				}
				
				$i++;
			}
$smarty->assign("sub",$activity['sub']);

}
elseif($_GET['moduleid']=='friend')
{
// print_r($_GET);
	$cafilename=$_GET['photo'];
	$filename=$_GET['newfilename'];
	$cp=explode("/",$cafilename);
	$cpcnt=count($cp);
	$cpfilename=$cp[$cpcnt-1];
	if($cafilename!=""){
		
		

		if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/user/".$cpfilename))
		{
			if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/180X158/".$cpfilename))
			{

		         $original['name'] = $cpfilename;
                        $original['tmp_name'] = "../../uploads/album/180X158/".$cpfilename;


                        $path = "../../uploads/album/180X158/";
                        $width_array  = array(180);
                        $height = 158;
                        $path_array = array($path);
                        resize_multiple_images_new($original, $width_array, $path_array, $height);
			if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/180X158/".$cpfilename))
			{
				 $original['name'] = $cpfilename;
				$original['tmp_name'] = "../../uploads/album/photo/180X158/".$cpfilename;
	
	
				$path = "../../uploads/album/photo/180X158/";
				$width_array  = array(180);
				$height = 158;
				$path_array = array($path);
				resize_multiple_images_new($original, $width_array, $path_array, $height);
				
				if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/400X300/".$cpfilename))
				{
					 $original['name'] = $cpfilename;
					$original['tmp_name'] = "../../uploads/album/photo/400X300/".$cpfilename;
		
		
					$path = "../../uploads/album/photo/400X300/";
					$width_array  = array(400);
					$height = 300;
					$path_array = array($path);
					resize_multiple_images_new($original, $width_array, $path_array, $height);
					if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/600X600/".$cpfilename))
					{
						 $original['name'] = $cpfilename;
						$original['tmp_name'] = "../../uploads/album/photo/600X600/".$cpfilename;
			
			
						$path = "../../uploads/album/photo/600X600/";
						$width_array  = array(600);
						$height = 600;
						$path_array = array($path);
						resize_multiple_images_new($original, $width_array, $path_array, $height);
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/132X101/".$cpfilename))
						{
							 $original['name'] = $cpfilename;
							$original['tmp_name'] = "../../uploads/album/photo/132X101/".$cpfilename;
				
				
							$path = "../../uploads/album/photo/132X101/";
							$width_array  = array(132);
							$height = 101;
							$path_array = array($path);
							resize_multiple_images_new($original, $width_array, $path_array, $height);
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/bigimage/".$cpfilename))
						{
						if(@copy(SITEROOT."/uploads/user/temp/".$cpfilename,"../../uploads/album/photo/bigimage/".$cpfilename))
						{
						@unlink("../../uploads/user/temp/".$cpfilename);
						}
						}
						}
					}
				}
			}
		}
		}
		
	}
	if($_GET['photo']!="")
	{
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$select_album=$dbObj->customqry(" select * from tbl_album where user_id='".$_SESSION["csUserId"]."' and url_title='".$url_title."'","");
	$res_album=@mysql_fetch_assoc($select_album);
	$num_album=@mysql_num_rows($select_album);
	
	if($num_album ==0)
	{
	$url_title=profile-pictures."-".$_SESSION["csUserId"];
	$sf_arr=array("user_id","album_title","album_description",'thumbnail','privacy ','url_title',"added_date");
	$sv_arr=array($_SESSION["csUserId"],'profile pictures','profile pictures',$cpfilename,'Public',$url_title,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_album",$sf_arr,$sv_arr,"1");
	$album_id=@mysql_insert_id();
	}
	else
	{
	$album_id=$res_album['album_id'];
	}
	$sf_arr=array("user_id","album_id","thumbnail","big_image","added_date");
	$sv_arr=array($_SESSION["csUserId"],$album_id,$cpfilename,$cpfilename,date("Y-m-d H:i:s"));
	$insert_details=$dbObj->cgi("tbl_albumphotos",$sf_arr,$sv_arr,"1");
	}
		
	if($_GET['txt_thinking']!="")
	{
	$loc_thinking=($_GET['txt_thinking']);
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','".$cpfilename."',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}
	if($_GET['txt_link']!="")
	{
	$loc_thinking=($_GET['txt_link']);
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','link','".$cpfilename."',Now(),'1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}
// 	$user=$arr_friend;
// 	$arr=@implode(",",$arr_friend);
// 	$count=count($arr);
// 
// 	for($j=0;$j<$count;$j++)
// 	{
if($_GET['userid']!="" )
{
$ses_user=$_GET['userid'];
}
else
{
$ses_user=$_SESSION['csUserId'];
}
		
	$select_merchant_fan=$dbObj->customqry("select userid from tbl_fan where fan_id='".$ses_user."'","");
	$i=0;
	while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
	{
		$merchant_fan[]=$fetch_merchant_fan;
	
		$merchant_fan_arr[]=$merchant_fan[$i]['userid'];
	$i++;
	}
// 	 $merchants=@implode(",",$merchant_fan_arr);
		$user=$arr_friend;

	$select_cat_preferance=$dbObj->customqry("select * from tbl_users where userid='".$ses_user."'","");
	$res_cat_preferance=@mysql_fetch_assoc($select_cat_preferance);
	$category_preferance=$res_cat_preferance['category_preferance'];
	
	$sel_other_merchant=$dbObj->customqry("select * from tbl_users where deal_cat in(".$category_preferance.") and  usertypeid='3'","");
	$i=0;
	while($res_other_merchant=@mysql_fetch_assoc($sel_other_merchant))
	{
		$merchant_other[]=$res_other_merchant;
		$merchant_other_arr[]=$merchant_other[$i]['userid'];
	$i++;
	}
	
	if(count($merchant_fan_arr)>0)
	{
	$merge_result = @array_merge($merchant_fan_arr,$merchant_other_arr);
	$unique_array = @array_unique($merge_result);
	$implode_array=@implode(",",$unique_array);
	}
	else
	{
	$unique_array = @array_unique($merchant_other_arr);
	$implode_array=@implode(",",$unique_array);
	}


	$arr1=@implode(",",array_unique($arr_friend));
	if(count($implode_array)==0 && count($arr1)>0)
	{
	$arr=$arr1;
	}
	elseif(count($implode_array)>0 && count($arr1)==0)
	{
	$arr=$implode_array;
	}
	elseif(count($implode_array)>0 && count($arr1)>0)
	{
	$arr=$implode_array.",".$arr1;
	}
	$count=count($arr);

			$user=$arr[$j];
			$select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid in(".$arr.") ","");
			$res_select_profile=@mysql_fetch_assoc($select_user_profile);
			$smarty->assign("user_profile",$res_select_profile);
			
// 			$select_activity=$dbObj->customqry("select a.*,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in('".$arr."') and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in('".$arr."')) or (a.uid='".$_GET['userid']."' and a.fid='".$_GET['userid']."') ) and a.parent_id='0'  order by msg_id DESC ","");
// 			echo "<br>cnt_merchant=".count($merchants);
// 			echo "<br>cnt_arr=".count($arr1);
			if(count($implode_array)>0 || count($arr1)>0)
			{
			$select_activity=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in($arr) and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in($arr)) or (a.uid in($arr) and a.fid in($arr)) or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or (a.vault_t='buy_deal' and (a.uid ='".$_GET['userid']."' or a.fid='".$_GET['userid']."'))) and a.parent_id='0' order by msg_id DESC limit $l","");

			$res_all=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in($arr) and a.fid='".$_GET['userid']."') or (a.uid='".$_GET['userid']."' and  a.fid in($arr)) or (a.uid in($arr) and a.fid in($arr)) or (a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or (a.vault_t='buy_deal' and (a.uid ='".$_GET['userid']."' or a.fid='".$_GET['userid']."'))) and a.parent_id='0' order by msg_id DESC","");
			}	
			else
			{
			$select_activity=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where (a.uid='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or  a.uid='".$_GET['userid']."' or a.fid='".$_GET['userid']."' and a.parent_id='0' order by msg_id DESC limit $l","");

			$res_all=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where (a.uid='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or  a.uid='".$_GET['userid']."' or a.fid='".$_GET['userid']."' and a.parent_id='0' order by msg_id DESC limit $l","");
			}
			$i=0;
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{

				$activity[]=$res_select_activity;
			
				$sel_cheer=$dbObj->customqry("select c.*,u.userid,u.business_name,u.usertypeid,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$res_select_activity['msg_id']."' group by cheer_id","");
				while($res_cheer=@mysql_fetch_assoc($sel_cheer))
				{
				$activity['cheer'][$i][]=$res_cheer;
				}
				$count=	mysql_num_rows($sel_cheer);
				$activity[$i]['count_cheer']=$count;

				$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	activity_id='".$res_select_activity['msg_id']."' and userid='".$_SESSION['csUserId']."'","");
				$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
				$count1=	$res_cheer1['count'];
				$activity[$i]['count_cheer1']=$count1;

				$sel_subcomment=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in ($arr) or a.fid in($arr)) or (a.uid='".$_GET['userid']."' and a.fid='".$_GET['userid']."')) and a.parent_id=".$res_select_activity['msg_id']." order by msg_id ASC","");
				$count_sub=@mysql_num_rows($sel_subcomment);
				$activity[$i]['count_sub']=$count_sub;
				while($res_sel_subcomment=@mysql_fetch_assoc($sel_subcomment))
				{
				$activity['sub'][$i][]=$res_sel_subcomment;
				}
				$i++;
				
				// echo "<pre>";print_r($activity['0']);echo "</pre>";exit;
			}
$smarty->assign("sub",$activity['sub']);

// 	}
 }
elseif($_GET['moduleid']=='favlocalbusiness')
{

		

	if($_GET['userid']!="" )
	{
	$user=$_GET['userid'];
	}
	else
	{
	$user=$_SESSION['csUserId'];
	}

	$select_merchant_fan=$dbObj->customqry("select userid from tbl_fan where fan_id='".$user."'","");
	$i=0;
	while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
	{
		$merchant_fan[]=$fetch_merchant_fan;
	
		$merchant_fan_arr[]=$merchant_fan[$i]['userid'];
	$i++;
	}
	 $merchants=@implode(",",$merchant_fan_arr);


			$select_activity=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in ($merchants)) and (a.fid in (".$merchants."))) and  a.parent_id='0' order by a.msg_id DESC limit $l","");

			$res_all=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where ((a.uid in ($merchants)) and (a.fid in (".$merchants."))) and  a.parent_id='0' order by a.msg_id DESC","");

			$i=0;
			
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{

				$activity[]=$res_select_activity;
				$sel_cheer=$dbObj->customqry("select c.*,u.business_name,u.usertypeid,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$res_select_activity['msg_id']."' group by cheer_id","");
				while($res_cheer=@mysql_fetch_assoc($sel_cheer))
				{
				$activity['cheer'][$i][]=$res_cheer;
				}
				$count=	mysql_num_rows($sel_cheer);
				$activity[$i]['count_cheer']=$count;

				$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	activity_id='".$res_select_activity['msg_id']."' and userid='".$_SESSION['csUserId']."'","");
				$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
				$count1=	$res_cheer1['count'];
				$activity[$i]['count_cheer1']=$count1;

				$sel_subcomment=$dbObj->customqry("select a.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where  a.parent_id=".$res_select_activity['msg_id']." order by msg_id ASC","");
				$count_sub=@mysql_num_rows($sel_subcomment);
				$activity[$i]['count_sub']=$count_sub;
				while($res_sel_subcomment=@mysql_fetch_assoc($sel_subcomment))
				{
				$activity['sub'][$i][]=$res_sel_subcomment;
				}
				$i++;
				
				// echo "<pre>";print_r($activity['0']);echo "</pre>";exit;
			}
$smarty->assign("sub",$activity['sub']);


}


elseif($_GET['moduleid']=='dealsasusual')
{

	if($_GET['userid']!="" )
	{
	$user=$_GET['userid'];
	}
	else
	{
	$user=$_SESSION['csUserId'];
	}

$select_merchant_fan=$dbObj->customqry("select userid from tbl_fan where fan_id='".$user."'","");
$i=0;
while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
{
	$merchant_fan[]=$fetch_merchant_fan;
	
// 	if($i==0)
// 	{
// 	$merchant_fan_arr[]=$merchant_fan[0]['userid'];
// 	}
	$merchant_fan_arr[]=$merchant_fan[$i]['userid'];
$i++;
}

$select_cat_preferance=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$res_cat_preferance=@mysql_fetch_assoc($select_cat_preferance);
$category_preferance=$res_cat_preferance['category_preferance'];

$sel_other_merchant=$dbObj->customqry("select * from tbl_users where deal_cat in(".$category_preferance.") and  usertypeid='3'","");
$i=0;
while($res_other_merchant=@mysql_fetch_assoc($sel_other_merchant))
{
	$merchant_other[]=$res_other_merchant;
	$merchant_other_arr[]=$merchant_other[$i]['userid'];
$i++;
}

if(count($merchant_fan_arr)>0)
{
$merge_result = @array_merge($merchant_fan_arr,$merchant_other_arr);
$unique_array = @array_unique($merge_result);
$implode_array=@implode(",",$unique_array);
}
else
{
$unique_array = @array_unique($merchant_other_arr);
$implode_array=@implode(",",$unique_array);
}

//temp
// 	echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
// 	echo "1 array";
// 	print_r($merchant_fan_arr); echo "<br>";
// 	echo "2 array";
// 	print_r($merchant_other_arr); echo "<br>";
// 	echo "unique array";
// 	print_r($unique_array); echo "<br>";
// 	echo "implode array";
// 	echo $implode_array; echo "<br>";
//temp

$cnt_implode1=count($implode_array);	
$smarty->assign("cnt_implode1",$cnt_implode1);
	if($cnt_implode1 > 0)
	{
	$cnd="d.merchant_id in(".$implode_array.") and d.deal_category='deal_as_usual'";


	$select_merchant = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id left join mast_deal_category c on u.deal_cat=c.id ","d.*,u.business_name,u.userid,m.city_name,c.category", $cnd, "", "", "", $l, "");//main
	$res_all = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id  left join mast_deal_category c on u.deal_cat=c.id","d.*,u.business_name,u.userid,m.city_name,c.category", $cnd, "", "", "", $l, "");//main
$i=0;
	while($select_merchant_deal=@mysql_fetch_assoc($select_merchant))
	{	
		$deal[]=$select_merchant_deal;
		$user=$arr_friend;
		$arr=@explode(",",$arr_friend);
		$count=count($arr);
		
	//rating

		$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$select_merchant_deal['userid']."'","");
		$res_rating1=@mysql_fetch_assoc($select_rating1);
		$count1=$res_rating1['count'];
		$sum_rating1=$res_rating1['sum_rating'];
		$average_rating1=@($sum_rating1/$count1);
		$deal[$i]['rating']=$average_rating1;


	//rating
	
	$sel_cheer=$dbObj->customqry("select c.*,u.business_name,u.usertypeid,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.deal_id='".$select_merchant_deal['deal_unique_id']."' group by cheer_id","");
	while($res_cheer=@mysql_fetch_assoc($sel_cheer))
	{
	$deal['cheer'][$i][]=$res_cheer;
	}
	$count=	@mysql_num_rows($sel_cheer);
	$deal[$i]['count_cheer']=$count;

	$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	deal_id='".$select_merchant_deal['deal_unique_id']."' and userid='".$_SESSION['csUserId']."'","");
	$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
	$count1=	$res_cheer1['count'];
	$deal[$i]['count_cheer1']=$count1;
		
			$deal_subcomment=$dbObj->customqry("select d.deal_title, a.*,u.userid,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_deals d on a.deal_id=d.deal_unique_id  where  a.deal_id='".$select_merchant_deal['deal_unique_id']."' order by msg_id ASC","");
			$count_sub=@mysql_num_rows($deal_subcomment);
			$deal[$i]['count_sub']=$count_sub;
			while($res_deal_subcomment=@mysql_fetch_assoc($deal_subcomment))
			{
			$dealsubcomment[]=$res_deal_subcomment;
			}
		
	$i++;	
	}
	}
	$smarty->assign("dealsubcomment",$dealsubcomment);

}
elseif( $_GET['moduleid']=='rightnowdeal')
{

	if($_GET['userid']!="" )
	{
	$user=$_GET['userid'];
	}
	else
	{
	$user=$_SESSION['csUserId'];
	}

$select_merchant_fan=$dbObj->customqry("select userid from tbl_fan where fan_id='".$user."'","");
$i=0;
while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
{
	$merchant_fan[]=$fetch_merchant_fan;
	
// 	if($i==0)
// 	{
// 	$merchant_fan_arr[]=$merchant_fan[0]['userid'];
// 	}
	$merchant_fan_arr[]=$merchant_fan[$i]['userid'];
$i++;
}

$select_cat_preferance=$dbObj->customqry("select * from tbl_users where userid='".$user."'","");
$res_cat_preferance=@mysql_fetch_assoc($select_cat_preferance);
$category_preferance=$res_cat_preferance['category_preferance'];

$sel_other_merchant=$dbObj->customqry("select * from tbl_users where deal_cat in(".$category_preferance.") and  usertypeid='3'","");
$i=0;
while($res_other_merchant=@mysql_fetch_assoc($sel_other_merchant))
{
	$merchant_other[]=$res_other_merchant;
	
// 	if($i==0)
// 	{
// 		$merchant_other_arr[]=$merchant_other[0]['userid'];
// 	}
	$merchant_other_arr[]=$merchant_other[$i]['userid'];
$i++;
}

if(count($merchant_fan_arr)>0)
{
$merge_result = @array_merge($merchant_fan_arr,$merchant_other_arr);
$unique_array = @array_unique($merge_result);
$implode_array=@implode(",",$unique_array);
}
else
{
$unique_array = @array_unique($merchant_other_arr);
$implode_array=@implode(",",$unique_array);
}
//temp
// 	echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
// 	echo "1 array";
// 	print_r($merchant_fan_arr); echo "<br>";
// 	echo "2 array";
// 	print_r($merchant_other_arr); echo "<br>";
// 	echo "unique array";
// 	print_r($unique_array); echo "<br>";
// 	echo "implode array";
// 	echo $implode_array; echo "<br>";
//temp

	
	$cnt_implode1=count($implode_array);	
	$smarty->assign("cnt_implode1",$cnt_implode1);
	if($cnt_implode1 > 0)
	{
	$cnd="d.merchant_id in(".$implode_array.") and d.deal_category='right_now_deal'";


	$select_merchant = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id ","d.*,u.business_name,u.userid,m.city_name", $cnd, "", "", "", $l, "");//main
	$res_all = $dbObj->gj("tbl_deals d left join tbl_users u on d.merchant_id=u.userid left join mast_city m on u.city=m.city_id ","d.*,u.business_name,u.userid,m.city_name", $cnd, "", "", "", $l, "");//main
	$i=0;
	while($select_merchant_deal=@mysql_fetch_assoc($select_merchant))
	{	
		$deal[]=$select_merchant_deal;
		$user=$arr_friend;
		$arr=@explode(",",$arr_friend);
		$count=count($arr);
		
	$sel_cheer=$dbObj->customqry("select c.*,u.userid,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.usertypeid,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.deal_id='".$select_merchant_deal['deal_unique_id']."' group by cheer_id","");
	while($res_cheer=@mysql_fetch_assoc($sel_cheer))
	{
	$deal['cheer'][$i][]=$res_cheer;
	}
	$count=	@mysql_num_rows($sel_cheer);
	$deal[$i]['count_cheer']=$count;

	$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	deal_id='".$select_merchant_deal['deal_unique_id']."' and userid='".$_SESSION['csUserId']."'","");
	$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
	$count1=	$res_cheer1['count'];
	$deal[$i]['count_cheer1']=$count1;
		
			$deal_subcomment=$dbObj->customqry("select d.deal_title, a.*,u.userid,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_deals d on a.deal_id=d.deal_unique_id  where  a.deal_id='".$select_merchant_deal['deal_unique_id']."' order by msg_id ASC","");
			$count_sub=@mysql_num_rows($deal_subcomment);
			$deal[$i]['count_sub']=$count_sub;
			while($res_deal_subcomment=@mysql_fetch_assoc($deal_subcomment))
			{
			$dealsubcomment[]=$res_deal_subcomment;
			}
		
	$i++;	
	}
	}
	$smarty->assign("dealsubcomment",$dealsubcomment);
	
}

	
	$smarty->assign("cheer1",$deal['cheer']);
	$smarty->assign("cheer",$activity['cheer']);
	$smarty->assign("deal",$deal);
	$smarty->assign("user_subactivity",$subactivity);
	$smarty->assign("user_activity",$activity);
	$count=@mysql_num_rows($select_activity);
	//$smarty->assign("sub",$activity['sub'])

for($i=0;$i<=$count;$i++)
{

	if(isset($_POST['submit_share'][$i]))
	{
		
		$id=$_POST['txt_id'][$i];
		if($_GET['id1']!="")
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','',Now(),'1','".$_SESSION['csUserId']."','".$_GET['id1']."','".$id."') ","");
		}
		else
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','',Now(),'1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','".$id."') ","");
		}	
	}
}

/*----------Pagination Part-2-------------------------------------------------------*/

		$nums = @mysql_num_rows($res_all);
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

#----------------------delete photo-----------------------------------#


$smarty->display(TEMPLATEDIR . '/modules/my-account/ajax_my_review.tpl');
$dbObj->Close();


?>