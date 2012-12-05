<?php
include_once('../../includes/SiteSetting.php');
if(!$_SESSION['duAdmId']){
	header("location:". SITEROOT . "/admin/login/index.php");
	exit;
}

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

if(isset($_POST['approve'])){

    //$id = $dbObj->customqry("update tbl_bussiness set approve = '1' where business_id = '".$_POST['busid']."'", "");
                    
    $tbl1="tbl_bussiness b INNER JOIN tbl_bussiness_category c ON b.bussiness_cat_id = c.categoryid left join tbl_users u ON u.userid = b.userid";
    	
    $cd="  b.business_id =". $_POST['busid'];	
   
    
    $sf = "b.*,u.first_name,u.last_name,u.email,u.contactno,u.position,c.category";//
    
    $rs_buss = $dbObj->gj($tbl1, $sf, $cd, "", "", "", $l,"");
    
    $buss_arr=@mysql_fetch_assoc($rs_buss);			
    	
    $email=$buss_arr['email'];
    $buss_name_arr=split(" ",$buss_arr['name']);
    
    $merch_code="MER"."-".strtoupper(str_rand(8,"numeric"));
    //$merch_code="MER".$buss_name_arr[0]."_".$userid_arr[$i];

    $usertypeid='3';
    $name=$buss_arr['name'];
    $city=$buss_arr['city'];
    $website=$buss_arr['website'];
    $add=$buss_arr['add1'].",".$buss_arr['add2'];
    
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
    
   
    $from = SITE_EMAIL;		
            @mail(trim($email),$subject,$sum6,"From: $from\nContent-Type: text/html; charset=iso-8859-1","");
            
    $id = $dbObj->customqry("update tbl_bussiness set approve = '1', merchet_id='".$merch_code."', date_of_approval='".date('Y-m-d')."' where business_id = '".$_POST['busid']."' and approve!='1'","");
    
    header("Location: ".SITEROOT."/admin/user/bussiness_list.php");
    exit;
}



/******************************************
To View Bussiness
*******************************************/
$tbl1="tbl_bussiness b INNER JOIN tbl_bussiness_category c ON b.bussiness_cat_id = c.categoryid left join tbl_users u ON u.userid = b.userid";
if($_GET['business_id'])
{	
    $cd="  b.business_id =". $_GET['business_id'];	
}

$sf = "b.*,u.first_name,u.last_name,u.email,c.category,u.contactno,u.position";//

$dbres1 = $dbObj->gj($tbl1, $sf, $cd, "", "", "", $l,"");

$row = @mysql_fetch_assoc($dbres1);
	$address="";
	if($row['add1']<>""){ if($address<>""){$address.=", "; } $address.=$row['add1'];  }
	if($row['add2']<>""){ if($address<>""){$address.=",<br> "; } $address.=$row['add2'];  }
	/*if($row['city']<>""){ if($address<>""){$address.=",<br> "; } $address.=$row['city'];  }
	if($row['state']<>""){ if($address<>""){$address.=", "; } $address.=$row['state'];  }
	if($row['zip']<>""){ if($address<>""){$address.=", "; } $address.=$row['zip'];  }*/		
	
	$row['address']=$address;
      if($row['state']<>""){
          $re1 = $dbObj->cgs("mast_state","state_name",array("country_id","id"),array("223",$row['state']),"state_name","","");
          while($row2 = @mysql_fetch_assoc($re1)){
                  $sel_state = $row2['state_name'];
          }
	 $row['state']=$sel_state;
	}
	if($row['fine_prints']<>""){
	$re1 = $dbObj->cgs("mast_fine_prints","fine_prints","fine_prints_id",$row['fine_prints'],"fine_prints","","");
		while($row2 = @mysql_fetch_assoc($re1)){
			$sel_fine_prints = $row2['fine_prints'];
		}
	$row['fine_prints']=$sel_fine_prints;
	}
$smarty->assign("row", $row);


$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/user/bussiness_view.tpl');

$dbObj->Close();
?>