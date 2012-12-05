<?php 
error_reporting(E_ERROR | E_WARNING);
 //error_reporting(E_ALL);
define('PREFIX', '../../');
include_once('../../includes.php');
 include("fb.php");

include_once("../../includes/JSON.php");
require_once '../../facebook-connect/facebook-php/src/facebook.php';

//send invitation to facebook friends


$facebook= new Facebook(array(
                'appId'  => '205887732815348',
                'secret' => '5db3c92c0f8d4129414c052544378819',
                'cookie' => true,
));

$uid = $facebook->getUser();
	$loginUrl=$facebook->getLoginUrl(array(
'scope'  => 'publish_stream'
));


// echo "<pre>";print_r($contacts['data']);exit;
// print_r($me);exit;
// echo count($contacts);exit;
//$getFacebook = ($_GET['facebook']?$_GET['facebook']:0);
//$flag = $_GET["flag"];

	if ($uid) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $friends = $facebook->api('/me/friends');
		//echo "<pre>";print_r($friends);	echo "</pre>";exit;
      } catch (FacebookApiException $e) {
        error_log($e);
        $uid = null;
      }
    }

//echo "<pre>";print_r($_POST['sfriends']);echo "</pre>";
$check=array();
if($_POST['submit']){
if($_POST['check']!="")
{
	echo "<pre>";print_r($_POST['check']);echo "</pre>";
//echo "<pre>";print_r($_POST);echo "</pre>";exit;
	
	 if($_SESSION['fb_205887732815348_access_token']!="" && $_SESSION['fb_205887732815348_user_id']!="")
        {
                        $uid = $_SESSION['fb_205887732815348_user_id'];
                        $access_token = $_SESSION['fb_205887732815348_access_token'];
				if($uid){


                        try {
				
									$email_query = "select * from emailtemplate where ID=13";
									$email_rs = mysql_query($email_query);
									$email_row = mysql_fetch_object($email_rs);
									
											$post =  array(
											'access_token' => $access_token,
											'method' =>'stream.publish',
											'message' =>$email_row->subject,
											'link' => "www.starcrews.com",
											'picture' => 'http://72.29.76.194/~starcrew/templates/default/images/logo1.png',
											'description' =>$email_row->message,
											'actions' => array(array('name' => "www.starcrews.com",
															'link' => "www.starcrews.com"))
											);
									
//	                            	print_r($post);exit;
//									and make the request
//									$sendTo=$_POST['check'];
									for($p=0;$p < count($_POST['check']);$p++)
									{
                                              echo "count=".count($_POST['check']);
//                                              echo "<br/>he".$p;
												//echo "===>1";exit;
												//echo "<pre>";print_r($post);echo "</pre>";exit;
												$sendTo=$_POST['check'][$p];
												//echo "===>2";exit;
												//$location = "/" . $sendTo . "/feed";
												$location = "/me/feed";
												//echo "===>3".$location;
												//echo "===>3".print_r($post);exit;
												//$facebook->api($location, 'POST', $post);
												$res[] = $facebook->api($location, 'POST', $post);
												echo "===>4";exit;
	                                           //  $res[]="https://graph.facebook.com/".$sendTo."/feed?access_token=".$access_token;
												
												$_SESSION['connect_msg']="Your message is posted on friend's wall";
											//	echo "===>5";exit;
									}
// 									PRINT_R($res);EXIT;

						}catch (FacebookApiException $e) {
//                                 print_r($e);
                                 error_log($e);
                        }//end try/catch loop

						 if($_GET['id2']!="")
						{		echo "=>";exit;
								header("location:".SITEROOT."/modules/invitation/invitation.php");
						}else{	

								echo "==------->";echo "<pre>";print_r($res);echo "</pre>";
								//echo "==>";exit;
								//header("location:".SITEROOT."/modules/invitation/invitation.php");
						}
						exit;

				}else{  //end of if($uid)
        		        ?><script type="text/javascript">alert("Access token invalid");</script><?php
      			}		//end of if($uid)

		}else{			//end of if($_SESSION['fb_205887732815348_access_token']!="" && $_SESSION['fb_205887732815348_user_id']!="")
                ?><script type="text/javascript">alert("Access token invalid");</script><?php
        }
} else{
                $_SESSION['connect_msg']="Please select the friend(s) to post a message";
        }
}


//send invitation to facebook friends
?>


<form name="facebook_friends" id="facebook_friends" action="" method="POST">

<div id="facebook" style="overflow:auto;<?php if (is_array($friends)) {?>height:470px;<?php } ?>width:850px;">
<table cellpadding="3" cellspacing="2">
<?php if(is_array($friends)){ ?>
<tr><td style="width:25px;padding-bottom:10px;"></td><TD colspan="4" style="padding-bottom:10px;padding-top:10px;"><input type="checkbox" name="checkall" id="checkall">&nbsp;&nbsp;Select All</td></tr>
<?php } ?>
<?php 
if(is_array($friends)){
$frdcnt=count($friends['data']);

for($i=0;$i<$frdcnt;$i++){
	echo '<TR><td style="width:25px;"></td><td style="width:25px;padding-bottom:10px;"><input type="checkbox" name="check[]" id="check[]" value='.$friends['data'][$i]['id'].'></td><TD style="width:300px;align:left;vertical-align:top;padding-bottom:10px;">';
	echo $friends['data'][$i]['name']."  </td><td style='width:200px;align:left;vertical-align:top;padding-bottom:10px;'>   ".$friends['data'][$i]['id'].'</td><td style="width:400px;align:left;vertical-align:top;padding-bottom:10px;">';
	echo "<img src='https://graph.facebook.com/".$friends['data'][$i]['id']."/picture'>"; echo "<br>";
	echo '</TD></TR>';
}
echo "<input type='submit' name='submit' id='submit' value='Invite'>";
}
?>
</table>
</div>
</form>


