<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
$msobj= new message();

if(!isset($_SESSION['duAdmId']))
{
      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}

/*-----------------------Pagination Part1--------------------*/
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
$newsperpage =20;
$StartRow = $newsperpage * ($page-1);
if($_GET['view'] == 'excel')
$l="";
else
$l =  $StartRow.','.$newsperpage;
        $rating_query = "select * from tbl_deal_reviews as tdr left join tbl_deal as tdu ON tdr.deal_id = tdu.deal_unique_id LIMIT ".$l;
       // $rating_query = "SELECT * FROM tbl_deal_reviews LEFT JOIN tbl_users ON tbl_deal_reviews.user_id=tbl_users.userid LEFT JOIN tbl_deal ON //tbl_deal_rating.deal_id=tbl_deal.deal_unique_id";
	$rating_rs = mysql_query($rating_query)or die(mysql_error());
	$i = 0;
	while($row = mysql_fetch_array($rating_rs))
	{
	   $tmp = array(
                 'review_id'=> $row['review_id'],
                 'deal_id'=> $row['deal_id'],
                 'user_id'=>$row['user_id'],
                 'review_text'=>$row['review_text'],
                 'review_name'=>$row['review_name'],
                 'review_date'=>$row['review_date'],
                'fullname'=>$row['fullname'],
                'title'=>$row['title']
                );
                $results[$i++] = $tmp;
	}
	$smarty -> assign("ratingmark", $results);
	$smarty -> assign("ratingdate",$rating_date);
	
// 
 if(isset($_POST['submit']))
 {
     $action=$_POST['action'];
     $review_id=$_POST['review_id'];
     $review_id = implode(",", $review_id);
      if($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_deal_reviews where review_id IN (".$review_id.")","");
		// $sql="DELETE from tbl_deal_rating where rating_id IN($rating_id)";
                //$result = mysql_query($sql)or die(mysql_error());
		$s=$msobj->showmessage(199);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		
		  header("Location: review_list.php");
	           exit;
	}
 }
// /*-----------------------Pagination Part2--------------------*/
$rs1 =$dbObj->gj("tbl_deal_reviews","*", "review_id", "", "", "", "", "");
$nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 20;
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");

    $showing   = !isset($_GET["page"]) ? 1 : $page;
    if($_GET['searchuser']!='')
    {
	    $firstlink = "review_list.php?searchuser=".$_GET['searchuser'];
	    $seperator = '&page=';
    }
    else 
    {
	  $firstlink = "review_list.php";
	  $seperator = '?page=';
    }
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);	
    $smarty-> assign("pagenation",$pagenation);
}
// /*-----------------------End Part2--------------------*/
 if(isset($_SESSION['msg'])){
 	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
 }
// $smarty->assign("inmenu", "user");
$smarty->display(TEMPLATEDIR . '/admin/modules/review/review_list.tpl');

$dbObj->Close();
?>
