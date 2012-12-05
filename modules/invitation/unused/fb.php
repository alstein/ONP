<?php	session_start();
$fb = ($_SESSION['myfbconnect']?$_SESSION['myfbconnect']:0);
//ini_set("display_erros",1);
if($fb > 0){
	$_SESSION['myfbconnect']=0;
	
	require_once '../../facebook-connect/facebook-php/src/facebook.php';
	
	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '205887732815348',
	  'secret' => '5db3c92c0f8d4129414c052544378819',
	  'cookie' => true,
	));
	
	// Get User ID
	$uid = $facebook->getUser();
	$loginUrl=$facebook->getLoginUrl(array(
		'scope'  => 'publish_stream'
	));
	// We may or may not have this data based 
	// on whether the user is logged in.
	// If we have a $user id here, it means we know 
	// the user is logged into
	// Facebook, but we don�t know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	
	if ($uid) {
	  try {
		// Proceed knowing you have a logged in user who's authenticated.
		$me = $facebook->api('/me');
		$friends = $facebook->api('/me/friends');
		//echo "<pre>";print_r($friends);echo "</pre>";exit;
		
	  } catch (FacebookApiException $e) {
		error_log($e);
		$uid = null;
	  }
	}

}




?>
