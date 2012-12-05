<?
	include_once('../../../includes/SiteSetting.php');
	include_once("../../../includes/common.lib.php");


	if(!$_SESSION['duAdmId'])
		header("location:".SITEROOT . "/admin/login/index.php");


	$date=date("Y-m-d H:i:s");
	//$date1=$date." 00:00:01";
	//echo "<br />";
// 	$date2=$date." 23:59:59";
	$cnd="product_city = 'New York' AND (deal_start_date <='$date' AND deal_end_date >= '$date')";
	$arr=$dbObj->gj("tbl_deal","*",$cnd,"","","","","");
	$dealarr=@mysql_fetch_assoc($arr);
	// print_r($counddown);
	//end calender
	//start product information
	$id = $_GET['id']?$_GET['id']:0;
$smarty->assign('dealid',$id);
	$tbl = "tbl_deal";
	$cnd = "product_id = ".$id;
	$sf = "*";
	$result = $dbObj ->gj($tbl ,$sf, $cnd,"", "" , "" , "", "","");
	while($ro = @mysql_fetch_assoc($result))
		$dealinfoarr = $ro;
	
	$smarty->assign("dealinfoarr",$dealinfoarr);


	$save = $dealinfoarr['product_act_price'] - $dealinfoarr['product_disc_price'];
	$disc = $save/$dealinfoarr['product_act_price'];
	$disc_rnd = round($disc,2);
	$per_rnd = ($disc_rnd)*100;
	//end information
	//start marchant information
	$merchant=$dbObj->cgs("tbl_users","*","userid",$dealinfoarr['merchant_id'],"","","");
	$usrarr=@mysql_fetch_assoc($merchant);
	
	$smarty->assign("userarray",$usrarr);
	//end marchant information
	//marchant feedback information
	$merchantfeedback=$dbObj->cgs("tbl_deal_reviews","*",array("deal_id"),array($_GET['id']),"","","");
	while($usrarrfeedback1=@mysql_fetch_assoc($merchantfeedback))
	{
		$usrarrfeedback[]=$usrarrfeedback1;
	}
	$smarty->assign("userarrayfeedback",$usrarrfeedback);
	//marchant feedback information end

	$deal_high=$dbObj->cgs("tbl_product_highlights","*",array("deal_id"),array($_GET['id']),"","","");
	while($deal_high1=@mysql_fetch_assoc($deal_high))
	{
		$arr_high[]=$deal_high1;
	}
	$smarty->assign("arr_high",$arr_high);

	$smarty->assign("dealinfoarr",$dealinfoarr);
	$smarty->assign("save",$save);
	$smarty->assign("per_disc",$per_rnd);
if($dealinfoarr['product_id']!="")
{
	$sql13 = "select sum(deal_quantity) as sumtotal from tbl_deal_payment where deal_id = ".$dealinfoarr['product_id'];
	$qry13 = @mysql_query($sql13); //echo "<br>";
	$nu = @mysql_num_rows($qry13); 
	if($nu>0)
	{
		$_arow = @mysql_fetch_assoc($qry13);
			$getSum=$_arow['sumtotal'];
	}
	else
	{
	$getSum='0';
	}
}else
{
$getSum='0';
}
	$smarty->assign("totalsold",$getSum);


/////////////////deal image //////////////////////////
	$l="0,5";
	if($dealinfoarr['product_id']!="")
	$cnd="product_id=".$dealinfoarr['product_id'];
	else
	$cnd="1";
  	$arr1=$dbObj->gj("tbl_product_image","*",$cnd,"","","",$l,"");
	if($arr1!= 'n')
	{
          $i=0;
         while($resws=mysql_fetch_assoc($arr1))
         {  $imageprd[$i]=$resws['thumbnail'];
            $i=$i+1;
         }	
         $smarty->assign("imageprd",$imageprd);
       }

///////////////////////////////////////////////
	
	//for timer
	$days = $dealinfoarr['deal_days'];
	$hours = $dealinfoarr['deal_hours'];
	
	$time = strtotime($dealarr['deal_end_date']);
	$start_time = strtotime($dealarr['deal_start_date']);
	$start_day = date("F d, Y H:i:s",$start_time);
	$end_day = date("F d, Y H:i:s",$time);


	$deal_day = date("d",mktime(0,0,0,date("m",$time),date("d",$time),0));
	$deal_month = date("m",mktime(0,0,0,date("m",$time),date("d",$time),0));
	$deal_year = date("Y",mktime(0,0,0,date("m",$time),date("d",$time),date("Y",$time)));
	$deal_hours = date("H",mktime(date("H",$time),date("i",$time),date("s",$time),date("m",$time),date("d",$time),date("Y",$time)));
	//echo $deal_hour = date("H",mktime(0,0,0,date("m",$time),date("d",$time)+$days,0));

	$smarty->assign("start_day",$start_day);
	$smarty->assign("end_day",$end_day);

	
	if($_POST['dealnewsletter'])
	{

		if($_POST['emailid']=='' || $_POST['emailid']=='--email id' )
		{
		$error = "Please enter an email address ";
				$smarty->assign("error",$error);
		}
		elseif(!isValidEmail($_POST['emailid']))
		{
					$error1 = "Please enter a valid email address ";
					$smarty->assign("error",$error1);
		}
		else
		{
			$queryarray=$dbObj->cgs("tbl_newsletter_subscriber","*","emailid",$_POST['emailid'],"","","");
			if($queryarray == 'n'){
			$dbObj->cgi("tbl_newsletter_subscriber",array("emailid","status"),array($_POST['emailid'],'Active'),"");
			}
			$error2 = "You'll receive your first daily email tomorrow";
			$smarty->assign("success",$error2);
		
		}
	}

	// Get cities
	$tbl = "tbl_deal as p, mast_city as c";
	$sf = "c.city_name";
	$cnd = "c.city_name = p.product_city";
	$res1 = $dbObj->gj($tbl,$sf,$cnd,"","p.product_city","","","");
	$arr_city = array();

	$smarty->assign("right", TEMPLATEDIR .'/rightside_admin.tpl');

	$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/view_deal.tpl');
	
	$dbObj->Close();
?>
