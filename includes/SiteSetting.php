<?php
//error_reporting(E_ALL);
date_default_timezone_set('Asia/Singapore');
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
require_once("DBTransact.php");



$SSdbObj=$dbObj;

define("SITEJS", SITEROOT."/js");




$res = $SSdbObj->cgs("sitesetting", "", "", "", "id", "", "");
if($res != 'n'){
	while($row = mysql_fetch_row($res)){
		define($row[1], $row[2]);
	}
}

//main page
if($_GET['type1'])
{
$_SESSION['de_type']=$_GET['type1'];
}

if($_SESSION['de_type']=='' || $_SESSION['de_type']=='home')
{
$type_cnd= '';
$cat_cnd= "";
} else
{
$type_cnd= "deal_type ='".$_SESSION['de_type']."' ";
$cat_cnd= " category_type ='".$_SESSION['de_type']."' ";
}



define("SITEIMG", SITEROOT."/templates/".TEMPLATEDIR."/images");
define("SITECSS", SITEROOT."/templates/".TEMPLATEDIR."/css");


require_once("libs/Smarty.class.php");

$smarty = new Smarty;

$smarty->compile_check = true;


#----------Check IE 6 browser-------------#
$dbObj->is_valid_browser();

$smarty->assign("browser_info", TEMPLATEDIR .'/browser_info.tpl');
#---------End Check IE 6 browser----------#


$smarty->assign("EMAIL_TO_FRIEND", EMAIL_TO_FRIEND);

$smarty->assign("siteroot", SITEROOT);
$smarty->assign("sitejs", SITEJS);
$smarty->assign("siteimg", SITEIMG);
$smarty->assign("sitecss", SITECSS);
$smarty->assign("templatedir", TEMPLATEDIR);
$smarty->assign("sitetitle", SITETITLE);
$smarty->assign("metades", META_DESCRIPTION);
$smarty->assign("metakeyword", META_KEYWORDS);
$smarty->assign("externalcode", EXTERNAL_CODE);


$smarty->assign("date_format", DATE_FORMAT);
$smarty->assign("smarty_date_format", SMARTY_DATE_FORMAT);

define("SITEJS_HTTPS", SITEROOT_HTTPS."/js");
define("SITEIMG_HTTPS", SITEROOT_HTTPS."/templates/".TEMPLATEDIR."/images");
define("SITECSS_HTTPS", SITEROOT_HTTPS."/templates/".TEMPLATEDIR."/css");

$smarty->assign("siteroot_https", SITEROOT_HTTPS);
$smarty->assign("sitejs_https", SITEJS_HTTPS);
$smarty->assign("siteimg_https", SITEIMG_HTTPS);
$smarty->assign("sitecss_https", SITECSS_HTTPS);
$smarty->assign("browser_info", TEMPLATEDIR .'/browser_info.tpl');

