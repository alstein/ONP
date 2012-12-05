<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!$_SESSION['duAdmId'])
  header("location:".SITEROOT . "/admin/login/index.php");


$date=date("Y-m-d H:i:s");
$date1=date("Y-m-d");

#------------Pagination Part-1-----------#
if(!isset($_GET['page']))
    $page =1;
else
    $page = $_GET['page'];

$adsperpage = 15;
$StartRow = $adsperpage * ($page-1);
$l =  ($StartRow).','.$adsperpage;
#--------------------------------------#

$tbl="tbl_deal as d,tbl_deal_payment as p,tbl_users as u";
$cnd_test = "p.deal_id=d.deal_unique_id and p.user_id = u.userid ";

if(isset($_GET['status']))
{
      $status = $_GET['status'];

      if($status =="expire")
	$cnd_test .=" and p.payment_done = 'yes' and p.expiry_date < {$date1}";
      elseif($status =="all")
	$cnd_test .= " and p.payment_done in('yes','no') and p.cancel_order = 'no'";
      else //pending
	$cnd_test .= " and p.payment_done = 'no' and d.deal_status = '1'";
}
else
    $cnd_test .=" and p.payment_done = 'no' and d.deal_status = '1'";

if($_GET['uname'] !='')
{
	$cnd1 = "username  = '{$_GET['uname']}'";
	$tbl1= "tbl_users";
	$sf1="userid";
	$rs_userid = $dbObj->gj($tbl1,$sf1,$cnd1, "", "", "", "", "");
	if( $rs_userid !='n')
	    $rs_name = @mysql_fetch_assoc($rs_userid);

	$cnd_test .= " and p.user_id= {$rs_name['userid']} ";
}

$arr=$dbObj->gj($tbl,"p.*,d.title as title1,u.username",$cnd_test,"","","",$l,""); 

$i=0;
if($arr !='n')
{
	while($deal=@mysql_fetch_assoc($arr))
	{
		$deal_ar[]=$deal;

		$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
		$qry_contri2 = @mysql_query($sql_contri2);
		$arr_contri2 = @mysql_fetch_assoc($qry_contri2);
		$total_contribution2=$arr_contri2['sum_contribute'];
		$deal_ar[$i]['bought1']=$total_contribution2;
		$image1=$deal['medium_image'];
		$image=explode(",",$image1);
		$deal_ar[$i]['medium_image']=$image[0];
		$orignal_bucket_value2=$deal['max_buyer'];


	         $i++;
	}

      $smarty->assign("product",$deal_ar);	
}

/*----------Pagination Part-2--------------*/
$rs2=$dbObj->gj($tbl,"p.*,d.title as title1,u.username",$cnd_test,"","","","",""); 
$nums = @mysql_num_rows($rs2);
$show = 30;		
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
	$smarty->assign("showpaging",'yes');

$showing   = !($_GET['page'])? 1 : $_GET['page'];

if($_GET['uname'] != '' &&  $_GET['status']=='')
{
      $firstlink = "deal-order.php?uname={$_GET['uname']}";
      $seperator = '&page=';
}
else if($_GET['uname'] == '' &&  $_GET['status']!='')
{
      $firstlink = "deal-order.php?status={$_GET['status']}";
      $seperator = '&page=';
}
else if($_GET['uname'] != '' &&  $_GET['status']!='')
{
      $firstlink = "deal-order.php?uname={$_GET['uname']}&status={$_GET['status']}";
      $seperator = '&page=';
}
else
{

      $firstlink = "deal-order.php";
      $seperator = '?page=';
}

$baselink  = $firstlink; 

$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
$smarty->assign("pgnation",$pgnation);

#-------------------End ----------------------#


#---------------Get all username-------------#
$u_name=array();

$cnd = "1";
$tbl= "tbl_users";
$sf="first_name,last_name,username";
$rs_user = $dbObj->gj($tbl,$sf,$cnd, "username", "", "", "", "");

if( $rs_user !='n')
{
    while($rs_name = @mysql_fetch_assoc($rs_user))
    {
	$u_name[]['fullname']=$rs_name['first_name']." ".$rs_name['last_name'];
	$u_name[]['username']=$rs_name['username'];
    }
}
$smarty->assign("user_list", $u_name);
#---------------Get all username-------------#


if($_SESSION['msg'])
 {
 	$smarty->assign('msg',$_SESSION['msg']);
 	unset($_SESSION['msg']);
 }
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/deal-order.tpl');
$dbObj->Close();
?>