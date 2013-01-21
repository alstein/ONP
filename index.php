<?php

include_once('include.php');

$year=date("Y")-17;
$smarty->assign("year",$year);

$date = date("Y-m-d H:i:s");	

$res = $dbObj->customqry("SELECT d.deal_unique_id,d.deal_title,d.offer_price,d.deal_image,d.deal_end_date,d.max_deal_no,d.discount_in_per,u.business_name,u.first_name,u.last_name FROM tbl_deals d,tbl_users u WHERE d.merchant_id=u.userid ORDER BY d.deal_end_date ASC");
while ($row = mysql_fetch_array($res))
{
    $all_deals[]=$row;
}

$smarty->assign("all_deals",$all_deals);

$categories = array();
$res = $dbObj->customqry("SELECT id, category FROM mast_deal_category WHERE parent_id = 0 AND active = 1");
while($rows = mysql_fetch_assoc($res))
{
//    $all_categories[$rows['id']][] = $rows['category'];
    $subcats = array();
    $res1 = $dbObj->customqry("SELECT id, category FROM mast_deal_category WHERE parent_id = '".$rows['id']."' AND active = 1");
    while($rows1 = mysql_fetch_assoc($res1))
    {
        $subcats[] = $rows1; 
//        $all_categories[$rows['id']][] = $rows1['category'];
    }
    $rows['subcats'] = $subcats;
    $categories[] = $rows;
}
       
//echo "<PRE>";
//print_r($cats);

$smarty->assign("categories",$categories);

//Category 
$sql="select * from mast_deal_category where parent_id=0 and active=1 order by category";
$result = mysql_query($sql) or die('Error, query failed');
$i = 0;
while($row = mysql_fetch_array($result))
{
    $tmp = array('id'=>$row['id'],
     'category'=>$row['category']);
    $results[$i++] = $tmp;
}
$count=mysql_num_rows($result);
$smarty->assign("category",$results);

