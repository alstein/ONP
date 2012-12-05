<?php
require_once('../../twitter/twitterOAuth.php');
require_once('../../twitter/Twitter.php');

$Twitter = new Twitter();

/* Consumer key from twitter */
$consumer_key = 'e7AUZ9xH8OF9Ikpo7JxYtA';
/* Consumer Secret from twitter */
$consumer_secret = '5xEG3S2S9HbVu53gJl4s6O8dGdUn1iUt3U7wryf9EVM';
/* Set up placeholder */
$content = NULL;
/* Set state if previous session */
$state = $_SESSION['oauth_state'];
/* Checks if oauth_token is set from returning from twitter */
$session_token = $_SESSION['oauth_request_token'];
/* Checks if oauth_token is set from returning from twitter */
$oauth_token = $_REQUEST['oauth_token'];
/* Set section var */
$section = $_REQUEST['section'];

/* Clear PHP sessions */
if ($_REQUEST['test'] === 'clear') 
{/*{{{*/
  session_destroy();
  session_start();
}/*}}}*/

/* If oauth_token is missing get it */
if ($_REQUEST['oauth_token'] != NULL && $_SESSION['oauth_state'] === 'start') 
{/*{{{*/
  $_SESSION['oauth_state'] = $state = 'returned';
}/*}}}*/

/*
 * Switch based on where in the process you are
 *
 * 'default': Get a request token from twitter for new user
 * 'returned': The user has authorize the app on twitter
 */

switch ($state)
{/*{{{*/
	case 'returned':
	echo "return=>";exit;
	/* If the access tokens are already set skip to the API call */
	if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
	/* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
            $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            /* Request access tokens from twitter */
            $tok = $to->getAccessToken();
    		echo "====>1";exit;
            /* Save the access tokens. Normally these would be saved in a database for future use. */
            $_SESSION['oauth_access_token'] = $tok['oauth_token'];
            $_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
			echo "====>2";exit;
	}
	/* Random copy */
	$content = 'your account should now be registered with twitter. Check here:<br />';
	$content .= '<a href="https://twitter.com/account/connections">https://twitter.com/account/connections</a>';
	echo "====>3";exit;
	/* Create TwitterOAuth with app key/secret and user access key/secret */
	$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
	/* Run request on twitter API as user. */
	echo "====>4";exit;
	$content = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml', array(), 'GET');
	echo "====>5";exit;
	//$content = $to->OAuthRequest('https://twitter.com/statuses/update.xml', array('status' => 'Test OAuth update. #testoauth'), 'POST');
	//$content = $to->OAuthRequest('https://twitter.com/statuses/replies.xml', array(), 'POST');


		$auth = $Twitter->oauth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
echo "====>6";exit;
		$t = $Twitter->call('account/verify_credentials');
echo "====>7";exit;
		
// 		$screen_name=$t->screen_name;
// 		$name=$t->name;
// 		$twitter_id=$t->id;
// 		$location=$t->location;
// 		$twtimage=$t->profile_image_url;
// 		$password="123456";
		
		if($t->name){$name = explode(" ",$t->name);}
               $twtid         = $t->id;;
               $first_name    = $name[0];
               $last_name     = $name[1];
               $city11        = $t->location;
               $screen_name   = $t->screen_name;
               $bigimg        = $t->profile_image_url;
               $smallimg      = $t->profile_image_url;
               $password      = "123456";




		/*checking twitter user already present in taowt db*/
		if($twtid != '')  // if get twitter userid and screen name. 
		{	
			echo $_SESSION['invite_screen_name']	= $screen_name;exit;
			header("location:".SITEROOT."/modules/invitation/invite_twitter_friends.php");
		}// check twitter end 
   
		

		break;
	 
  default:
    /* Create TwitterOAuth object with app key/secret */
    $to = new TwitterOAuth($consumer_key, $consumer_secret);
    /* Request tokens from twitter */
    $tok = $to->getRequestToken();
	
    /* Save tokens for later */
    $_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
    $_SESSION['oauth_state'] = "start";

    /* Build the authorization URL */
    $request_link = $to->getAuthorizeURL($token);
 //	echo "<pre>";
 //		print_r($request_link);exit;
    /* Build link that gets user to twitter to authorize the app */
   // $content = 'Click on the link to go to twitter to authorize your account.';

	$content .= $request_link;
	 break;
}/*}}}*/

//echo $content;
//$smarty->assign("TWITTER_CONNECT",$content);

?>
