<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");

if($_GET['id']!="" && $_GET['status']=='yes')
{
$update_offer=$dbObj->customqry("update tbl_users set offer_deal='yes' where userid='".$_GET['id']."'","");
@header("Location:".SITEROOT."/admin/user/offer_deal_request.php");
exit;
}
/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =15;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

#----code for excel report----#
    if($_GET['view'] == 'excel')
    {
        $out ="Seller Information";		
        $out .="\n";
        $out .="\n";
        $out .='A/C No & Name,Full Name,Email,City,Post Code,Registration Date,Last Login,Package Name,Subscription Status,Added By';
        $out .="\n";
        $out .="\n";
        $l="";
    }
#----code end-----------------#
$sf="u.*, t.usertype";
$tbl="tbl_users u INNER JOIN mast_usertype t ON u.usertypeid = t.typeid";
$cnd = "usertypeid =3  and is_applied=1";
if($_GET['exel_id']!='')
{
    $cnd .= " and u.userid =".$_GET['exel_id'];
}

if(isset($_GET['searchuser']))
{
$search=$dbObj->sanitize($_GET['searchuser']);
$cnd .= " and ( u.username LIKE '%{$search}%' OR u.email LIKE '%{$search}%' OR u.first_name LIKE '%{$search}%' OR u.last_name LIKE '%{$search}%' OR u.fullname LIKE '%{$search}%' OR u.postalcode LIKE '%{$search}%' ) ";
}
    //$cnd .= " and ( u.username LIKE '%{$_GET['searchuser']}%' OR u.email LIKE '%{$_GET['searchuser']}%' OR u.first_name LIKE '%{$_GET['searchuser']}%' OR u.last_name LIKE '%{$_GET['searchuser']}%' OR u.fullname LIKE '%{$_GET['searchuser']}%' OR u.postalcode LIKE '%{$_GET['searchuser']}%' ) ";

    $rs=$dbObj->gj($tbl, $sf, $cnd, "userid", "", "DESC", $l, "");
    if($rs != 'n')
    {
	$i=0;
	while($row=@mysql_fetch_assoc($rs))
        {
		  $users[$i]=$row;

               	
// 		 if($_GET['view'] == 'excel')
//                  {
//                     #---code for csv report-----#
// 
// 
// $out .= '"'.$users['userid']. $row['username'].'","'.$fullname.'","'.$row['email'].'","'.$row['city'].'","'.$row['postalcode'].'","'.date("d-m-Y",strtotime($row['signup_date'])).'","'.$date.'","'.$users[$i]['pack_name'].'","'.$user_subscription_status.'","'.$user_type.'"';
// 
// 
//                      $out .= "\n";
//                     #----code end---#
//                 }
            $i++;
	}
	$smarty->assign("users", $users);
    }

/*-----------------------Pagination Part2--------------------*/
$rs1=$dbObj->gj($tbl, $sf, $cnd, "userid", "", "DESC", "", "");
$nums =@mysql_num_rows($rs1);
$smarty -> assign("recordsFound",$nums);
$show = 10;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if(isset($_GET['searchuser']))
    {
	    $firstlink = "seller_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "seller_list.php";
	  $seperator = '?page=';
    }
        $baselink  = $firstlink;
        $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
        $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

#----code for csv report-------#
// 	if($_GET['view'] == 'excel')
// 	{
//             header("Content-type: text/x-csv");
//             header("Content-type: application/csv");
//             header("Content-Disposition: attachment; filename=Seller-details.csv");	
//             echo $out;
//             exit;
// 	}
	#----code end------#
if(isset($_SESSION['msg'])){
	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
}
$smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/user/offer_deal_request.tpl');
$dbObj->Close();
?>
