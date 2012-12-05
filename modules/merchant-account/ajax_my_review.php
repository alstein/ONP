<?php
include_once('../../include.php');
include('../../includes/paging.php');

#------------Pagination Part-1--------------------------------

/*********************************************************************************/
	$sqlre="SELECT * FROM tbl_rating WHERE user_id=".$_SESSION['csUserId']." AND merchant_id=".$_GET['merchantid']." ";
	$retres = $dbObj->customqry($sqlre, "");
	$numrets=@mysql_num_rows($retres);
	
	$smarty->assign("numrets",$numrets);
	

if($_POST['Submit_review']) 
{
	extract($_POST);
	$char=substr($fan_ratesel_,1,1);
	$merchantid=$_GET['merchantid'];
	$date=date("Y-m-d H:m:s");
	$prn = "";
        $rewards=0;
        $flag=1;
	$f = array("merchant_id", "user_id", "feedback","summary", "average_rating", "rating_date");
	$v = array($merchantid,$_SESSION['csUserId'],$dtlss,$summary,$char, $date);
	$res = $dbObj ->cgi('tbl_rating' , $f , $v , $prn);
        //.....................adding reward points..............................//
        
        
	$select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=".$flag,"");
        $rsltset=@mysql_fetch_assoc($select);
        
        $select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=4","");
        $total=@mysql_fetch_assoc($select);
        
        if($rsltset['reward']!=""){
            
            
            $rewards=$rsltset['reward']+5;
            $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=".$flag,"");
            $rsltset=@mysql_fetch_assoc($select);
        }
        else{
            $rewards=5;
            $variables = array("userid", "rewardpoints","flag");
            $datava = array($_SESSION['csUserId'],$rewards,$flag);
            $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
        }
 
      if($total['reward']!=""){
                $rewards=$total['reward']+5;
                $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=4","");
                $rsltset=@mysql_fetch_assoc($select);
      }
      
      else{
          $rewards= 5;
          $variables = array("userid", "rewardpoints","flag");
          $datava = array($_SESSION['csUserId'],$rewards,4);
          $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
      }
        
        
        
	$mar_name=$dbObj->cgs("tbl_users","*","userid","$merchantid","","","");
	$mar_fetch=@mysql_fetch_assoc($mar_name);
	$mar_fetch['business_name'];
	$mast_id =$dbObj->cgs("mast_emails","*","emailid","85","","","");
	$mast_mail = @mysql_fetch_object($mast_id);
			
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $mast_mail->subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message  = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($mast_mail->message),$email_message);
			
		   $email_message = str_replace("[[Merchant_name]]",$mar_fetch['business_name'],$email_message);
			$email_message = str_replace("[[Name]]",$_SESSION['csFullName'],$email_message);
		
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[TODAYS_DATE]]",$today,$email_message);
			
			//$email_message = str_replace("[[fname]]",$user1['first_name'],$email_message);
			$email_message = str_replace("[[email]]",$mar_fetch['email'],$email_message);
			//$email_message = str_replace("[[password]]",$pass,$email_message);
			//echo $email_message;

			$email = $mar_fetch['email'];
			$from = SITE_EMAIL;
			@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			$_SESSION['msg_succ']="Your Review message has been sent to the marchant email account.";
// 			echo "email==".$email;
// 			echo "<br>subjects==".$email_subject;
// 			echo $email_message;exit;
	           
                   
	?>
		<script type="text/javascript" language="javascript">
			window.parent.location.reload();
		</script>

	<?php

    
}



/***************************************************************************************/



// echo "<br>";
// print_r($_SESSION);
// print_r($_GET);
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


