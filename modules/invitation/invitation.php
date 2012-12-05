<?php 

include_once('../../include.php');
// @include_once("templates/default/commonfiles/header-start.php"); 

if(isset($_SESSION['connect_msg']))
{
$message_fb=$_SESSION['connect_msg'];
unset($_SESSION['connect_msg']);
}

?>
<? if($msg){?>
<div align="center" style="color: green;font-size: 17px;"><? echo $msg;?></div>
<? } ?>
<?php


$a="no";
$send="no";
include('../../OpenInviter/openinviter.php');
$inviter=new OpenInviter();
$oi_services=$inviter->getPlugins();

/* for gmail */
if (isset($_POST['provider_box'])) 
{
	if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
	elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
	else $plugType='';
}
else $plugType = '';
function ers($ers)
{
	if (!empty($ers))
	{
		$contents="<table cellspacing='0' cellpadding='0' style='border:0px solid red;' align='center'><tr><td valign='middle' style='padding:3px' valign='middle'></td><td valign='middle' style='color:red;padding:5px;'>";
	
		foreach ($ers as $key=>$error)
		$contents.="{$error}<br >";
		$contents.="</td></tr></table><br >";
		return $contents;
	}
}
	
function oks($oks)
{
if (!empty($oks))
	{
	$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
	foreach ($oks as $key=>$msg)
	$contents.="{$msg}<br >";
	$contents.="</td></tr></table><br >";
	return $contents;
	}
}

if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
if (isset($_POST['import']) || isset($_POST['send']))
	{
// 	print_r($_POST);
// 	echo "step==".$step;
// echo "<br>";
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']))
			$ers['email']="Email missing !";
		if (empty($_POST['password_box']))
			$ers['password']="Password missing !";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing !";
// 	echo "<br>email==".$ers['email'];
// 		echo "<br>password==".$ers['password'];
// 		echo "<br>provider==".$ers['provider'];
// 		echo "<br>cnt==".count($ers);
	
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			echo "".$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
				$temp_var="1";
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				$ers['contacts']="Unable to get contacts !";
			else
				{
				$a="yes";
				echo '<input type="hidden" name="a" id="a" value="'.$a.'">';
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
				//print_r($_POST['check']);exit;
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing !';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal) $ers['internal']=$internal;
			else
				{
				if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing !';
				if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session !';
				//if (empty($_POST['message_box'])) $ers['message_body']='Message missing !';
				else $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
				if ($inviter->showContacts())
					{	
							$fullname=$_SESSION['csFullName'];
							$email_query = "select * from mast_emails where emailid=77";
						
							$email_rs = @mysql_query($email_query);
							$email_row = @mysql_fetch_object($email_rs);
							$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
							$email_subject = str_replace("[[name]]",$fullname,$email_subject);
						
							$email_message = file_get_contents(ABSPATH."/email/email.html");
							
							$link=SITEROOT."/my-account/".$_SESSION['csUserId']."/my_profile/";
							$link1='<a href="'.$link.'">Click Here To View His Portfolio</a>';
							$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
							$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
							
							$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
							$email_message = str_replace("[[LINK]]", $link1, $email_message);
							$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
							
							$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
							$email_message = str_replace("[[TODAYS_DATE]]",$signup_date, $email_message);
							$email_message = str_replace("[[link]]",$link, $email_message);
							$from = SITE_EMAIL;
							foreach ($_POST['check'] as $key=>$val){
								$email_message = str_replace("[[name]]",$fullname,$email_message);
								$email_message = str_replace("[[email]]",$email,$email_message);
								@mail(trim($val),$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
								$_SESSION['msg1']="You Are Registered Sucessfully.To Login click on verification link provided by you through email";
							}


						echo '<div align="center" style="padding-top:50px;background-color: white;color:#00CC00"><b>Invitations sent successfully.</b></div>';
						exit;
							
	
					}
				}
			}
			if (count($ers)==0)
			{
			
			}
		}
	}
/*else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	}*/

