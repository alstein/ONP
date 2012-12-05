<?php
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/paging.php');
//include_once('../../../includes/classes/class.forum.php');
//$forumObj = new Forum();

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");

#--get info about deal and seller--#
$date=date("Y-m-d H:i:s");

$cnd_arr = "deal_unique_id = ".$_GET['id'];
$rs_arr = $dbObj->gj("tbl_deal", "seller_id,title", $cnd_arr, "", "", "", "", "");
$deal = @mysql_fetch_assoc($rs_arr);

// $cnd_sup = "userid=".$deal['seller_id'];
// $rs_sup = $dbObj->gj("tbl_users","userid",$cnd_sup,$ob, "", "", "", "");
// $res_sup = @mysql_fetch_assoc($rs_sup);
#---end---#
#--inserting record into tbl_feedback_review----#

$sql_feed = "select avg(rating) as rating,count(fid) as id from feedback where deal_id = ".$_GET['id']." group by deal_id";
			$qry_feed = @mysql_query($sql_feed);
			$arr_feed = @mysql_fetch_assoc($qry_feed);
                        $avg=($arr_feed['rating']/5)*100;
                        $smarty->assign("total",round($avg));

               
                 $cnd_feed = "deal_id = ".$_GET['id'];
		$rs_feed = $dbObj->gj("tbl_feedback_review", "*", $cnd_feed, "", "", "", "", "");
		$feed = @mysql_fetch_assoc($rs_feed);
                $smarty->assign("feed",$feed);

if(isset($_POST['submit']))
{
extract($_POST);

                
                if($rs_feed != "n")
                {
                        $f=array("total","review","posted_date");
                        $v=array($per_fb,$review_fb,$date);
                        $rs=$dbObj->cupdt('tbl_feedback_review', $f, $v, 'deal_id',$_GET['id'],'');
                
                        $_SESSION['msg']="<span class='Success'><strong>Feedback review updated successfully.</strong></span>";
                        $msg="Feedback updated by administrator for deal ".$deal['title'];
 
                }
                else
                {
              
                $field_arr1 = array("seller_id","deal_id","total","review","posted_date");
                $value_arr1 = array($deal['seller_id'],$_GET['id'],$per_fb,$review_fb,$date);
                $insert_id1 = $dbObj->cgi("tbl_feedback_review",$field_arr1,$value_arr1,""); 
                $_SESSION['msg']="<span class='Success'><strong>Feedback review added successfully.</strong></span>";
                $msg="Feedback added by administrator for deal ".$deal['title'];
                }

                 #---notifications---#
                $field_notification = array(
                "userid"=>$deal['seller_id'],
                "message"=>$msg,
                "date"=>date("Y-m-d")
                );
                $dbObj->cgii("tbl_notifications",$field_notification,"");
                #----end-----#
                 header("Location:".$_SERVER['HTTP_REFERER']);
                exit;
}




#---end---#

/*-----------------------Pagination Part1--------------------*/

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;
$newsperpage = 10;
$StartRow = $newsperpage * ($page-1);
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/

$sf = "f.*,u.first_name,(select first_name from tbl_users uu where f.userid = uu.userid) as buyer";
$tbl = "feedback as f LEFT JOIN tbl_users as u ON u.userid = f.userid ";
$cnd="f.deal_id=".$_GET['id'];
#-------------------------------------------------------------

$rs = $dbObj->gj($tbl, $sf , $cnd,$od , "", $ad, $l, "");
$i = 0;
while($row = @mysql_fetch_assoc($rs))
{
	$faq[] = $row;
	
	$faq[$i]['grey']= 5 -$row['rating'];
        $faq[$i]['delivery_grey']= 5 -$row['delivery'];
        $faq[$i]['item_grey']= 5 -$row['item'];
	$i++;
}
/*
echo"<pre>";
 print_r($faq);exit;*/
$smarty->assign("feedback", $faq);

/*-----------------------Pagination Part2--------------------*/
$rs=$dbObj->gj($tbl, $sf, $cnd, "", "", "", "", "");  
$nums =@mysql_num_rows($rs);
$smarty -> assign("recordsFound",$nums);
$show = 5;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{	
    $smarty -> assign("showpgnation","yes");
$showing   = !isset($_GET["page"]) ? 1 : $page;

if(!empty($_GET))
{
	$firstlink = "deal-feedback.php?search=".$_GET['search']."&supplier=".$_GET['supplier']."&from=".$_GET['from']."&submit=Submit";
}
else
	$firstlink = "deal-feedback.php?";

$seperator = '&page=';
$baselink  = $firstlink; 
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

if(isset($_SESSION['msg'])){
	$smarty->assign("msg", $_SESSION['msg']);
	unset($_SESSION['msg']);
	
}

/*---Fetch supplier list---*/
$cnd_sup = "usertypeid = 'supplier'";
$ob="first_name ASC";
$rs_sup = $dbObj->gj("tbl_users","userid,first_name,usertypeid",$cnd_sup,$ob, "", "", "", "");
while($res_sup = @mysql_fetch_assoc($rs_sup))
{
	$result_sup[]=$res_sup;
}
$smarty->assign("result_sup",$result_sup);
/*---End fetch supplier list---*/

/*---Fetch buyer list---*/
$cnd_buy = "usertypeid = 'buyer'";
//$ob="first_name ASC";
$rs_buy = $dbObj->gj("tbl_users","userid,first_name,usertypeid",$cnd_buy,$ob, "", "", "", "");
while($res_buy = @mysql_fetch_assoc($rs_buy))
{
	$result_buy[]=$res_buy;
}
$smarty->assign("result_buy",$result_buy);
/*---End fetch supplier list---*/
$smarty->assign("sort_by_field",$sort_by_field);
$smarty->assign("order_type",$order_type);

$smarty->assign("inmenu","sitemodules");
$sea=$_GET['search'];
$smarty->assign('searchby',$sea);

if($_SESSION['msg'])
 {
 	$smarty->assign('msg',$_SESSION['msg']);
 	unset($_SESSION['msg']);
 }

$smarty->display(TEMPLATEDIR . '/admin/modules/feedback/deal-feedback.tpl');



$dbObj->Close();
?>