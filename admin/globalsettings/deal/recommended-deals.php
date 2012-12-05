<?php
//ini_set("session.save_path", "/home/usortd/tmp");
session_start();
include_once("../../../includes/paging.php");
include_once('../../../includes/SiteSetting.php');
include_once('../../../includes/class.message.php');

if(!$_SESSION['duAdmId'])
  header("location:".SITEROOT . "/admin/login/index.php");

if($_GET['slider'])
{

	//@mysql_query("update tbl_slider set slider=".$_GET['slider']." where id='1'");
   $dbres = $dbObj->cupdt('tbl_slider', "slider" , $_GET['slider'] ,'id',"2","");
header("location:".SITEROOT."/admin/globalsettings/deal/recommended-deals.php");
 exit;


}

   $res_slid = $dbObj->cgs("tbl_slider","slider","id","2","","","");
   $row_slid = @mysql_fetch_assoc($res_slid );
   $smarty->assign("slid",$row_slid['slider']);
#------------Check For access----------#
if(!(in_array("39", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

extract($_POST);

extract($_GET);

if($_POST['submit']=='update')
{

//print_r($_POST);exit;
$cd = "recommend ='1'";
$dbres = $dbObj->gj('tbl_deal', "*" , $cd, "", "","", "", "");	
	
	while($row_results = @mysql_fetch_assoc($dbres))
	{
	@mysql_query("update tbl_deal set sizeorder2=".$_POST[$row_results['deal_unique_id']]." where deal_unique_id=".$row_results['deal_unique_id'] );
	//$dbres = $dbObj->cupdt('tbl_product_property', "sizeorder" , $_POST[$row_results['property_id']] ,'property_id',$row_results['property_id'],"0");
	}

}






#--------Action-----------#


#---------END-------------#

  #--------Pagination1-------------------------#
   $getpage=$_GET['page'];
   if(!isset($getpage))
      $page =1;
      else
      $page = $getpage;             
      $adsperpage =10;              
      $StartRow = $adsperpage * ($page-1);         
   //   $l =  $StartRow.','.$adsperpage;
   #----------------------------------------#
   
   #-------- Show Testimonails -------------------#
   
   


$date = date("Y-m-d H:i:s");	

   //$tbl = "tbl_deal as p left Join tbl_users u on u.userid = p.seller_id";
   $tbl = "tbl_deal as p";
   $sf = "p.*";
   $cnd = "p.admin_approve = 'yes' and admin_review = '1' and deal_status = '1' and (start_date <= '$date' and end_date >= '$date') and recommend ='1'";



   $res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $feed[] = $row;
      $feed[$i]['end_date']=date("F j, Y, g:i a",strtotime($row['end_date']));
      $feed[$i]['start_date']=date("F j, Y, g:i a",strtotime($row['start_date']));			

         $sql_s = "Select u.first_name as s_firstname, u.last_name as s_lastname from tbl_users u where userid =".$feed[$i]['seller_id'];
         $res_s = $dbObj->customqry($sql_s,0);
         $row_s = @mysql_fetch_assoc($res_s);
         $feed[$i]['s_firstname'] = $row_s['s_firstname'];
         $feed[$i]['s_lastname'] = $row_s['s_lastname'];
     
      $i++;
   }
//    echo "<pre>";
//    echo "<pre>";print_R($feed);exit;

   $smarty->assign("deal",$feed);

$smarty->assign("inmenu","sitemodules");
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/recommended-deals.tpl');

$dbObj->Close();
?>