<?php	session_start();
$fb = ($_SESSION['myfbconnect']?$_SESSION['myfbconnect']:0);
//ini_set("display_erros",1);

if($fb > 0){
	$_SESSION['myfbconnect']=0;
	
	require_once 'facebook-php/src/facebook.php';
	
	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '468889599797776',
	  'secret' => '2c3186a410eb846ede811ef86825b448',
	  'cookie' => true,
	));
	
	$uid = $facebook->getUser();
   
    	
	if ($uid) {
	  try {
		// Proceed knowing you have a logged in user who's authenticated.
		$me = $facebook->api('/me');
        //$contacts = $facebook->api('/me/friends');      
       
         
	  } catch (FacebookApiException $e) {
		error_log($e);
		$uid = null;
	  }
            
	}
    
  

}




?>