$contents.="<form action='' method='POST' name='frm' id='frm'>".ers($ers).oks($oks);

$done=false;
if (!$done)
	{
	//if ($step=='get_contacts')
	//	{
		$contents.="<table align='center' class='thTable' cellspacing='2' cellpadding='0' style='border:none;'>
			<tr class='thTableRow'><td >
			<label style='line-height:26px; margin-right:3px; width:95px; float:left'>Email Address</label>
			<div class='fl textbox'>
                  
                
			<input type='text' name='email_box' id='email_box' value='{$_POST['email_box']}' >
			</div>
			</td></tr>
			
			<tr class='thTableRow'><td>
			<label style='line-height:26px; margin-right:3px; width:95px; float:left'>Password</label>
			<div class='fl textbox'>
			<input class='field' type='password' name='password_box' id='password_box' value='{$_POST['password_box']}'>
			</div>			
			</td></tr>
			
			<tr class='thTableRow'  style='display:none'><td>
			<label style='line-height:26px; margin-right:3px;width:95px;'>Select Email Provider</label>
			<div class='register_forminput fl' style='width:283px; height:16px;'>
			<select class='field' name='provider_box' id='provider_box'>";
		
				$contents.="<option value='gmail'".">GMail</option>";
		
			$contents.="</select>
			
			</td></tr>
			<tr><td style='height:10px;'></td></tr>
			<tr class='thTableImportantRow'><td colspan='2' align='left'><input class='button1' type='submit' name='import' value='Import Contacts'></td></tr>
			<tr><td style='height:10px;'></td></tr>
		</table><input type='hidden' name='step' value='get_contacts'>";
	}
$contents.="</form>";


/* end for gmail*/

$contents1="<script type='text/javascript'>
	function toggleAll(element) 
	{
	var form = document.forms.openinviter, z = 0;
	
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
</script>";
$contents1.="<form action='' method='POST' name='openinviter' id='openinviter'>".ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$contents1.="<table class='thTable' align='center' cellspacing='0' cellpadding='0' style='width: 829px;'><tr class='thTableHeader'><td colspan='".($plugType=='email'? "3":"2")."'>Your contacts</td></tr>";
			if (count($contacts)==0)
				$contents1.="<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".($plugType=='email'? "3":"2")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents1.="<tr class='thTableDesc'><td><input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked>Invite?</td>".($plugType == 'email' ?"<td></td>":"")."</tr><tr class='{$class}'><td colspan='2' ><div style='overflow:auto;height:330px;width:428px'>";
				$odd=true;$counter=0;
				foreach ($contacts as $email=>$name)
					{
					$counter++;
					$email1=$email;	
					$email=substr($email,0,25);
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents1.="<div style='width:300px;float:left;padding-right:10px;margin-bottom:5px;'><input name='check[]' id='check' value='{$email1}' type='checkbox' class='thCheckbox' checked>&nbsp;&nbsp;".($plugType == 'email' ?"{$email}":"")."</div>";
					$odd=!$odd;
					}
			$contents1.="</div></td></tr><tr class='thTableFooter'><td colspan='".($plugType=='email'? "3":"2")."' style='padding-top:20px;'><input type='submit' name='send' value='Invite Friend' class='button1' onclick='return validate()'></td></tr>";



  
				}
			$contents1.="</table>";
			}
		$contents1.="<input type='hidden' name='step' value='send_invites'>
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
$contents1.="</form>";





/* for others */
if (isset($_POST['provider_box'])) 
{
	if (isset($oi_services['email'][$_POST['provider_box']])) $plugType='email';
	elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType='social';
	else $plugType='';
}
else $plugType = '';
function ers1($ers)
	{
	if (!empty($ers))
		{
		$contentsothers="<table cellspacing='0' cellpadding='0' style='border:0px solid red;' align='center'><tr><td valign='middle' style='padding:3px' valign='middle'></td><td valign='middle' style='color:red;padding:5px;'>";
		foreach ($ers as $key=>$error)
			$contentsothers.="{$error}<br >";
		$contentsothers.="</td></tr></table><br >";
		return $contentsothers;
		}
	}