if(strstr($_SERVER['PHP_SELF'], "/admin/")){

	global $smarty;
	$smarty->assign("header1", TEMPLATEDIR .'/admin/header1.tpl');
	$smarty->assign("header2", TEMPLATEDIR .'/admin/header2.tpl');
	$smarty->assign("footer", TEMPLATEDIR .'/admin/footer.tpl');
	$smarty->assign("admin_header_start", TEMPLATEDIR .'/admin/admin_header_start.tpl');
	$smarty->assign("admin_header_end", TEMPLATEDIR .'/admin/admin_header_end.tpl');	
	$smarty->assign("admin_category", TEMPLATEDIR .'/admin/admin_category.tpl');
	$smarty->assign("admin_footer", TEMPLATEDIR .'/admin/admin_footer.tpl');	
	$smarty->assign("lbheader", TEMPLATEDIR .'/admin/lbheader.tpl');
	$smarty->assign("lbfooter", TEMPLATEDIR .'/admin/lbfooter.tpl');
	
	//seller My Account area
	$smarty->assign("header_seller1", TEMPLATEDIR .'/admin/header_seller1.tpl');
	$smarty->assign("header_seller2", TEMPLATEDIR .'/admin/header_seller2.tpl');
	$smarty->assign("footer_seller", TEMPLATEDIR .'/admin/footer_seller.tpl');
	$smarty->assign("no_js", TEMPLATEDIR .'/no_js.tpl');
}else{

	global $smarty;
	$smarty->assign("header_start", TEMPLATEDIR .'/header_start.tpl');
	$smarty->assign("header_end", TEMPLATEDIR .'/header_end.tpl');
	$smarty->assign("help_left", TEMPLATEDIR .'/help-left.tpl');

	//$smarty->assign("category", TEMPLATEDIR .'/category.tpl');
	//$smarty->assign("admin_header_start", TEMPLATEDIR .'/admin/admin_header_start.tpl');
	//$smarty->assign("admin_header_end", TEMPLATEDIR .'/admin/admin_header_end.tpl');	
	//$smarty->assign("admin_category", TEMPLATEDIR .'/admin/admin_category.tpl');
	//$smarty->assign("admin_footer", TEMPLATEDIR .'/admin/admin_footer.tpl');	
	//$smarty->assign("profile", TEMPLATEDIR .'/modules/my-account/profile-left-col.tpl');
	//$smarty->assign("myacc", TEMPLATEDIR .'/myaccount_right.tpl');
	//$smarty->assign("message_menu", TEMPLATEDIR .'/modules/my-account/message_menu.tpl');
	//$smarty->assign("ads", TEMPLATEDIR .'/ads.tpl');
	//$smarty->assign("header_start_secure", TEMPLATEDIR .'/header_start_secure.tpl');
	//$smarty->assign("header_end_secure", TEMPLATEDIR .'/header_end_secure.tpl');

	$smarty->assign("footer", TEMPLATEDIR .'/footer.tpl');
	$smarty->assign("footer_free_coupons", TEMPLATEDIR .'/footer_free_coupons.tpl');
	$smarty->assign("profile_header", TEMPLATEDIR .'/profile_header.tpl');
	$smarty->assign("profile_header2", TEMPLATEDIR .'/profile_header2.tpl');
	$smarty->assign("profile_left", TEMPLATEDIR .'/profile_left.tpl');
	$smarty->assign("profile_right", TEMPLATEDIR .'/profile_right.tpl');
	$smarty->assign("myprofile_left_panel", TEMPLATEDIR .'/myprofile_left_panel.tpl');
	$smarty->assign("myprofile_right_panel", TEMPLATEDIR .'/myprofile_right_panel.tpl');
	$smarty->assign("merchant_home_left", TEMPLATEDIR .'/merchant_home_left.tpl');
	$smarty->assign("merchant_home_right", TEMPLATEDIR .'/merchant_home_right.tpl');
	$smarty->assign("merchantprofile_left_panel", TEMPLATEDIR .'/merchantprofile_left_panel.tpl');
	$smarty->assign("merchantprofile_right_panel", TEMPLATEDIR .'/merchantprofile_right_panel.tpl');

	//$smarty->assign("footer_secure", TEMPLATEDIR .'/footer_secure.tpl');

   	$smarty->assign("no_js", TEMPLATEDIR .'/no_js.tpl');
}

   $csuserid = $_SESSION['csUserId'];
   //-------------For User------------------------------------------------
   $query = "select * from tbl_users where userid='".$csuserid."'";
   $res = @mysql_query($query);
   $num = @mysql_num_rows($res);
   if($num>0){
      $user = mysql_fetch_object($res);
      $smarty->assign("user", $user);
   }
 //  echo "<pre>";
 //  print_r($user);
//   echo "</pre>";
   //------------- how it works --------------//
      $queryhowit = "select * from tbl_pages where pageid=11";
	  $howitrs = @mysql_query($queryhowit);
   	  $howit = @mysql_fetch_object($howitrs);
   	  $smarty->assign("howit",$howit);

      $queryhowit1 = "select * from tbl_pages where pageid=19";
	  $howitrs1 = @mysql_query($queryhowit1);
   	  $howit1 = @mysql_fetch_object($howitrs1);
   	  $smarty->assign("howit1",$howit1);

      $queryhowit2 = "select * from tbl_pages where pageid=22";
	  $howitrs2 = @mysql_query($queryhowit2);
   	  $howit2 = @mysql_fetch_object($howitrs2);
   	  $smarty->assign("howit2",$howit2);

      $queryhowit3 = "select * from tbl_pages where pageid=23";
	  $howitrs3 = @mysql_query($queryhowit3);
   	  $howit3 = @mysql_fetch_object($howitrs3);
   	  $smarty->assign("howit3",$howit3);
	  
	  $smarty->assign("follow_facebook",FOLLOW_FACEBOOK);
	  $smarty->assign("follow_twitter",FOLLOW_TWITTER);
	  $smarty->assign("follow_rss",FOLLOW_RSS);
	 $smarty->assign("twitter_connect","f0ndqsL1puGsB7ojRkr5wYKid3GFdcl5Ce67aya3c");
$smarty->assign("detype",$_SESSION['de_type']);

putenv("TZ=US/Eastern");
$date = date("F d Y H:i:s",strtotime($_GET['date']));
$currnt=date("D M d Y H:i:s");
$smarty->assign("currant",$currnt);
$smarty->assign("d",$date);

#-----------Check for Modules Permisions--------#


#-----Siteuserid check---#

