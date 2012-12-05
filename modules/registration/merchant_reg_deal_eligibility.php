<?php

$PATH_PREFIX = "../";
include_once('../../include.php');
if($_SESSION['merchantabout_business']=="")
{
    @header("Location:".SITEROOT."/registration/merchant_reg_profileinfo");
}
//echo "<pre>";print_r($_SESSION);echo "</pre>";
if($_GET['id1']==skip)
{
    $contact_per=$_SESSION['merchantcontact_person'];
    $fname=$_SESSION['merchantfname'];
    $lname=$_SESSION['merchantlname'];
    $memail=$_SESSION['merchantemail'];
    $password=md5($_SESSION['merchantpassword']);
    $business_name=$_SESSION['merchantbusiness_name'];
    $address1=$_SESSION['merchantaddress1'];
    $concat_address=$_SESSION['concat_address'];
    $address2=$_SESSION['merchantaddress2'];
    $address3=$_SESSION['merchantaddress3'];
    $address4=$_SESSION['merchantaddress4'];
    $address5=$_SESSION['merchantaddress5'];
    $countryid=$_SESSION['merchantcountryid'];
    $state=$_SESSION['merchantstate'];
    $cityid=$_SESSION['merchantcityid'];
    $phone=$_SESSION['merchantphone'];
    $website=$_SESSION['merchantwebsite'];
    $maincategory=$_SESSION['merchantmaincategory'];
    $subcategory=$_SESSION['merchantsubcategory'];
    $speciality=$_SESSION['merchantspeciality'];
    $signup_date=date("Y-m-d H:i:s");

    $b=str_replace(" ","_",$business_name);	
    $username = $b."_".rand();

    $fullname=$fname." ".$lname;
    $starthour=$_SESSION['merchantstarthour'];
    $endhour=$_SESSION['merchantendhour'];
    $starthour1=$_SESSION['merchantstarthour1'];
    $endhour1=$_SESSION['merchantendhour1'];
    $menuprice=$_SESSION['merchantmenuprice'];
    $photo=$_SESSION['merchantphoto'];
    $about_business=$_SESSION['merchantabout_business'];
    $name_key=$_SESSION['merchant_name_key'];
    $merchant_phone=$_SESSION['merchant_phone'];
    $mail=$_SESSION['merchant_mail'];

    $fl = array("first_name","last_name","business_name","fullname","username",'password','email','usertypeid',"signup_date","address1","address2","address3","address4","address5","city",'state_id','countryid', "business_webURL","contact_detail",'status',"subscribe_status",'about_us','deal_cat','deal_subcat','specility','business_start_date1','business_end_date1','business_start_date2','business_end_date2','menu_price_file','photo',"contact_person","concat_address");
    $vl = array($fname,$lname,$business_name,$fullname,$username,$password,$memail,3,$signup_date,$address1,$address2,$address3,$address4,$address5,$cityid,$state,$countryid,$website,$phone,"Active","Expired",$about_business,$maincategory,$subcategory,$speciality,$starthour,$endhour,$starthour1,$endhour1,$menuprice,$photo,$contact_per,$concat_address);
// 	print_r($vl);
// 	exit;
    $resIns = $dbObj->cgi('tbl_users',$fl,$vl,'');
// 	echo "<br>merchant_name_key=".$_SESSION['merchant_name_key'];
// 	echo "<br>merchant_phone=".$_SESSION['merchant_phone'];
// 	echo "<br>merchant_mail=".$_SESSION['merchant_mail'];exit;


    $select_user_cat=$dbObj->customqry("select * from tbl_users where category_preferance like '%".$maincategory."%' and isverified='yes' and usertypeid='2'","1");
    while($res_user=mysql_fetch_assoc($select_user_cat))
    {
        $select_category=$dbObj->customqry("select * from mast_deal_category where id='".$maincategory."'","");
        $res_category=mysql_fetch_assoc($select_category);
        $category=$res_category['category'];

        $select_user=$dbObj->customqry("select * from tbl_users where userid ='".$res_user['userid']."'","");
        $res_user=mysql_fetch_assoc($select_user);
        $name=$res_user['first_name']." ".$res_user['last_name'];
         $email=$res_user['email'];

        $select_merchantuser=$dbObj->customqry("select * from tbl_users where userid ='".$resIns."'","");
        $res_merchant=mysql_fetch_assoc($select_merchantuser);
        $merchantname=$res_merchant['business_name'];

        $email_query = "select * from mast_emails where emailid=81";

        $email_rs = @mysql_query($email_query);
        $email_row = @mysql_fetch_object($email_rs);
        $email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
        $email_subject = str_replace("[[Category]]",$category,$email_subject);
        $email_subject = str_replace("[[Merchantname]]",$merchantname,$email_subject);
        $email_subject = str_replace("amp;","",$email_subject);

        $email_message = file_get_contents(ABSPATH."/email/email.html");

        $attach = SITEROOT;
        $link = "<a href='{$attach}'>{$attach}</a>";

        $email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
        $email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
        $email_message = str_replace("[[TODAYS_DATE]]",date("d M,Y"),$email_message);
        $email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

        $email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
        $email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
        $email_message = str_replace("[[User]]",$name,$email_message);
        $email_message = str_replace("[[Merchantname]]",$merchantname,$email_message);
        $email_message = str_replace("[[Category]]",$category,$email_message);
        $email_message = str_replace("[[Link]]",$link, $email_message);
        $email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);

        $from = SITE_EMAIL;
        @mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// 				echo "<br>mail==".$email;
// 	echo "<br>subject==".$email_subject;
// 	echo "<br>message==".$email_message;
    }

    if($_SESSION['merchant_name_key']!="" && $_SESSION['merchant_phone']!="" && $_SESSION['merchant_mail']!="")
    {
	$insert_merchant_deal_request=$dbObj->customqry("insert into tbl_merchant_deal_request(name_of_key,phone_no,	mail,merchant_id,status)values('".$name_key."','".$merchant_phone."','".$mail."','".$resIns."','no') ","");
    }	
    $verifycode=md5($resIns * 32767);
    $rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $resIns, "");
    $rs=$dbObj->cgs("tbl_users", "", "userid", $resIns, "", "", "");
    $user = @mysql_fetch_assoc($rs);
    $email=$user['email'];
    $email_query = "select * from mast_emails where emailid=56";

    $email_rs = @mysql_query($email_query);
    $email_row = @mysql_fetch_object($email_rs);
    $email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
    $email_subject = str_replace("[[name]]",$fullname,$email_subject);

    $email_message = file_get_contents(ABSPATH."/email/email.html");

    $attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$resIns;
    $link = "<a href='{$attach}'>{$attach}</a>";

    $email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
    $email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
    $email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

    $email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
    $email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
    $email_message = str_replace("[[name]]",$fullname,$email_message);
    $email_message = str_replace("[[fname]]",$fname,$email_message);
    $email_message = str_replace("[[lname]]",$lname,$email_message);
    $email_message = str_replace("[[email]]",$memail,$email_message);
    $email_message = str_replace("[[password]]",$_SESSION['merchantpassword'],$email_message);
    $email_message = str_replace("[[phone_no]]",$phone,$email_message);
    $date1 = date("d-m-Y");
    $email_message = str_replace("[[TODAYS_DATE]]",$signup_date, $email_message);
    $email_message = str_replace("[[link]]",$link, $email_message);
    $from = SITE_EMAIL;
    @mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");

    $_SESSION['msg1']="You Are Registered Sucessfully.To Login click on verification link provided by you through email";

    if($_SESSION!="")
    {
	$_SESSION['merchantfname']="";
	$_SESSION['merchantlname']="";
	$_SESSION['merchantemail']="";
	$_SESSION['merchantpassword']="";
	$_SESSION['merchantbusiness_name']="";
	$_SESSION['merchantaddress1']="";
	$_SESSION['merchantaddress2']="";
	$_SESSION['merchantaddress3']="";
	$_SESSION['merchantaddress4']="";
	$_SESSION['merchantaddress5']="";
	$_SESSION['merchantcountryid']="";
	$_SESSION['merchantstate']="";
	$_SESSION['merchantcityid']="";
	$_SESSION['merchantphone']="";
	$_SESSION['merchantwebsite']="";
	$_SESSION['merchantmaincategory']="";
	$_SESSION['merchantsubcategory']="";
	$_SESSION['merchantspeciality']="";
	$_SESSION['merchantstarthour']="";
	$_SESSION['merchantendhour']="";
	$_SESSION['merchantstarthour1']="";
	$_SESSION['merchantendhour1']="";
	$_SESSION['merchantmenuprice']="";
	$_SESSION['merchantsmallphoto']="";
	$_SESSION['merchantabout_business']="";
	$_SESSION['merchant_name_key']="";
	$_SESSION['merchant_phone']="";
	$_SESSION['merchant_mail']="";
	$_SESSION['merchantcontact_person']	="";
	unset($_SESSION);
	
	}

	@header("Location:".SITEROOT."/success/success/");
}
if(isset($_POST['Submit'])!="" )
{

if($_POST['chk_agree']!="")
{


	$contact_per=$_SESSION['merchantcontact_person'];
	$fname=$_SESSION['merchantfname'];
	$lname=$_SESSION['merchantlname'];
	$email=$_SESSION['merchantemail'];
	$password=md5($_SESSION['merchantpassword']);
	$business_name=$_SESSION['merchantbusiness_name'];
	$address1=$_SESSION['merchantaddress1'];
	$concat_address=$_SESSION['concat_address'];
	$address2=$_SESSION['merchantaddress2'];
	$address3=$_SESSION['merchantaddress3'];
	$address4=$_SESSION['merchantaddress4'];
	$address5=$_SESSION['merchantaddress5'];
	$countryid=$_SESSION['merchantcountryid'];
	$state=$_SESSION['merchantstate'];
	$cityid=$_SESSION['merchantcityid'];
	$phone=$_SESSION['merchantphone'];
	$website=$_SESSION['merchantwebsite'];
	$maincategory=$_SESSION['merchantmaincategory'];
	$subcategory=$_SESSION['merchantsubcategory'];
	$speciality=$_SESSION['merchantspeciality'];
	$signup_date=date("Y-m-d H:i:s");
	
	$b=str_replace(" ","_",$business_name);
	$username = $b."_".rand();

	//$user_arr=explode(" ",$business_name);
	//$user_arr1=$user_arr[0]."_".$user_arr[1];
	//$username = $user_arr1_.rand();
	$fullname=$fname." ".$lname;
	$starthour=$_SESSION['merchantstarthour'];
	$endhour=$_SESSION['merchantendhour'];
	$starthour1=$_SESSION['merchantstarthour1'];
	$endhour1=$_SESSION['merchantendhour1'];
	$menuprice=$_SESSION['merchantmenuprice'];
	$photo=$_SESSION['merchantphoto'];
	$about_business=$_SESSION['merchantabout_business'];
	$name_key=$_SESSION['merchant_name_key'];
	$merchant_phone=$_SESSION['merchant_phone'];
	$mail=$_SESSION['merchant_mail'];
	$fl = array("first_name","last_name","business_name","fullname","username",'password','email','usertypeid',"signup_date","address1","address2","address3","address4","address5","city",'state_id','countryid', "business_webURL","contact_detail",'status',"subscribe_status",'about_us','deal_cat','deal_subcat','specility','business_start_date1','business_end_date1','business_start_date2','business_end_date2','menu_price_file','photo',"contact_person","concat_address");
	$vl = array($fname,$lname,$business_name,$fullname,$username,$password,$email,3,$signup_date,$address1,$address2,$address3,$address4,$address5,$cityid,$state,$countryid,$website,$phone,"Active","Expired",$about_business,$maincategory,$subcategory,$speciality,$starthour,$endhour,$starthour1,$endhour1,$menuprice,$photo,$contact_per,$concat_address);
// 	print_r($vl);
// 	exit;
	$resIns = $dbObj->cgi('tbl_users',$fl,$vl,'');
// 			echo "<br>merchant_name_key=".$_SESSION['merchant_name_key'];
// 	echo "<br>merchant_phone=".$_SESSION['merchant_phone'];
// 	echo "<br>merchant_mail=".$_SESSION['merchant_mail'];exit;

	$select_user_cat=$dbObj->customqry("select * from tbl_users where category_preferance like '%".$maincategory."%' and isverified='yes' and usertypeid='2'","1");
	while($res_user=mysql_fetch_assoc($select_user_cat))
	{

		$select_category=$dbObj->customqry("select * from mast_deal_category where id='".$maincategory."'","");
		$res_category=mysql_fetch_assoc($select_category);
		$category=$res_category['category'];

		$select_user=$dbObj->customqry("select * from tbl_users where userid ='".$res_user['userid']."'","");
		$res_user=mysql_fetch_assoc($select_user);
		$name=$res_user['first_name']." ".$res_user['last_name'];
		 $email=$res_user['email'];

		$select_merchantuser=$dbObj->customqry("select * from tbl_users where userid ='".$resIns."'","");
		$res_merchant=mysql_fetch_assoc($select_merchantuser);
		$merchantname=$res_merchant['business_name'];
		
		$email_query = "select * from mast_emails where emailid=81";

		$email_rs = @mysql_query($email_query);
		$email_row = @mysql_fetch_object($email_rs);
		$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
		$email_subject = str_replace("[[Category]]",$category,$email_subject);
		 $email_subject = str_replace("[[Merchantname]]",$merchantname,$email_subject);
			 $email_subject = str_replace("amp;","",$email_subject);
	
		$email_message = file_get_contents(ABSPATH."/email/email.html");
	
		$attach = SITEROOT;
		$link = "<a href='{$attach}'>{$attach}</a>";
	
		$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
		$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
		$email_message = str_replace("[[TODAYS_DATE]]",date("d M,Y"),$email_message);
		$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
	
		$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
		$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
		$email_message = str_replace("[[User]]",$name,$email_message);
		$email_message = str_replace("[[Merchantname]]",$merchantname,$email_message);
		$email_message = str_replace("[[Category]]",$category,$email_message);
		$email_message = str_replace("[[Link]]",$link, $email_message);
		  $email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
		
		$from = SITE_EMAIL;
	@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// 					echo "<br>mail==".$email;
// 	echo "<br>subject==".$email_subject;
// 	echo "<br>message==".$email_message;
	}

	if($_SESSION['merchant_name_key']!="" && $_SESSION['merchant_phone']!="" && $_SESSION['merchant_mail']!="")
	{
	$insert_merchant_deal_request=$dbObj->customqry("insert into tbl_merchant_deal_request(name_of_key,phone_no,	mail,merchant_id,status)values('".$name_key."','".$merchant_phone."','".$mail."','".$resIns."','no') ","");
	}
		$verifycode=md5($resIns * 32767);
	$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $resIns, "");
	$rs=$dbObj->cgs("tbl_users", "", "userid", $resIns, "", "", "");
	$user = @mysql_fetch_assoc($rs);
	
	$email_query = "select * from mast_emails where emailid=56";

	$email_rs = @mysql_query($email_query);
	$email_row = @mysql_fetch_object($email_rs);
	$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
	$email_subject = str_replace("[[name]]",$fullname,$email_subject);

	$email_message = file_get_contents(ABSPATH."/email/email.html");

	$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$resIns;
	$link = "<a href='{$attach}'>{$attach}</a>";

	$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
	$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
	$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);

	$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
	$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
	$email_message = str_replace("[[name]]",$fullname,$email_message);
	$email_message = str_replace("[[fname]]",$fname,$email_message);
	$email_message = str_replace("[[lname]]",$lname,$email_message);
	$email_message = str_replace("[[email]]",$memail,$email_message);
	$email_message = str_replace("[[password]]",$_SESSION['merchantpassword'],$email_message);
	$email_message = str_replace("[[phone_no]]",$phone,$email_message);
	$date1 = date("d-m-Y");
	$email_message = str_replace("[[TODAYS_DATE]]",$signup_date, $email_message);
	$email_message = str_replace("[[link]]",$link, $email_message);
	$from = SITE_EMAIL;
	$email=$user['email'];
