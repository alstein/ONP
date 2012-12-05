<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');

if((!$_SESSION['duAdmId']) || $_SESSION['duUserTypeId'] != 3)
{
	$_SESSION['type'] = 'seller';
	header("location:". SITEROOT . "/signin");
}

/////////////////////////////////////////////
//START 
//this file is added for checking the subscription is expired or subscribed of seller
include_once(ABSPATH.'/admin/seller/check_seller_subscription.php');
//this file is added for checking the subscription is expired or subscribed of seller
//END
/////////////////////////////////////////////

	if($_GET['id'] !='')
	{
		$sel1= $dbObj->customqry("SELECT * FROM tbl_deal WHERE deal_unique_id IN (".$_GET['id'].")","");//exit;
		$id1=array();
		if($sel !='n')
		{
			if($_GET['agree']=='yes')
			{
				$temp1 = $dbObj->customqry("update tbl_deal set featured = '0' where deal_unique_id IN (".$_GET['id'].")","");//exit;
				$_SESSION['msg']="<span class='success'>Deal has been unset featured deal </span>";
				header("Location:".SITEROOT."/admin/seller/deal/pending-deal.php");
				exit;
			}
			while($rest1=@mysql_fetch_assoc($sel1))
			{

				//Start
				//new work
				//I should not be able to set two deals as featured for the same category i.e. "Daily Deals"
				if($_GET['typid'] != '')
				{
					$setOthUnFeat = $dbObj->customqry("update tbl_deal set featured = '0' where deal_main_type='".$_GET['typid']."'","");
				}
				//End

				$sel2= $dbObj->customqry("SELECT * FROM tbl_deal WHERE featured ='1'","");//exit;
				$munrs2=@mysql_num_rows($sel2);
				$smarty->assign("number",$munrs2);
				if($rest1['featured']==0)
				{
					$temp1 = $dbObj->customqry("update tbl_deal set featured = '1' where deal_unique_id IN (".$_GET['id'].")","");//exit;
							$_SESSION['msg']="<span class='success'>Deal has been set featured deal </span>";
					header("Location:".SITEROOT."/admin/seller/deal/pending-deal.php");
					exit;
				}
				else
				{
					$temp1 = $dbObj->customqry("update tbl_deal set featured = '0' where deal_unique_id IN (".$_GET['id'].")","");//exit;
							$_SESSION['msg']="<span class='success'>Deal has been unset featured deal </span>";
					header("Location:".SITEROOT."/admin/seller/deal/pending-deal.php");
					exit;
				}
			}
		}
	}


   if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
	//print_r($_POST);exit;
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
				@unlink($imgcrop1);
		
				$imgcrop2="../../../uploads/product/thumb588X288/".$rest['big_image'];
				if($rest['big_image']!="")
				@unlink($imgcrop2);
		
				$imgcrop3="../../../uploads/product/thumb332X290/".$rest['medium_image'];
				if($rest['medium_image']!="")
				@unlink($imgcrop3);
			}
		}
		
		//delete all deal cities from reference table
		$delDlCities = $dbObj->customqry("delete from tbl_deal_city where deal_id IN (".$deal_ids.")","");

                  $_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";
                  $temp = $dbObj->customqry("delete from tbl_deal where deal_unique_id IN (".$deal_ids.")","");
         }
         if($_POST['action'] == "Unrecommended")
         {
               $temp = $dbObj->customqry("update tbl_deal set recommend = '0' where deal_unique_id IN (".$deal_ids.")","");//exit;
               $_SESSION['msg']="<span class='success'>Deal has been Unrecommended deal </span>";
         }
         elseif($_POST['action'] == "recommended")
         {
               $temp = $dbObj->customqry("update tbl_deal set recommend = '1' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal has been recommended deal </span>";
         }
         if($_POST['action'] == "approve")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes', deal_status = '1' where deal_unique_id IN (".$deal_ids.")","");//exit;
               $_SESSION['msg']="<span class='success'>Deal has been approved deal </span>";
	       header("Location:".SITEROOT."/admin/seller/deal/manage_deal.php");
	       exit;
         }
         if($_POST['action'] == "reject")
         {
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'yes', deal_status = '2', reject_by_id = '".$_SESSION['duAdmId']."' where deal_unique_id IN (".$deal_ids.")","");//exit;
               $_SESSION['msg']="<span class='success'>Deal has been rejected deal </span>";
	       header("Location:".SITEROOT."/admin/seller/deal/rejected-deals.php");
	       exit;
         }
      }
      else
      {
         $_SESSION["msg"] = "<span class='success'>Please select atleast one record.</span>";
      }
      header("location:".$_SERVER['HTTP_REFERER']);
      exit;
   }

	


function get_user_from_id($usr_id)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "userid={$usr_id}", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}

