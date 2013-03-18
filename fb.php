<?php 
session_start();
// include_once("includes/include.php");
include_once('includes/SiteSetting.php');
// echo "root==".SITEROOT;
// echo "<br>";
//print_r($_SESSION);

$fb = ($_SESSION['myfbconnect']?$_SESSION['myfbconnect']:0);
// echo "fb==>".$fb = ($_SESSION['myfbconnect']?$_SESSION['myfbconnect']:0);
//ini_set("display_erros",1);

//echo '###';exit;
//$fb = 1;

//echo "fb==".$fb=1;
if($fb){
    // echo "in if";
    // print_r($_SESSION);
    $_SESSION['myfbconnect']=0;
    //require_once 'facebook-php/src/facebook.php';

    require_once 'includes/facebook/src/facebook.php';

    //      Create our Application instance (replace this with your appId and secret).
    $facebook = new Facebook(array(
    //   'appId'  => '121073564658327',
    //   'secret' => ' b24e442bd413eab53664ac6db5649ce0',
    //  'appId'  => '179603878798564',			//227 server
    //   'secret' => 'b7be9d6b30025c00ca4df2381636d41b',	//227 server

        'appId' => '468889599797776',
        'secret' => '2c3186a410eb846ede811ef86825b448',
        'cookie' => true
    ));

    // We may or may not have this data based on a $_GET or $_COOKIE based session.
    //
    // If we get a session here, it means we found a correctly signed session using
    // the Application Secret only Facebook and the Application know. We dont know
    // if it is still valid until we make an API call using the session. A session
    // can become invalid if it has already expired (should not be getting the
    // session back in this case) or if the user logged out of Facebook.
    // Get User ID
    $uid = $facebook->getUser();

    //$_SESSION['myfbconnect'] = 1;

    // We may or may not have this data based 
    // on whether the user is logged in.
    // If we have a $user id here, it means we know 
    // the user is logged into
    // Facebook, but we don�t know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.
    //     echo "uid=>".$uid;
    if($uid) {
        try {
        // Proceed knowing you have a logged in user who's authenticated.
            $me = $facebook->api('/me');
        } catch (FacebookApiException $e) {
            error_log($e);
            $uid = null;
        }
    }
    /*
        echo "me-->"."<pre>";print_r($me);*/
    /*-------------fetch records store in variable-----------------------*/
    $ucity="";
    if($me['location']['name'])
    {
        $ucity = explode(",",$me['location']['name']);
        $ucity = trim($ucity[0]);
    }
    // echo "me==".count($me);
    // echo "ucity===".$ucity;

    // 	echo "in if";
    $fbafname = $me['first_name'];
    $fbalname = $me['last_name'];
    $fbauname = $me['first_name'].$me['last_name'];
    $fbaemail = $me['email'];
    $fbasex   = $me['gender'];
    $fbbio    = $me['bio'];

    $password = generate_Password();
    $fbbirthd = $me['birthday'];//birthday//06/22/1983
    $birtharr = explode("/",$fbbirthd);
    $fbbrthdt = $birtharr[2]."-".$birtharr[0].'-'.$birtharr[1];
    $fbaid    = $me['id'];

    /*checking facebook user already present in Vmatrix db*/
    if(($fbaid != '') || ($fbaemail != ''))  // if get facebook userid and email id  
    {
        $tbl_f = "tbl_users";
        $sf_f  = "*";
        $cnd_f = "facebook_userid = '".$me['id']."' and email='".trim($me['email'])."' ";
        $rs_f  = $dbObj->gj($tbl_f,$sf_f,$cnd_f, "","","","","1");

        $unum  = @mysql_num_rows($rs_f);

        /*If facebook-user already present in Vmatrix db; get set user's session and | do login to site directly*/
        if($unum > 0)
        {
            $row_f = @mysql_fetch_assoc($rs_f);		
            if($row_f['status'] == 'active')
            {
                /* set and assign session values*/
                $_SESSION['csFacebookUserId'] = $fbaid;
                $_SESSION['csUserId'] 	      = $row_f['userid'];
                $_SESSION['csEmail'] 	      = $row_f['email'];
                $_SESSION['csUserName']	      = $row_f['username'];
                $_SESSION['csFirstName']      = $row_f['first_name'];
                $_SESSION['csLastName']       = $row_f['last_name'];
                $_SESSION['csFullName'] = $row_f['first_name']." ".$row_f['last_name'];
                $_SESSION['csUserTypeId'] 	= '2';

                if($row_f['facebook_userid'] == 0)
                {
                    $dbObj->cupdt("tbl_users","facebook_userid",$fbaid,"userid",$row_f['userid'],"");
                }

                # inserting record in to login log table
                $f = array("userid", "login_date", "ipaddress");
                $v = array($_SESSION['csUserId'], date("Y-m-d H:i:s"), $_SERVER['REMOTE_ADDR']);
                $id = $dbObj->cgi("tbl_login_log", $f, $v, "");	
                header("location:".SITEROOT."/my-account/my_profile_home");
                exit;
            }
            else
            {
                $_SESSION['msg']="Sorry,your account is temporary banned,for login please contact to admin.";
                @header("location:".SITEROOT); exit;
            }
        }
        /*If facebook-user not present in Vmatrix db; then first do new entry in Vmatrix db and set user's session and | do login to site directly*/
        else
        {
            $field = array("username","first_name", "last_name","fullname","email","password","gender", "birthdate",   "isverified","verified_date","facebook_userid","signup_date","usertypeid");
            $value = array($fbauname,$fbafname,$fbalname,$fbafname." ".$fbalname, $fbaemail,md5($password), $fbasex, $fbbrthdt, "yes",date("Y-m-d H:i:s"),$me['id'],date("Y-m-d H:i:s"),"2");
            $dbObj->cgi("tbl_users",$field,$value,"");

            $usId  = mysql_insert_id(); // getting recently added record-id	

            // 		$field1 = array("userid", "about_me","current_city","countryid","stateid");
            // 		$value1 = array($usId, $fbbio,$fblcity,$fblcountry,$fblstate);
            // 		$dbObj->cgi("tbl_profile",$field1,$value1,"");

            /*set and assign session value */
            $_SESSION['csFacebookUserId'] 	= $fbaid;
            $_SESSION['csUserId'] 		= $usId;
            $_SESSION['csEmail'] 		= $fbaemail;
            $_SESSION['csFirstName'] 	= $fbafname;
            $_SESSION['csLastName'] 	= $fbalname;
            $_SESSION['csFullName'] = $fbafname." ".$fbalname;
            $_SESSION['csUserTypeId'] 	= '2';
            $_SESSION['csUserName']		= $fbauname;

            # inserting record in to login log table
            $f = array("userid", "login_date", "ipaddress");
            $v = array($_SESSION['csUserId'], date("Y-m-d H:i:s"), $_SERVER['REMOTE_ADDR']);
            $id = $dbObj->cgi("tbl_login_log", $f, $v, "");

            header("location:".SITEROOT."/editprofile/fb");
            exit;
        }
    }
}
?>
