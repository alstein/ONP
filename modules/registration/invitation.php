<?php 
define('PREFIX', '../../');
include_once('../../include.php');
include_once('../../includes/SiteSetting.php');
include_once('../../includes/SiteConfig.php');
include_once(PREFIX."includes/grid.class.php");
// include_once(PREFIX."includes/classes/input.class.php");
require_once(PREFIX."includes/classes/formvalidator.class.php");
//if($_SESSION['profile_intrested_in']=="")
if($_SESSION['profile_category']=="")
{
@header("Location:".SITEROOT."/profilestep");
}
?>

<?php if($msg){?>
<div align="center" style="color: green;font-size: 17px;"><?php echo $msg;?></div><?php } ?>

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
		$contents="<table cellspacing='0' cellpadding='0' style='border:0px solid red;' align='center' width='100%'><tr><td valign='middle' style='padding:3px' valign='middle'></td><td valign='middle' style='color:red;padding:5px;text-align:center'>";
	
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
	$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;'  width='1270px' align='center'><tr><td valign='middle' valign='middle'><img src='images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
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
				$temp_var="1";
				}
			elseif (false===$contacts=$inviter->getMyContacts())
				$ers['contacts']="Unable to get contacts !";
			else
				{
				$a="yes";
				 '<input type="hidden" name="a" id="a" value="'.$a.'">';
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
						

//new

							$fullname=$_SESSION['profilename']." ".$_SESSION['profilelname'];
							$email_query = "select * from mast_emails where emailid=78";
						
							$email_rs = @mysql_query($email_query);
							$email_row = @mysql_fetch_object($email_rs);
							$email_subject = str_replace("[[SITETITLE]]", SITETITLE, $email_row->subject);
							$email_subject = str_replace("[[name]]",$fullname,$email_subject);
						
							$email_message = file_get_contents(ABSPATH."/email/email.html");
							
							//$link=SITEROOT."/my-account/".$_SESSION['csUserId']."/my_profile/";
							$link=SITEROOT;
							$link1='<a href="'.$link.'">Offersnpals</a>';
							$email_message = str_replace("[[SITEROOT]]", SITEROOT, $email_message);
							$email_message = str_replace("[[EMAIL_HEADING]]",$email_subject,$email_message);
							
							$email_message = str_replace("[[EMAIL_CONTENT]]",html_entity_decode($email_row->message),$email_message);
							$email_message = str_replace("[[LINK]]", $link1, $email_message);
							$email_message = str_replace("[[SITETITLE]]", SITETITLE, $email_message);
							
							$email_message = str_replace("[[SITEROOT]]",SITEROOT,$email_message);
							$email_message = str_replace("[[TODAYS_DATE]]",date("Y-m-d H:i:s"), $email_message);
							$email_message = str_replace("[[link]]",$link, $email_message);
							$from = SITE_EMAIL;





			

						foreach ($_POST['check'] as $key=>$val){
							$send="yes";
							$_SESSION['send']="yes";

								$email_message = str_replace("[[name]]",$fullname,$email_message);
								$email_message = str_replace("[[email]]",$email,$email_message);
								@mail(trim($val),$email_subject,$email_message,"From: $from\nContent-Type: text/html; charset=iso-8859-1");
								$_SESSION['msg1']="You Are Registered Sucessfully.To Login click on verification link provided by you through email";

							
							
							
						}
						
					}
				}
			}
			if (count($ers)==0)
			{
			
			}
		}
	}


$contents.="<form action='' method='POST' name='frm' id='frm'>".ers($ers).oks($oks);

