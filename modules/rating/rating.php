<?php
include_once('../../include.php');


   $deal_idc=$_GET['deal_id']; 
   $deal_id=$dbObj->sanitize($deal_idc);
   $smarty->assign("deal_id",$deal_id);

if(!isset($_SESSION['csUserId']))
{	
	header("location:".SITEROOT."/all_rating_view?deal_id=".$deal_id);	
}
///////////Get the Deal_Name And Seller_Name start////////////////
                     $rs=$dbObj->cgs("tbl_deal","*","deal_unique_id",$deal_id,"","","");
                     $rec_dealid=@mysql_fetch_assoc($rs);
                     $deal_title=$rec_dealid['title'];
                     $deal_seller_name= getDealSellerFromId($rec_dealid['deal_unique_id']); //$rec_dealid['deal_from_seller_name'];
                     $big_image=$rec_dealid['big_image'];
                     $description=$rec_dealid['description'];
                     $smarty->assign("deal_title",$deal_title);
                     $smarty->assign("deal_seller_name",$deal_seller_name);
                     $smarty->assign("big_image",$big_image);
                     $smarty->assign("description",$description);
///////////Get the Deal_Name And Seller_Name end////////////////

                $querydealid = "select deal_unique_id from tbl_deal where deal_unique_id=".$_GET['deal_id'];
		$rsdealid = mysql_query($querydealid);
		$rec_dealid=@mysql_fetch_assoc($rsdealid);		
                $deal_id=$rec_dealid['deal_unique_id'];
		
		if($deal_id !='')
		{
		  $smarty->assign("deal_idexit",$deal_id);
		}else
		{
                    $deal_id='';		
                    $smarty->assign("deal_idexit",$deal_id);
		}
        if($deal_id)
        {
		$query = "select * from rating_question where status='active'";
		$rs = mysql_query($query);
		while($pageques=@mysql_fetch_assoc($rs))
		{
			$ques[]=$pageques;
		}
		$smarty->assign("ques",$ques);
        }
    //////////////Get total Review posted on specific deal////////////////
                                $pfileid = $_SESSION['csUserId'];
                                $tbl = "tbl_rating r JOIN tbl_users u ON r.user_id=u.userid";
                                $sf="r.*,u.fullname,u.username";
                                $cnd="r.deal_id='$deal_id' AND r.status=1";
                                $rs=$dbObj->gj($tbl,$sf,$cnd,"r.rating_id desc","","","","");
                
                                $totalreview=@mysql_num_rows($rs);
                                $rs=$dbObj->gj($tbl,$sf,$cnd,"r.rating_id desc","",""," 0,5 ","");
                                $pagereview=@mysql_num_rows($rs);
                                $smarty->assign("totalreview",$totalreview);
                                $smarty->assign("pagereview",$pagereview);
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
                                    $smarty->assign("profile_r",$results);
                                    $smarty->assign("subprofile_r",$subprofile_r);

/////////////////////Get the Deal Title By using Deal id///////////////	
                         $dealsql = "select * from tbl_deal where deal_unique_id = ".$deal_id;
                         $dealrow = mysql_query($dealsql);
                         $dealrec=@mysql_fetch_assoc($dealrow);
                         $deal_title=$dealrec['title'];
//////////////////////////////////////insert rating deals /////////////////////
if($_POST['Submit'])
{
                    			$f_array = array(	
							"user_id" => $pfileid,
							"deal_id" => $deal_id, 
							"feedback" => $_POST['feedback'],
							"rating_date" => date("Y-m-d H:i:s"),							
							"deal_title" =>$deal_title, 
							"feedback_title" => $_POST['feedback_title'],
							"status"=>'1'
							);
                                                $insertedId = $dbObj->cgii("tbl_rating",$f_array,"");
                                                $reatingId = mysql_insert_id();
						foreach ($_POST as $key => $value)
						{ 
							if (is_numeric ($key))
							{
                                                            $queryratque = "select * from rating_question where status='active' and id = ".$key;
                                                            $rsratque = mysql_query($queryratque);
                                                            $rating_que = "";
                                                            if($rowratque=@mysql_fetch_assoc($rsratque))
                                                            {
                                                                    $rating_que = $rowratque['rating_question'];
                                                            }
                                                            if($value>0)
                                                            {
                                                                    $qfact = mysql_query("select * from rating_question where id=".$key);
                                                                    $fact=@mysql_fetch_assoc($qfact);
                                                                    $ret_array = array(
                                                                                        "rating_id" => $reatingId,
                                                                                        "question_id" => $key,
                                                                                        "rating_question" => $rating_que,
                                                                                        "rating_mark " => $value
                                                                                        );
                                                                    $insertedId = $dbObj->cgii("tbl_detailed_rating",$ret_array,"");//exit;
                                                            }
							}
						}
						$testsql = "Select avg(rating_mark) as retavg from tbl_detailed_rating where rating_id=".$reatingId;
						$sql =mysql_query($testsql);
						$pagecon=@mysql_fetch_assoc($sql);
						$ne = $pagecon['retavg'];
						$dbObj->cupdt("tbl_rating", array("average_rating"),array(round($ne)), "rating_id", $reatingId,"");
                                                $_SESSION['msg']="Deals Rated Successfully"; 
                                                header("location:".SITEROOT . "/rating?deal_id=".$deal_id);
                                                exit;
}
//Get meta tags of the page as per id
$call_meta=$dbObj->meta_SEO(25);
$smarty->assign("row_meta",$call_meta);


if(isset($_SESSION['msg'])){
   $smarty->assign("msg", $_SESSION['msg']);
   unset($_SESSION['msg']);
}
            $smarty->display(TEMPLATEDIR . '/modules/rating/rating.tpl');
?>