<?php

$PATH_PREFIX = "../";
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/common.lib.php");
if($_SESSION['merchantemail']=="")
{
    @header("Location:".SITEROOT."/registration/merchant_reg_profileinfo");
}

#----------------get Main category----------------------------#
$sql="select * from mast_deal_category where parent_id=0 AND active=1 order by category";
$result = mysql_query($sql) or die('Error, query failed');
$i = 0;
while($row = mysql_fetch_array($result))
{
    $tmp = array('id'=>$row['id'], 'category'=>$row['category']);
    $results[$i++] = $tmp;
}
$smarty->assign("category",$results);
#----------------get Main category----------------------------#



#--------------Get Time--------------------#
$i = 0;
$hr = array();	
for($hh = 0; $hh <=23; $hh++) 
{
    if($hh<10)
        $hh = "0$hh"; 
    else
        $hh = $hh;
    $hr[$i] = $hh;
    $i++;
}
$rev_hr = array_reverse($hr);
$smarty->assign("rev_hr",$rev_hr);
$smarty->assign("hr",$hr);
$smarty->assign("delivery_hrs",$hr);

$i = 0;
$min = array();	
for($mm = 0; $mm <=59; $mm++) 
{
    if($mm<10)
        $mm = "0$mm"; 
    else
        $mm = $mm;
    $min[$i] = $mm;
    $i++;
}
$min=array("00","15","30","45");
$rev_min = array_reverse($min);
$smarty->assign("rev_min",$rev_min);
$smarty->assign("min",$min);
$smarty->assign("delivery_mins",$min);

$days = range(2,30);
$smarty->assign("days",$days);
$hours = range(0,23);
$smarty->assign("hours",$hours);

if($_FILES['price_menu_list'])
{
    $original_1 = newgeneralfileupload($_FILES['price_menu_list'], "../../uploads/menu_price_list/", true); 
}
if($_FILES['upload_photo'])
{
    $original_2 = newgeneralfileupload($_FILES['upload_photo'], "../../uploads/user/", true); 
}
#---------------End Time-------------------#
// print_r($_SESSION);
if($_POST['maincategory']!="" && $_POST['subcategory']!="" && $_POST['speciality']!="" )
{
    $starthour=$_POST['start_hour'].":".$_POST['start_min'].":00";
    $endhour=$_POST['end_hour'].":".$_POST['end_min'].":00";
    $starthour1=$_POST['start_hour1'].":".$_POST['start_min1'].":00";
    $endhour1=$_POST['end_hour1'].":".$_POST['end_min1'].":00";
    $_SESSION['merchantabout_business']=$_POST['about_business'];
    $_SESSION['merchantmaincategory']=$_POST['maincategory'];
    $_SESSION['merchantsubcategory']=$_POST['subcategory'];
    $_SESSION['merchantspeciality']=$_POST['speciality'];
    $_SESSION['merchantstarthour']=$starthour;
    $_SESSION['merchantendhour']=$endhour;
    $_SESSION['merchantstarthour1']=$starthour1;
    $_SESSION['merchantendhour1']=$endhour1;
    $_SESSION['merchantmenuprice']=$original_1;
    $_SESSION['merchantphoto']=$original_2;

    // code from merchant deal eligibility copied
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

    $resIns = $dbObj->cgi('tbl_users',$fl,$vl,'');

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

    }

    $insert_merchant_deal_request=$dbObj->customqry("insert into tbl_merchant_deal_request(name_of_key,phone_no,	mail,merchant_id,status)values('".$contact_per."','".$phone."','".$memail."','".$resIns."','no') ","");
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


    //@header("Location:".SITEROOT."/registration/merchant_reg_deal_eligibility");
    //exit;
//}

$smarty->display(TEMPLATEDIR.'/modules/registration/merchant_reg_profilepic.tpl');

$dbObj->Close();
?>