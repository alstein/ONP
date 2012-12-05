<?php
include_once('../../includes/SiteSetting.php');
include_once('../../includes/class.message.php');

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


if(isset($_POST['email'])){

	$zipCode=$_POST['zipcode'];
	$city=$_POST['city'];

	if($_POST['zipcode'] != ""){
		$p=explode(" ",$_POST['zipcode']);
		if(strlen($p[0])>4){
			$zip=$p[0][0].$p[0][1].$p[0][2].$p[0][3];
			$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
			if(!$city){
				$zip=$p[0][0].$p[0][1].$p[0][2];
				$rs=$dbObj->cgs("zipData", "*", "zipcode", $zip, "", "", "");
				$row=@mysql_fetch_assoc($rs);
				$city=$row['city'];
			}
		}else{
			$rs=$dbObj->cgs("zipData", "*", "zipcode",$p[0], "", "", "");
			$row=@mysql_fetch_assoc($rs);
			$city=$row['city'];
		}
	}
	if($_POST['zipcode'] == ""){
		$foundCity =$_POST['city'];
		$rs=$dbObj->cgs("zipData", "*", "city", $foundCity, "zipcode ASC", "", "");
		$row=@mysql_fetch_assoc($rs);
		$zip=$row['zipcode'];
	}
	extract($_POST);
	$flag = true;

	if($flag){
	$usertypeid = 2;

	$fullname = $first_name." ".$last_name;
  
	$fl = array("first_name","last_name","fullname","username",'password','email','usertypeid',"signup_date",'city', 'postalcode','status',"access_level");
	$vl = array($first_name,$last_name,$fullname,$username,md5($password),$email,1,date("Y-m-d H:i:s"),$city,$zipCode,"Active",$level);
	$resIns = $dbObj->cgi('tbl_users',$fl,$vl,'');

	if($rs){
		$f_array = array("nemail"    => $email,
				"city"       => $city,
				"zipcode"    => $zipCode,
				"ndate"      => date("Y-m-d H:i:s"));
		$insertedId1 = $dbObj->cgii("tbl_newsletter",$f_array,"");
	}

	#---------Send Registaration Email-------------#
	$verifycode=md5($resIns * 32767);
	$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $resIns, "");
	$rs=$dbObj->cgs("tbl_users", "", "userid", $resIns, "", "", "");
	$user = @mysql_fetch_assoc($rs);
	$email_query = "select * from mast_emails where emailid=57";

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
        // echo "<pre>To ==".$email."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
        $s=$msobj->showmessage(2);
	$_SESSION['msg']="<span class='success'>Admin added successfully.</span>";

        header("Location:".SITEROOT."/admin/user/manage_admin.php");
        exit;
      }
}

#----------Get access level------------#
$m_id = $dbObj->gj("mast_levels","*","1","","","","","");
if($m_id !='n')
{
    while($modules = mysql_fetch_assoc($m_id))
	    $module_info[] =  $modules;
    $smarty->assign("level", $module_info);
}
#----------Get all Modules------------#

#----------Edit Admin------------#
$u_id = $dbObj->gj("tbl_users","*","userid='{$_GET['id']}'","","","","","");
if($u_id !='n')
{
    $rs_usr = mysql_fetch_assoc($u_id);
	$rs_usr =  $rs_usr;
    $smarty->assign("user", $rs_usr);
}
#----------Get all Modules------------#

if(isset($_SESSION['msg'])){ $smarty->assign("msg", $_SESSION['msg']); unset($_SESSION['msg']);}

// $smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/user/add-admin.tpl');
$dbObj->Close();
?>