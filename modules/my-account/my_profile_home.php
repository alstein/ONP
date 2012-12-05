<?php
include_once('../../include.php');
include_once('../../include/SiteSetting.php');
if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}
//print_r($_REQUEST); exit;
$select3=$dbObj->customqry("SELECT * FROM tbl_users WHERE userid=".$_SESSION['csUserId']);
$rsltset3=@mysql_fetch_assoc($select3);
$smarty->assign("username",$rsltset3['fullname']);     
$row_meta=$dbObj->getseodetails(25);
$smarty->assign("row_meta",$row_meta);
$smarty->assign("fbid",FACEBOOKAPPID);

if(isset($_POST['txn_id'])){
    if($_POST['txn_id']!=""){
        
       if($_GET['flagchk']==1){
        $smarty->assign("facebookshare",1);
        $amount=$_POST['mc_gross'];
        $flag=2;
        $prn="";
        $select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=".$flag);
        $rsltset=mysql_fetch_assoc($select);
        
        $select=$dbObj->customqry("SELECT rewardpoints as reward FROM tbl_rewards where userid=".$_SESSION['csUserId']." and flag=4");
        $total=mysql_fetch_assoc($select);
       
        if($rsltset['reward']!=""){
                $rewards=$rsltset['reward']+round($amount);
                $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=".$flag);
                $rsltset=mysql_fetch_assoc($select);
        } 
        else{
                $rewards= $amount;
                $variables = array("userid", "rewardpoints","flag");
                $datava = array($_SESSION['csUserId'],$rewards,$flag);
                $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
            }
      if($total['reward']!=""){
                $rewards=$total['reward']+round($amount);
                $select=$dbObj->customqry("update tbl_rewards set rewardpoints=".$rewards." where userid=".$_SESSION['csUserId']." and flag=4");
                $rsltset=mysql_fetch_assoc($select);
      }
      
      else{
          $rewards= $amount;
          $variables = array("userid", "rewardpoints","flag");
          $datava = array($_SESSION['csUserId'],$rewards,4);
          $res = $dbObj ->cgi('tbl_rewards' , $variables , $datava , $prn);
      }
      
       }
    }
}
// if(isset($_POST['share']))
// {
// 	if($_FILES['photo']['name']!="")
// 	{
// 
// 		if($_FILES['photo'])
// 		{
// 		
// 			$original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 
// 		}
// 	
// // 	echo "".$_SESSION['photo_post']=$original_1;exit;
// 	}
// 	if($_GET['userid']!="")
// 	{
// 	
// 		$loc_thinking=($_GET['txt_thinking']);
// 		$timestamp=date("Y-m-d H:i:s");
// 		$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','".$original_1."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_GET['userid']."','0') ","1");
// 	@header("location:".SITEROOT."/my-account/".$_GET['userid']."/"."friend/my_profile_home");
// 	}
// 	else
// 	{
// 		$loc_thinking=($_GET['txt_thinking']);
// 		$timestamp=date("Y-m-d H:i:s");
// 		$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id)values('".$loc_thinking."','status','".$original_1."','".$timestamp."','1','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','0') ","1");
// 		@header("location:".SITEROOT."/my-account/friend/my_profile_home");
// 	}
// }

	
function timediff($time1, $time2) {

  list($h,$m,$s) = explode(":",$time1);
  $t1 = $h * 3600 + $m * 60 + $s;
  list($h2,$m2,$s2) = explode(":",$time2);
  $seconds = ($h2 * 3600 + $m2 * 60 + $s2) - $t1;
  return sprintf("%02d:%02d:%02d",floor($seconds/3600),floor($seconds/60)%60,$seconds % 60);
	
}
if($_GET['id1']!="")
{
$user=$_GET['id1'];
}
else
{
$user=$_SESSION['csUserId'];
}
// $select_user_profile=$dbObj->customqry("select u.*,c.country,s.state_name from tbl_users  u left join mast_country c on u.countryid=c.countryid left join mast_state s on u.state_id=s.id  where u.userid='".$user."'","");
// $res_select_profile=@mysql_fetch_assoc($select_user_profile);
// $smarty->assign("user_profile",$res_select_profile);

// $smarty->assign("user_activity",$activity);
$smarty->display(TEMPLATEDIR . '/modules/my-account/my_profile_home.tpl');
$dbObj->Close();
?>