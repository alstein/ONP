<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'facebook.php';
 
define("FACEBOOK_APP_ID", '101047238433');
define("FACEBOOK_SECRET_KEY", 'ed6e9afd784b0eeb10d67dd3379bbcb2');
define("FACEBOOK_CANVAS_URL", 'http://apps.facebook.com/testoffersnpals');

$facebook = new Facebook(array(
            'appId' => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_SECRET_KEY,
            'cookie' => true,
            'domain' => 'testwww.offersnpals.com'
        ));

$session = $facebook->getSession();

if (!$session) {

    $url = $facebook->getLoginUrl(array(
                'canvas' => 1,
                'fbconnect' => 0
            ));

    echo "<script type='text/javascript'>top.location.href = '$url';</script>";
} else {

    try {

        $uid = $facebook->getUser();
        $me = $facebook->api('/me');

        $updated = date("l, F j, Y", strtotime($me['updated_time']));

        //echo "Hello " . $me['name'] . "<br />";
        //echo "You last updated your profile on " . $updated;
    } catch (FacebookApiException $e) {

        echo "Error:" . print_r($e, true);
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
        <script type="text/javascript">
            FB.init({
                appId  : '101047238433',
                status : true, // check login status
                cookie : true, // enable cookies to allow the server to access the session
                xfbml  : true  // parse XFBML
            });
        </script>
 
    <fb:serverFbml style="width: 500px;">
        <script type="text/fbml">
            <fb:fbml>
 
                    <fb:is-logged-out>
                        <fb:else>
                            <fb:request-form content="Join me on foursquare! It's the best way to meetup with friends and discover new places. &lt;fb:req-choice url='http://testwww.offersnpals.com' label='Join foursquare!' /&gt;" type="foursquare" invite="true" method="POST" action="http://testwww.offersnpals.com">
                                <fb:multi-friend-selector showborder="false" cols="5" rows="3" exclude_ids="721781462" actiontext="Invite your friends to foursquare."></fb:multi-friend-selector>
                            </fb:request-form>
                        </fb:else>
                    </fb:is-logged-out>
 
            </fb:fbml>
        </script>
    </fb:serverFbml>
</body>
</html>