if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
$whose_profile="Consumer";
$smarty->assign("whose_profile",$whose_profile);
function timediff($time1, $time2) {
  list($h,$m,$s) = explode(":",$time1);
  $t1 = $h * 3600 + $m * 60 + $s;
  list($h2,$m2,$s2) = explode(":",$time2);
  $seconds = ($h2 * 3600 + $m2 * 60 + $s2) - $t1;
  return sprintf("%02d:%02d:%02d",floor($seconds/3600),floor($seconds/60)%60,$seconds % 60);
}
// print_r($_GET);
//**********************************************Find login person is  fan of consumer ******************//
if($_SESSION['csUserTypeId']=='2')
{
$select_fan_ornot=$dbObj->customqry("select * from tbl_fan where userid='".$_GET['userid']."' and fan_id='".$_SESSION['csUserId']."'","");
$count_fan_or_not=@mysql_num_rows($select_fan_ornot);
$smarty->assign("count_fan_or_not",$count_fan_or_not);
}
//***********************************************End of Find login person is  fan of consumer*************************//
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
		$friend[$i]=$res_select_friend['friendid'];
		}
		elseif($res_select_friend['friendid']==$ses_user)
		{
		$friend[$i]=$res_select_friend['userid'];
		}

		if($friend[$i]!=0){
			$arr_friend[]=$friend[$i];
		}
		
		//$arr_friend=$arr_friend.",".$friend[$i];
		$i++;

}

//echo "<===";print_r($arr_friend);echo "===>";exit;


