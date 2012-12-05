<?php
/**
* Project:     Outsourced2Earth
* File:        class.registration.php
*
* @author Yogesh Kadam <k dot yotesh at agiletechnosys dot com>
* @package Smarty
* @version 2.6.19
*/
Class Registration extends DBTransact
{
	function doRegistration()
	{
		//print_r($_POST);exit;
#----------Sanitize site data-----------#
		extract($_POST);
		if(isset($reference))
			$refid		= 	base64_decode($_POST['reference']);
		unset($_POST);
		#----------END-----------#

		unset($_SESSION['msg']);
		if($first_name == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter first name.</span>";
			return false;
		}
		elseif($email == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter email address.</span>";
			return false;
		}
		elseif($email == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter password.</span>";
			return false;
		}

		#----------Checking Email availability-----------#
		$rs = $this->customqry("SELECT * FROM tbl_users WHERE email='".$email."'", "");
		$row = @mysql_fetch_assoc($rs);
		if($row['userid'])
		{
			$_SESSION['msg'] = "<span class='error'>email address already in use.</span>";
			return false;
		}
		#----------END-----------#
		
		if(!isset($birth_date))  	$birth_date = "1980-01-01";
		if(!isset($gender)) 		$gender = "Female";
		if(!isset($countryid)) 	$countryid = 1;
		if(!isset($cityid)) 		$cityid = 1;
		if(!isset($alt_email))	$alt_email = '';

		if($usertypeid=='')
			$usertypeid = 2;

		$f = array("first_name", "last_name", "username", "email", 'alt_email',"address", "password",'zipcode', "birth_date", "gender","type","contactno","countryid", "city", "signup_date", "usertypeid","isverified","verified_date","ref_email");
		$v = array($first_name, $last_name, $username, $email, $alt_email,$address, md5($password), $zip, $birth_date, $gender,"buyer",$contactn, $countryid, $city, date("Y-m-d H:i:s"), $usertypeid,'yes',date("Y-m-d H:i:s"),$remail);
		$userid = $this->cgi("tbl_users", $f, $v, "");

		if($userid)
		{
			#------------Sending Registration email verification---------------#
			$activationcode = md5($userid * 32767);
			$rs = $this->customqry("UPDATE tbl_users SET activationcode='".$activationcode."' WHERE userid=".$userid, "");
			$_SESSION['activationcode'] = $activationcode;

						#--------------Email format--------------------------------#
	 	$rs=$this->cgs("mast_emails", "", "emailid",'25', "", "", "");
		$mail=@mysql_fetch_assoc($rs);	
	
	
		$myFile = "../../email/emailtemplate.html"; // HTML Template
		$content = file_get_contents($myFile);
		$image='<img src='.SITEROOT.'/templates/'.TEMPLATEDIR.'/images/logo_agile.gif border=none />';
		$sum = "";

		$link1 = "<a href=".SITEROOT.">Tonto.com</a>";
		$sitename = SITETITLE;
		  $msg = $mail['message'];
  		 $sub1 = $mail['subject'];


	 $_tmp = $email;
 			if($alt_email)
 				$_tmp .= " Or ".$alt_email;
		if ($content !== false){
				$sum = str_replace("[[siteroot]]",SITEROOT,$content);
				$sum1 = str_replace("[[default]]",TEMPLATEDIR,$sum);
				$sum2 = str_replace("[[subject]]",$sub1,$sum1);
				$sum3 = str_replace("[[content]]",trim($msg),$sum2);
				$sum4 = str_replace("[sitename]",$sitename,$sum3);
				$sum5 = str_replace("[first_name]",$first_name,$sum4);
				$sum6 = str_replace("[[last_name]]",$last_name,$sum5);
				$sum7 = str_replace("[email]", $_tmp, $sum6);
				$sum8 = str_replace("[password]", $password, $sum7);
				$link = "<a href=".SITEROOT."/admin/login/>login</a>";
			
				$sum9 = $mail['message'] = str_replace("[link]",$link,
		 $sum8);
			} else 
			{
				echo "error";
				// an error happened
			}

		$from = EMAIL_FROM;
// 		echo $sum9;
//  		exit;
		@mail($email,$sub1,$sum9,"From: $from\nContent-Type: text/html; charset=iso-8859-1","-femail@domain.com");
		//header("location:".$_SERVER['HTTP_REFERER']);
		}
#-------------------------End of send mail-------------------------------------

			//Commennt this code when upload it on server
				return $userid;
			//End Comment
		
			if($alt_email)
			{
				$flag=mail($alt_email,$mail['subject'],$mail['message'],$headers);
		
			return $userid;

			}
		else
			return false;
	}
	
		function doSupplierRegistration()
	{
		#----------Sanitize site data-----------#
		extract($_POST);
		if(isset($reference))
			$refid		= 	base64_decode($_POST['reference']);
		unset($_POST);
		#----------END-----------#

		unset($_SESSION['msg']);
		if($first_name == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter first name.</span>";
			return false;
		}
		elseif($email == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter email address.</span>";
			return false;
		}
		elseif($email == '')
		{
			$_SESSION['msg'] = "<span class='error'>enter password.</span>";
			return false;
		}

		#----------Checking Email availability-----------#
		$rs = $this->customqry("SELECT * FROM tbl_users WHERE email='".$email."'", "");
		$row = @mysql_fetch_assoc($rs);
		if($row['userid'])
		{
			$_SESSION['msg'] = "<span class='error'>email address already in use.</span>";
			return false;
		}
		#----------END-----------#

		if(!isset($birth_date))  	$birth_date = "1980-01-01";
		if(!isset($gender)) 		$gender = "Female";
		if(!isset($countryid)) 	$countryid = 1;
// 		if(!isset($cityid)) 		$cityid = 1;
		if(!isset($alt_email))	$alt_email = '';

		if($usertypeid=='')
			$usertypeid = 2;

		$f = array("first_name", "last_name", "email", 'alt_email', "password", "birth_date","type","company_name","aboutme", "signup_date", "usertypeid","contactno","address","membership_type","payment_details","service","service_cate","serviceSubCat","ServiceSubSubCat","countryid","state","city","service_details","service_experience","isverified","verified_date");
		$v = array($first_name, $last_name,  $email, $alt_email, md5($password), $birth_date,"supplier",$companyName,$aboutme, date("Y-m-d H:i:s"), $usertypeid,$phone,$address,2,$payment,$service,$servCat,$servSubCat,$servSubSubCat,$countryid,$state,$city,$servDetails,$experience,"yes",date("Y-m-d H:i:s"));
		$userid = $this->cgi("tbl_users", $f, $v, "");

		if($userid)
		{
			#------------Sending Registration email verification---------------#
			$activationcode = md5($userid * 32767);
			$rs = $this->customqry("UPDATE tbl_users SET activationcode='".$activationcode."' WHERE userid=".$userid, "");
			$_SESSION['activationcode'] = $activationcode;

			$rs=$this->cgs("mast_emails", "", "emailid",'25', "", "", "");
			$mail=@mysql_fetch_assoc($rs);	
	
	
		$myFile = "../../email/emailtemplate.html"; // HTML Template
		$content = file_get_contents($myFile);
		$image='<img src='.SITEROOT.'/templates/'.TEMPLATEDIR.'/images/logo_agile.gif border=none />';
		$sum = "";

		$link1 = "<a href=".SITEROOT.">Tonto.com</a>";
		$sitename = SITETITLE;
		$msg = $mail['message'];
  		$sub1 = $mail['subject'];
		$_tmp = $email;
 			if($alt_email)
 				$_tmp .= " Or ".$alt_email;
		if ($content !== false){
				$sum = str_replace("[[siteroot]]",SITEROOT,$content);
				$sum1 = str_replace("[[default]]",TEMPLATEDIR,$sum);
				$sum2 = str_replace("[[subject]]",$sub1,$sum1);
				$sum3 = str_replace("[[content]]",trim($msg),$sum2);
				$sum4 = str_replace("[sitename]",$sitename,$sum3);
				$sum5 = str_replace("[first_name]",$first_name,$sum4);
				$sum6 = str_replace("[[last_name]]",$last_name,$sum5);
				$sum7 = str_replace("[email]", $_tmp, $sum6);
				$sum8 = str_replace("[password]", $password, $sum7);
				$link = "<a href=".SITEROOT."/admin/login/>login</a>";
				$sum9 = $mail['message'] = str_replace("[link]",$link,$sum8);
			} 
		else 
			{
				echo "error";
				// an error happened
			}
			$from = EMAIL_FROM;
// 			echo $sum9;
//  			exit;
		@mail($email,$sub1,$sum9,"From: $from\nContent-Type: text/html; charset=iso-8859-1","-femail@domain.com");
		header("location:".$_SERVER['HTTP_REFERER']);
		}
			return $userid;
		if($alt_email)
			{
				$flag=mail($alt_email,$mail['subject'],$mail['message'],$headers);
		
		//	return $userid;
			}
		else
			return false;
	}

	function getCountryList()
	{
		$rs = $this->customqry("SELECT * FROM mast_country", "");
		while($row = @mysql_fetch_assoc($rs))
			$countries[] = $row;

		return $countries;
	}
	/** ---This function create for get stanadard membership info list--- **/
	function getMembership()
	{
		$cnd_mem = "type='Standard'";
		$mem = $this->gj("membership","*",$cnd_mem,"","","","","");
		while($memarray = @mysql_fetch_assoc($mem))
		{
			$membership[] = $memarray;			
		}
		//print_r($membership);
		return $membership;
	}
	/** ---This function create for get promotional membership info--- **/
	function getPromoMem($promocode)
	{
		$cnd_promo_mem = "promoCode='".$promocode."'";
		$mem_promo = $this->gj("membership","*",$cnd_promo_mem,"","","","","");
		$memarray_promo = mysql_fetch_assoc($mem_promo);
		return $memarray_promo;
	}
}
?>