function oks1($oks)
	{
	if (!empty($oks))
		{
		$contentsothers="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ($oks as $key=>$msg)
			$contentsothers.="{$msg}<br >";
		$contentsothers.="</td></tr></table><br >";
		return $contentsothers;
		}
	}

if (!empty($_POST['step'])) $step=$_POST['step'];
else $step='get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;
//if ($_SERVER['REQUEST_METHOD']=='POST')
if (isset($_POST['import1'])|| isset($_POST['send1']))
	{
	if ($step=='get_contacts')
		{
		if (empty($_POST['email_box']))
			$ers['email']="Email missing !";
		if (empty($_POST['password_box']))
			$ers['password']="Password missing !";
		if (empty($_POST['provider_box']))
			$ers['provider']="Provider missing !";
		if (count($ers)==0)
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal)
				$ers['inviter']=$internal;
			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
				{
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later !");
				$temp_var1="2";
				
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				$ers['contacts']="Unable to get contacts !";
			else
				{
				$a="yes";
				echo '<input type="hidden" name="a" id="a" value="'.$a.'">';
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
				//print_r($_POST['check']);exit;
		if (empty($_POST['provider_box'])) $ers['provider']='Provider missing !';
		else
			{
			$inviter->startPlugin($_POST['provider_box']);
			$internal=$inviter->getInternalError();
			if ($internal) $ers['internal']=$internal;
			else
				{
				if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing !';
				if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session !';
				//if (empty($_POST['message_box'])) $ers['message_body']='Message missing !';
				else $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				//$message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);

				$email_subject="test subject";
				$shareFaceTwittMsg="test messages";
 				$message = array("subject"=>$email_subject,"body"=>$shareFaceTwittMsg);
				//echo "==>".$_POST['oi_session_id'];
			//	echo "<pre>";print_r($message);echo "</pre>";

				//echo "<pre>";print_r($_POST['check1']);echo "</pre>";
             			//  $sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$_POST['check1']);
			 
				//echo "===>";exit;
				//$inviter->logout();
				//echo "==>".$sendMessage;
				//echo "<pre>";print_r($sendMessage);echo "</pre>";
				if ($inviter->showContacts())
					{
						 $sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$_POST['check1']);
						//echo "------>";exit;
						

								//invite friends
								/*$copyright = date("Y"). " StarCrews. All Rights Reserved";
								$sql = 'SELECT * FROM emailtemplate WHERE 1=1 AND ID=13';
								$rs = $db->customqry($sql);
								if(is_resource($rs) && $db->num_rows > 0){
									$email_row = $db->fetchAssoc($rs);
									$link 		= SITEROOT;
									$subject 	= str_replace("[[name]]", $_SESSION['usrS_firstname']." ".$_SESSION['usrS_lastname'], $email_row['subject']);
									$body 		= $email_row['email_message'];
									$body 		= str_replace("[[name]]", $_SESSION['usrS_firstname']." ".$_SESSION['usrS_lastname'], $body);
									$body 		= str_replace("[[SITEROOT]]", SITEROOT, $body);
									$body 		= str_replace("[[copyright]]", $copyright, $body);
									$body 		= html_entity_decode($body);
				
								}//end if
							

			

						foreach ($_POST['check1'] as $key=>$val){
							$send="yes";
							$_SESSION['send']="yes";
							include_once(ABSPATH."/includes/classes/phpmailer/class.phpmailer.php");
							$mail = new PHPMailer();
							$mail->Mailer = "mail";
							
							$mail->From=$_SESSION['usrS_email'];
							$mail->FromName=$_SESSION['usrS_firstname']." ".$_SESSION['usrS_lastname'];
			/*           	$mail->FromName=Starcrew;*/
							/*$mail->Sender=SITE_EMAIL; // indicates ReturnPath header
							$mail->AddAddress(trim($val));
							$mail->Subject = $subject;
							$mail->IsHTML(true);
							$mail->Body = $body;
							$mail->Send();
							
						}*/
					//	echo '<div align="center" style="padding-top:50px;background-color: white;"><b>Invitations sent successfully.</b></div>';
						exit;
					}
				}
			}
		if (count($ers)==0)
			{
			
			}
		}
	}
