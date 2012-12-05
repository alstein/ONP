<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

$timestamp=date("Y-m-d H:i:s");
$sel_type=$dbObj->customqry("select usertypeid from tbl_users where userid ='".$_GET['userid']."'","");
$fetch_sel_type=@mysql_fetch_assoc($sel_type);
$usertypeid=$fetch_sel_type['usertypeid'];

$sel_type1=$dbObj->customqry("select usertypeid from tbl_users where userid ='".$_SESSION['csUserId']."'","");
$fetch_sel_type1=@mysql_fetch_assoc($sel_type1);
$usertypeid1=$fetch_sel_type1['usertypeid'];

		if($usertypeid == '2')
		{
		$select=$dbObj->customqry("select fullname,userid from tbl_users where userid 	='".$_GET['userid']."'","");
		$fetch_select=@mysql_fetch_assoc($select);
		$fullname=$fetch_select['fullname'];
		$cust=$fetch_select['userid'];
		}
		elseif($usertypeid == '3')
		{
		$select=$dbObj->customqry("select business_name,userid from tbl_users where userid 	='".$_GET['userid']."'","");
		$fetch_select=@mysql_fetch_assoc($select);
		$fullname=$fetch_select['business_name'];
		$mer=$fetch_select['userid'];
		}
// echo "<br>name=".$fullname;
// echo "<br>";
		if($usertypeid1 == '2')
		{
		$select1=$dbObj->customqry("select fullname,userid from tbl_users where userid ='".$_SESSION['csUserId']."'","");
		$fetch_select1=@mysql_fetch_assoc($select1);
		$fullname1=$fetch_select1['fullname'];
		$cust1=$fetch_select1['userid'];
		}
		elseif($usertypeid1 == '3')
		{
		$select1=$dbObj->customqry("select business_name,userid from tbl_users where userid ='".$_SESSION['csUserId']."'","");
		$fetch_select1=@mysql_fetch_assoc($select1);
		$fullname1=$fetch_select1['business_name'];
		$mer1=$fetch_select1['userid'];
		}

		if($_GET['module']=='dealsasusual' || $_GET['module']=='rightnowdeal' )
		{
			$dealname=$_GET['shareid'];
                        
                        
			//$sel_deal_id=$dbObj->customqry("select merchant_id,discount_in_per, deal_unique_id,is_share from tbl_deals where deal_title 	='".$dealname."' and deal_image='".$_GET['img_val']."'","");

			$sel_deal_id=$dbObj->customqry("select merchant_id,discount_in_per, deal_unique_id,is_share from tbl_deals where deal_unique_id=".$_GET['deal_id'],"");

			$res_deal_id=mysql_fetch_assoc($sel_deal_id);
                        
			$deal_id=$res_deal_id['deal_unique_id'];
			$discount=$res_deal_id['discount_in_per'];
			$merchant_id=$res_deal_id['merchant_id'];
			$link_deal=SITEROOT."/buy/".$deal_id;
			
			if($res_deal_id['is_share']=="1"){
					$msg=ucfirst($fullname1)." shared the message<br><b style='color:#044EA2'>".ucfirst($dealname)."</b>";
			}elseif($res_deal_id['is_share']=="0"){
					$msg=ucfirst($fullname1)." shared an offer <br><b style='color:#044EA2'>".$discount."% off on <a style='color:#044EA2' href=".$link_deal." target=_blank >".ucfirst($dealname)."</a></b>";
			}
                        

                        $prn="";
                        $variables = array("msg", "vault_t","vault","timestamp", "wall","uid","fid", "parent_id","deal_id","merchant_id");
                        $datava = array($msg,'deal',$_GET['img_val'],$timestamp,'0',$_SESSION['csUserId'],$_GET['userid'],'','',$merchant_id);
                        $res = $dbObj ->cgi('tbl_activity' , $variables , $datava , $prn);

                        
                }
		elseif($_GET['module']=='favlocalbusiness')
		{
			$select_activity=$dbObj->customqry("select * from tbl_activity where msg_id='".$_GET['shareid']."'","");
			$fetch_select_activity=@mysql_fetch_assoc($select_activity);
			$arr=@explode("<br>",$fetch_select_activity['msg']);
			$count=@count($arr);
			if($count>0)
			{
			$msg=$arr[$count-1];
			}
			else
			{
			$msg=$fetch_select_activity['msg'];
			}
			
			$vault=$fetch_select_activity['vault'];
			//$finalmsg=$fullname1."  shared the deal of  ". $fullname;
			//$finalmsg1=$finalmsg;
			//$finalmsg1=$finalmsg."<br><div>".$msg;echo "</div><br>";




			if($usertypeid1 == '2'){
					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname.'</a>';	
					
					$finalmsg1='<a href="'.SITEROOT.'/my-account/'.$_SESSION['csUserId'].'/my_profile"  target="_blank">'. $fullname1.'</a>'.'  shared the message of '.$temp."<br><b style='color:#044EA2'>".$msg."</b>";

			}elseif($usertypeid1 == '3'){

				//	$finalmsg='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of  <a href="'.SITEROOT.'/my-account/'.$cust1.'/my_profile"  target="_blank">'. $fullname .'</a>';;

					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname .'</a>';	
					
					$finalmsg1='<a href="'.SITEROOT.'/merchant-account/'.$_SESSION['csUserId'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of '.$temp."<br><b style='color:#044EA2'>".$msg."</b>";

			}




			if($_GET['userid']!="")
			{
				$loc_thinking=@trim($_POST['txt_thinking']);
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','deal','".$vault."','".$timestamp."','0','".$_SESSION['csUserId']."','".$_GET['userid']."','','".$_GET['dealid']."') ","");
			}
			else
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','deal','".$vault."','".$timestamp."','0','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','','".$_GET['dealid']."') ","");
			}
		}	
		else
		{
			$select_activity=$dbObj->customqry("select * from tbl_activity where msg_id='".$_GET['shareid']."'","");
			$fetch_select_activity=@mysql_fetch_assoc($select_activity);
			$arr=@explode("<br>",$fetch_select_activity['msg']);
			
			$count=@count($arr);
			if($count>0)
			{
				if($arr[$count-1] == "")
				{
				$msg=$arr[$count-2];
				}
				else
				{
				$msg=$arr[$count-1];
				}
				
			}
			else
			{
			$msg=$fetch_select_activity['msg'];
			}
			$vault_t=$fetch_select_activity['vault_t'];
			$vault=$fetch_select_activity['vault'];
			//$finalmsg=$fullname1."  shared the message of  ". $fullname;
			
			if($usertypeid1 == '2'){
					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname.'</a>';	
					
					$finalmsg='<a href="'.SITEROOT.'/my-account/'.$_SESSION['csUserId'].'/my_profile"  target="_blank">'. $fullname1.'</a>'.'  shared the message of '.$temp;;

			}elseif($usertypeid1 == '3'){

				//	$finalmsg='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of  <a href="'.SITEROOT.'/my-account/'.$cust1.'/my_profile"  target="_blank">'. $fullname .'</a>';;

					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname .'</a>';	
					
					$finalmsg='<a href="'.SITEROOT.'/merchant-account/'.$_SESSION['csUserId'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of '.$temp;;

			}
			

			$finalmsg1=$finalmsg;
			echo $finalmsg1=$finalmsg."<br><b style='color:#044EA2'>".$msg."</b>";
			if($_GET['userid']!="")
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','".$vault_t."','".$vault."','".$timestamp."','0','".$_SESSION['csUserId']."','".$_GET['userid']."','','".$_GET['dealid']."') ","");
			}
			else
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','".$vault_t."','".$vault."','".$timestamp."','0','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','','".$_GET['dealid']."') ","1");
				
			}
		}	

 $dbObj->Close();
?>
