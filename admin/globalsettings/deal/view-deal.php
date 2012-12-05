<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("8", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#


#-----------Delete Articles--------------#
if($_POST['action'])
{
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {

                              $sel= $dbObj->customqry("SELECT * FROM tbl_deal WHERE deal_unique_id IN (".$deal_ids.")","");
                            $munrs=mysql_num_rows($sel);
            if($munrs>0)
            {
               while($rest=mysql_fetch_assoc($sel))
               {
                  $imgcrop1="../../../uploads/product/thumb76X64/".$rest['samll_image'];
                  if($rest['samll_image']!="")
                  unlink($imgcrop1);

                  $imgcrop2="../../../uploads/product/thumb588X288/".$rest['big_image'];
                  if($rest['big_image']!="")
                  unlink($imgcrop2);

                  $imgcrop3="../../../uploads/product/thumb332X290/".$rest['medium_image'];
                  if($rest['medium_image']!="")
                  unlink($imgcrop3);
               }
            }

                  $_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
                  $temp = $dbObj->customqry("delete from tbl_deal where deal_unique_id IN (".$deal_ids.")","");
         }
         elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been Published </span>";
         }
         elseif($_POST['action'] == "inactive")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'no' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been Unpublished </span>";
         }
         elseif($_POST['action'] == "recommended")
         {
               $temp = $dbObj->customqry("update tbl_deal set recommend = '1' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been recommended deal </span>";
         }
	 elseif($_POST['action'] == "approve")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been approved successfully </span>";
         }
	 elseif($_POST['action'] == "disapprove")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'no' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been disapproved successfully </span>";
         }		
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }
   #--------------End-----------------------#


#-------reject------

	


#--approve----
/*if($_GET['id'])
	{
	$temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes', admin_review = '1' where deal_unique_id=".$_GET['id'], "");
	$_SESSION['msg']="<span class='success'>Deal approved successfully.</span>";	
	}	*/	


if($_POST['city']!="")
{
   $res_u = $dbObj->cgs("tbl_users","",array("city","usertypeid"),array($city,3),"first_name","","");
   $array1 = array();
   while($row_u = @mysql_fetch_assoc($res_u))
   {
      $array1[] = $row_u;
   }
   $smarty->assign("merchant",$array1);
}else
{
        $res_u = $dbObj->cgs("tbl_users","",array("usertypeid"),array("3"),"first_name asc","","");
   $array1 = array();
   while($row_u = @mysql_fetch_assoc($res_u))
   {
      $array1[] = $row_u;
   }
   $smarty->assign("merchant",$array1);

}
   //Merchant
   

   //city for user
   $res_c = $dbObj->cgs("tbl_users","city",array("userid"),array($_GET['userid']),"userid asc","","");
   $row_c = @mysql_fetch_assoc($res_c);
   $smarty->assign("merchantcity",$row_c['city']);

//country
   $res1 = $dbObj->cgs("mast_country","",array("status"),array("active"),"country asc","","");
   $array = array();
   while($row1 = @mysql_fetch_assoc($res1))
   {
      $array[] = $row1;
   }
   $smarty->assign("country",$array);
   extract($_POST);
   
//    if($_POST['country'])
//    {
//       $res2 = $dbObj->cgs("mast_city","city_name,city_id",'','',"","","");
//       while($row2 = @mysql_fetch_assoc($res2))  
//       {
//          $arr_city[] = $row2;
//       }
//       $smarty->assign("city_arr",$arr_city);
//    }

   #------------ Display All Citites ---------------#
//gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn)
   $cnd_city = "status='Active'";
   $rs_city = $dbObj->gj("mast_city", "*", $cnd_city, "city_name", "", "ASC", "", "");
   
   while($row_city = @mysql_fetch_assoc($rs_city))
   {
      $arr_city[]=$row_city;
   }
   //$num = @mysql_num_rows($rs_city);
   //echo $num;
   //print_r($arr_city);
   $smarty->assign("city_arr", $arr_city);
   #------------------------------------------------#

   #--------Pagination1-------------------------#
   $getpage=$_GET['page'];
   if(!isset($getpage))
      $page =1;
      else
      $page = $getpage;             
      $adsperpage =10;              
      $StartRow = $adsperpage * ($page-1);         
      $l =  $StartRow.','.$adsperpage;
   #----------------------------------------#
   
   #-------- Show Testimonails -------------------#
   
   
   //$tbl = "tbl_deal as p left Join tbl_users u on u.userid = p.seller_id";
   $tbl = "tbl_deal as p";
   $sf = "p.*";
   
   
   if($_POST['submit']) 
   {
                if($_POST['city']  && $_POST['merchant_id'])
      {
         $cnd = "p.admin_approve = 'no' and deal_status != 2 AND p.deal_city = '".$_POST['city']."' AND p.seller_id = '".$_POST['merchant_id']."'";
      }
      elseif($_POST['city'])
      {
         $cnd = "p.admin_approve = 'no' and deal_status != 2 AND p.deal_city = '".$_POST['city']."'";
      }
      elseif($_POST['merchant_id'])
      {
         $cnd = "p.admin_approve = 'no' and deal_status != 2 AND p.seller_id = '".$_POST['merchant_id']."'";
      }
      else
      {
         $cnd = "p.admin_approve = 'no'and deal_status != 2 ";
      }
   }
   elseif($_GET['userid'])
   {
      $cnd = "p.admin_approve = 'no' and deal_status != 2 AND p.seller_id = ".$_GET['userid'];
   }
   else
   {
      $cnd = "p.admin_approve = 'no' and deal_status != 2 ";
      //$cnd="1";
   }


   $res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $feed[] = $row;