else
	{
	$_POST['email_box']='';
	$_POST['password_box']='';
	$_POST['provider_box']='';
	}

$contentsothers.="<form action='' method='POST' name='frm1' id='frm1'>".ers1($ers).oks1($oks);

$done=false;
if (!$done)
	{
	//if ($step=='get_contacts')
	//	{
		$contentsothers.="<table align='center' class='thTable' cellspacing='2' cellpadding='0' style='border:none;'>
			<tr class='thTableRow'><td >
			<label style='line-height:26px; margin-right:3px; width:95px;'>Email Address</label>
			<div class='register_forminput fl' style='width:283px; height:16px'>
			<input class='field' type='text' name='email_box' id='email_box' value='{$_POST['email_box']}' >
			</div>
			<div class='error' htmlfor='email_box' generated='true' style='padding-left:97px'></div>	
			</td></tr>
			<tr><td style='height:10px;'></td></td>
			<tr class='thTableRow'><td>
			<label style='line-height:26px; margin-right:3px; width:97px;'>Password</label>
			<div class='register_forminput fl' style='width:283px; height:16px'>
			<input class='field' type='password' name='password_box' id='password_box' value='{$_POST['password_box']}'>
			</div>
			<div class='error' htmlfor='password_box' generated='true' style='padding-left:97px'></div>	
			</td></tr>
			<tr><td style='height:10px;'></td></tr>
			<tr class='thTableRow'><td>
			<label style='line-height:26px; margin-right:3px;width:95px;'>Email Provider</label>
			<div class='register_forminput fl' style='width:283px; height:20px'>
			<select class='field' name='provider_box' id='provider_box' >";
			"<option value=''>Select Email Provider</option>";
			foreach ($oi_services as $type=>$providers)	
			{
				$contentsothers.="<optgroup label='{$inviter->pluginTypes[$type]}'>";
				foreach ($providers as $provider=>$details)
				$contentsothers.="<option value='{$provider}'".($_POST['provider_box']==$provider?' 		selected':'').">{$details['name']}</option>";
				$contentsothers.="</optgroup>";
			}

			//$contentsothers.="<option value='twitter'".">Twitter</option>";
			$contentsothers.="</select>
			</div>
			<div class='error' htmlfor='provider_box' generated='true' style='padding-left:95px'></div>
			</td></tr>
			<tr><td style='height:10px;'></td></tr>
			<tr class='thTableImportantRow'><td colspan='2' align='left'><input class='button1' type='submit' name='import1' value='Import Contacts'></td></tr>
			<tr><td style='height:10px;'></td></tr>
			</table><input type='hidden' name='step' value='get_contacts'>";
	}
$contentsothers.="</form>";



$contents2="<script type='text/javascript'>
	function toggleAll1(element) 
	{
	var form = document.forms.openinviter1, z = 0;
	
	for(z=0; z<form.length;z++)
		{
		if(form[z].type == 'checkbox')
			form[z].checked = element.checked;
	   	}
	}
	</script>";
