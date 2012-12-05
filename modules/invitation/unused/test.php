<?php 
define('PREFIX', '../../');
include_once('../../includes.php');
?>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
   function share_offline_access_box(){
      FB.getLoginStatus(function(response) {
         if (response.status === 'connected') {
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;
              	    window.location.href = "<?php echo SITEROOT?>/modules/invitation/invite_facebook_friends.php";
         } else {
			alert('no user session available, someone you dont know');
         }
      });
   }
</script>

<br><div id="fb-root"></div>
<script>
   FB.init({ 
	  appId:'124175017703114',
	  cookie:true,
	  status:true,
	  xfbml:true
   });
</script>
<fb:login-button v="2" onlogin="share_offline_access_box();" scope="publish_stream"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>