$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$smarty->assign('config', $config);
if($_GET['moduleid']=='review')
{
		if($_GET['status']=='new')
		{
		$select_activity=$dbObj->customqry("select r.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$_GET['userid']."'  order by rating_id  DESC limit $l","");

		$res_all=$dbObj->customqry("select r.*,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$_GET['userid']."'  order by rating_id  DESC","");
		}
		else
		{
			$select_activity=$dbObj->customqry("select r.*,u.userid,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$_GET['userid']."'  order by rating_id  DESC limit $l","");

			$res_all=$dbObj->customqry("select r.*,u.business_name,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_rating r left join tbl_users u on r.user_id =u.userid  where r.merchant_id ='".$_GET['userid']."'  order by rating_id  DESC ","");
		}



			$i=0;
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{
				$activity[]=$res_select_activity;
				$sel_cheer=$dbObj->customqry("select c.*,u.business_name,u.usertypeid,u.first_name,u.last_name from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$res_select_activity['msg_id']."' group by cheer_id","");
				while($res_cheer=@mysql_fetch_assoc($sel_cheer))
				{
				$activity['cheer'][$i][]=$res_cheer;
				}
				$count=	mysql_num_rows($sel_cheer);
				$activity[$i]['count_cheer']=$count;

				$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	activity_id='".$res_select_activity['msg_id']."' and userid='".$_SESSION['csUserId']."'","");
				$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
				$count1=$res_cheer1['count'];
				$activity[$i]['count_cheer1']=$count1;
				$review_subcomment=$dbObj->customqry("select a.*,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where  a.review_id='".$res_select_activity['rating_id']."' order by msg_id ASC","");
				$count_sub=@mysql_num_rows($review_subcomment);
				$activity[$i]['count_sub']=$count_sub;
				$count_sub1=$count_sub-1;
				$activity[$i]['count_sub1']=$count_sub1;
				$j=0;
				while($res_review_subcomment=@mysql_fetch_assoc($review_subcomment))
				{
				$activity['sub'][$i][]=$res_review_subcomment;
				$activity['sub'][$i][$j]['timestamp']=getunfiddenhours($res_review_subcomment['timestamp']);
				$j++;
// 				$reviewsubcomment[]=$res_review_subcomment;
				}
		$i++;
			
			}
$smarty->assign("reviewsubcomment",$activity['sub']);
// $smarty->assign("reviewsubcomment",$reviewsubcomment);
}

elseif($_GET['moduleid']=='friend')
{
if($_GET['userid']!="" )
{
$ses_user=$_GET['userid'];
}
else
{
$ses_user=$_SESSION['csUserId'];
}



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
	$loc_thinking=$dbObj->sanitize(($_GET['txt_thinking']));
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','".$cpfilename."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}
	if($_GET['txt_link']!="")
	{
	$loc_thinking=($_GET['txt_link']);
	$timestamp=date("Y-m-d H:i:s");
	$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','link','".$cpfilename."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","");
	}

	$user=$arr_friend;

	$arr=@implode(",",$arr_friend);
	$count=count($arr);

if($_GET['userid']!="" )
{
$ses_user=$_GET['userid'];
}
else
{
$ses_user=$_SESSION['csUserId'];
}
$select_merchant_fan=$dbObj->customqry("select fan_id from tbl_fan where userid='".$ses_user."'","");
	$i=0;
	while($fetch_merchant_fan=@mysql_fetch_assoc($select_merchant_fan))
	{
		$merchant_fan[]=$fetch_merchant_fan;
	
		$merchant_fan_arr[]=$merchant_fan[$i]['fan_id'];
	$i++;
	}
// 	print_r($merchant_fan_arr);
 $merchants=@implode(",",$merchant_fan_arr);

// or a.uid ='".$merchants."' or a.fid='".$merchants."'
// or a.uid ='".$merchants."' or a.fid='".$merchants."'

	//for($j=1;$j<$count;$j++)
	//{
			//$user=$arr[$j];
			$select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid in('".$arr."') ","");
			$res_select_profile=@mysql_fetch_assoc($select_user_profile);
			$smarty->assign("user_profile",$res_select_profile);

			//$select_activity=$dbObj->customqry("select a.*,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo,u1.first_name as fname,u1.last_name as lname,u1.business_name as bname,u1.usertypeid as utypeid from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid  where ((a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or a.uid ='".$_GET['userid']."' or  a.fid='".$_GET['userid']."' or a.uid ='".$merchants."' or a.fid='".$merchants."') and a.parent_id='0' and a.vault_t!='buy_deal' order by msg_id DESC limit $l","");


$select_activity=$dbObj->customqry("select a.*,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo,u1.first_name as fname,u1.last_name as lname,u1.business_name as bname,u1.usertypeid as utypeid from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid  where ((a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."' || a.uid ='".$_SESSION['csUserId']."' and a.fid='".$_GET['userid']."')) and a.parent_id='0' and a.vault_t!='buy_deal' order by msg_id DESC limit $l","");

		
		//	$res_all=$dbObj->customqry("select a.*,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo,u1.first_name as fname,u1.last_name as lname,u1.business_name as bname,u1.usertypeid as utypeid from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid where ((a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."') or a.uid ='".$_GET['userid']."' or  a.fid='".$_GET['userid']."' or a.uid ='".$merchants."' or a.fid='".$merchants."') and a.parent_id='0' and a.vault_t!='buy_deal'  order by msg_id DESC ","");

	$res_all=$dbObj->customqry("select a.*,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name,u.photo,u1.first_name as fname,u1.last_name as lname,u1.business_name as bname,u1.usertypeid as utypeid from tbl_activity a left join tbl_users u on a.uid=u.userid left join tbl_users u1 on a.fid=u1.userid where ((a.uid ='".$_GET['userid']."' and a.fid='".$_GET['userid']."' || a.uid ='".$_SESSION['csUserId']."' and a.fid='".$_GET['userid']."')) and a.parent_id='0' and a.vault_t!='buy_deal'  order by msg_id DESC ","");


			$i=0;
			while($res_select_activity=@mysql_fetch_assoc($select_activity))
			{
				$activity[]=$res_select_activity;
				$activity[$i]['timestamp']=getunfiddenhours($res_select_activity['timestamp']);
				$sel_cheer=$dbObj->customqry("select c.*,u.business_name,u.usertypeid,u.userid,u.first_name,u.last_name from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.activity_id='".$res_select_activity['msg_id']."' group by cheer_id","");
				while($res_cheer=@mysql_fetch_assoc($sel_cheer))
				{
				$activity['cheer'][$i][]=$res_cheer;
				}
				$count=	@mysql_num_rows($sel_cheer);
				$activity[$i]['count_cheer']=$count;

				$sel_cheer1=$dbObj->customqry("select count(*) as count from tbl_cheers where 	activity_id='".$res_select_activity['msg_id']."' and userid='".$_SESSION['csUserId']."'","");
				$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
				$count1=$res_cheer1['count'];
				$activity[$i]['count_cheer1']=$count1;

				$sel_subcomment=$dbObj->customqry("select a.*,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where a.parent_id='".$res_select_activity['msg_id']."' order by msg_id ASC","");
				$count_sub=@mysql_num_rows($sel_subcomment);
				$activity[$i]['count_sub']=$count_sub;
				$count_sub1=$count_sub-1;
				$activity[$i]['count_sub1']=$count_sub1;
				$j=0;
				while($res_sel_subcomment=@mysql_fetch_assoc($sel_subcomment))
				{
				$activity['sub'][$i][]=$res_sel_subcomment;
				$activity['sub'][$i][$j]['timestamp']=getunfiddenhours($res_sel_subcomment['timestamp']);
// 				$subactivity[]=$res_sel_subcomment;
				$j++;
				}
				$i++;
				
				
			}
//echo "<pre>";print_r($activity);echo "</pre>";
	//}
 }



elseif($_GET['moduleid']=='dealsasusual' || $_GET['moduleid']=='rightnowdeal')
{
	
	if($_GET['userid']!="" )
	{
	$user=$_GET['userid'];
	}
	else
	{
	$user=$_SESSION['csUserId'];
	}
	if($_GET['moduleid']=='dealsasusual')
	{
		$deal_type='deal_as_usual';
	}
	else
	{
		$deal_type='right_now_deal';
	}
	$cnd="merchant_id='".$user."'and d.deal_category='".$deal_type."'";
	

	//$select_merchant = $dbObj->gj("tbl_users u left join tbl_deals d on u.userid=d.merchant_id ","u.business_name,u.usertypeid,u.userid,d.*", $cnd, "", "", "", $l, "");
	//$res_all = $dbObj->gj("tbl_users u left join tbl_deals d on u.userid=d.merchant_id ","u.business_name,u.usertypeid,u.userid,d.*", $cnd, "", "", "", "", "");

$select_merchant = $dbObj->gj("tbl_users u left join tbl_deals d on u.userid=d.merchant_id left join mast_deal_category c on u.deal_cat=c.id","u.business_name,u.usertypeid,u.userid,d.*,c.category,c.id", $cnd, "d.deal_unique_id", "", "desc", $l, "");

$res_all = $dbObj->gj("tbl_users u left join tbl_deals d on u.userid=d.merchant_id left join mast_deal_category c on u.deal_cat=c.id","u.business_name,u.usertypeid,u.userid,d.*,c.category,c.id", $cnd, "d.deal_unique_id", "", "desc", "", "");

$i=0;
	while($select_merchant_deal=@mysql_fetch_assoc($select_merchant))
	{	
		$deal[]=$select_merchant_deal;
		$user=$arr_friend;
		$arr=explode(",",$arr_friend);
		$count=count($arr);

//rating

		$select_rating1=$dbObj->customqry("select *,count(rating_id)  as count,sum(average_rating) as sum_rating from tbl_rating where merchant_id ='".$select_merchant_deal['userid']."'","");
		$res_rating1=@mysql_fetch_assoc($select_rating1);
		$count1=$res_rating1['count'];
		$sum_rating1=$res_rating1['sum_rating'];
		$average_rating1=@($sum_rating1/$count1);
		$deal[$i]['rating']=$average_rating1;


//rating


		$sel_cheer=$dbObj->customqry("select c.*,u.business_name,u.usertypeid,u.first_name,u.last_name,u.fullname from tbl_cheers c left join tbl_users u on c.userid=u.userid  where c.deal_id='".$select_merchant_deal['deal_unique_id']."' group by cheer_id","");
		while($res_cheer=@mysql_fetch_assoc($sel_cheer))
		{
		$deal['cheer'][$i][]=$res_cheer;
		}
		$count=	@mysql_num_rows($sel_cheer);
		$deal[$i]['count_cheer']=$count;
	
		$sel_cheer1=$dbObj->customqry("select count(cheer_id) as count from tbl_cheers where 	deal_id='".$select_merchant_deal['deal_unique_id']."' and userid='".$_SESSION['csUserId']."'","");
		$res_cheer1=@mysql_fetch_assoc($sel_cheer1);
		$count1=	$res_cheer1['count'];
		$deal[$i]['count_cheer1']=$count1;

			$deal_subcomment=$dbObj->customqry("select a.*,u.business_name,u.userid,u.usertypeid,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where  a.deal_id='".$select_merchant_deal['deal_unique_id']."' order by msg_id ASC","");
			$count_sub=@mysql_num_rows($deal_subcomment);
			$deal[$i]['count_sub']=$count_sub;
			$count_sub1=$count_sub-1;
			$deal[$i]['count_sub1']=$count_sub1;
			while($res_deal_subcomment=@mysql_fetch_assoc($deal_subcomment))
			{
			$dealsubcomment[]=$res_deal_subcomment;
			}
		
	$i++;	
	}
	
	$smarty->assign("dealsubcomment",$dealsubcomment);
}
	$smarty->assign("cheer1",$deal['cheer']);
	$smarty->assign("cheer",$activity['cheer']);
	$smarty->assign("deal",$deal);


// 	$smarty->assign("user_subactivity",$subactivity);
$smarty->assign("user_subactivity",$activity['sub']);
	$smarty->assign("user_activity",$activity);
	$count=@mysql_num_rows($select_activity);

//echo "<pre>";print_r($deal[0]);echo "</pre>";
// if($_GET['moduleid']=='review')
// {
// 	if($_GET['userid']!="" )
// 	{
// 	$user=$_GET['userid'];
// 	}
// 	else
// 	{
// 	$user=$_SESSION['csUserId'];
// 	}
// 		$select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid='".$user."' ","");
// 		$res_select_profile=@mysql_fetch_assoc($select_user_profile);
// 		$smarty->assign("user_profile",$res_select_profile);
// 		
// 		$select_activity=$dbObj->customqry("select a.*,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where (a.uid='".$user."' or a.fid='".$user."') and a.parent_id='0'  order by msg_id DESC","");
// 		$i=0;
// 		while($res_select_activity=@mysql_fetch_assoc($select_activity))
// 		{
// 			$activity[]=$res_select_activity;
// 			$sel_subcomment=$dbObj->customqry("select a.*,u.first_name,u.last_name,u.photo from tbl_activity a left join tbl_users u on a.uid=u.userid  where (a.uid='".$user."' or a.fid='".$user."') and a.parent_id='".$res_select_activity['msg_id']."' order by msg_id DESC","");
// 			while($res_sel_subcomment=@mysql_fetch_assoc($sel_subcomment))
// 			{
// 			$subactivity[]=$res_sel_subcomment;
// 			}
// 			$i++;
// 			
// 			// echo "<pre>";print_r($activity['0']);echo "</pre>";exit;
// 		}
// 	$smarty->assign("user_subactivity",$subactivity);
// 	$smarty->assign("user_activity",$activity);
// 	$count=@mysql_num_rows($select_activity);
// }
for($i=0;$i<=$count;$i++)
{

	if(isset($_POST['submit_share'][$i]))
	{
		$id=$_POST['txt_id'][$i];
		if($_GET['id1']!="")
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['id1']."','".$id."') ","");
		}
		else
		{
			$loc_thinking=trim($_POST['txt_thinking']);
			$timestamp=date("Y-m-d H:i:s");
			$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','".$id."') ","");
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



$smarty->display(TEMPLATEDIR . '/modules/merchant-account/ajax_my_review.tpl');
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
						
						$result = "1 day ago"; 

						}
						elseif($diff>=2 && $diff<=360)
						{
						 	$res = strtotime($feedtime);

							$result=date("M d , Y H:i:s",$res);
						}
						else
						{
						
											  $res = strtotime($feedtime);

											  $result=date("M d , Y",$res); 

						}
			}
			else
			{
				$result     = $diff." hrs ago";

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