$contents2.="<form action='' method='POST' name='openinviter1' id='openinviter1'>".ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$contents2.="<table class='thTable' align='center' cellspacing='0' cellpadding='0' style='height:480px'><tr class='thTableHeader'><td colspan='".($plugType=='email'? "3":"2")."'>Your contacts</td></tr>";
			if (count($contacts)==0)
				$contents2.="<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".($plugType=='email'? "3":"2")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents2.="<tr class='thTableDesc'><td><input type='checkbox' onChange='toggleAll1(this)' name='toggle_all1' title='Select/Deselect all' checked>Invite?</td>".($plugType == 'email' ?"<td></td>":"")."</tr><tr class='{$class}'><td colspan='2' ><div style='overflow:auto;height:350px;width:700px'>";
				$odd=true;$counter=0;
				//print_r($contacts);exit;
				$c=count($contacts);
				for($k=0;$k<$c;$k++)
				{
				$counter++;
				//$email1=$email;
				//$email=substr($email,0,25);
				if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
				$contents2.="<div style='width:200px;float:left'><input name='check1[]' value='{$contacts[$k]}' type='checkbox' class='thCheckbox' checked>".$contacts[$k]."</div>";
				$odd=!$odd;
				}
				$contents2.="</div></td></tr><tr class='thTableFooter'><td colspan='".($plugType=='email'? "3":"2")."' style='padding-top:30px;'><input type='submit' name='send1' value='Invite Friend' class='button1'></td></tr>";
				}
				$contents2.="</table>";
			}
				$contents2.="<input type='hidden' name='step' value='send_invites'>
					<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
					<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
					<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
$contents2.="</form>";


/* end for others*/

?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="<?php echo SITEROOT?>/js/jquery-1.2.6.pack.js"></script>
<!--<script src="<?php echo SITEROOT ?>/js/jquery.validate.pack.js"></script>-->
<link href="<?php echo SITEROOT ?>/templates/default/css/basic.css" rel="stylesheet" type="text/css" />
<link href="<?php echo SITEROOT ?>/templates/default/css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function togglegmail()
{
	$("#showgmail").toggle();
}

function toggleothers()
{
	$("#showothers").toggle();
}

</script>
<script language="javascript" type="text/javascript">

function popitup(url){
	newwindow=window.open(url,'name','height=600,width=600,scrollbars=yes');
	if (window.focus){
		newwindow.focus();
	}
	return false;
}


</script>
<script src="http://connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<script type="text/javascript">
   function offline_access_box(){
	     FB.getLoginStatus(function(response) {
			 if (response.status === 'connected') {
			var uid = response.authResponse.userID;
			var accessToken = response.authResponse.accessToken;
//                 	window.location.href = window.location.href;
// 				window.location.href = "<?php echo SITEROOT;?>/modules/invitation/share-fb-only.php?flag=pullcontact&facebook=1";
	window.location.href = "<?php echo SITEROOT;?>/modules/invitation/invite_facebook_friends.php";

         } else {
			alert('no user session available, someone you dont know');
         }
      });
   }