// signup code
if(isset($_POST['Submit']))
{
    $result = 'true';
    if(trim($_REQUEST['email']) != "") {
        $cnd = "email ='".trim($_REQUEST['email'])."' and isDeleted <> 1";
        $rs = $dbObj->gj("tbl_users","email", $cnd, "", "", "", "", "");
        if($rs != 'n') {
            if($row =@mysql_fetch_assoc($rs)) {
                $result='false';
            }
        }
    }
    if($result == 'true') {
        $_SESSION['profilename']=$_POST['name'];
        $_SESSION['profilelname']=$_POST['lname'];
        $_SESSION['profileemail']=$_POST['email'];
        $_SESSION['profilereenter_email']=$_POST['reenter_email'];
        $_SESSION['profilepassword']=$_POST['password'];
        $_SESSION['profilesel_gender']=$_POST['sel_gender'];
        $_SESSION['profilebdate']=$_POST['sel_dd']."-".$_POST['sel_mm']."-".$_POST['sel_yy'];

        //Code by Konstant start
        if($_POST['chk_category']!="") {
            $category_array=$_POST['chk_category'];
            $cat=$category_array[0];
            for($i=1;$i<$count;$i++) {
                if($category_array[$i]=="") {
                    $cat=$cat;
                }
                else {
                    $cat=$cat.",".$category_array[$i];
                }
            }

            $_SESSION['profile_category']=$cat;
            $_SESSION['deal_by_email']=$_POST['deal_thr_email'];
            //@header("Location:".SITEROOT."/profilepicture");
            //exit;

            $arr=explode("-",$_SESSION['profilebdate']);
            $bdate=$arr[2]."-".$arr[1]."-".$arr[0];
            $fname=$_SESSION['profilename'];
            $lname=$_SESSION['profilelname'];
            $email=$_SESSION['profileemail'];
            $password=md5($_SESSION['profilepassword']);
            $gender=$_SESSION['profilesel_gender'];
            $city=$_SESSION['profilecity'];
            $rel_status=$_SESSION['profilel_relstatus'];
            $grad_collage=$_SESSION['profile_grad_collage'];
            $under_grad_collage=$_SESSION['profile_under_grad_collage'];
            $music=$_SESSION['profile_music'];
            $activities=$_SESSION['profile_activity'];
            //$intrested_in=$_SESSION['profile_intrested_in'];
            $category_preferance=$_SESSION['profile_category'];
            $photo=$_SESSION['profile_photo'];
            $signup_date=date("Y-m-d H:i:s");
            $username = str_replace(" ","_",$fname)."_".str_replace(" ","_",$lname).rand();
            $fullname=$fname." ".$lname;
            $deal_thr_email=$_SESSION['deal_by_email'];

            $insert=$dbObj->customqry("insert into tbl_users(first_name,last_name,fullname,username,email,password,gender,birthdate,city,rel_status,grad_college,under_grad_college,music,activities ,category_preferance,photo,signup_date,usertypeid,isverified,verified_date,status,deal_by_email)values('".$fname."','".$lname."','".$fullname."','".$username."','".$email."','".$password."','".$gender."','".$bdate."','".$city."','".$rel_status."','".$grad_collage."','".$under_grad_collage."','".$music."','".$activities."','".$category_preferance."','".$photo."','".$signup_date."','2','yes','".$signup_date."','active','".$deal_thr_email."')","");
            
            $ses_userid=mysql_insert_id();
            
            $verifycode=md5($ses_userid * 32767);
            //$rs=$dbObj->cupdt("tbl_users", "activationcode", $verifycode, "userid", $ses_userid, "1");
            $rs=$dbObj->cgs("tbl_users", "", "userid", $ses_userid, "", "", "");
            $user = mysql_fetch_assoc($rs);
//            print_r($user);
//            exit;
            /*$email_query = "select * from mast_emails where emailid=16";

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
            $email_message = str_replace("[[fname]]",$fname,$email_message);
            $email_message = str_replace("[[lname]]",$lname,$email_message);
            $email_message = str_replace("[[email]]",$email,$email_message);
            $email_message = str_replace("[[password]]",$_SESSION['profilepassword'],$email_message);

            $date1 = date("d-m-Y");
            $email_message = str_replace("[[TODAYS_DATE]]",$date1, $email_message);
            $email_message = str_replace("[[link]]",$link, $email_message);

            $from = SITE_EMAIL;
            @mail($email,$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
            $_SESSION['msg1']="You Are Registered Successfully.To Login click on verification link provided by you through email";*/
            // 		echo $email;
            // 	echo $email_message;
            // 	echo $email_subject;exit;
            if($_SESSION!="") {
                $_SESSION['profilebdate']="";
                $_SESSION['profilename']="";
                $_SESSION['profilelname']="";
                $_SESSION['profileemail']="";
                $_SESSION['profilepassword']="";
                $_SESSION['profilesel_gender']="";
                $_SESSION['profilecity']="";
                $_SESSION['profilel_relstatus']="";
                $_SESSION['profile_grad_collage']="";
                $_SESSION['profile_under_grad_collage']="";
                $_SESSION['profile_music']="";
                $_SESSION['profile_activity']="";
                $_SESSION['profile_intrested_in']="";
                $_SESSION['profile_category']="";
                $_SESSION['profile_photo']="";
                $_SESSION['deal_by_email']="";
//                unset($_SESSION);
            }
            // auto login Starts (Only for Customers)
            // set cookie
            setcookie("lemail", "");
            setcookie("lpassword", "");
            setcookie("isremember", 0);

            $_SESSION['usrLgn']         = "TRUE";
            $_SESSION['csUserId']       =  $user['userid'];
            $_SESSION['csFullName']     =  $user['fullname'];
            $_SESSION['csEmail']        =  $user['email'];
            $_SESSION['csUserTypeId']   =  $user['usertypeid'];
            $_SESSION['csUserAvtar']    =  ((strlen(trim($user['pic_image']))>0)?$user['pic_image']:"noimage");

            $f_array = array( // values for login log
                "userid"     => $user['userid'],
                "login_date"      => date("Y-m-d H:i:s"),
                "ipaddress"       => $_SERVER['REMOTE_ADDR']
            );

            $dbObj->cgii("tbl_login_log",$f_array,""); // update the login log table

            // auto login ends
             
//            @header("Location:".SITEROOT."/success/success/");
            header("Location:".SITEROOT."/my-account/my_profile_home");
            //header("Location:".SITEROOT);
        }
        //Code by Konstant end

        //@header("Location:".SITEROOT."/profileinfo");
        // header("Location:".SITEROOT."/profilestep");
        exit;
    }
    else {
        $smarty->assign('name',$_POST['name']);
        $smarty->assign('lname',$_POST['lname']);
        $smarty->assign('email', $_POST['email']);    
        $smarty->assign('gender',$_POST['sel_gender']);
        $smarty->assign('sel_dd',$_POST['sel_dd']);
        $smarty->assign('sel_mm',$_POST['sel_mm']);
        $smarty->assign('sel_yy',$_POST['sel_yy']);
        $smarty->assign('email_exist',"1");
    }
}

//if($_SESSION['msg1']!="")
//{
//    $msg_success=$_SESSION['msg1'];
//    $smarty->assign("msg_success",$msg_success);
//    unset($_SESSION['msg1']);
//}

$smarty->display(TEMPLATEDIR.'/newindex.tpl');

$dbObj->Close();
?>
