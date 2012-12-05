<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!isset($_SESSION['duAdmId']))
    header("location:".SITEROOT . "/admin/login/index.php");

/*---------------Get dau_id hear and display deal_id and userid - tbl_deal_affiliate_users table-------------------*/
   if($_GET['dau_id']>0)
   {
        $sqlrs="SELECT tu.userid, tu.username, tu.first_name, tu.last_name, td.title, ta . *
        FROM tbl_deal_affiliate_users ta LEFT JOIN tbl_users tu ON tu.userid = ta.user_id LEFT JOIN tbl_deal td ON td.deal_unique_id= ta.deal_id
         where dau_id=".$_GET['dau_id'];
        $sqlrec=mysql_query($sqlrs)or die(mysql_error());
        $row=@mysql_fetch_assoc($sqlrec);
        $smarty->assign("viewpay", $row);
   }
   
   /*------------Pagination Part-1------------*/
    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
        $adsperpage=20;
        $StartRow = $adsperpage * ($page-1);
        $l= $StartRow.','.$adsperpage;

/*-----------------------------------*/
/*---------------Get deal_id and userid -and display record  *tbl_deal_affiliate_tosend_users* table-------------------*/

if($row['deal_id']>0)
{
        $sql="SELECT  * FROM tbl_deal_affiliate_tosend_users where deal_id={$row['deal_id']}  and user_id={$row['user_id']} LIMIT {$l}";
        $rec=mysql_query($sql)or die(mysql_error());
    while($rows=@mysql_fetch_assoc($rec))
    {
        $list[]=$rows;
    }
} 
  /*------------Pagination Part-2------------*/
        $sqlpage="SELECT  * FROM tbl_deal_affiliate_tosend_users where deal_id={$row['deal_id']}  and user_id={$row['user_id']}"; 
        $rsrecpage=mysql_query($sqlpage)or die(mysql_error());
        $nums = @mysql_num_rows($rsrecpage);
        $show = 5;
        $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1)
    {
        $smarty->assign("showpgnation","yes");
        $showing   = !isset($_GET["page"]) ? 1 : $page;
        $firstlink = "view_refer_friend.php?dau_id=".$_GET['dau_id'];
        $seperator = '&page=';
        $baselink  = $firstlink;
        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }
        $smarty->assign("list", $list);
        $smarty->display(TEMPLATEDIR . '/admin/modules/referfriend/view_refer_friend.tpl');
        $dbObj->Close();
?>