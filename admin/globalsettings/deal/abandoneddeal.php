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


#-----------Delete Articles--------------#
if($_POST['action'])
{
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {

                             

                  $_SESSION['msg']="<span class='success'>Record deleted successfully</span>";
                  $temp = $dbObj->customqry("delete from tbl_checkpayment where id IN (".$deal_ids.")","");
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
 


   $res = $dbObj->gj("tbl_checkpayment","","status='1'","paydate","","DESC",$l, "");
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
         $feed[] = $row;

         $sql_s = "Select u.first_name as s_firstname, u.last_name as s_lastname,u.username from tbl_users u where userid =".$feed[$i]['user_id'];
         $res_s = $dbObj->customqry($sql_s,0);
         $row_s = @mysql_fetch_assoc($res_s);
         $feed[$i]['s_firstname'] = $row_s['s_firstname'];
         $feed[$i]['s_lastname'] = $row_s['s_lastname'];
         $feed[$i]['username'] = $row_s['username'];
     

        $sql_s1 = "Select * from tbl_deal where deal_unique_id =".$feed[$i]['deal_id'];
         $res_s1 = $dbObj->customqry($sql_s1,0);
         $row_s1 = @mysql_fetch_assoc($res_s1);
         $feed[$i]['title'] = $row_s1['title'];



        

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




      $i++;
   }

   $smarty->assign("deal",$feed);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
   $res = $dbObj->gj("tbl_checkpayment","","1","paydate","","DESC","", "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($search)
      $firstlink = "abandoneddeal.php?search=" . $_GET['search'];
   else
      $firstlink = "abandoneddeal.php?";
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
   
   $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/abandoneddeal.tpl'); 
    $dbObj->Close();
?>
