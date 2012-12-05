<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");

if(!isset($_SESSION['duAdmId']))
    header("location:".SITEROOT . "/admin/login/index.php");

/*---------------Get dau_id hear and display deal_id and userid - tbl_deal_affiliate_users table-------------------*/
   if($_GET['user_id']>0)
   {
        $sqlrs="SELECT sum( tdts.affiliate_amt ) 'totAmt',tds.email,tu.userid, tu.username, tu.first_name, tu.last_name FROM
         tbl_deal_affiliate_users tds  LEFT JOIN tbl_deal_affiliate_tosend_users tdts ON tds.unique_id = tdts.unique_id LEFT JOIN tbl_users tu ON
         tu.userid = tds.user_id WHERE tds.user_id =".$_GET['user_id']." AND tdts.used = 'yes'";
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

/*---------------Get  userid -and display record  *tbl_deal_affiliate_tosend_users* table-------------------*/

if($row['userid']>0)
{
        $sql="SELECT  * FROM tbl_deal_affiliate_tosend_users where user_id=".$row['userid']."  AND used = 'yes' LIMIT ".$l;
        $rec=mysql_query($sql)or die(mysql_error());
    while($rows=@mysql_fetch_assoc($rec))
    {
        $list[]=$rows;
    }
  /*------------Pagination Part-2------------*/
        $sqlpage="SELECT  * FROM tbl_deal_affiliate_tosend_users where user_id=".$row['userid']."  AND used = 'yes'"; 
        $rsrecpage=mysql_query($sqlpage)or die(mysql_error());
        $nums = @mysql_num_rows($rsrecpage);
        $show = 5;
        $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1)
    {
        $smarty->assign("showpgnation","yes");
        $showing   = !isset($_GET["page"]) ? 1 : $page;
        $firstlink = "view_referal_report.php?user_id=".$_GET['user_id'];
        $seperator = '&page=';
        $baselink  = $firstlink;
        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }
}
        $smarty->assign("list", $list);
        $smarty->display(TEMPLATEDIR . '/admin/report/view_referal_report.tpl');
        $dbObj->Close();
?>