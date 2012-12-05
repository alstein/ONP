<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once('../../includes/classes/class.frontregister.php');
	$msobj= new message();

	if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

	$objregister = new frontregister();
	$userData = $objregister->getUserDetails($_SESSION['duAdmId']);

	if($_POST["Update"])
	{
		$id=$_SESSION['duAdmId'];
		extract($_POST);

		//////////START Inserting Records in tbl_delivery_service_charges////////////
		$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$_SESSION['duAdmId'],"");

		$opt1 = 1;$opt2 = 1;$opt3 = 1;$opt4 = 1;$opt5 = 1;
		while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
		{
			$j = 1;
			while($j<=5)
			{
				if($row_delivery_service_chr['delivery_service_option'] == "opt".$j)
				{
					if($j == 1)$opt1 = 0;if($j == 2)$opt2 = 0;if($j == 3)$opt3 = 0;if($j == 4)$opt4 = 0;if($j == 5)$opt5 = 0;
					$field_del_ser_chr = array(
										"delivery_service_option"=>$_POST['delivery_service_option_'.$j],
										"delivery_charges_pound"=>$_POST['delivery_charges_pound_'.$j],
										"delivery_charges_euro"=>$_POST['delivery_charges_euro_'.$j],
										"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_'.$j],
										"delivery_service_option"=>"opt".$j,
										"is_selected"=>($_POST['delivery_service_option_chk_'.$j] == 'on'?'yes':'no')
										);

					$dbObj->cupdtii("tbl_delivery_service_charges",$field_del_ser_chr,"id=".$row_delivery_service_chr['id'],"");
				}
				$j++;

			} //End Inner While
		} //End Outer While

		if($opt1)
		{
			$field_del_ser_chr = array(
								"user_id"=>$_SESSION['duAdmId'],
								"delivery_service_option"=>$_POST['delivery_service_option_1'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_1'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_1'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_1'],
								"delivery_service_option"=>"opt1",
								"is_selected"=>($_POST['delivery_service_option_chk_1'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt2)
		{
			$field_del_ser_chr = array(
								"user_id"=>$_SESSION['duAdmId'],
								"delivery_service_option"=>$_POST['delivery_service_option_2'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_2'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_2'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_2'],
								"delivery_service_option"=>"opt2",
								"is_selected"=>($_POST['delivery_service_option_chk_2'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt3)
		{
			$field_del_ser_chr = array(
								"user_id"=>$_SESSION['duAdmId'],
								"delivery_service_option"=>$_POST['delivery_service_option_3'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_3'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_3'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_3'],
								"delivery_service_option"=>"opt3",
								"is_selected"=>($_POST['delivery_service_option_chk_3'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt4)
		{
			$field_del_ser_chr = array(
								"user_id"=>$_SESSION['duAdmId'],
								"delivery_service_option"=>$_POST['delivery_service_option_4'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_4'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_4'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_4'],
								"delivery_service_option"=>"opt4",
								"is_selected"=>($_POST['delivery_service_option_chk_4'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		if($opt5)
		{
			$field_del_ser_chr = array(
								"user_id"=>$_SESSION['duAdmId'],
								"delivery_service_option"=>$_POST['delivery_service_option_5'],
								"delivery_charges_pound"=>$_POST['delivery_charges_pound_5'],
								"delivery_charges_euro"=>$_POST['delivery_charges_euro_5'],
								"delivery_charges_dollar"=>$_POST['delivery_charges_dollar_5'],
								"delivery_service_option"=>"opt5",
								"is_selected"=>($_POST['delivery_service_option_chk_5'] == 'on'?'yes':'no')
								);

			$dbObj->cgii("tbl_delivery_service_charges",$field_del_ser_chr,"");
		}
		///////////END Inserting Records in tbl_delivery_service_charges/////////////

		$description_decode = html_entity_decode($description);

		$field = array("delivery_charges_pound"=>$_POST['delivery_charges_pound'],
				"delivery_charges_euro"=>$_POST['delivery_charges_euro'],
				"delivery_charges_dollar"=>$_POST['delivery_charges_dollar'],
				"refund_policy"=>$description_decode,
				"seller_support_email"=>$_POST['seller_support_email'],
				"tracking_url_code"=>$_POST['tracking_URL'],
				"delivered_tracking_url_code"=>$_POST['delivered_tracking_URL'],
				"affiliate_link"=>$_POST['affiliate_URL'],
				"affiliate_code"=>$_POST['affiliate_code']);
		$dbObj->cupdtii("tbl_users",$field,"userid=".$id,"");

		//checking is any field changed in personal details.
		$userDataNew = $objregister->getUserDetails($_SESSION['duAdmId']);
		if($userData['delivery_charges_pound']!=$_POST['delivery_charges_pound']||
		$userData['delivery_charges_euro']!=$_POST['delivery_charges_euro']||
		$userData['delivery_charges_dollar']!=$_POST['delivery_charges_dollar']||
		$userData['seller_support_email']!=$_POST['seller_support_email']||
		$userData['tracking_url_code']!=$_POST['tracking_URL']||
		$userData['delivered_tracking_url_code']!=$_POST['delivered_tracking_URL']||
		$userData['affiliate_link']!=$_POST['affiliate_URL']||
		$userData['affiliate_code']!=$_POST['affiliate_code'])
		{
			//sending email to admin about seller profile details update.
			$email_query = "select * from mast_emails where emailid=64";
	
			$email_rs = @mysql_query($email_query);
			$email_row = @mysql_fetch_object($email_rs);
			$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);

			$email_message = file_get_contents(ABSPATH."/email/email.html");

			$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
			$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
			$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
			
			$date1 = date("d-m-Y");
			$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	
			$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
			$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
			$email_message = str_replace("[[FNAME]]",$userDataNew["first_name"],$email_message);
			$email_message = str_replace("[[LNAME]]",$userDataNew["last_name"],$email_message);
			$email_message = str_replace("[[ACCOUNTNAME]]",$userDataNew["username"],$email_message);
			$email_message = str_replace("[[EMAIL]]",$userDataNew["email"],$email_message);
			$email_message = str_replace("[[ADD1]]",$userDataNew["address"],$email_message);
			$email_message = str_replace("[[ADD2]]",$userDataNew["b_add2"],$email_message);
			$email_message = str_replace("[[CITY]]",$userDataNew["city"],$email_message);
			$email_message = str_replace("[[STATE]]",$userDataNew["b_state"],$email_message);
			$email_message = str_replace("[[COUNTRY]]",$userDataNew["country_name"],$email_message);
			$email_message = str_replace("[[POSTCODE]]",$userDataNew["postalcode"],$email_message);
			$email_message = str_replace("[[WEBSITEURL]]",$userDataNew["business_webURL"],$email_message);
			$email_message = str_replace("[[PHONENO]]",$userDataNew["contact_detail"],$email_message);
			$email_message = str_replace("[[POUND]]",$userDataNew["delivery_charges_pound"],$email_message);
			$email_message = str_replace("[[EURO]]",$userDataNew["delivery_charges_euro"],$email_message);
			$email_message = str_replace("[[DOLLAR]]",$userDataNew["delivery_charges_dollar"],$email_message);
			$email_message = str_replace("[[SUPPORTEMAIL]]",$userDataNew["seller_support_email"],$email_message);
			$email_message = str_replace("[[TRACKINGURLCODE]]",$userDataNew["tracking_url_code"],$email_message);
			$email_message = str_replace("[[DELIVEREDTRACKINGURLCODE]]",$userDataNew["delivered_tracking_url_code"],$email_message);
			$email_message = str_replace("[[AFFILIATEURL]]",$userDataNew["affiliate_link"],$email_message);
			$email_message = str_replace("[[AFFILIATECODE]]",$userDataNew["affiliate_code"],$email_message);
			$email_message = str_replace("[[REFUNDPOLICY]]",html_entity_decode($userDataNew["refund_policy"]),$email_message);
			$email_message = str_replace("[[TODAY]]", date("F dS, Y",time()), $email_message);
	
			$to = SITE_EMAIL;
			$from = EMAIL_FROM;
			@mail($to,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
			//echo "<pre>To ==".$array["email"]."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
		}

		//$s=$msobj->showmessage(243);
		// $_SESSION['msg']="<span class='success'>Manage Other Details updated successfully</span>";
		header("location:". SITEROOT . "/admin/seller/my-profile-view.php");exit;
	}

    //----Get the updated id here and display record to manage_lightbox_page_edit.tpl file-----

	if($_SESSION['duAdmId'])
	{
		$id=$_SESSION['duAdmId'];
		$sql="select userid,delivery_charges_pound,delivery_charges_euro,delivery_charges_dollar,refund_policy,seller_support_email,tracking_url_code,delivered_tracking_url_code,affiliate_link,affiliate_code from tbl_users where userid='$id'";

		$sqlrow=mysql_query($sql)or die(mysql_error());
		$results = array();
		$r=mysql_fetch_array($sqlrow);
		$userid=$r['userid'];
		$delivery_charges_pound=$r['delivery_charges_pound'];
		$delivery_charges_euro=$r['delivery_charges_euro'];
		$delivery_charges_dollar=$r['delivery_charges_dollar'];
		$seller_support_email=$r['seller_support_email'];
		$tracking_url_code=$r['tracking_url_code'];
		$refund_policy=$r['refund_policy'];
		$delivered_tracking_url_code=$r['delivered_tracking_url_code'];
		$affiliate_url=$r['affiliate_link'];
		$affiliate_code=$r['affiliate_code'];

/////OLD FCKEditor code start here/////////////////////////////////
//         include_once '../../ckeditor/ckeditor.php' ;
//         require_once '../../ckfinder/ckfinder.php' ;
// 	include("../../editor/fckeditor.php");
// 	$oFCKeditor = new FCKeditor('description') ;
// 	$oFCKeditor->BasePath = '../../editor/';
// 	$oFCKeditor->Value = html_entity_decode($r['refund_policy']);
// 	$oFCKeditor->Width  = '100%';
// 	$oFCKeditor->Height = '400';
// 	$smarty->register_object("oFCKeditor", $oFCKeditor);
/////OLD FCKEditor code end here///////////////////////////////////
		include_once '../../ckeditor/ckeditor.php' ;
		require_once '../../ckfinder/ckfinder.php' ;
		$ckeditor = new CKEditor('description') ; //
		$ckeditor->basePath	= '../../ckeditor/' ;
		CKFinder::SetupCKEditor($ckeditor, '../../' ) ;
		$initialValue = html_entity_decode($r['refund_policy']); //
		$editorcontentTitle= $ckeditor->editor("description", $initialValue, $config); //
		$smarty->assign("oFCKeditorDesc", $editorcontentTitle);
		
		$smarty->assign('userid', $userid);
		$smarty->assign('delivery_charges_pound',$delivery_charges_pound);
		$smarty->assign('delivery_charges_euro',$delivery_charges_euro);
		$smarty->assign('delivery_charges_dollar',$delivery_charges_dollar);
		$smarty->assign('seller_support_email', $seller_support_email);
		$smarty->assign('tracking_url_code', $tracking_url_code);
		$smarty->assign('delivered_tracking_url_code', $delivered_tracking_url_code);
		$smarty->assign('affiliate_url', $affiliate_url);
		$smarty->assign('affiliate_code', $affiliate_code);
	}

	////////////////////////START to fetching delivery charges label//////////////////////////////////
	$res_delivery_chr = $dbObj->customqry("SELECT * FROM sitesetting WHERE id IN(52,53,54,55,56)","");
	while($row_delivery_chr = @mysql_fetch_assoc($res_delivery_chr))
		$data_delivery_chr[] = $row_delivery_chr;

	$smarty->assign("data_delivery_chr", $data_delivery_chr);

	$res_delivery_service_chr = $dbObj->customqry("SELECT * FROM tbl_delivery_service_charges WHERE set_for = 'user' AND user_id = ".$_SESSION['duAdmId'],"");
	while($row_delivery_service_chr = @mysql_fetch_assoc($res_delivery_service_chr))
		$data_delivery_service_chr[] = $row_delivery_service_chr;

	$smarty->assign("data_delivery_service_chr", $data_delivery_service_chr);
	/////////////////////////END to fetching delivery charges label///////////////////////////////////

	if(isset($_SESSION['msg']))
	{
		$smarty->assign("msg", $_SESSION['msg']);
		unset($_SESSION['msg']);
	}
	$smarty->display(TEMPLATEDIR . '/admin/seller/manage_other_details.tpl');
	
	$dbObj->Close();
?>