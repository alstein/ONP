<?php
include_once("../../includes/common.lib.php");
include_once('../../includes/SiteSetting.php');
if(isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/index.php");

$pgbck = $_POST['pgbck'];
/********************************** start server side validation **********************************/
if($_POST['loginname'] != '' && $_POST['password'] != '')
{
	$admin_loginname = $dbObj->sanitize($_POST['loginname']);
	$admin_password = $dbObj->sanitize($_POST['password']);

	if( (strpos($admin_loginname, "'") === false) )
	{
		$cnd="username='" . $admin_loginname . "' AND password='" . md5($admin_password) . "' AND usertypeid =1 and isDeleted=0 and status='active'";
		$res = $dbObj->gj("tbl_users", "*", $cnd, "", "", "", "", "");
		
		
		if($res != 'n')
			$row=mysql_fetch_assoc($res);
		if($row)
		{
			if(isset($rememberme))
			{
				setcookie('loginName', $row['loginName']);
				setcookie('duUsrpass', $row['loginPassword']);
			}
		
			$_SESSION['admLgn']=true;
			$_SESSION['duAdmId']=$row['userid'];
			$_SESSION['duAdmFname'] = $row['first_name'];
			$_SESSION['duAdmLname'] = $row['last_name'];
			$_SESSION['duUserTypeId'] = $row['usertypeid'];
			$_SESSION['duAdmThumbnail'] = $row['thumbnail'];
			$_SESSION['duAdmlevelId']=$row['access_level'];
			
		
			$f_array = array("userid"     => $row['userid'],
							"username"        => $_POST['loginname'],
							"login_date"      => date("Y-m-d H:i:s"),
							"ipaddress"       => $_SERVER['REMOTE_ADDR'],
							"success"         => 'yes');
		
			$InsertedIdLog=$dbObj->cgii("tbl_admin_login_log",$f_array,"");
		
		$_SESSION['login_log_id']= $InsertedIdLog;
		//print_r($_SESSION);exit;
			if($pgbck=="")
			{
				header("Location:".SITEROOT."/admin/index.php");
			}
			else
			{
				header("Location:".$pgbck);
			}
		}
		else
		{
			$f_array = array("userid"     => $row['userid'],
							"username"        => $_POST['loginname'],
							"login_date"      => date("Y-m-d H:i:s"),
							"ipaddress"       => $_SERVER['REMOTE_ADDR'],
							"success"         => 'no');
		
			$dbObj->cgii("tbl_admin_login_log",$f_array,"");
			$_SESSION['msg']="<span class='error'>Incorrect login information, Please enter valid information.</span>";
			header("Location:". SITEROOT ."/admin/login/index.php");
		}
	}else
	{
		$_SESSION['msg']="<span class='error'>Incorrect login information, Please enter valid information.</span>";
		header("Location:". SITEROOT ."/admin/login/index.php");
	}
}else{
	$_SESSION['msg']="<span class='error'>Please enter username and password.</span>";
	header("Location:". SITEROOT ."/admin/login/index.php");
}

?>