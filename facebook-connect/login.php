<?php
	include("fb.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Facebook Coonect IE 9 </title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>


</head>
<body>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
   function offline_access_box(){
      FB.getLoginStatus(function(response) {
         if (response.status === 'connected') {
			// the user is logged in and connected to your
			// app, and response.authResponse supplies
			// the user's ID, a valid access token, a signed
			// request, and the time the access token 
			// and signed request each expire
			var uid = response.authResponse.userID;
			var accessToken = response.authResponse.accessToken;
			//alert(uid +'-'+accessToken);
             $.post("fb_connect.php",'',function(data){
                  window.location.href = window.location.href;
            },'html');
         } else {
            // no user session available, someone you dont know
			alert('no user session available, someone you dont know');
         }
      });
   }
</script>

<div id="fb-root"></div>
<script>
   FB.init({ 
	  appId:'204117416273546',
	  cookie:true,
	  status:true,
	  xfbml:true
   });
</script>

<h1>Facebook Connect Code including IE9</h1>

<fb:login-button v="2" onlogin="offline_access_box();" scope="email"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>

<?php if($me){ ?>
<h3>Session</h3>
<?php if($me){ ?>
<pre><?php print_r($session); ?></pre>

<h3>You</h3>
<img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
<?php echo $me['name']; ?>

  <?php echo $logoutUrl  = $facebook->getLogoutUrl(); ?>

<h3>Your User Object</h3>
<pre><?php print_r($me); ?></pre>
<?php }else{ ?>
<strong><em>You are not Connected.</em></strong>
<?php } ?>

<?php } ?>

<br /><br /><br /><br /><br /><br />

<img src="https://graph.facebook.com/1513862083/picture">
Mukesh Rane

</body>
</html>
