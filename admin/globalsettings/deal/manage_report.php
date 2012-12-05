<?php
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

$msobj= new message();
$smarty->assign("msobj",$msobj);

if(!$_SESSION['duAdmId'])
	{
		header("location:".SITEROOT . "/admin/login/_welcome.php");
	}



function get_user_from_id($usr_id)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "userid={$usr_id}", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}

function get_user_from_email($usr_emailid)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "email='{$usr_emailid}'", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}

// select * from tbl_deal where product where product_id = (select product_id,max(`deal_end_date`) from tbl_deal where deal_on != '0000-00-00 00:00:00' group by product_id  order by `deal_end_date` desc)

$deal_t_rs = $dbObj->customqry("select product_id,max(`deal_end_date`) as end_date
from tbl_deal
where deal_on_date != '0000-00-00 00:00:00'
group by product_id
order by `deal_end_date` desc","");

while($deal_t_res=@mysql_fetch_array($deal_t_rs))
{
    $deal_t_arr[] = $deal_t_res; 
}


 $t=0;
foreach($deal_t_arr as $da)
{
    $title_sf    = "p.*";
    $title_table = " tbl_deal as p";
    $title_cnd   = "p.deal_end_date = '{$da['end_date']}' and p.product_id={$da['product_id']} and (p.deal_status =1 or p.deal_status =2)";

    $deal_title_rs = $dbObj->gj($title_table, $title_sf, $title_cnd , "", "", "", "", "");
    $deal_title_res = @mysql_fetch_assoc($deal_title_rs);

    if($deal_title_res['product_name'])
    $deal_title_arr[] = $deal_title_res;
    $t++;
}
$smarty -> assign("deal_title_arr",$deal_title_arr);




/* ----------------------------------------------------------------------------------- */


if($_GET['prod_deal_id'] != "")
{

/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;                        

$newsperpage =25;                            
$StartRow = $newsperpage * ($page-1);            
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$sf = "dpu.*, dp.*, p.product_disc_price, p.product_name";
$tbl = "tbl_deal_payment_unique as dpu, tbl_deal_payment as dp, tbl_deal as p";

$cnd = "dpu.deal_id = {$_GET['prod_deal_id']} and dp.pay_id = dpu.pay_id and dpu.deal_id = p.product_id";


$rs = $dbObj->gj($tbl, $sf , $cnd, "", "", "", $l, "");
$i=0;
while($row = @mysql_fetch_assoc($rs))
{
	$deal_arr[$i] = $row;

	$user_arr = get_user_from_id($row['user_id']);
	$deal_arr[$i]['from_username']=	$user_arr['first_name']." ".$user_arr['last_name'];
        $deal_arr[$i]['email']=	$user_arr['email'];
        $deal_arr[$i]['product_name']=	$row['product_name'];
         

$i++;
}	

$smarty->assign("deal_arr", $deal_arr);

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 10;        
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;
$firstlink = basename($_SERVER['PHP_SELF']) . "?search=".$_GET['search'];
$seperator = '&page=';
$baselink  = $firstlink; 
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/

}



$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/sitemodules/deal/manage_report.tpl');

$dbObj->Close();
?>