function get_user_from_email($usr_emailid)
{
	$dbObj = new DBTransact();
	$users_rs = $dbObj->gj("tbl_users as u", "username, first_name, last_name, email, city" , "email='{$usr_emailid}'", "", "", "", "", "");
	$users_row = @mysql_fetch_assoc($users_rs);

return $users_row;
}




/* ----------------------------------------------------------------------------------- */
#-----------------Get Deal Types--------------------#
$_reDlType = $dbObj->cgs("tbl_dealtype","","","","dealtype","ASC","");
$num = @mysql_num_rows($_reDlType);
$dltype_arr = array();
$i = 0;
$defDlTypeId = "0";
while($_row = @mysql_fetch_assoc($_reDlType))
{
	if($i == 0)
	{
		$defDlTypeId = $_row['typeid'];
	}
	$dltype_arr[] = $_row;
	$i++;
}
$smarty->assign("dltypes",$dltype_arr);
#-----------------Get Deal Types--------------------#

#-----------------Get sellar  Types--------------------#

$sql="SELECT  DISTINCT deal_from_seller_name FROM tbl_deal WHERE deal_from_seller_name IS NOT NULL AND deal_from_seller_name != ''";
$_reDlType=mysql_query($sql)or die(mysql_error());
$num = @mysql_num_rows($_reDlType);
$dltype_arr = array();
$i = 0;
$defDlTypeId = "0";
while($_row = @mysql_fetch_assoc($_reDlType))
{
	if($i == 0)
	{
		$defDlTypeId = $_row['seller_id'];
	}
	$dltype_arr[] = $_row;
	$i++;
}
$smarty->assign("deal_from_seller_names",$dltype_arr);
#-----------------Get Deal Types--------------------#



/*-----------------------Pagination Part1--------------------*/
$page=$_GET['page'];

if(!isset($_GET['page']))
    $page =1;
else
    $page = $page;                        

$newsperpage =20;                            
$StartRow = $newsperpage * ($page-1);            
$l =  $StartRow.','.$newsperpage;
/*-----------------------End Part1--------------------*/
$date = date("Y-m-d H:i:s");
   $tbl = "tbl_deal as p , tbl_users as tu, tbl_dealtype dt";
   $sf = "p.*";
	
      //$cnd = "p.admin_approve = 'yes' and p.admin_review = '1' and deal_status = '1' and (start_date > '$date')";
      $cnd = "p.admin_approve = 'no' and p.admin_review = '1' and deal_status = '1' and admin_userid = ".$_SESSION['duAdmId']." ";
      //$cnd="1";
  // }
  if($_GET['dltype'])
{
 $get_dlType = (($_GET['dltype']) ? $_GET['dltype'] : "");
   if($get_dlType)
   {
	if($get_dlType != 'all')
		$cnd .= "and p.deal_main_type ='".$get_dlType."'";
   }else
   {
	if($defDlTypeId > 0)
	{
		$cnd .= "and p.deal_main_type ='".$defDlTypeId."'";
	}
   }
}
if($_GET['deal_from_seller_name']){

   $getdeal_from_seller_name = (($_GET['deal_from_seller_name']) ? $_GET['deal_from_seller_name'] : "");
   if($getdeal_from_seller_name)
   {
	if($getdeal_from_seller_name != 'all')
		$cnd .= "and p.deal_from_seller_name ='".$getdeal_from_seller_name."'";
   }else
   {
	if($defDlTypeId > 0)
	{
		$cnd .= "and p.deal_from_seller_name ='".$defDlTypeId."'";
	}
   }

}


if(isset($_GET['search']))
{
	$cnd .= " AND (p.title LIKE '%".$_GET['search']."%' OR tu.first_name LIKE '%".$_GET['search']."%' OR tu.last_name LIKE '%".$_GET['search']."%' OR tu.fullname LIKE '%".$_GET['search']."%' OR dt.dealtype LIKE '%".$_GET['search']."%' OR p.groupbuy_price LIKE '%".$_GET['search']."%' OR p.orignal_price LIKE '%".$_GET['search']."%' OR p.deal_from_seller_name_other LIKE '%".$_GET['search']."%')";
}