// if($_SESSION['csUserId']!="")
// {
      include_once('classes/class.profile.php');
		//echo "<pre>"; print_r($_GET);echo "</pre>";
      if($_GET["user"]!='')
      {
		
         $siteUserId = $profObj->fetchUserid($_GET["user"]);
         if($siteUserId=="")
         {
                  header("Location:".SITEROOT."/");
                  exit;
         }
         $smarty->assign("siteUserId", $siteUserId);
 	 $profileinfo = $profObj->fetchProfile($siteUserId);
	 $smarty->assign("profileinfo",$profileinfo);

      }
//       else
//       {	
// 		$profileinfo = $profObj->fetchProfile($_SESSION['csUserId']);
// 		$smarty->assign("profileinfo",$profileinfo);
//       }
//}

#--------------------------#
if($_SESSION['duAdmId'] != "")
{
	require_once("AccessLevel.php");

	#-------------Get admin access-----------#
	$arr_modules_permit = $accObj->getAdminAccess($_SESSION['duAdmId']);
	$smarty->assign("arr_modules_permit",$arr_modules_permit);
	#-------------Get admin access-----------#

	#-------------Get deal details-----------#
	$smarty->assign("deal_notice_info",$accObj->getAllDealDetails());
	#-------------Get deal details-----------#

	#-------------Get deal details-----------#
	$smarty->assign("affiliate_notice_info",$accObj->getAllAffiliateDetails());
	#-------------Get deal details-----------#

	#-------------Get deal details-----------#
	$smarty->assign("deal_notice_info_seller",$accObj->getSellerAllDealDetails($_SESSION['duAdmId']));
	#-------------Get deal details-----------#

	#-------------Get Total admin-----------#
	$smarty->assign("TOT_ADMIN",$accObj->getTotalAdmin());
	#-------------End Total admin-----------#

	#-------------Get Total Buyers-----------#
  	$smarty->assign("TOT_BUYER",$accObj->getTotalBuyer());
	#-------------End Total Buyers-----------#

	#-------------Get Total Seller-----------#
  	$smarty->assign("TOT_SELLER",$accObj->getTotalSeller());
	#-------------End Total Seller-----------#

	#--------------Get Admin Message----------#
	$smarty->assign("TOT_ADMIN_MSG",$accObj->getTotalAdminMessage());
	#--------------End Admin Message----------#

	#-------------Get Subscriber List-----------#
	$smarty->assign("TOT_SUBSCRIBER",$accObj->getTotalSubscriber());
	#-------------Get Subscriber List-----------#

}
#--------End Check for Modules Permisions-------#
//------ToolTip Start------
$tooltip_record = $dbObj->gj("tbl_tooltip","description","module_name ='Header'","","","","","");
   while($tooltiprows = @mysql_fetch_assoc($tooltip_record))
   {
      $headertooltip[]=$tooltiprows['description'];
  }

 //echo "<pre>";
 //print_r($tooltiparray);
$smarty->assign("headertooltip",$headertooltip);
//------ToolTip End------



////////START Seller AND Admin access area Defination///////////

if(strpos($_SERVER['PHP_SELF'],"/admin/") && (!strpos($_SERVER['PHP_SELF'],"/admin/_welcome.php")))
{
	if(strpos($_SERVER['PHP_SELF'],"/admin/seller/"))
	{
		if(isset($_SESSION['duUserTypeId']) && $_SESSION['duUserTypeId'] == '1')
		{
			header("location:".SITEROOT."/admin");
			exit();
		}
	}else
	{
		if(isset($_SESSION['duUserTypeId']) && $_SESSION['duUserTypeId'] == '3')
		{
			header("location:".SITEROOT."/admin");
			exit();
		}
	}
}

/////////END Seller AND Admin access area Defination///////////

/////////Ipod Css Detect Code start here/////////////

$isiPad = 0;
 
 $OSList = array
 (
    // Match user agent string with operating systems
    'Windows 3.11' => 'Win16',
    'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
    'Windows 98' => '(Windows 98)|(Win98)',
    'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
    'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
    'Windows Server 2003' => '(Windows NT 5.2)',
    'Windows Vista' => '(Windows NT 6.0)',
    'Windows 7' => '(Windows NT 7.0)',
    'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
    'Windows ME' => 'Windows ME',
    'Open BSD' => 'OpenBSD',
    'Sun OS' => 'SunOS',
    'Linux' => '(Linux)|(X11)',
    'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
    'QNX' => 'QNX',
    'BeOS' => 'BeOS',
    'OS/2' => 'OS/2',
    'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
 );
 // Loop through the array of user agents and matching operating systems
 foreach($OSList as $CurrOS=>$Match){
    // Find a match
    if (eregi($Match, $_SERVER['HTTP_USER_AGENT'])){
      // We found the correct match
      break;
    }
 }
 
 if($CurrOS == "Search Bot"){ // ipad
  $isiPad = 1;
 }
 
 // You are using Windows Vista
 //echo "You are using ".$CurrOS;
 
 $smarty->assign('isiPad', $isiPad);

