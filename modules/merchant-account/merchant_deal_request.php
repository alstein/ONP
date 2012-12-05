<?php
include_once('../../include.php');
if($_GET['sp']== "")
{
if(!isset($_SESSION['csUserId']) || $_SESSION['csUserTypeId']!=3)
{
	header("location:".SITEROOT); exit;
}
}

$select=$dbObj->customqry("select * from tbl_users where userid='".$_SESSION['csUserId']."'","");
$result=mysql_fetch_assoc($select);
$smarty->assign("result",$result);

	if(isset($_POST['Submit']))
	{

				extract($_POST);
		if($_GET['sp']=="")
		{
				$insert_merchant_deal_request=$dbObj->customqry("insert into tbl_merchant_deal_request(name_of_key,	phone_no,	mail,merchant_id,status)values('".$name_of_key."','".$phone_no."','".$mail."','".$_SESSION['csUserId']."','no') ","");
				
				if($insert_merchant_deal_request!="")
				{
				$msg="Request Sent Successfully";
				$_SESSION['msg']=$msg;
 				header("location:".SITEROOT."/merchant-account/merchant_profile_home");
				
				//$smarty->assign("msg",$msg);
				}
		}
		else
		{
		$msg="Request Send Successfully";
		$_SESSION['merchant_name_key']=$name_of_key;
		$_SESSION['merchant_phone']=$phone_no;
		$_SESSION['merchant_mail']=$mail;
		$_SESSION['msg']=$msg;
	
		?>

		<script language="JavaScript" type="text/javascript">
				window.parent.location.reload();
		</script>
		
	<?php 
		exit;
		}
	
	}



$smarty->display(TEMPLATEDIR . '/modules/merchant-account/merchant_deal_request.tpl');
$dbObj->Close();
?>