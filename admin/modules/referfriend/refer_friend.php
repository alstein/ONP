<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!isset($_SESSION['duAdmId']))
    header("location:".SITEROOT . "/admin/login/index.php");
	
if($_POST["submit"] == "Go")
{
            $id = implode(",",$_POST["dau_id"]);
             
            if($_POST["action"]=="delete")
            {
                    $sqldel="SELECT deal_id,user_id FROM tbl_deal_affiliate_users WHERE dau_id IN (".$id.")";
                    $ratingdel = mysql_query($sqldel)or die(mysql_error());
		while($rowdel = mysql_fetch_array($ratingdel))
		{
                    $dbObj->customqry("delete from tbl_deal_affiliate_tosend_users where deal_id IN (".$rowdel['deal_id'].")","");
		}
                    $id = $dbObj->customqry("delete from tbl_deal_affiliate_users where dau_id IN (".$id.")","");		
                    $_SESSION['msg']="<span class='success'>Refer friend Deleted Successfully.</span>";		
                    header("Location:refer_friend.php");
                    exit;
            }
}//if

/*------------Pagination Part-1------------*/
    if(!isset($_GET['page']))
        $page =1;
    else
        $page = $_GET['page'];
        $adsperpage=20;
        $StartRow = $adsperpage * ($page-1);
        $l= $StartRow.','.$adsperpage;

/*---------------Get record hear- tbl_deal_affiliate_users table-------------------*/
        $sqlrs="SELECT tu.userid, tu.username, tu.first_name, tu.last_name, td.title, ta . *
        FROM tbl_deal_affiliate_users ta LEFT JOIN tbl_users tu ON tu.userid = ta.user_id LEFT JOIN tbl_deal td 
        ON td.deal_unique_id= ta.deal_id ORDER BY ta.dau_date LIMIT ". $l;
        $sqlrec=mysql_query($sqlrs)or die(mysql_error());
    while($row=@mysql_fetch_assoc($sqlrec))
    {
          $list[]=$row;
    } 
     /*------------Pagination Part 2------------*/
        $rs="SELECT tu.userid, tu.username, tu.first_name, tu.last_name, td.title, ta . *
         FROM tbl_deal_affiliate_users ta LEFT JOIN tbl_users tu ON tu.userid = ta.user_id LEFT JOIN tbl_deal td 
         ON td.deal_unique_id= ta.deal_id ORDER BY ta.dau_date";
        $rsrec=mysql_query($rs)or die(mysql_error());
        $nums = @mysql_num_rows($rsrec);
        $show = 5;
        $total_pages = ceil($nums / $adsperpage);
    if($total_pages > 1)
    {
        $smarty->assign("showpgnation","yes");
        $showing   = !isset($_GET["page"]) ? 1 : $page;
        $firstlink = "refer_friend.php";
        $seperator = '?page=';
        $baselink  = $firstlink;
        $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
        $smarty -> assign("pgnation",$pgnation);
    }
        $smarty->assign("list", $list);

if(isset($_SESSION['msg']))
{
    $smarty->assign("msg", $_SESSION['msg']);
    unset($_SESSION['msg']);
}
    $smarty->display(TEMPLATEDIR . '/admin/modules/referfriend/refer_friend.tpl');
    $dbObj->Close();
?>