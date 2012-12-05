<?php
include_once('../../includes/SiteSetting.php');
include_once("../../includes/paging.php");
include_once('../../includes/class.message.php');
$msobj= new message();

if(!$_SESSION['duAdmId'])
{
	header("location:". SITEROOT . "/admin/login/index.php");

}
#----------Get deal reating information-------------#
if($_GET['rating_id'])
{
                        $rating_id=$_GET['rating_id'];
                        $sql="select * from tbl_rating where rating_id=".$rating_id;
                        $resultrating=mysql_query($sql)or die(mysql_error());
                        $row=mysql_fetch_array($resultrating);
                        if(!(@mysql_num_rows($resultrating) > 0))
                        {
                            header("location:".SITEROOT . "/admin/modules/rating/raviews_rating_deals_list.php");
                            exit;
                        }
                        $deal_id=$row['deal_id'];
                        $user_id=$row['user_id'];
                        $average_rating=$row['average_rating'];
                        $ratingdate=$row['rating_date'];
                         $feedback=$row['feedback'];
                        $smarty->assign("deal",$row['deal_id']);
                        $smarty->assign("average_rating",$average_rating);
                        $smarty->assign("ratingdate",$ratingdate);
                        $smarty->assign("feedback_text",$feedback);

                        $tbl = "tbl_detailed_rating sr, rating_question q ";
			$sf="sr.*,q.rating_question";
			$cnd=" sr.question_id=q.id AND rating_id=".$row['rating_id'];
			$rs_rating=$dbObj->gj($tbl,$sf,$cnd,"","","","","");
			
			
			while($rows_rating=@mysql_fetch_assoc($rs_rating))
			{
				$subprofile_r[]=$rows_rating;	
			}
// 			echo "<pre>";
// 			print_r($subprofile_r);
// 			exit;
                         $smarty->assign("subprofile",$subprofile_r);

                        $sqldeal="select * from tbl_deal where deal_unique_id=$deal_id";
                        $resultdeal=mysql_query($sqldeal)or die(mysql_error());
                        $rowdeal=mysql_fetch_array($resultdeal);
                        
                        $rowdeal=$rowdeal['title'];
                        $smarty->assign("dealname",html_entity_decode($rowdeal));
                        
                        $sqlusers="select * from tbl_users where userid=$user_id";
                        $resultusers=mysql_query($sqlusers)or die(mysql_error());
                        $rowusers=mysql_fetch_array($resultusers);
                        $rowfrist=$rowusers['first_name'];
                        $rowlast=$rowusers['last_name'];
                        $smarty->assign("fristname",$rowfrist);
                        $smarty->assign("lastname",$rowlast);
}
else{
$smarty->assign("emptyblog");
}
$smarty->display(TEMPLATEDIR . '/admin/modules/rating/raviews_rating_view.tpl');

$dbObj->Close();
?>