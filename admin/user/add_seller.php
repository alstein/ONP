<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');
include_once("../../includes/common.lib.php");
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	

#----------------get Main category----------------------------#
	$sql="select * from mast_deal_category where parent_id=0 order by category";
        $result = mysql_query($sql) or die('Error, query failed');
        $i = 0;
        while($row = mysql_fetch_array($result))
        {
                $tmp = array('id'=>$row['id'],
                 'category'=>$row['category']);
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

#---------------End Time-------------------#

if(isset($_POST['password']))
{

        extract($_POST);

	$fullname = $first_name." ".$last_name;
    if($_FILES['price_menu_list'])
    {
                        $original_1 = newgeneralfileupload($_FILES['price_menu_list'], "../../uploads/menu_price_list/", true); 
    }
    if($_FILES['upload_photo'])
    {
             $original_2 = newgeneralfileupload($_FILES['upload_photo'], "../../uploads/user/", true); 
    }
 

		$starthour=$_POST['start_hour'].":".$_POST['start_min'].":00";
		$endhour=$_POST['end_hour'].":".$_POST['end_min'].":00";
		$starthour1=$_POST['start_hour1'].":".$_POST['start_min1'].":00";
		$endhour1=$_POST['end_hour1'].":".$_POST['end_min1'].":00";

		$b=str_replace(" ","_",$business_name);	
		$username = $b."_".rand();


	$fl = array("first_name","last_name","business_name","fullname","username",'password','email','usertypeid',"signup_date","title","address1","address2","address3","address4","address5","city",'state_id','countryid', 'postalcode',"business_webURL","contact_detail",'subscription_pack_id',"company_type","limited_comp","vat_reg","activiti",'status',"subscribe_status",'added_by','about_us','deal_cat','deal_subcat','deal_subsubcat','deal_subsubsubcat','	specility','business_start_date1','business_end_date1','business_start_date2','business_end_date2','menu_price_file','photo','is_applied','	contact_person');
	$vl = array($first_name,$last_name,$business_name,$fullname,$username,md5($password),$email,3,date("Y-m-d H:i:s"),$title,$address1,$address2,$address3,$address4,$address5,$cityid,$state,$countryid,$zipCode,$business_webURL,$contact_detail,$subscription,$company_type,$limited_comp,$vat_reg,$activity,"Active","Expired",$_SESSION['duAdmId'],$about_business,$maincategory,$subcategory,$subsubcategory,$subsubsubcategory,$specility,$starthour,$endhour,$starthour1,$endhour1,$original_1,$original_2,$applyfordealservices,$contact_person);

	$resIns = $dbObj->cgi('tbl_users',$fl,$vl,'');


	#---------------------Send Registration Email---------------#
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
	$email_message = str_replace("[[fname]]",$_POST["first_name"],$email_message);
	$email_message = str_replace("[[lname]]",$_POST["last_name"],$email_message);
	$email_message = str_replace("[[email]]",$_POST["email"],$email_message);
	$email_message = str_replace("[[password]]",$_POST["password"],$email_message);
	$email_message = str_replace("[[phone_no]]",$_POST["phone_no"],$email_message);
	$date1 = date("d-m-Y");
	$email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
	$email_message = str_replace("[[link]]",$link, $email_message);

	$from = SITE_EMAIL;
	@mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
// echo "<br>".$email_message;
	#-----------End Send Registration email----------------#

	$s=$msobj->showmessage(2);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	
	@header("Location:".SITEROOT."/admin/user/seller_list.php");
	
}



if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/user/add_seller.tpl');
$dbObj->Close();
?>