/////////////Ipod Css Detect Code end here/////////////////

$adealdate=date("Y-m-d H:i:s");
$adealtbl = "tbl_deals as p, tbl_users as tu";
$adealsf = "p.*,tu.business_name,tu.deal_cat";
$adealcnd="p.merchant_id=tu.userid and p.deal_end_date >= '$adealdate' and p.status='active' ";
$adealres = $dbObj->gj($adealtbl,$adealsf,$adealcnd,"deal_unique_id","","DESC","", "");
$adealnum=@mysql_num_rows($adealres);
$smarty->assign("adealnum",$adealnum);


$edealdate=date("Y-m-d H:i:s");
$edealtbl = "tbl_deals as p, tbl_users as tu";
$edealsf = "p.*,tu.business_name ";
$edealcnd="p.merchant_id=tu.userid and p.deal_end_date <= '$edealdate' and p.is_share='0'";

$edealres = $dbObj->gj($edealtbl,$edealsf,$edealcnd,"deal_unique_id","","DESC","", "");
while($edealrow=@mysql_fetch_assoc($edealres)){

		$sel_buy_deal_no2=$dbObj->customqry("SELECT count(*) as count FROM tbl_deal_payment_unique  WHERE deal_id='".$edealrow['deal_unique_id']."'", "");
		$res_buy_deal2=@mysql_fetch_assoc($sel_buy_deal_no2); 
		if($res_buy_deal2['count']!=$edealrow['max_deal_no']){ 
			$feed2[] = $row;
		}

}

 $smarty->assign("edealnum",count($feed2));


 
    $cdealsf = "p.*,tu.fullname,tu.business_name,tu.deal_cat";
	$cdealcnd="1 and p.status='active' and p.is_share='0'";
	$cdealres = $dbObj->customqry("SELECT ".$cdealsf." FROM tbl_deals as p LEFT JOIN tbl_users as tu ON p.merchant_id=tu.userid WHERE ".$cdealcnd."", "");
	while($cdealrow = @mysql_fetch_assoc($cdealres))
	{	
		$sel_buy_deal_no1=$dbObj->customqry("SELECT count(*) as count FROM tbl_deal_payment_unique  WHERE deal_id='".$cdealrow['deal_unique_id']."'", "");
		$res_buy_deal1=@mysql_fetch_assoc($sel_buy_deal_no1); 
		if($res_buy_deal1['count']==$cdealrow['max_deal_no']){ 
			$feed1[] = $row;
			
		}
	}

$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


if(isset($_SESSION['csUserId']) && isset($_SESSION['csUserTypeId'])){
	//get the second last login date
	$cuserres=$dbObj->customqry("select logout_date from tbl_login_log where userid=".$_SESSION['csUserId']." order by id desc limit 1,1","");
	$cuserrow=@mysql_fetch_array($cuserres);
	$cuserdate=$cuserrow['logout_date'];
	//get the second last login date
	
	
	//get new messages count
	$tbl_new="messages m left join inbox i on m.mid=i.MID";
	$cd_new="i.TO_ID='".$_SESSION['csUserId']."' and m.status='1' and i.flag='0'";
	$sf_new="m.cdate,m.mid";
	$rs_new=$dbObj->gj($tbl_new, $sf_new , $cd_new, "", "", "", "", "");
	$num_new=@mysql_num_rows($rs_new);
	if($num_new=="")
		$num_new='0';
	$smarty->assign("new_messages",$num_new);
	//get new messages count
}


 


$smarty->assign("cdealcnt",count($feed1));

// function to genereate random password. 
function generate_Password()
{
$Source[0] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
$Source[1] = "0123456789";
$Source[2] = "!@#$%^*_-+=?|:";

$alpha =1;
$num=1;
$other=1;
                if($alpha == '1' )
                {
                        $Use[] = $Source[0];
                }
                if($num == '1' )
                {
                        $Use[] = $Source[1];
                }
                if($other == '1' )
                {
                        $Use[] = $Source[2];
                }
                $Passwordlen = '8';
                if($Passwordlen >= count($Use))
                {
                        $Min = 0;
                        while($i < $Passwordlen)
                        {
                                $Max = strlen($Use[$i % count($Use)])-1;
                                $Rand = rand($Min,$Max);
                                $Password .= substr($Use[$i % count($Use)],$Rand,1);
                                $i++;
                        }
                }

      return $Password;
}


// header categories
        $resulth =$dbObj->customqry("select * from mast_deal_category where parent_id=0 order by category","");
        $i = 0;
        while($rowh = mysql_fetch_array($resulth))
        {
                $tmph = array('id'=>$rowh['id'],
                 'category'=>$rowh['category']);
                $resultsh[$i++] = $tmph;
        }
	$smarty->assign("categoryh",$resultsh);
// header categories
?>
