<?php

// Copyright 2007 Facebook Corp.  All Rights Reserved.
//
// Application: What your post
// File: 'index.php'
//   This is a sample skeleton for your application.
//

require_once 'php/facebook.php';

$appapikey = '256976704344295';
$appsecret = 'd1efd2e783dbd89006fb9990a8279c57';


$facebook = new Facebook($appapikey, $appsecret);
$user = $facebook->require_login();


$facebook = new Facebook($appapikey, $appsecret);
$infinite_key_array = $facebook->api_client->auth_getSession($_REQUEST['auth_token']);
print_r($infinite_key_array);

    try {
        if (!$facebook->api_client->users_isAppAdded()) {
            $facebook->redirect($facebook->get_add_url());
        }
    }
    catch (Exception $excatch) {
        $facebook->set_user(null, null);
        $facebook->redirect($appcallbackurl);
    }


?>