$done=false;
if (!$done)
	{
	//if ($step=='get_contacts')
	//	{
		$contents.="<table align='center' class='thTable' cellspacing='2' cellpadding='0' style='border:none;'>
			<tr class='thTableRow'><td >
			<label style='line-height:26px; margin-right:3px; width:95px;'>Email Address:</label>
			<input class='textbox' style='border:none' type='text' name='email_box' id='email_box' value='{$_POST['email_box']}' >
			
			</td></tr>
			<tr><td style='height:10px;'></td></td>
			<tr class='thTableRow'><td>
			<label style='line-height:26px; margin-right:3px; width:95px;'>Password:</label>
			<input class='textbox' style='border:none;margin-left:56px;'  type='password' name='password_box' id='password_box' value='{$_POST['password_box']}'>			
			</td></tr>
			<tr><td style='height:10px;'></td></tr>
			<tr class='thTableRow'  style='display:none'><td>
			<label style='line-height:26px; margin-right:3px;width:95px;'>Select Email Provider</label>
			<div class='register_forminput fl' style='width:283px; height:16px;'>
			<select class='field' name='provider_box' id='provider_box'>";
		
				$contents.="<option value='gmail'".">GMail</option>";
		
			$contents.="</select>
			
			</td></tr>
			<tr><td style='height:10px;'></td></tr>
			<tr class='thTableImportantRow'><td colspan='2' align='left'>
				<span style=margin-left:'10px'; class='sitesub-btn-lft'><span class='sitesub-btn-right'>
			<input class='loc_busines fl' type='submit' name='import' value='Import Contacts'>
			</span></span>
			</td></tr>
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
$contents1.="<div style='width:514px;'><form action='' method='POST' name='openinviter' id='openinviter'>";//.ers($ers).oks($oks);
if (!$done)
	{
	if ($step=='send_invites')
		{
		if ($inviter->showContacts())
			{
			$contents1.="<table class='thTable' align='center' cellspacing='0' cellpadding='0' style='height:320px;overflow-y: scroll;'><tr class='thTableHeader'><td colspan='".($plugType=='email'? "2":"1")."'>Your contacts</td></tr>";
			if (count($contacts)==0)
				$contents1.="<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".($plugType=='email'? "2":"1")."'>You do not have any contacts in your address book.</td></tr>";
			else
				{
				$contents1.="<tr class='thTableDesc'><td><input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked>Invite?</td>".($plugType == 'email' ?"<td></td>":"")."</tr><tr class='{$class}'><td colspan='2' ><div style='overflow:auto ;height:250px;width:496px;'>";
				$odd=true;$counter=0;
				foreach ($contacts as $email=>$name)
					{
					$counter++;
					$email1=$email;	
					$email=substr($email,0,25);
					if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					$contents1.="<div style='width:220px;float:left;padding-right:15px;'><input name='check[]' value='{$email1}' type='checkbox' class='thCheckbox' checked>".($plugType == 'email' ?"{$email}":"")."</div>";
					$odd=!$odd;
					}
				$contents1.="</div></td></tr><tr class='thTableFooter'><td colspan='".($plugType=='email'? "2":"1")."' style='padding-top:0px;'><input type='submit' name='send' value='Invite Friend' class='button1'></td></tr>";
				}
			$contents1.="</table>";
			}
		$contents1.="<input type='hidden' name='step' value='send_invites'>
			<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
		}
	}
	$contents1.="</form></div>";





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
				 '<input type="hidden" name="a" id="a" value="'.$a.'">';
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
				}
			}
		}
	elseif ($step=='send_invites')
		{
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
				else $_POST['message_box']=strip_tags($_POST['message_box']);
				$selected_contacts=array();$contacts=array();
				$email_subject="test subject";
				$shareFaceTwittMsg="test messages";
 				$message = array("subject"=>$email_subject,"body"=>$shareFaceTwittMsg);
				if ($inviter->showContacts())
					{
						 $sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$_POST['check1']);

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
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<!-- Website title -->

<title>User Profile</title>

<!--Attached css-->

<link href="<?php echo SITEROOT?>/templates/default/css/basic.css" rel="stylesheet" type="text/css">
<link href="<?php echo SITEROOT?>/templates/default/css/main.css" rel="stylesheet" type="text/css">
<link href="<?php echo SITEROOT?>/templates/default/css/form.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="<?php echo SITEROOT?>/js/jquery-1.4.4.js"></script>
<script src="<?php echo SITEROOT ?>/js/jquery.validate.pack.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo SITEROOT?>/favicon.ico"/>


<script type="text/javascript">
function togglegmail()
{
	var state=document.getElementById('showgmail').style.display;
	if(state == 'block')
	{
		document.getElementById('showgmail').style.display = 'none';
		$("#gbord").css("border-bottom","none");
	}
	else
	{
		document.getElementById('showgmail').style.display = 'block';
		$("#gbord").css("border-bottom","1px solid #DADADA");
	}
}

function toggleothers()
{

		var state=document.getElementById('showothers').style.display;
		if(state == 'block')
		{
			document.getElementById('showothers').style.display = 'none';
		}
		else
		{
			document.getElementById('showothers').style.display = 'block';
		}
}
function redirect()
{
	window.location.href = '<?php echo SITEROOT?>/modules/registration/invite_friend.php?id=1';
}

function validate_terms(){
	$("#termsfrm").validate();
	if($("#termsfrm").valid()){
		
		var act='<?php echo SITEROOT?>/modules/registration/invite_friend.php?id=1';
		$("#termsfrm").attr("action", act);
		$("#termsfrm").submit();	
	}
}



function validate_terms1(){
	$("#termsfrm").validate();
	if($("#termsfrm").valid()){
		window.location='<?php echo SITEROOT?>/modules/registration/invite_friend.php?id=1';
	}
}

</script>

<script language="javascript" type="text/javascript">
// <!--
function popitup(url) {
	newwindow=window.open(url,'name','height=600,width=600,scrollbars=yes');
	if (window.focus) {newwindow.focus();}
	return false;
}

// -->
</script>
<script type="text/javascript" language="JavaScript">

$(document).ready(function(){
	$("#termsfrm").validate({
		errorElement:'div',
		rules: {
			chk_agree:{
				required: true
			}
		},
		messages: {
			chk_agree:{
				required: "Please Agree to Terms and Conditions to proceed"
			}
		}
	});
	
});
</script>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
   function share_offline_access_box(){
      FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
			var uid = response.authResponse.userID;
			var accessToken = response.authResponse.accessToken;
                	window.location.href = "<?php echo SITEROOT?>/modules/invitation/invite_facebook_friends_register.php";
         } else {
			alert('no user session available, someone you dont know');
         }
      });
   }
