<?php 
// $username = 'danieldavis2';
// $password = '12345612345';
// $status = urlencode(stripslashes(urldecode('This is a new Tweet!')));
// 
// if ($status) {
// $tweetUrl = 'http://www.twitter.com/statuses/update.xml';
// 
// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, "$tweetUrl");
// curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_POST, 1);
// curl_setopt($curl, CURLOPT_POSTFIELDS, "status=$status");
// curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
// 
// $result = curl_exec($curl);
// $resultArray = curl_getinfo($curl);
// //print_r($resultArray);exit;
// if ($resultArray['http_code'] == 200)
// echo 'Tweet Posted';
// else
// echo 'Could not post Tweet to Twitter right now. Try again later.';
// 
// curl_close($curl);
// }
?>
<?php

$username = 'jackbrown00001';
$password = '12345612345';
$format = 'xml'; //alternative: json
$message = 'David Walsh\'s blog rocks! http://davidwalsh.name/';

/* work */
$result = shell_exec('curl http://twitter.com/statuses/update.'.$format.' -u '.$username.':'.$password.' -d status="'.str_replace('"','\"',$message).'"');
echo $result;
?>