function validate(){
	var cat_checked = $("input[id=check]:checked").length;
	if(cat_checked==0){
		alert("Please select at least one checkbox");
		return false;
	}else{
		return true;
	}
		
}
</script>
</head><body style="background: none">
<div id="popup">
  <div class="tansbg"></div>
  <div class="popupmainwrap" style="top:0px;">
    <div class="popupwrap rel" style="position: fixed;width:429px;margin:0 auto;">
      <div class="midcontent ovfl-hidden">
        <div style="background:#eaeaea;background-color: white;">
          <!--<a href="<?php //echo $loginUrl;?>"> Connect</a> -->
          <div  <?php if($a=="yes" && $send=="no"){?> style="display:block;"<?php }  else {?> style="display:none;" <?php }?>>
          <?php if($contents1!=""){ echo $contents1;} if($contents2!=""){ echo  $contents2; } ?>
        
        </div>
        <div class="clr"></div>
        <div  <?php if($send=="yes"){?> style="display:block;width:429px;height:452px;color:green"<?php }  else {?> style="display:none;" <?php }?> align="center" class="success">
        Invitations sent successfully.</div>
      <div class="clr"></div>
      <?php if($message_fb!=""){ ?>
      <div style="height:20px;vertical-align:middle;padding-left:150px;background-color: white;"></div>
      <span style="padding-left:150px;background-color:white"><strong>
      <?php if($message_fb!="") { echo $message_fb; }?>
      </span></strong> </div>
    <?php }?>
    <!--invited to facebook friends-->
    <!--facebook friends-->
    <div id="maincont" class="rel" <?php if(($_POST['import']=="Import Contacts" && $send=="yes") ||( $a=="yes")){ ?> style="display:none" <?php }else { ?> style="display:block" <?php } ?>>
      
        <div class="ovfl-hidden">
        <div class="register ovfl-hidden " style="width:400px; margin:0 auto">
          
          <div style="border-bottom:2px solid #dadada; margin:15px 0 0 0; padding:0 0 10px 0" <?php if(($_POST['import']=="Import Contacts" && $send=="yes") ||( $a=="yes")){ ?> style="display:none" <?php }else { ?> style="display:block" <?php } ?>>
          <p style=" font: bold 12px Arial, Helvetica, sans-serif; color:#333333; line-height:18px">
          Invite your friends to Offersnpals. Searching through your email
          account is the fastest way to let them know you're on Offersnpals!
          </p>
          
          </div>
          <ul class="reset ovfl-hidden register_form">
            <li style="margin:15px 0 0 0; border-bottom:2px solid #dadada; padding:0 0 10px 0"<?php if(($_POST['import']=="Import Contacts" && $send=="yes") ||( $a=="yes")){ ?> style="display:none" <?php }else { ?> style="display:block" <?php } ?> >
            <div class="regi2  ovfl-hidden" style="height:50px">
              <h1 class="fl"><a href="#"><img src="<?php echo SITEROOT; ?>/templates/<?php echo TEMPLATEDIR?>/images/gmail_img.png" width="82" height="36" alt="Gmail"></a></h1>
              <div class="fr finpadtop" style="margin-right:110px;"><a href="javascript:void(0)" onClick="togglegmail()"><strong>Find Friends</strong></a></div>
            </div>
            <div id="showgmail"  <?php if($_POST['import']=="Import Contacts"){ ?> style="display:block" <?php }else { ?> style="display:none" <?php } ?>>
            <?php echo $contents;?>
            </div>
            <div class="clr"></div>
            </li>
            <li style="padding:10px 0 0px 0"<?php if(($_POST['import']=="Import Contacts" && $send=="yes") ||( $a=="yes")){ ?> style="display:none" <?php }else { ?> style="display:block" <?php } ?>>
            <div class="regi2" >
              <div class="fl" style="padding-top:8px"><a href="#"><img src="<?php echo SITEROOT; ?>/templates/<?php echo TEMPLATEDIR?>/images/facebook.png"  alt="Yahoo!"></a></div>
              <div id="fb-root" class="fl" ></div>
              <script type="text/javascript">
						FB.init({ 
							appId:'271589349611901',
							cookie:true,
							status:true,
							xfbml:true
						});
				</script>
              <div style="float:right;width:180px; margin:15px 0 0 0">
                <fb:login-button v="2" onlogin="offline_access_box();" scope="read_stream,publish_stream,publish_actions,read_requests,email,user_birthday,status_update,offline_access">
                  <fb:intl>Connect with Facebook</fb:intl>
                </fb:login-button>
              </div>
            </div>
            <div class="clr"></div>
            </li>
            <!--//twitter-->
            <li style="margin:15px 0 0 0; border-bottom:2px solid #dadada; padding:10px 0 0px 0" <?php if(($_POST['import']=="Import Contacts" && $send=="yes") ||( $a=="yes")){ ?> style="display:none" <?php }else { ?> style="display:block" <?php } ?>>
            <div class="regi2 fl" style="padding-top:8px">
              <div class="fl" style="width:200px"> <a href="#"><img src="<?php echo SITEROOT?>/templates/<?php echo TEMPLATEDIR ?>/images/twitter-logo.png" style="border:none" /> </a></div>
              <div class="fr finpadtop" style="padding-right:4px;vertical-align:top; margin:10px 0 0 20px"><a href="javascript:void(0);" onClick="return popitup('https://twitter.com/intent/tweet?original_referer=http://offersnpals.com/friends&amp;text= Network On Social Engine is an awesome way to share your updates with your friends and public. Join me @ networkonsocialengine.com')"><strong>Find Friends</strong></a></div>
            </div>
            </li>
          </ul>
        
      </div>
    </div>
  
</div>
<div class="clr"></div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>