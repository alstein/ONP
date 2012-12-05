<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#-------------Check For access------------#
if(!(in_array("44", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#-----------End Check For access----------#

$date=date("Y-m-d H:i:s",strtotime("+3 hours"));


$cnd_deal="admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and end_date >= '$date'";	
$res_deal = $dbObj->gj("tbl_deal","*",$cnd_deal,"","","","","");
	if($res_deal !='n')
	{
	while($_req_deal = @mysql_fetch_assoc($res_deal))
	{
		$_arr1_deal[] = $_req_deal;
	}
	$smarty->assign("deal",$_arr1_deal);
	}

#------------- Get Message type --------------#
$sf=array("nl_id,nl_name,nl_title");
$dbres = $dbObj->cgs("tbl_nl_content", $sf,"", "", "", "", $ptr);
if($dbres !='n')
{
    while($row_title = @mysql_fetch_assoc($dbres))
    {
	    $tilte[] = $row_title;
    }
    $smarty->assign("title",$tilte);
}
#-------------Get Message type--------------#

// 	$res11 = $dbObj->gj("mast_city as m,tbl_users as u","*","m.city_name=u.city and isverified = 'yes' and (usertypeid='2' OR usertypeid='3')","","m.city_name","","","");
// 	if($res11 !='n')
// 	{
// 	while($_req = @mysql_fetch_assoc($res11))
// 		$_arr1[] = $_req;
// 	$smarty->assign("city_arr",$_arr1);
// 	}
// 	
	//$qry = "SELECT * FROM student ORDER BY 'student_no' ASC LIMIT 0, 10";
	$tbl_city = "tbl_newsletter as c";
	$res11 = $dbObj->gj($tbl_city,"DISTINCT(city)","1","c.city","","","","");
	if($res11 !='n')
	{
	while($_req = @mysql_fetch_assoc($res11))
	{
		if($_req['city'] != '')
		{
			$_arr1[] = $_req;
		}
	}
	$smarty->assign("city_arr",$_arr1);
	}
	
#-------------Get Message content--------------#
if($_GET['news'])
{
    $nlid=$_GET['news'];

    if($nlid)
    {
	$cd =" nl_id = $nlid ";
	$res1 = $dbObj->gj("tbl_nl_content", "", $cd, "", "",  "ASC", $l, "");
	$frow =@mysql_fetch_assoc($res1);
	$page=$frow['nl_pagecontent'];

	$smarty->assign("pagecontent",$page);
    }
}
// include("../../../editor/fckeditor.php");
// $oFCKeditor = new FCKeditor('nl_pagecontent') ;
// $oFCKeditor->BasePath = '../../../editor/';
// $oFCKeditor->Value = html_entity_decode(stripslashes($frow['nl_pagecontent']));
// $oFCKeditor->Width  = '75%';
// $oFCKeditor->Height = '350';
// $smarty->register_object("oFCKeditor", $oFCKeditor);
include_once '../../../ckeditor/ckeditor.php' ;
require_once '../../../ckfinder/ckfinder.php' ;
$initialValue = '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' ;
$ckeditor = new CKEditor( ) ;
$ckeditor->basePath	= '../../../ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, '../../../' ) ;
$config['toolbar'] = array(
array( 'Source', '-', 'Bold', 'Italic', 'Underline', 'Strike' ),
array( 'NumberedList','BulletedList','-','Image','Format','FontSize','TextColor','BGColor'));
$initialValue = stripslashes(html_entity_decode($frow['nl_pagecontent']));
$editorcontent= $ckeditor->editor("editor2", $initialValue, $config);
//print_r($editorcontent);
$smarty->assign("oFCKeditor", $editorcontent);
#-------------End Message content--------------#

#------------Send Newsletter-------------------#
if(isset($_POST['submit']))
{
	extract($_POST);

	$res = $dbObj->cgs("tbl_nl_content", "","nl_id", $_POST['newsletter'], "", "", "");
	$row =@mysql_fetch_assoc($res);
	$title = $row['nl_title'];

	$subject = $subject;
	$strsplit="";

	if($_POST['city_name'] != 'all')
	{
		$cnd_email11 = "city = '".$_POST['city_name']."'";
		$res_user = $dbObj->gj("tbl_newsletter","nemail",$cnd_email11,"","","","","");//exit;
		
		$i=0; $user_arr ="";
		
		while($row_user = @mysql_fetch_assoc($res_user))
		$user_arr[] = $row_user;
		for($i=0;$i<count($user_arr);$i++)
		{
			$strsplit[$i] = $user_arr[$i]['nemail'];
		}
	}
	else
	{
		$cnd_email11 = "1";
		$res_user = $dbObj->gj("tbl_newsletter","nemail",$cnd_email11,"","","","","");//exit;
		
		$i=0; $user_arr ="";
		
		while($row_user = @mysql_fetch_assoc($res_user))
		$user_arr[] = $row_user;
		for($i=0;$i<count($user_arr);$i++)
		{
			$strsplit[$i] = $user_arr[$i]['nemail'];
		}
	}

// echo "<pre>";print_r($strsplit); 
// exit;

// 	if($_POST['all']=='all') //all seller
// 	{
// 		
// 		 $user_arr[] = $_POST['user_list'];
// 		for($i=0;$i<count($user_arr);$i++)
// 		    $strsplit[$i] = $_POST[]['user_list'];
// 	}
// 	else if($_POST['all']=='allbuyer') //all buyers
// 	{
// 	  $cnd="usertypeid =2 and isverified = 'yes'";
// 	  $res_user = $dbObj->gj("tbl_users","email",$cnd,"","","","","");
//   
// 	  $i=0; $user_arr ="";
// 
// 	  while($row_user = @mysql_fetch_assoc($res_user))
// 	      $user_arr[] = $row_user;
// 	  for($i=0;$i<count($user_arr);$i++)
// 	  {
// 	      $strsplit[$i] = $user_arr[$i]['email'];
// 	  }
// 	}
// 	else //all users
// 	{
//                 if($to !='')
// 		    $strsplit = split(",",$to);
// 	}

	
	//$str =explode(",",$_POST['user_list']);
	//$str= implode("','",$user_list);
// 	$res_user = $dbObj->gj("tbl_users","email","email IN('{$str}')","","","","","");
//   
// 	  $i=0; $user_arr ="";
// 
// 	  while($row_user = @mysql_fetch_assoc($res_user))
// 	      $user_arr[] = $row_user;
// 	  for($i=0;$i<count($user_arr);$i++)
// 	  {
// 	      $strsplit[$i] = $user_arr[$i]['email'];
// 	  }






if($_POST['user']=='all') //all users
	{
	     $cnd_users="1";  	
        }
 else
if($_POST['user']=='buyer')
        {
                
            $cnd_users="usertypeid=2"; 

        }
else
if($_POST['user']=='seller')
        {
                
            $cnd_users="usertypeid=3"; 

        }


$res_users = $dbObj->gj("tbl_users","first_name,last_name,email",$cnd_users,"","","","","");


#--fetching email content--#
                $mail_rs= $dbObj->cgs("mast_emails","*",array("emailid"),array(16),"","","");
                $mail = @mysql_fetch_assoc($mail_rs);    
                $mail_content=stripslashes(html_entity_decode($mail['message']));


                $i=0;
$msgs="";
	while($row = @mysql_fetch_assoc($res_users))
	{	
                $users[]=$row;
        $email_message = file_get_contents(SITEROOT."/email/all-users-email.html");
		$email_message = str_replace("[SITEROOT]", SITEROOT, $email_message);
		$email_message = str_replace("[[EMAIL_HEADING]]",$mail_content,$email_message);
		$email_message  = str_replace("[message]",nl2br($_POST['editor2']),$email_message);
		$email_message  = str_replace("[firstname]",$row['first_name'],$email_message);
		$email_message  = str_replace("[lastname]",$row['last_name'],$email_message);
		$from = "GroupBuyIt.co.uk <noreply@groupbuyit.co.uk>";
                //echo $email_message;exit;
		$sendmail = @mail($row['email'],$subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
        $i++;
        }


//$name=implode("','",$deal_name);
	



       
	    $_SESSION['msg_news']="<span>Email sent successfully</span>";

	//header("location:".$_SERVER['HTTP_REFERER']);
	//exit;
}


if($_SESSION['msg_news'])
{	
	$smarty->assign("msg",$_SESSION['msg_news']);
	unset($_SESSION['msg_news']);
}

$smarty->assign("nlid",$nlid);

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/message-center/all-users-email.tpl');
$dbObj->close();	
?>
