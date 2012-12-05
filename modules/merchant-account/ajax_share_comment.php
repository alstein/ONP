<?php
include_once('../../include.php');

if(!isset($_SESSION['csUserId']))
{
	header("location:".SITEROOT); exit;
}

	
 

$sel_type=$dbObj->customqry("select usertypeid from tbl_users where userid ='".$_GET['userid']."'","");
$fetch_sel_type=@mysql_fetch_assoc($sel_type);
$usertypeid=$fetch_sel_type['usertypeid'];

$sel_type1=$dbObj->customqry("select usertypeid from tbl_users where userid ='".$_SESSION['csUserId']."'","");
$fetch_sel_type1=@mysql_fetch_assoc($sel_type1);
$usertypeid1=$fetch_sel_type1['usertypeid'];

		if($usertypeid == '2')
		{
		$select=$dbObj->customqry("select fullname from tbl_users where userid 	='".$_GET['userid']."'","");
		$fetch_select=@mysql_fetch_assoc($select);
		$fullname=$fetch_select['fullname'];
		}
		elseif($usertypeid == '3')
		{
		$select=$dbObj->customqry("select business_name from tbl_users where userid 	='".$_GET['userid']."'","");
		$fetch_select=@mysql_fetch_assoc($select);
		$fullname=$fetch_select['business_name'];
		}
// echo "<br>name=".$fullname;
// echo "<br>";
		if($usertypeid1 == '2')
		{
		$select1=$dbObj->customqry("select fullname from tbl_users where userid ='".$_SESSION['csUserId']."'","");
		$fetch_select1=@mysql_fetch_assoc($select1);
		$fullname1=$fetch_select1['fullname'];
		}
		elseif($usertypeid1 == '3')
		{
		$select1=$dbObj->customqry("select business_name from tbl_users where userid ='".$_SESSION['csUserId']."'","");
		$fetch_select1=@mysql_fetch_assoc($select1);
		$fullname1=$fetch_select1['business_name'];
		}

// echo "<br>name1=".$fullname1;

		if($_GET['module']=='dealsasusual' || $_GET['module']=='rightnowdeal' || $_GET['module']=='favlocalbusiness')
		{
		$dealname=$_GET['shareid'];
		//$sel_deal_id=$dbObj->customqry("select merchant_id,discount_in_per, deal_unique_id,deal_category from tbl_deals where deal_title 	='".$dealname."' and deal_image='".$_GET['img_val']."'","");


		$sel_deal_id=$dbObj->customqry("select merchant_id,discount_in_per, deal_unique_id,deal_category,is_share from tbl_deals where deal_unique_id=".$_GET['deal_id'],"");

		$res_deal_id=mysql_fetch_assoc($sel_deal_id);
		$deal_id=$res_deal_id['deal_unique_id'];
		$discount=$res_deal_id['discount_in_per'];
		$merchant_id=$res_deal_id['merchant_id'];
		$deal_category=$res_deal_id['deal_category'];
		$link_deal=SITEROOT."/buy/".$deal_id;

		if($res_deal_id['is_share']=="1"){
			$msg=ucfirst($dealname);
		}elseif($res_deal_id['is_share']=="0"){	
			$msg=ucfirst($fullname1)." shared a deal <br>"."<div>$discount% off on <a href=$link_deal target=_blank>".ucfirst($dealname)."</a></div>";
		}
// 		$msg=$fullname1." shares a deal <br> <br>".$dealname;
		$date=date("Y-m-d H:i:s");
		$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id,merchant_id)values('".$msg."','deal','".$_GET['img_val']."','".$date."','0','".$_SESSION['csUserId']."','".$_GET['userid']."','','','".$merchant_id."') ","");
		

// 		$insert_thinking=$dbObj->customqry("insert into tbl_deals
// 				(merchant_id,deal_category,	deal_title,deal_image,posted_date,status,is_share)
// 				values('".$merchant_id."','".$deal_category."','".$msg."','".$_GET['img_val']."','".date("Y-m-d H:i:s")."','active','1')","");

		}
		else
		{
			$select_activity=$dbObj->customqry("select * from tbl_activity where msg_id='".$_GET['shareid']."'","");
			$fetch_select_activity=@mysql_fetch_assoc($select_activity);
			$arr=explode("<br>",$fetch_select_activity['msg']);
			$count=count($arr);
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
			//$finalmsg1=$finalmsg;
 			//$finalmsg1=$finalmsg."<br><div>".$msg;echo "</div>";


			if($usertypeid1 == '2'){
					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname.'</a>';	
					
					$finalmsg1='<a href="'.SITEROOT.'/my-account/'.$_SESSION['csUserId'].'/my_profile"  target="_blank">'. $fullname1.'</a>'.'  shared the message of '.$temp."<br><b>".$msg."</b>";

			}elseif($usertypeid1 == '3'){

				//	$finalmsg='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of  <a href="'.SITEROOT.'/my-account/'.$cust1.'/my_profile"  target="_blank">'. $fullname .'</a>';;

					if($usertypeid=='2')
							$temp='<a href="'.SITEROOT.'/my-account/'.$_GET['userid'].'/my_profile" target="_blank">'. $fullname .'</a>';
					else
							$temp='<a href="'.SITEROOT.'/merchant-account/'.$_GET['userid'].'/merchant_profile" target="_blank">'. $fullname .'</a>';	
					
					$finalmsg1='<a href="'.SITEROOT.'/merchant-account/'.$_SESSION['csUserId'].'/merchant_profile" target="_blank">'. $fullname1 .'</a>'.'  shared the message of '.$temp."<br><b>".$msg."</b>";

			}



			
			if($_GET['userid']!="")
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$timestamp=date("Y-m-d H:i:s");
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','".$vault_t."','".$vault."','".$date."','0','".$_SESSION['csUserId']."','".$_GET['userid']."','','".$_GET['dealid']."') ","");
			}
			else
			{
				$loc_thinking=trim($_POST['txt_thinking']);
				$timestamp=date("Y-m-d H:i:s");
				$insert_thinking=$dbObj->customqry("insert into tbl_activity(msg,vault_t,vault,timestamp,wall,uid,fid,parent_id,deal_id)values('".$finalmsg1."','".$vault_t."','".$vault."','".$date."','0','".$_SESSION['csUserId']."','".$_SESSION['csUserId']."','','".$_GET['dealid']."') ","");
			}
		}	

 $dbObj->Close();
?>