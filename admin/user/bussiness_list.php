<?
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");
	
	
function str_rand($length = 8, $seeds = 'alphanum')
{
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $seedings['hexidec'] = '0123456789abcdef';
    
    // Choose seed
    if (isset($seedings[$seeds]))
    {
        $seeds = $seedings[$seeds];
    }
    
    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);
    
    // Generate
    $str = '';
    $seeds_count = strlen($seeds);
    
    for ($i = 0; $length > $i; $i++)
    {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }
    
    return $str;
}

if($_GET['sorttype']<>""){	$searchuser=$_GET['searchuser'];
}else{	$searchuser=$_POST['searchuser'];	}
if($_GET['sortord']<>""){ $sortord=$_GET['sortord'];  }else{ $sortord='asc'; }
$smarty->assign("ord",$sortord);
if($searchuser<>""){	$smarty->assign("searchuser", $searchuser);}

extract($_GET);

if($_GET['act']=="approve" and $_GET['approve']!="" and $_GET['business_id']!="")
{
if($_GET['approve']=='Suspend')
{
                $id = $dbObj->customqry("update tbl_bussiness set approve = '0' where business_id = ".$_GET['business_id'],"");
		$s=$msobj->showmessage(82);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
elseif($_GET['approve']=='Active')
{
                $id = $dbObj->customqry("update tbl_bussiness set approve = '1' where business_id = ".$_GET['business_id'],"");
		$s=$msobj->showmessage(83);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
}
if(isset($_POST['submit'])){	
	if($_POST['action'] == "" || !isset($_POST['action'])){
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['userid']) == 0 || (!isset($_POST['userid']))){
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	extract($_POST);
	$userid1 = implode(", ", $userid);
        if($action == "Suspend")
        {
            $id = $dbObj->customqry("update tbl_bussiness set approve = '0' where business_id in (".$userid1.")","");
            $s=$msobj->showmessage(15);
            $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
        }
        elseif($action == "approve")
        {
            //$id = $dbObj->customqry("update tbl_bussiness set approve ='1' where business_id in (".$userid1.")","");
            //$_SESSION['msg']="<span class='success'>Buissness Approved Successfully</span>";
            $userid_arr=$userid;
            if(is_array($userid_arr))
            {
                $userid_cnt=0;
                $userid_cnt=count($userid_arr);
                for($i=0;$i<$userid_cnt;$i++)
                {
                    // $id = $dbObj->customqry("update tbl_bussiness set approve = '1' where business_id =".$userid_arr[$i]."", "");
                        $tbl1="tbl_bussiness b INNER JOIN tbl_bussiness_category c ON b.bussiness_cat_id = c.categoryid left join tbl_users u ON u.userid = b.userid";
    	
                        $cd="  b.business_id =". $userid_arr[$i];	
                    
                        
                        $sf = "b.*,u.first_name,u.last_name,u.email,u.contactno,u.position,c.category";
                        
                        $rs_buss = $dbObj->gj($tbl1, $sf, $cd, "", "", "", $l,"");
                        $buss_arr=@mysql_fetch_assoc($rs_buss);			
				
                    $email=$buss_arr['email'];
                    $buss_name_arr=split(" ",$buss_arr['name']);
                    $merch_code="MER"."-".strtoupper(str_rand(8,"numeric"));
        
                    $usertypeid='3';
                    $name=$buss_arr['name'];
                    $city=$buss_arr['city'];
                    $website=$buss_arr['website'];
                    $add=$buss_arr['add1'].",".$buss_arr['add2'];

// 				$site_updates=0;
// 				$newsletter=0;
// 				$set_commission=0;
// 				if($buss_arr['bussiness_picture']<>""){
// 					$bigphoto=$buss_arr['bussiness_picture'];
// 					copy("../../uploads/bussiness_photo/big_image/".$buss_arr['bussiness_picture'], "../../uploads/user_photo/big_image/".$buss_arr['bussiness_picture']);	
// 				}else{	$bigphoto=""; }
// 				$fl = array('business_name','business_add','business_city','website','password','email','usertypeid','site_updates','newsletter','bigphoto',"isverified","signup_date","set_commission");
// 				$vl = array($name,$add,$city,$website,md5($password),$email,$usertypeid,$site_updates,$newsletter,$photos,"no",date("Y-m-d H:i:s"),$set_commission);
// 				$rs = $dbObj->cgi('tbl_users',$fl,$vl,'');
				
				// to send the mail
				$myFile = '../../email/email_bussiness_approve.html';
				$content = file_get_contents($myFile);
				$sum = "";
				$subject = "Welcome to ".SITETITLE." & Your Merchent Account Is Approved By Admin";
				if($usertypeid == 3)
					$link = "<a href='".SITEROOT."/merchantportal/login/'>".SITEROOT.'/merchantportal/login/'."</a>";
				
				if($content !== false){
					$sum = str_replace("[[siteroot]]",SITEROOT,$content);
					$sum1 = str_replace("[[default]]",TEMPLATEDIR,$sum);
					$sum2 = str_replace("[[sitename]]",SITETITLE,$sum1);
					$sum3 = str_replace("[[subject]]",$subject,$sum2);
					$sum4 = str_replace("[[buss_name]]",$name,$sum3);
					$sum5 = str_replace("[[website]]",$website,$sum4);
					$sum6 = str_replace("[[merch_code]]",$merch_code,$sum5);
					
				} else {
					echo "error";
				// an error happened
				}
			
				//echo "".$sum6; exit;
				$from = SITE_EMAIL;		
					@mail(trim($email),$subject,$sum6,"From: $from\nContent-Type: text/html; charset=iso-8859-1","");
				//end mail
//$id = $dbObj->customqry("update tbl_bussiness set approve = '1', merchet_id='".$merch_code."', date_of_approval='".date('Y-m-d')."' where business_id = '".$_POST['busid']."' and approve!='1'","");
	$id = $dbObj->customqry("update tbl_bussiness set approve = '1', merchet_id='".$merch_code."', date_of_approval='".date('Y-m-d')."' where business_id in (".$userid_arr[$i].") and approve!='1'","");
	 }
	}else{ //$userid_cnt=0
		$merch_code="MER"."-".strtoupper(str_rand(8,"numeric"));
		$id = $dbObj->customqry("update tbl_bussiness set approve = '1', merchet_id='".$merch_code."', date_of_approval='".date('Y-m-d')."' where business_id =".$userid_arr."","");
	}
			$s=$msobj->showmessage(16);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
elseif($action == "delete")
{
	$id = $dbObj->customqry("delete from tbl_bussiness where business_id in (".$userid1.")","");
  //$id = $dbObj->customqry("update tbl_bussiness set approve = '0' where business_id in (".$userid1.")","");  
  //exit;  
   $s=$msobj->showmessage(17);
	$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

ob_start();
$sf="";
$cnd="(b.name LIKE '%". trim($searchuser)."%' OR b.website LIKE '%". trim($searchuser)."%')";
$tbl="tbl_bussiness b INNER JOIN tbl_bussiness_category c ON b.bussiness_cat_id = c.categoryid";
if($_GET['state']){	$cnd.=" AND b.state LIKE'%". $_GET['state']."%'";	}
if($_GET['city']){	$cnd.=" AND b.city LIKE'%". $_GET['city']."%'";	}
if($_GET['search_zipcode']){	$cnd.=" AND b.zip =". $_GET['search_zipcode'];	}
if($_GET['usertypeid']){	$cnd.=" AND b.usertypeid =". $_GET['usertypeid'];	}
if($_GET['business_code']){	$cnd.=" AND b.business_code =". $_GET['business_code'];	}
if($_GET['categoryid']){	$cnd.=" AND b.bussiness_cat_id =". $_GET['categoryid'];	}
if($_GET['area_code']){	$cnd.=" AND b.area_code =". $_GET['area_code'];	}
if($_GET['telephoneno']){	$cnd.=" AND b.phone =". $_GET['telephoneno'];	}

if($_GET['categoryid']<>""){	$cnd.=" AND b.bussiness_cat_id =". $_GET['categoryid'];	}
	
if($_GET['sorttype']=='' || $_GET['sorttype']=='name')
	$ob = "b.name ".$_GET['sortord']."";
elseif($_GET['sorttype']=='website')
	$ob = "b.website " . $_GET['sortord'];
elseif($_GET['sorttype']=='category')
	$ob = "c.category " . $_GET['sortord'];
elseif($_GET['sorttype']=='country')
	$ob = "c.bussiness_cat_id " . $_GET['sortord']; 
elseif($_GET['sorttype']=='signup')
	$ob = "b.signup_date " . $_GET['sortord'];
elseif($_GET['sorttype']=='last_login')
	$ob = "lastlogin " . $_GET['sortord'];
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='code')
	$ob = "b.business_code ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='offer')
	$ob = "b.totalOffers ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='generated')
	$ob = "b.totalGenerated ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='approvedt')
	$ob = "b.date_of_approval ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='address')
	$ob = "b.add1 ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='city')
	$ob = "b.city ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='state')
	$ob = "b.state ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='zipcode')
	$ob = "b.zip ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='approve')
	$ob = "b.approve ".$_GET['sortord']."";
elseif($_GET['sorttype']=='' || $_GET['sorttype']=='comment')
	$ob = "b.comment ".$_GET['sortord']."";
 elseif($_GET['sorttype']=='' || $_GET['sorttype']=='telephone')
 	$ob = "b.phone ".$_GET['sortord']."";

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;
$newsperpage =10;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/


$rs=$dbObj->gj($tbl, $sf, $cnd, $ob, "", "", $l, "");
if($rs != 'n'){
	$i=0;
	while($row=@mysql_fetch_assoc($rs)){
		$users[]=$row;


	if($users[$i]['state']<>""){
		$re1 = $dbObj->cgs("mast_state","state_name",array("id"),array($users[$i]['state']),"state_name","","");
		while($row2 = @mysql_fetch_assoc($re1)){
			$sel_state = $row2['state_name'];
		}
		$users[$i]['state']=$sel_state;
		$row['state']=$sel_state;	
	}
	if($users[$i]['userid']<>""){
		$re1u = $dbObj->cgs("tbl_users","*",array("userid"),array($users[$i]['userid']),"first_name","","");
		while($row2u = @mysql_fetch_assoc($re1u))
                {
		        $users[$i]['first_name']=$row2u['first_name'];
		        $users[$i]['last_name']=$row2u['last_name'];
		        $users[$i]['position']=$row2u['position'];
		        $users[$i]['email']=$row2u['email'];
		        $users[$i]['contactno']=$row2u['contactno'];
		}
		
	}


// 		if($row['state']<>""){ if($address<>""){$address.=", "; } $address.=$users[$i]['state'];  }
// 		if($row['zip']<>""){ if($address<>""){$address.=", "; } $address.=$users[$i]['zip'];  }
// 		if($row['phone']<>""){ if($address<>""){$address.=", "; } $address.=$users[$i]['phone'];  }
// 		$users[$i]['address']=$address;
/*
	if($row['fine_prints']<>""){
	$re1 = $dbObj->cgs("mast_fine_prints","fine_prints","fine_prints_id",$row['fine_prints'],"fine_prints","","");
		while($row2 = @mysql_fetch_assoc($re1)){
			$sel_fine_prints = $row2['fine_prints'];
		}
	$row['fine_prints']=$sel_fine_prints;
	}
*/
		$i++;
	}
	if(isset($users))
		$smarty->assign("users", $users);
}

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1){
$smarty->assign("showpgnation","yes");
	$showing   = !isset($_GET["page"]) ? 1 : $page;
  if($_GET['categoryid'])
	  $firstlink = "bussiness_list.php?categoryid=".$_GET['categoryid'];
  else  
	  $firstlink = "bussiness_list.php";
  if($_GET['categoryid'])
	  $seperator = '&page=';
  else
	  $seperator = '?page=';
	$baselink  = $firstlink;
	$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator);
	$smarty -> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg']))
{
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}

#-----Bussiness Category type List--------
	$rs=$dbObj->cgs("tbl_bussiness_category","","","","","","");
	while($row=@mysql_fetch_array($rs))
		$BCategory[]=$row;
	$smarty->assign("BCategory",$BCategory);
#--------END-------------


	$sf1=array("id","state_name");
	$result1 = $dbObj->cgs('mast_state',$sf1,"" ,"", "" ,"" ,""); 
		while($row1=@mysql_fetch_assoc($result1))
		{
			$state1[]=$row1;
		}
	$smarty->assign("state",$state1);

$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/bussiness_list.tpl');

$dbObj->Close();
?>