// 	echo "<br>mail==".$email;
// 	echo "<br>subject==".$email_subject;
// 	echo "<br>message==".$email_message;exit;
	@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
	$_SESSION['msg1']="You Are Registered Sucessfully.To Login click on verification link provided by you through email";

	if($_SESSION!="")
	{
	$_SESSION['merchantcontact_person']	="";
	$_SESSION['merchantfname']="";
	$_SESSION['merchantlname']="";
	$_SESSION['merchantemail']="";
	$_SESSION['merchantpassword']="";
	$_SESSION['merchantbusiness_name']="";
	$_SESSION['merchantaddress1']="";
	$_SESSION['merchantaddress2']="";
	$_SESSION['merchantaddress3']="";
	$_SESSION['merchantaddress4']="";
	$_SESSION['merchantaddress5']="";
	$_SESSION['merchantcountryid']="";
	$_SESSION['merchantstate']="";
	$_SESSION['merchantcityid']="";
	$_SESSION['merchantphone']="";
	$_SESSION['merchantwebsite']="";
	$_SESSION['merchantmaincategory']="";
	$_SESSION['merchantsubcategory']="";
	$_SESSION['merchantspeciality']="";
	$_SESSION['merchantstarthour']="";
	$_SESSION['merchantendhour']="";
	$_SESSION['merchantstarthour1']="";
	$_SESSION['merchantendhour1']="";
	$_SESSION['merchantmenuprice']="";
	$_SESSION['merchantsmallphoto']="";
	$_SESSION['merchantabout_business']="";
	$_SESSION['merchant_name_key']="";
	$_SESSION['merchant_phone']="";
	$_SESSION['merchant_mail']="";
	unset($_SESSION);
	
	}

	@header("Location:".SITEROOT."/success/success/");
}
else
{
$msg="Please Agree to Terms and Conditions to proceed";
$smarty->assign("msg",$msg);
}
}
$smarty->display(TEMPLATEDIR.'/modules/registration/merchant_reg_deal_eligibility.tpl');

$dbObj->Close();
?>