<?php 
ob_start();
include_once('../../include.php');
require_once '../../facebook-connect/facebook-php/src/facebook.php';

//create an object of facebook class
$facebook= new Facebook(array(
                'appId'  => '307567435998026',
                'secret' => '77046c89cec4155058e40e462edc8085',
                'cookie' => true,
));

//get the current facebook login user id
$uid = $facebook->getUser();
$loginUrl=$facebook->getLoginUrl(array(
'scope'  => 'publish_stream'
));

//if userid exists import the frinds of that user
if ($uid) {
	try {
			// Proceed knowing you have a logged in user who's authenticated.
			$friends = $facebook->api('/me/friends');		
	}catch (FacebookApiException $e) {
			error_log($e);
			$uid = null;
	}
}

$sfriends=array();
if(isset($_POST['submit'])){
		if($_POST['sfriends']!="")
		{	
			if($_SESSION['fb_358594510844783_access_token']!="" && $_SESSION['fb_358594510844783_user_id']!="")
				{
						$uid = $_SESSION['fb_358594510844783_user_id'];
						$access_token = $_SESSION['fb_358594510844783_access_token'];
						if($uid){
		
								try {
						
											$email_query = "select * from mast_emails where emailid=78";
											$email_rs = mysql_query($email_query);
											$email_row = mysql_fetch_object($email_rs);

											$link=SITEROOT."/my-account/".$_SESSION['csUserId']."/my_profile/";
											$link1='<a href="'.$link.'">Click Here To View His Portfolio</a>';

											$d=str_replace("<p>","",html_entity_decode($email_row->message));
											$d=str_replace("</p>","",$d);
											$d=str_replace("[[name]]",$_SESSION['csFullName'],$d);
											$d=str_replace("[[LINK]]",$link1,$d);
											$d=str_replace("[[SITETITLE]]",SITETITLE,$d);

											$post =  array(
													'access_token' => $access_token,
													'method'       => 'stream.publish',
													'message'      => str_replace("[[name]]",$_SESSION['csFullName'],$email_row->subject),
													'link'         => "www.Networkonsocialengine.com",
													'picture'      => 'http://72.29.76.227/~alsteinp/templates/default/images/inner_logo.png',
													'description'  => $d,
													'actions'      => array(array('name' => "Network On Social Engine",
																	'link' => "http://www.Networkonsocialengine.com/"))
											);
											//echo "<pre>";print_r($post);echo "<pre>";exit;
											for($p=0;$p < count($_POST['sfriends']);$p++)
											{
														$sendTo=$_POST['sfriends'][$p];
														$location = "/" . $sendTo . "/feed";
														$res[] = $facebook->api($location, 'POST', $post);
													    $_SESSION['connect_msg']="Your message is posted on friend's wall";
											}

		
								}catch (FacebookApiException $e) {
										error_log($e);
								}//end try/catch loop
		
								if($res){
										header("location:".SITEROOT."/modules/invitation/invitation.php");
								}
								exit;
		
						}else{  //end of if($uid)
								?><script type="text/javascript">alert("Access token invalid");</script><?php
						}
		
				}else{//end of if($_SESSION['fb_205887732815348_access_token']!="" && $_SESSION['fb_205887732815348_user_id']!="")
						?><script type="text/javascript">alert("Access token invalid");</script><?php
				}
		} else{
						$_SESSION['connect_msg']="Please select the friend(s) to post a message";
		}
}


//send invitation to facebook friends
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">
		$(document).ready(function()
		{
			
			$("#checkall").click(function(){
				$("#facebook_friends").find("input[name='sfriends[]']").attr("checked",this.checked);
			});
			
		});

function validate(){
	var cat_checked = $("input[id=sfriends]:checked").length;
	if(cat_checked==0){
		alert("Please select at least one checkbox");
		return false;
	}else{
		return true;
	}
		
}


		</script>

<form name="facebook_friends" id="facebook_friends" action="" method="POST">

<div id="facebook" style="<?php if (is_array($friends)) {?>height:470px;<?php } ?>width:450px;">
<table cellpadding="3" cellspacing="2">
<?php if(is_array($friends)){ ?>
<tr><td style="width:25px;padding-bottom:10px;"></td><TD colspan="4" style="padding-bottom:10px;padding-top:10px;font: 12px/16px Arial,Helvetica,sans-serif;color: #656565;"><input type="checkbox" name="checkall" id="checkall">&nbsp;&nbsp;Select All</td></tr>
<?php } ?>
<?php 
if(is_array($friends)){
$frdcnt=count($friends['data']);

for($i=0;$i<$frdcnt;$i++){
	echo '<TR><td style="width:25px;"></td><td style="width:25px;padding-bottom:10px;vertical-align:top"><input type="checkbox" name="sfriends[]" id="sfriends" value='.$friends['data'][$i]['id'].' ></td><TD style="width:300px;align:left;vertical-align:top;padding-bottom:10px;font: 12px/16px Arial,Helvetica,sans-serif;color: #656565;">';
	echo $friends['data'][$i]['name'].'</td><td style="width:150px;align:left;vertical-align:top;padding-bottom:10px;">';
	echo "<img src='https://graph.facebook.com/".$friends['data'][$i]['id']."/picture'>"; echo "<br>";
	echo '</TD></TR>';
}

}
?>
</table>
<input type='submit' name='submit' id='submit' value='Invite' onclick="return validate()">
</div>
</form>