//       if($feed[$i]['seller_id'] != 1)
//       {
         $sql_s = "Select u.first_name as s_firstname, u.last_name as s_lastname,u.username from tbl_users u where userid =".$feed[$i]['seller_id'];
         $res_s = $dbObj->customqry($sql_s,0);
         $row_s = @mysql_fetch_assoc($res_s);
         $feed[$i]['s_firstname'] = $row_s['s_firstname'];
         $feed[$i]['s_lastname'] = $row_s['s_lastname'];
         $feed[$i]['username'] = $row_s['username'];
      //}

	 $tbl_new = "tbl_quote_comment ";
   	$sf_new = "`read`";
	$cnd_new="`read`=0 and dealid=".$row['deal_unique_id'];
	$res_new = $dbObj->gj($tbl_new,$sf_new,$cnd_new,"","","","", "");

 	if($res_new!="n")
 	{
 	$feed[$i]['new']=1;
 	}
	else
	{
	$feed[$i]['new']=0;
	}

         $tbl_quote = "tbl_dealquate";
   	$sf_quote = "posted_date,admin_id";
	$cnd_quote="dealid=".$row['deal_unique_id'];
	$res_quote = $dbObj->gj($tbl_quote,$sf_quote,$cnd_quote,"","","","", "");
        $row_quote = @mysql_fetch_assoc($res_quote);
 	if($res_quote!="n")
 	{
 	$feed[$i]['quote_date']=$row_quote['posted_date'];
 	}
	else
	{
	$feed[$i]['quote_date']=0;
	}
        

        $quote_user_array = $dbObj->cgs("tbl_users","first_name,last_name","userid",$row_quote['admin_id'],"","","");
		$quote_user = @mysql_fetch_assoc($quote_user_array);

        if($quote_user_array!="n")
        {
        $feed[$i]['admin_name']=$quote_user['first_name']." ".$quote_user['last_name'];
        }
        else
        {
         $feed[$i]['admin_name']="Not Available";
        }
//         $j=0;
//          $tbl_new1 = "tbl_quote_comment ";
//    	$sf_new1 = "posted_date";
// 	$cnd_new1="`read`=0 and dealid=".$row['deal_unique_id'];
// 	$res_new1 = $dbObj->gj($tbl_new1,$sf_new1,$cnd_new1,"","","","", "");
//        while($row_new1=@mysql_fetch_assoc($res_new1))
//         {
// 
//            if($row_new1['posted_date'] < $row_quote['posted_date'])
//                 {
//                         $comment_flag=0;
//                 }
//         if($row_new1['posted_date'] > $row_quote['posted_date'])
//                 {
//                         $comment_flag=1;
//                 }         
// 
// 
//         $j++;
//         }
// 
//         if($comment_flag==0 )
//  	{
//  	$feed[$i]['quote_status']="Waiting for seller comment";
//  	}
// 	if($comment_flag==1 )
// 	{
// 	$feed[$i]['quote_status']="Seller comments received";
// 	}
//         if($comment_flag!=0 && $comment_flag!=1 )
//         {
//         $feed[$i]['quote_status']="----";
//         }
        




      $i++;
   }
//    echo "<pre>";
//    echo "<pre>";print_R($feed);exit;

   $smarty->assign("deal",$feed);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
   $res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($search)
      $firstlink = "view-deal.php?search=" . $_GET['search'];
   else
      $firstlink = "view-deal.php?";
   $seperator = '&page=';
   $baselink = $firstlink;
   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
   
   $smarty->assign("pgnation",$pgnation);
   
   #----------------------------------------#
   
    $autho_rs = $dbObj->gj("tbl_deal_autho","deal_id","1","","","","","");
    while($row = @mysql_fetch_assoc($autho_rs))
    {
        $autho[] = $row['deal_id'];
    }
    //echo "<pre>"; print_r($autho); echo "</pre>";
    $smarty->assign("autho",$autho);	


   #----------Success message=--------------#
   if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }
   #--------------End-----------------------#
   
   $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/view-deal.tpl'); 
    $dbObj->Close();
?>
