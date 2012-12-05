<?php 
ob_start();
include_once('../../include.php');
require_once '../../facebook-connect/facebook-php/src/facebook.php';

//create an object of facebook class
$facebook= new Facebook(array(
		 'appId'  => '271589349611901',
      'secret' => '645603ae1a15626e30d52a9b6a8806a8',
      'cookie' => true,
));

//get the current facebook login user id
$uid = $facebook->getUser();
$loginUrl=$facebook->getLoginUrl(array(
'scope'  => 'read_stream,publish_stream,publish_actions,read_requests,email,user_birthday,status_update,offline_access'
));

//if userid exists import the frinds of that user
if ($uid) {

	try {

		

			$friends = $facebook->api('/me/friends');	

	}catch (FacebookApiException $e) {
			error_log($e);
			$uid = null;
	}
}



$sfriends=array();
// print_r($sfriends);exit;
if(isset($_POST['submit'])){
		count($_POST['sfriends']);
		if($_POST['sfriends']!="")
		{	
			
			if($_SESSION['fb_271589349611901_access_token']!="" && $_SESSION['fb_271589349611901_user_id']!="")
				{
						$uid = $_SESSION['fb_271589349611901_user_id'];
						$access_token = $_SESSION['fb_271589349611901_access_token'];
						if($uid){

								try {
			
						
						
										echo $email_query = "select * from mast_emails where emailid 	=78";
											$email_rs = mysql_query($email_query);
											$email_row = mysql_fetch_assoc($email_rs);

											$link=SITEROOT."/my-account/".$_SESSION['csUserId']."/my_profile/";
											$link1='<a href="'.$link.'">Click Here To View His Portfolio</a>';
												echo "msg==".$email_row['message'];
											$d=str_replace("<p>","",html_entity_decode($email_row['message']));
											$d=str_replace("</p>","",$d);
											$d=str_replace("[[name]]",$_SESSION['csFullName'],$d);
											$d=str_replace("[[LINK]]",$link1,$d);
											$d=str_replace("[[SITETITLE]]",SITETITLE,$d);
// 		echo "in submit if";exit;
											$post =  array(
													'access_token' => $access_token,
													'method'       => 'stream.publish',
													'message'      => str_replace("[[name]]",$_SESSION['csFullName'],$email_row['subject']),
													'link'         => "www.offersnpals.com",
													'picture'      => 'http://www.offersnpals.com/templates/default/images/offernpals-logo.png',
													'description'  => $d,
													'actions'      => array(array('name' => "offersnpals",
																	'link' => "http://www.offersnpals.com/"))
											);
										

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


