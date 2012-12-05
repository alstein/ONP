<?php
include_once('../../include.php');
include_once("../../includes/paging.php");

  $deal_idc=$_GET['deal_id']; 
  $deal_id=$dbObj->sanitize($deal_idc);
  $smarty->assign("deal_id",$deal_id);

if(isset($_GET['red']) && isset($_GET['deal_id']))
{
    $_SESSION['previous_page']=SITEROOT."/rating?deal_id=".$deal_id;
    header("location:".SITEROOT."/signin");
    exit;
}
///////////Get the Deal_Name And Seller_Name////////////////
                     $rs=$dbObj->cgs("tbl_deal","*","deal_unique_id",$deal_id,"","","");
                     $rec_dealid=@mysql_fetch_assoc($rs);		
                     $deal_title=$rec_dealid['title'];
                    $deal_seller_name= getDealSellerFromId($rec_dealid['deal_unique_id']); //$rec_dealid['deal_from_seller_name'];
                    $description=$rec_dealid['description'];
                    $big_image=$rec_dealid['big_image'];
                    $smarty->assign("deal_title",$deal_title);
                    $smarty->assign("deal_seller_name",$deal_seller_name);
                    $smarty->assign("big_image",$big_image);
                    $smarty->assign("description",$description);
///////////Get the Deal_Name And Seller_Name end////////////////


if(!isset($_GET['page']))
                     $page =1;	
                else
                     $page = $_GET['page'];
                     $newsperpage =4;
                     $StartRow = $newsperpage * ($page-1);
                     $l =  $StartRow.','.$newsperpage;
            //////////////Get All Review posted on perticular Deals////////////////
		
		 $tbl = "tbl_rating r JOIN tbl_users u ON r.user_id=u.userid";
		 $sf="r.*,u.fullname,u.username";
                 $cnd="r.deal_id='$deal_id' AND r.status=1";
                 $rs=$dbObj->gj($tbl,$sf,$cnd,"r.rating_id desc","","",$l,"");

// 		 $totalreview=@mysql_num_rows($rs);
// 		 $rs=$dbObj->gj($tbl,$sf,$cnd,"r.rating_id desc","","","","");
// 		 $pagereview=@mysql_num_rows($rs);
// 		 //print_r($totalreview);exit;
// 		 $smarty->assign("totalreview",$totalreview);
// 		 $smarty->assign("pagereview",$pagereview);
		 $i=0;
		while($row=@mysql_fetch_assoc($rs))
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
                            $tbl_r = "tbl_detailed_rating sr, rating_question q ";
                            $sf_r="sr.*,q.rating_question";
                            $cnd_r=" sr.question_id=q.id AND rating_id=".$row['rating_id'];
                            $rs_rating=$dbObj->gj($tbl_r,$sf_r,$cnd_r,"","","","","");
                            $subprofile_r = array();
                            while($rows_rating=@mysql_fetch_assoc($rs_rating))
                            {
                                    $subprofile_r[]=$rows_rating;
                            }
                            $tmp['subprofile_r'] = $subprofile_r;
                            $results[$i++] = $tmp;
	        } 
                            $smarty->assign("profile_r",$results);
                            $smarty->assign("subprofile_r",$subprofile_r);
		
		/*----------Pagination Part-2--------------*/
                     $rs=$dbObj->gj($tbl,$sf,$cnd,"","","","","");
                     $nums =@mysql_num_rows($rs);
                     $smarty -> assign("recordsFound",$nums);
                     $show = 20;
                     $total_pages = ceil($nums / $newsperpage);
               if($total_pages > 1)
                {
                     $smarty->assign("showpgnation","yes");
                     $showing   = !isset($_GET["page"]) ? 1 : $page;
	             $firstlink = "all_rating_view?deal_id=$deal_id";
                     $seperator = "&page=";
                     $baselink  = $firstlink;
                     $pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator,$nums);
                     $smarty-> assign("pagenation",$pagenation);		
		}
		//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(25);
$smarty->assign("row_meta",$call_meta);
		$smarty->display(TEMPLATEDIR . '/modules/rating/all_rating_view.tpl');


?>