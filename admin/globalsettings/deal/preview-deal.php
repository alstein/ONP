<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
ob_start();
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');
include_once('../../../includes/classes/class.forum.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

// #------------Check For access----------#
// if(!(in_array("8", $arr_modules_permit)))
// {
//       unset($_SESSION['duAdmId']);
//       $s=$msobj->showmessage(166);
//       $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
// 
//       header("location:".SITEROOT . "/admin/login/index.php");
//       exit;
// }
// #----------End Check For access----------#


$_SESSION['deal_type'] = "service";




        $user_array=$dbObj->cgs("tbl_users","pic_image","userid",$_SESSION['duAdmId'],"","","");
	$user=@mysql_fetch_assoc($user_array);


        $deal_array=$dbObj->cgs("tbl_deal","*","deal_unique_id",$_GET['id'],"","","");
	$deal=@mysql_fetch_assoc($deal_array);
        $sql_feed = "select avg(total) as total  from tbl_feedback_review where seller_id = ".$deal['seller_id']." group by seller_id";
			$qry_feed = @mysql_query($sql_feed);
			$arr_feed = @mysql_fetch_assoc($qry_feed);
                     $avg=$arr_feed["total"];
                        $avg=round($avg);   
                    if($avg>=80)
                    {
                        $color="green";
                    }
                    else
                    if($avg>=60 && $avg<=79)
                    {
                        $color="orange";
                    }else
                     if($avg<60)    
                    {
                        $color="white";
                    }
                    $smarty->assign("color",$color);
                #--------end--------------#

	$dealImages = explode(",",$deal['big_image']);
	$smarty->assign("dealImages",$dealImages);
	$deaImg = count($dealImages);

	$sql_s = "Select u.username,u.usertypeid, u.first_name as s_firstname, u.last_name as s_lastname, city as s_city, address1 as s_address1 from tbl_users u where userid =".$deal['seller_id'];
			$res_s = $dbObj->customqry($sql_s,0);
			$row_s = @mysql_fetch_assoc($res_s);
			$seller_fname = $row_s['s_firstname'];
			$seller_lname = $row_s['s_lastname'];
			$seller_city = $row_s['s_city'];
			$seller_address = $row_s['s_address1'];
			$seller_type = $row_s['usertypeid'];
			$username = $row_s['username'];
		$sql_contri2 = "select sum(deal_quantity) as sum_contribute from tbl_deal_payment where deal_id = ".$deal['deal_unique_id']." group by deal_id";
 		$qry_contri2 = @mysql_query($sql_contri2);
 		$arr_contri2 = @mysql_fetch_assoc($qry_contri2);
		$test=$arr_contri2['sum_contribute']+$deal['fake_user'];
		if($test >= $deal['max_buyer'])
                {  
                $test2=$test-$arr_contri2['sum_contribute'];
                $total_contribution2=$test-$test2;
                }
                else
                {
		$total_contribution2=$arr_contri2['sum_contribute']+$deal['fake_user'];
                }
		if($total_contribution2 >= $deal['min_buyer'])
		{
		   $smarty->assign("total_buy","1"); 	
		} 
		 if($total_contribution2 >= $deal['max_buyer'])
		{		
       			$smarty->assign("deal_flag","2");
		}
		$deal['bought1']=$total_contribution2;
		$orignal_bucket_value2=$deal['max_buyer'];
		$complete2=($total_contribution2/$orignal_bucket_value2)*100;
		$total2=(100*$deal['min_buyer'])/$deal['max_buyer'];
		//$leftside=($total/100);
		$deal['progress']=@round($complete2);

		$prog2 = ($deal['progress']/100)*286;
		$left2 = ($total2/100)*286;
		$proleft2 = $left2-8;
		$deal['min_bar']=$proleft2;
		$deal['proleft3']=$left2;
		$deal['proleft2']=$prog2;
		$pwidth2 = ($deal['progress2']/100)*286;
		$prowidth2 = 0+$pwidth1;
		$deal['prowidth2']=$prowidth2;
		//// Google map code
		$a=explode(",",$deal['option_selected']);
		if($a)
		{
			
			 if(in_array("7", $a) && $deal['shop_location']!='')
			 {
			 	$deal['googlemap']="yes";
				// $coordinates = strip_tags(getLATIANDLONG($deal['shop_location'].",".$deal['deal_city']));
			 }
		}
		// Video
		if(trim($deal['vedio_link']))
		$deal['video']="<a href='".$deal['vedio_link']."' target='_blank'>".trim($deal['vedio_link'])."</a>";
		if(stristr(trim($deal['vedio_link']),"www.youtube.com/watch"))
		{
			$v= explode("v=",trim($deal['vedio_link']));
			if($v[1])
				$deal['video']='<object width="279" height="238"><param name="movie" value="http://www.youtube.com/v/'.$v[1].'?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$v[1].'?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="279" height="238"></embed></object>';

		}

	#-----insert forum----#
	$wf = array("f.categoryid","f.deal_id");
	$wv = array(1,$deal['deal_unique_id']);
	$forum = array();
	$rs = $dbObj->cgs("tbl_forum f", "f.forumid", $wf, $wv, "", "", "");
	if($rs != "n")
	{
	    $row=@mysql_fetch_assoc($rs);
	    $forumid= $row['forumid'];
	    $smarty->assign("forums", $row);
	}
	else
	{
	    $fl = array("categoryid", "title", "description", "userid","deal_id","posted_date","status");
	    $vl = array(1, trim($deal['title']),$deal['description'],1,$deal['deal_unique_id'], date("Y-m-d H:i:s"),"Active");
	    $id = $dbObj->cgi('tbl_forum' , $fl , $vl , "");
	    $forumid= $id;
	}
	$smarty->assign("forumid",$forumid);
	#--------end----------#            
	
		
	$smarty->assign("username",$username );
	$smarty->assign("seller_type",$seller_type);
	$smarty->assign("seller_fname",$seller_fname);
	$smarty->assign("seller_lname",$seller_lname);	
	$smarty->assign("coordinates",$coordinates);
	$smarty->assign("seller_city",$seller_city);
	$smarty->assign("seller_address",$seller_address);	
	$smarty->assign("deal",$deal);
	
//         $count_from = date("Y-m-d H:i:s");
// 	$datefrom = strtotime($count_from, 0);
// 	$dateto = strtotime($deal['start_date'], 0);
// 
// 	$datediff = date("z", $dateto) - date("z", $datefrom);
// 	$smarty->assign("days",floor($difference / 86400));//days
// 	$smarty->assign("hrs",floor($difference / 3600));//hr
// 	$smarty->assign("min",floor($difference / 60));//min
// 	$smarty->assign("sec",floor($difference));//sec

#---------------Get category list----------------#
$date=date("Y-m-d H:i:s",strtotime("+3 hours"));
$cnd_test="(start_date <='$date' AND end_date >= '$date') AND d.featured = 1 AND d.seller_id=u.userid and d.admin_approve ='yes' and d.deal_status= 1";
$actv_deal_cat=$dbObj->gj("tbl_deal as d LEFT JOIN tbl_users as u ON d.seller_id=u.userid","d.deal_cat",$cnd_test,"","","","","");
if($actv_deal_cat!='n')
{
    while($actv_deal_id=mysql_fetch_assoc($actv_deal_cat))
        $actv_deal[]=$actv_deal_id['deal_cat'];

    $dealId = implode(",",$actv_deal);

    $rs_cat = $dbObj->gj("mast_deal_category as c","c.category,c.id","c.id IN ({$dealId})","c.category","","", "", "");
    if($rs_cat!='n')
    {
	$i=0;
	$category=array();	
	while($row_cat=@mysql_fetch_assoc($rs_cat))
	{	
	    $category[$i]['category']=$row_cat['category'];
	    $category[$i]['id']=$row_cat['id'];	
	    $i++;
	}
	$smarty->assign("category_list",$category);	
    }
 }
#---------------End category list-------------#
#--------------Get footer Page --------------#
    #1]. Get Page Category-
    $rs_pg = $dbObj->gj("tbl_page_category", "id,title", "id!=5 and status = 'Active'","", "", "","","");
    if($rs_pg != "n")
    {
          $i=0;
          $page_cat = array();

          #2]. get a;; pages of corresponding pg category
          while($rs_page=@mysql_fetch_assoc($rs_pg))
	  {
       	      $page_cat[$i]['categoty'] = $rs_page['title'];
	      $page_cat[$i]['categoty_url']= str_replace(" ","-",strtolower($rs_page['title']));

 	      $rs_p = $dbObj->gj("tbl_pages", "title", "page_cat ='{$rs_page[id]}' and status = 'Active'","title", "", "", "","");
	      if($rs_p != 'n')
	      {
		  $j=0;$kl=0;
		  while($r=@mysql_fetch_assoc($rs_p))
		  { 
		      $page_cat[$i]['subpage'][$j]['page'] = $r['title'];
		      $page_cat[$i]['subpage'][$j]['page_url'] = str_replace(" ","-",strtolower($r['title']));
		      $j++;
		  }
              }
              $i++;
          }
      $page_cat['totpgs']=($i - 1);
      $smarty->assign("page_cat", $page_cat);
    }

#--------------End footer Page --------------#

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/preview-deal.tpl'); 
$dbObj->Close();
?>