</script>


</head>

<body id="inner-head">

<!-- main continer of the page -->

<div id="wrapper">

  <div id="header">
    <div>
      <h1 id="inner-page-logo" class="fl"><a href="{$siteroot}">&nbsp;</a></h1>
	
      
    </div>
    <div class="clr"></div>
  </div>
  <!-- Header ends -->

  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="creat-deal">


	<h1>User Registration</h1>

      <div class="profile-thumb">

      <ul class="reset profile-thumb">

      <li >

      <h1>Step-1</h1>

      <p>Profile Info</p>

      </li>

      

      <li>

      <h1>Step-2</h1>

      <p>Profile Picture</p>

      </li>

      <li class="active">

      <h1>Step-3</h1>

      <p>Invite friends</p>

      </li>

      </ul>

     
      <div class="clr"></div>

      </div>

      <div class="registration-form-inn">

        <div class="form-inn">

          <h2><span>Quite a few of your friends might be here :</span></h2>

          <p class="title">Browsing through your email contacts is the best way to find your friends on </p>

          <ul class="reset mail-listing">


		<div  <?php if($send=="yes"){ ?> style="display:block;color:green"<?php }  else { ?> style="display:none;" <?php }?> align="center" class="success">Invitations sent successfully.</div>


            <li>

              <div class="fl"> <img src="<?php echo SITEROOT?>/templates/default/images/gmail-img.png" width="93" height="41" alt="" title="" /> </div>

              <div class="fr"> <a href="javascript:void(0)" onClick="togglegmail()">Find Friend</a> </div>

              <div class="clr"></div>

            </li>



            <li id="gbord" style="<?php if($a=="yes"){?> border-bottom:1px solid #DADADA"<?php }else {?>border-bottom:none" <?php }?>>


<div  id="showgmail" <?php if($_POST['import']=="Import Contacts" && $a=="no"){ ?> style="display:block" <?php }else { ?> style="display:none" <?php } ?>>
	<?php echo $contents;?>
</div>

<div  <?php if($a=="yes" && $send=="no"){ ?> style="display:block;"<?php }  else {?> style="display:none;" <?php }?>><?php if($contents1!=""){ echo $contents1;
} ?>
</div>

            </li>







            <li>


					<div id="fb-root"></div>
					<script>
								FB.init({ 
									appId:'307567435998026',
									cookie:true,
									status:true,
									xfbml:true
								});
					</script>

              <div class="fl"> <img src="<?php echo SITEROOT?>/templates/default/images/fb-img.png" width="82" height="36" alt="" title=""  /> </div>


              <div class="fr"> 
					<fb:login-button v="2" onlogin="share_offline_access_box();" scope="publish_stream">	
                    	    <fb:intl>Connect with Facebook</fb:intl>
                     </fb:login-button>
			  </div>


              <div class="clr"></div>

            </li>

            <li>

              <div class="fl"> <img src="<?php echo SITEROOT?>/templates/default/images/twiiter-img.png" width="82" height="36" alt="" title="" /> </div>

              <div class="fr"> <a href="javascript:void(0);" onClick="return popitup('https://twitter.com/intent/tweet?original_referer=http://offersnpals.com/friends&amp;text= Network On Social Engine is an awesome way to share your updates with your friends and public. Join me @ networkonsocialengine.com')">Find Friend</a> </div>

              <div class="clr"></div>

            </li>

<form name="termsfrm" id="termsfrm" action="" method="POST" >
            <li style="border:none">

            <div class="fl" style="margin-left:30px;width:427px;">

			<input type="checkbox"  class="styled fl" name="chk_agree" id="chk_agree" value="yes" style="display:block;"/>
			    <p class="fl forminntxt" style="line-height:15px"> I have read and Agree to <a href="<?php echo SITEROOT?>/terms">Term &amp; Conditions</a></p>

                <a href="javascript:void(0)" class="fr" onClick="validate_terms1();">Skip this Step</a>

			  </div>

              <div class="clr"></div>

            </li>

			<li><div htmlfor="chk_agree" generated="true" class="error" style="padding-left:30px"></div></li>
          </ul>

          <div class="clr"></div>

          <div class="pre-btn fr">

			<input type="submit" name="submit" id="submit" style="width:192px" value="Save And Continue" class="previe-btn" onClick="validate_terms()">

          </div>

          <div class="clr"></div>

</form>
        </div>

      </div>

    </div>

    <!-- Maincontent ends -->

  </div>

</div>

<!-- Footer starts -->

<div id="footer">

  <div id="footerwrap">

    <p class="fl"><a href="<?php echo SITEROOT?>/help/19/content/">Help</a> | <a href="<?php echo SITEROOT?>/blog">Blog</a> | <a href="<?php echo SITEROOT?>/faq/faq-consumer/">Faq</a> | <a href="<?php echo SITEROOT?>/privacy-policy">Privacy</a> | <a href="<?php echo SITEROOT?>/contact-us">Contact Us</a> | <a href="<?php echo SITEROOT?>/terms">Terms</a> </p>

    <div class="copy fr"> <span class="copytxt">Talk to Us? Here you go:<b> we_listen@alsteincorp.com</b></span>

      <p class="copytxt">© 2012 Alstein Pte Ltd. All Rights Reserved.</p>

    </div>

  </div>

</div>

<!-- Footer ends -->

</body>

</html>