//    $res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");

   $res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC LIMIT ".$l, "");


   $i=0;
   while($row = @mysql_fetch_assoc($res))
   {
      $feed[] = $row;

		$feed[$i]['end_date']=date(DATE_FORMAT." H:i:s",strtotime($row['end_date']));
		$feed[$i]['start_date']=date(DATE_FORMAT." H:i:s",strtotime($row['start_date']));

		if($row['deal_currency'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($row['deal_currency'] == 'pound') ? '&#163; ' : '$ ');

		$feed[$i]['deal_currency_type'] = $curr_type;

        $sql_s = "Select u.first_name as s_firstname, u.last_name as s_lastname from tbl_users u where userid =".$feed[$i]['seller_id'];
         $res_s = $dbObj->customqry($sql_s,0);
         $row_s = @mysql_fetch_assoc($res_s);
         $feed[$i]['s_firstname'] = $row_s['s_firstname'];
         $feed[$i]['s_lastname'] = $row_s['s_lastname'];
        
        if($row['admin_userid'] != 0 )
        {

         $sql_ad = "Select u.first_name as ad_firstname, u.last_name as ad_lastname,username from tbl_users u where userid =".$row['admin_userid'];
         $res_ad = $dbObj->customqry($sql_ad,0);
         $row_ad = @mysql_fetch_assoc($res_ad);
         $feed[$i]['ad_name'] = $row_ad['ad_firstname']." ".$row_ad['ad_lastname'];
          
        }
        
        	  /*//get seller user first_name and last_name as per selected seller id*/
	if(($row['deal_from_seller_name'] != "") && ($row['deal_from_seller_name'] != "other_seller") && ($row['deal_from_seller_name'] > 0))
	{
		$sellerData = getDataFromTable('tbl_users',"userid, fullname, first_name, last_name","userid = '".$row['deal_from_seller_name']."'");
		$seller_name = $sellerData['first_name']." ".$sellerData['last_name'];
	}else
	{
		$seller_name = $row['deal_from_seller_name_other'];
	}
        $feed[$i]['deal_from_seller_name']=$seller_name;

        
	
	//get city name through city id
         /*$sql_city = "Select c.* from mast_city c where city_id =".$row['deal_city'];
         $res_city = $dbObj->customqry($sql_city,0);
         $row_city = @mysql_fetch_assoc($res_city);
         $feed[$i]['city_name'] = $row_city['city_name'];*/

	
	 ///////////////////////////////////////////
         //START Get multiple cities as per product id
	 $feed[$i]['city_name'] = $dbObj->getDealMultiCities($row['deal_unique_id']);
         //END Get multiple cities as per product id

	
         $feed[$i]['deal_main_type_id'] = $row['deal_main_type'];

	//get deal main type name through deal_main_type
         $sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$row['deal_main_type'];
         $res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
         $row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
         $feed[$i]['deal_main_type'] = $row_dlMainType['dealtype'];


      $i++;
   }
//    echo "<pre>";
//    echo "<pre>";print_R($feed);exit;

   $smarty->assign("deal",$feed);

// /*-----------------------Pagination Part2--------------------*/
//  $rs = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC","", "");
 $rs = $dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC", "");

 $nums =@mysql_num_rows($rs);
 $smarty -> assign("recordsFound",$nums);
$show = 10;        
$total_pages = ceil($nums / $newsperpage);
if($total_pages > 1)
    $smarty -> assign("showpgnation","yes");

$showing   = !isset($_GET["page"]) ? 1 : $page;
// $firstlink = basename($_SERVER['PHP_SELF']) . "?prod_deal_id=".$_GET['prod_deal_id'];
// $seperator = '&page=';
// $baselink  = $firstlink; 
if($search)
      $firstlink = "pending-deal.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "pending-deal.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
   $seperator = '&page=';
   $baselink = $firstlink;
$pagenation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
$smarty -> assign("pagenation",$pagenation);
/*-----------------------End Part2--------------------*/

if($_SESSION['duUserTypeId'] == 1)
{

  $res2 = $dbObj->cgs("mast_city","*","","","city_name","","");
		while($row2 = @mysql_fetch_assoc($res2))	
		{
			$arr_city[] = $row2;
		}
	$smarty->assign("city_arr",$arr_city);

}
else
{
   if($admin_perm_city != "")
      {
   
         $res2 = $dbObj->gj("mast_city", "city_name,city_id", "city_id in ({$admin_perm_city})", "city_name", "", "", "", "");
      
         if($res2 != "n")
         {
         while($row2 = @mysql_fetch_assoc($res2))	
         {
            $arr_city[] = $row2;
         }
         $smarty->assign("city_arr",$arr_city);
         }
      }
}
  if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }

  #----------------------------------------#
   
    $autho_rs = $dbObj->gj("tbl_deal_autho","deal_id","1","","","","","");
    while($row = @mysql_fetch_assoc($autho_rs))
    {
        $autho[] = $row['deal_id'];
    }
    //echo "<pre>"; print_r($autho); echo "</pre>";
    $smarty->assign("autho",$autho);	


   #----------Success message=--------------#

$smarty->assign("inmenu","deal_management");
$smarty->display(TEMPLATEDIR . '/admin/seller/deal/pending_purchases.tpl');

$dbObj->Close();
?>