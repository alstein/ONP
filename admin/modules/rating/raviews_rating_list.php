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
 if($_GET['deal_id'])
 {
if(!isset($_GET['page']))
    $page =1;	
else
    $page = $_GET['page'];
    $newsperpage =20;
    $StartRow = $newsperpage * ($page-1);
    $l =  $StartRow.','.$newsperpage;

        $rating_query = "SELECT * FROM tbl_rating LEFT JOIN tbl_users ON tbl_rating.user_id=tbl_users.userid LEFT JOIN tbl_deal ON tbl_rating.deal_id=tbl_deal.deal_unique_id WHERE deal_id=".$_GET['deal_id']." order by rating_date DESC LIMIT ".$l;
	$rating_rs = mysql_query($rating_query)or die(mysql_error());
	$i = 0;
	if(!(@mysql_num_rows($rating_rs) > 0))
        {
            header("location:".SITEROOT . "/admin/modules/rating/raviews_rating_deals_list.php");
            exit;
        }			
	while($row = mysql_fetch_array($rating_rs))
	{
	   $tmp = array(
                 'rating_id' => $row['rating_id'],
                 'deal_id'=> $row['deal_id'],
                 'user_id'=>$row['user_id'],
                 'deal_title'=>$row['deal_title'],
                 'feedback_title'=>$row['feedback_title'],
                 'feedback'=>$row['feedback'],
                 'average_rating'=>$row['average_rating'],
                 'rating_date'=>$row['rating_date'],
                'fullname'=>$row['fullname'],
                'title'=>$row['title']
                );
                $smarty -> assign("deal_name",html_entity_decode(html_entity_decode($row['deal_title'])));
                $tbl = "tbl_detailed_rating sr, rating_question q ";
                $sf="sr.*,q.rating_question";
                $cnd=" sr.question_id=q.id AND rating_id=".$row['rating_id'];
                $rs_rating=$dbObj->gj($tbl,$sf,$cnd,"","","","","");

                $subprofile_r = array();
                while($rows_rating=@mysql_fetch_assoc($rs_rating))
                {
                    $subprofile_r[]=$rows_rating;
                }

                $tmp['subprofile_r'] = $subprofile_r;
                $results[$i++] = $tmp;
	}
	$smarty -> assign("ratingmark", $results);
	$smarty -> assign("ratingdate",$rating_date);
	$smarty -> assign("subprofile_r",$subprofile_r);
	
/*-----------------------Pagination Part2--------------------*/
	
//$rs1 =$dbObj->gj("tbl_rating","*","rating_id","", "","","","");
$rs1= $dbObj->customqry("SELECT * FROM tbl_rating LEFT JOIN tbl_users ON tbl_rating.user_id=tbl_users.userid LEFT JOIN tbl_deal ON tbl_rating.deal_id=tbl_deal.deal_unique_id WHERE deal_id=".$_GET['deal_id']." order by rating_date DESC","");
 $nums =@mysql_num_rows($rs1);

$smarty -> assign("recordsFound",$nums);
$show = 20;
  $total_pages = ceil($nums / $newsperpage);

if($total_pages > 1)
{
    $smarty->assign("showpgnation","yes");
    $showing   = !isset($_GET["page"]) ? 1 : $page;
    $firstlink = "raviews_rating_list.php?deal_id=".$_GET['deal_id'];
    $seperator = "&page="; 
    $baselink  = $firstlink;
    $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);
    $smarty-> assign("pagenation",$pagenation);
}
/*-----------------------End Part2--------------------*/

 if(isset($_POST['submit']))
 {
     $action=$_POST['action'];
     $rating_id=$_POST['rating_id'];
     $rating_id = implode(",", $rating_id);
      if($action == "delete")
	{
		$id = $dbObj->customqry("delete from tbl_rating where rating_id IN (".$rating_id.")","");
		$s=$msobj->showmessage(198);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";		
                header("Location: raviews_rating_list.php?deal_id=".$_GET['deal_id']);
                exit;
	}
}
}else{
           $smarty->assign("emptyrecord");
     }
 if(isset($_SESSION['msg']))
 {
 	$smarty->assign("msg",$_SESSION['msg']);
	$_SESSION['msg']=NULL;
 }
$smarty->display(TEMPLATEDIR . '/admin/modules/rating/raviews_rating_list.tpl');

$dbObj->Close();
?>
