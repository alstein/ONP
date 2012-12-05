<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript">
		$(document).ready(function()
		{
			
			$("#checkall").click(function(){
				$("#twitter_friends").find("input[name='sfriends[]']").attr("checked",this.checked);
			});
			
		});
		
		</script>

<?php
session_start();
require_once('../../twitter/twitterOAuth.php');
require_once('../../twitter/Twitter.php');


$Twitter = new Twitter();
	/* If the access tokens are already set skip to the API call */
	if ($_SESSION['oauth_access_token'] === NULL && $_SESSION['oauth_access_token_secret'] === NULL) {
	/* Create TwitterOAuth object with app key/secret and token key/secret from default phase */
            $to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            /* Request access tokens from twitter */
            $tok = $to->getAccessToken();
    		
            /* Save the access tokens. Normally these would be saved in a database for future use. */
            $_SESSION['oauth_access_token'] = $tok['oauth_token'];
            $_SESSION['oauth_access_token_secret'] = $tok['oauth_token_secret'];
			
	}
	/* Random copy */
	$content = 'your account should now be registered with twitter. Check here:<br />';
	$content .= '<a href="https://twitter.com/account/connections">https://twitter.com/account/connections</a>';
	
	/* Create TwitterOAuth with app key/secret and user access key/secret */
	$to = new TwitterOAuth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
	/* Run request on twitter API as user. */
	
	$content = $to->OAuthRequest('https://twitter.com/account/verify_credentials.xml', array(), 'GET');
	
	//$content = $to->OAuthRequest('https://twitter.com/statuses/update.xml', array('status' => 'Test OAuth update. #testoauth'), 'POST');
	//$content = $to->OAuthRequest('https://twitter.com/statuses/replies.xml', array(), 'POST');


		$auth = $Twitter->oauth($consumer_key, $consumer_secret, $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);

		$t = $Twitter->call('account/verify_credentials');

		
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
			$_SESSION['invite_screen_name']	= $screen_name;
			
		}// check twitter end 





?>

<?php 

//echo "<pre>";print_r($_SESSION);echo "</pre>";
$trends_url = "http://api.twitter.com/1/statuses/followers/".$_SESSION['invite_screen_name'].".json";


////// exmaple $trends_url = "http://api.twitter.com/1/statuses/followers/w3cgallery.json"; or $trends_url = "http://api.twitter.com/1/statuses/followers/22250021.json";
 
$ch = curl_init(); 
 
curl_setopt($ch, CURLOPT_URL, $trends_url);
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 
$curlout = curl_exec($ch);
 
curl_close($ch);
 
$response = json_decode($curlout, true);?>

<form name="twitter_friends" id="twitter_friends" action="test.php" method="POST">
<table cellpadding="3" cellspacing="2">

<tr><td style="width:25px;padding-bottom:10px;"></td><TD colspan="4" style="padding-bottom:10px;padding-top:10px;"><input type="checkbox" name="checkall" id="checkall">&nbsp;&nbsp;Select All</td></tr>
 <TR>
		<td style="width:25px;">&nbsp;</td>
		<td style="width:25px;padding-bottom:10px;vertical-align:top">Select</td>
		<TD style="width:250px;align:left;vertical-align:top;padding-bottom:10px;">Screen Name</td>
		<td style='width:250px;align:left;vertical-align:top;padding-bottom:10px;'> Name</td>
		<td style="width:200px;align:left;vertical-align:top;padding-bottom:10px;">Image</td>
</tr>
<br /><br />
<?php
echo "<pre>";print_r($response);echo "</pre>";
$i=0;
foreach($response as $friends){
 
$thumb = $friends['profile_image_url'];
 
$url = $friends['screen_name'];
 
$name = $friends['name'];
?>
<TR>
	<td style="width:25px;"></td>
	<td style="width:25px;padding-bottom:10px;vertical-align:top"><input type="checkbox" name="sfriends[]" id="sfriends[]" value="sfriends<?php echo $i;?>"></td>
	<TD style="width:250px;align:left;vertical-align:top;padding-bottom:10px;"><?php echo substr($friends['screen_name'],0,30);?></td>
	<TD style="width:250px;align:left;vertical-align:top;padding-bottom:10px;"><?php echo substr($friends['name'],0,30);?></td>
	<td style="width:200px"><img src="<?php echo $friends['profile_image_url_https'];?>"><br></TD>
</TR>

<?php
$i++;
} 
 
?>
</table>
<input type='submit' name='submit' id='submit' value='Invite'>
</div>
</form>



<!--echo '<TR>
				<td style="width:25px;"></td>
				<td style="width:25px;padding-bottom:10px;vertical-align:top"><input type="checkbox" name="sfriends[]" id="sfriends[]" value="sfriends"'.$i;'"></td>
				<TD style="width:300px;align:left;vertical-align:top;padding-bottom:10px;">';echo $friends['screen_name']."  </td>
				<td style='width:200px;align:left;vertical-align:top;padding-bottom:10px;'>";echo $friends['name'];'</td>
				<td style="width:400px;align:left;vertical-align:top;padding-bottom:10px;">';-->