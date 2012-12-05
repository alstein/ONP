<?php
include_once('../../includes/SiteSetting.php');
require_once("../../includes/classes/class.registration.php");
require_once("../../includes/common.lib.php");
include_once("../../includes/classes/combo.class.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if(!isset($_POST['Submit'])){
	$_SESSION['cities_name'] = array();
}

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



#-------------access levels-#
$rs1=$dbObj->cgs("mast_levels","","","","","","0");
while($rows=@mysql_fetch_array($rs1))
{
	$levels[] = $rows;
}
$smarty->assign("levels",$levels);

#------end---#

if(isset($_POST['email'])){

	extract($_POST);
	$flag = true;

	if($flag){
	$usertypeid = 2;

	$original_1 = newgeneralfileupload($_FILES["photo"], "../../uploads/user", true); 

	$fullname = $first_name." ".$last_name;
	$username = str_replace(" ","_",$first_name)."_".str_replace(" ","_",$last_name).rand();
	$tdate=$_POST['sel_dd']."-".$_POST['sel_mm']."-".$_POST['sel_yy'];;
	$arr=explode("-",$tdate);
	$bdate=$arr[2]."-".$arr[1]."-".$arr[0];

	$category_array=$_POST['cat_ref'];
	$count=count($category_array);
	$cat=$category_array[0];
	for($i=1;$i<$count;$i++)
	{
		if($category_array[$i]=="")
		{
		$category_preferance=$cat;
		}
		else
		{
		$category_preferance=$cat.",".$category_array[$i];
		}
	}
$fullname=$first_name." ".$last_name;

$insert=$dbObj->customqry("insert into tbl_users(first_name,last_name,	fullname,username,email,password,gender,birthdate,city,rel_status,grad_college,under_grad_college,music,activities ,category_preferance,photo,signup_date,usertypeid)values('".$first_name."','".$last_name."','".$fullname."','".$username."','".$email."','".md5($password)."','".$gender."','".$bdate."','".$city."','".$rel_status."','".$grad_collage."','".$under_grad_collage."','".$music."','".$activity."','".$category_preferance."','".$original_1."','".date("Y-m-d H:i:s")."','2')","");


	 $ses_userid=mysql_insert_id();

	$verifycode=md5($ses_userid * 32767);
	$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $ses_userid, "");

	$rs=$dbObj->cgs("tbl_users", "", "userid", $ses_userid, "", "", "");
	$user = @mysql_fetch_assoc($rs);

	#---------Send Registaration Email-------------#
	$verifycode=md5($resIns * 32767);
	$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $ses_userid, "");
	$rs=$dbObj->cgs("tbl_users", "", "userid", $ses_userid, "", "", "");
	$user = @mysql_fetch_assoc($rs);
	$email_query = "select * from mast_emails where emailid=16";

	$email_rs = @mysql_query($email_query);
	$email_row = @mysql_fetch_object($email_rs);
	$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
	$email_subject = str_replace("[[name]]",$fullname,$email_subject);

	$email_message = file_get_contents(ABSPATH."/email/email.html");

	$attach = SITEROOT."/registration/conformation/".$user['activationcode']."/".$ses_userid;
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
//      echo $email_message;exit;
       //echo "<pre>To ==".$email."<br>From ==".$from."<br>Sub ==".$email_subject."<br>Msg ==".$email_message."<br></pre>"; exit;
        $s=$msobj->showmessage(2);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

        @header("Location:".SITEROOT."/admin/user/users_list.php");
        exit;
      }
}

$year=date("Y")-17;
$smarty->assign("year",$year);
$smarty->assign("inmenu","user");
$smarty->display(TEMPLATEDIR . '/admin/user/add_user.tpl');
$dbObj->Close();
?>
