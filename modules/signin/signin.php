<?php
include_once('../../include.php');

header("location:".SITEROOT);

if(isset($_SESSION['csUserId']))
{
    header("location:".SITEROOT . "/my-account-view");
}

//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(22);
$smarty->assign("row_meta",$call_meta);

if(isset($_POST['login']))
{
	$cd = "password = '". md5($_POST["pass"])."' and email = '".$_POST["email"]."' AND status='active' AND isDeleted=0 AND usertypeid=2 AND isverified='yes' and fb_user_id=0 and twitter_uid=0";
	$result = $dbObj ->gj('tbl_users',"*",$cd,$ob,$gb,$ad,$l,""); 
	$c = @mysql_num_rows($result);
	//print_r($c);exit;
	if($c !="")
	{
		$abc=mysql_fetch_array($result);

////////Insert tbl_login_log table details Start////////////

		$f_array = array("userid"	=> $abc['userid'],
					"usertypeid"	=> 2,
					"login_date"	=> date("Y-m-d H:i:s"),
					"ipaddress"	=> $_SERVER['REMOTE_ADDR']
					);
		$InsertedIdLog = $dbObj->cgii("tbl_login_log",$f_array,"");

//////////Insert tbl_login_log table details End/////////////

////////Setting seller user Cookies Start////////

		if(isset($_POST['rememberme']))
		{
			setcookie('login', $_POST['email']);
			setcookie('pass', $_POST['pass']);
			setcookie('remember', "yes");
		}
		else
		{
			setcookie('login', "");
			setcookie('pass', "");
			setcookie('remember', "");
		}

////////Setting seller user Cookies End////////

////////Setting user session Start////////

		$_SESSION['csUserLgn'] 		= "TRUE";
		$_SESSION['csUserId']		= $abc['userid'];
		$_SESSION['firstname']		= $abc['first_name'];
		$_SESSION['lastname']		= $abc['last_name'];
		$_SESSION['csFullName']		= $abc['first_name']." ".$abc['last_name'];
		$_SESSION['csUserEmail']		= $abc['email'];
		$_SESSION['password']		=$abc['password'];
		$_SESSION['csUserTypeId'] 	= 2;
		$_SESSION['login_log_id']	= $InsertedIdLog;

		//print_r($_SESSION);exit;

////////Setting user session End//////////

		$url = SITEROOT."/my-account-view";
		if(isset($_SESSION['previous_page']))
		{
			$url = $_SESSION['previous_page'];
		}
		
		unset($_SESSION['previous_page']);
		header("location:". $url);
	}
	else
	{
		$_SESSION['msg']="Invalid Email or password.";
		$_SESSION['type']="buyer";
		header("location:".SITEROOT."/signin"); exit;
	}
}


if(isset($_POST['seller_login']))
{
	$cd = "password = '". md5($_POST["pass"])."' and email = '".$_POST["email"]."' AND status='active' AND isDeleted=0 AND usertypeid=3 AND isverified='yes' and fb_user_id=0 and twitter_uid=0";
	$result = $dbObj ->gj('tbl_users',"*",$cd,$ob,$gb,$ad,$l,""); 
	$c = @mysql_num_rows($result);
	//print_r($c);exit;
	if($c !="")
	{
		$abc=mysql_fetch_array($result);

////////Insert tbl_login_log table details Start////////////

		$f_array = array("userid"	=> $abc['userid'],
					"usertypeid"	=> 3,
					"login_date"	=> date("Y-m-d H:i:s"),
					"ipaddress"	=> $_SERVER['REMOTE_ADDR']
					);
		$InsertedIdLog = $dbObj->cgii("tbl_login_log",$f_array,"");

//////////Insert tbl_login_log table details End/////////////

////////Setting seller user Cookies Start////////

		if(isset($_POST['rememberme']))
		{
			setcookie('sellerlogin', $_POST['email']);
			setcookie('sellerpass', $_POST['pass']);
			setcookie('sellerremember', "yes");
		}
		else
		{
			setcookie('sellerlogin', "");
			setcookie('sellerpass', "");
			setcookie('sellerremember', "");
		}

////////Setting seller user Cookies End////////

////////Setting seller user session Start////////

		$_SESSION['admLgn']			= true;
		$_SESSION['duAdmId']		= $abc['userid'];
		$_SESSION['duAdmFname'] 		= $abc['first_name'];
		$_SESSION['duAdmLname'] 		= $abc['last_name'];
		$_SESSION['duUserTypeId'] 	= 3;
		//$_SESSION['duAdmlevelId']	= 0;
		$_SESSION['duAdmEmail']		= $abc['email'];
		$_SESSION['duadmpassword']	= $abc['password'];
		$_SESSION['login_log_id']	= $InsertedIdLog;

		//print_r($_SESSION);exit;

////////Setting seller user session End//////////

		$url = SITEROOT."/admin/seller/my-profile-view.php";
		if(isset($_SESSION['previous_page']))
		{
			$url = $_SESSION['previous_page'];
		}
		
		unset($_SESSION['previous_page']);
		header("location:". $url);
	}
	else
	{
		$_SESSION['msg']="Invalid Email or password.";
		$_SESSION['type']="seller";
		header("location:".SITEROOT."/signin"); exit;
	}
}


///////////////////
$toSetSection = (($_GET['st']) ? $_GET['st'] : "");
$smarty->assign("toSetSection", $toSetSection);

#--------------Get Country for Country dropdown--------------#
        $cnd="status = 'Active'"; 
        $selVal = (($input->post(""))?$input->post(""):"");
        $countryCombo = $combo->getComboCountry('countryid','country','country ASC', $cnd, $selVal, "");
        $smarty->assign("countryCombo", $countryCombo);
#--------------End Country for Country dropdown--------------#

	if(isset($_SESSION['msg']))
	{
		$smarty->assign("msg", $_SESSION['msg']);
		unset($_SESSION['msg']);
	}

	if(isset($_SESSION['msg_succ']))
	{
		$smarty->assign("msg_succ", $_SESSION['msg_succ']);
		unset($_SESSION['msg_succ']);
	}

	if(isset($_SESSION['twittmsg']))
	{
		$smarty->assign("twittmsg", $_SESSION['twittmsg']);
		unset($_SESSION['twittmsg']);
	}

	if(isset($_SESSION['type']))
	{
		$smarty->assign("type", $_SESSION['type']);
		unset($_SESSION['type']);
	}

$smarty->display(TEMPLATEDIR . '/modules/signin/signin.tpl');
$dbObj->Close();
?>