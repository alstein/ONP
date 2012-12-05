<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

#------------Check For access----------#
if(!(in_array("16", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#

if(isset($_POST['submit']))
{
	if($_POST['action'] == "" || !isset($_POST['action']))
        {
		$s=$msobj->showmessage(4);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	if(count($_POST['dealid']) == 0 || (!isset($_POST['dealid'])))
        {	
		$s=$msobj->showmessage(5);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}

	extract($_POST);
	$dealid = implode(", ", $dealid);	
	if($action == "delete")
	{
		$sel= $dbObj->customqry("SELECT * FROM tbl_deal WHERE deal_unique_id IN (".$dealid.")","");
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
		$delDlCities = $dbObj->customqry("delete from tbl_deal_city where deal_id IN (".$dealid.")","");

		$id = $dbObj->customqry("delete from tbl_deal where deal_unique_id  in (".$dealid.")","");
		$s=$msobj->showmessage(163);
		$_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";
	}
	if($action == "restore")
	{
               $temp = $dbObj->customqry("update tbl_deal set admin_approve = 'no', admin_review = '1', deal_status = '1', reject_by_id = '0' where deal_unique_id IN (".$dealid.")","");
               $_SESSION['msg']="<span class='success'>Deal has been restored successfully </span>";
	}
	header("location:".$_SERVER['HTTP_REFERER']);
	exit;
}

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

// $sql="SELECT  DISTINCT deal_from_seller_name FROM tbl_deal WHERE  deal_from_seller_name != '' and deal_from_seller_name!='other_seller'";
// 
// $_reDlType=mysql_query($sql)or die(mysql_error());
// $num = @mysql_num_rows($_reDlType);
// $dltype_arr = array();
// $i = 0;
// $defDlTypeId = "0";
// while($_row = @mysql_fetch_assoc($_reDlType))
// {
// 	if($i == 0)
// 	{
// 		$defDlTypeId = $_row['seller_id'];
// 	}
// 
// 	if(intval($_row['deal_from_seller_name']))
// 	{
// 		$sellerData = getDataFromTable('tbl_users',"userid, fullname, first_name, last_name","userid = '".$_row['deal_from_seller_name']."'");
// 		$seller_name = $sellerData['first_name']." ".$sellerData['last_name'];
// 		$seller_value = $_row['deal_from_seller_name'];
// 	}else
// 	{
// 		$seller_name = $_row['deal_from_seller_name_other'];
// 		$seller_value = $_row['deal_from_seller_name_other'];
// 	}
// 
// 	$dltype_arr[$i]['name'] = $seller_name;
// 	$dltype_arr[$i]['value'] = $seller_value;
// 	$i++;
// }
// $smarty->assign("deal_from_seller_names",$dltype_arr);

$res_sellerDet = $dbObj->cgs("tbl_users","userid, fullname, first_name, last_name, email",array("isDeleted","usertypeid"),array(0,3),"first_name","ASC","");
$num_seller = @mysql_num_rows($res_sellerDet);
$row_sellerDet = array();
while($row = @mysql_fetch_assoc($res_sellerDet))
{
	$row_sellerDet[] = $row;
}
$smarty->assign("deal_from_seller_names",$row_sellerDet);
#-----------------Get seller Types--------------------#


#------------Pagination Part-1-----------#
if(!isset($_GET['page']))
    $page =1;
else
    $page = $_GET['page'];

$adsperpage = 20;
$StartRow = $adsperpage * ($page-1);
$l =  ($StartRow).','.$adsperpage;
#--------------------------------------#

//    $tbl="tbl_deal as d,tbl_users as u, tbl_dealtype dt";
$tbl="tbl_deal as p,tbl_users as tu";
$cnd = "p.deal_status = '2' and admin_approve = 'yes'";
// if($_GET['dltype'])
// {
//     $dltype=$_GET['dltype'];
// }else{
// 
// $dltype=$_GET['deal_from_seller_name'];
// 
// }
// $tbl = "tbl_deal as p, tbl_users as tu, tbl_dealtype dt ";

//  $sf = "p.*";


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

if($_GET['deal_from_seller_name'])
{
	$getdeal_from_seller_name = (($_GET['deal_from_seller_name']) ? $_GET['deal_from_seller_name'] : 0);
	if($getdeal_from_seller_name)
	{
		if($getdeal_from_seller_name != 'all')
		{
			if(intval($getdeal_from_seller_name))
			{
				$cnd .= "and p.deal_from_seller_name ='".$getdeal_from_seller_name."'";
			}else
			{
				$cnd .= "and p.deal_from_seller_name_other ='".$getdeal_from_seller_name."'";
			}
		}
	}
}
//    $tbl = "tbl_deal as p, tbl_users as tu, tbl_dealtype dt ";
//     $sf = "p.*";
// 

if(isset($_GET['search']))
{
	$cnd .= " AND (p.title LIKE '%".$_GET['search']."%' OR tu.first_name LIKE '%".$_GET['search']."%' OR tu.last_name LIKE '%".$_GET['search']."%' OR tu.fullname LIKE '%".$_GET['search']."%' OR p.groupbuy_price LIKE '%".$_GET['search']."%' OR p.orignal_price LIKE '%".$_GET['search']."%' )";
}


if($_GET['uname'] !='')
{
	$cnd1 = "username  = '{$_GET['uname']}'";
	$tbl1= "tbl_users";
	$sf1="userid";
	$rs_userid = $dbObj->gj($tbl1,$sf1,$cnd1, "", "", "", "", "");
	if( $rs_userid !='n')
	    $rs_name = @mysql_fetch_assoc($rs_userid);

	
}

 
		$arr = $dbObj->customqry("SELECT p.*,tu.username, tu.first_name, tu.last_name, tu.fullname FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid  WHERE ".$cnd." ORDER BY deal_unique_id DESC LIMIT ".$l, "");



$i=0;
if($arr !='n')
{
	while($deal=@mysql_fetch_assoc($arr))
	{
		$deal_ar[]=$deal;

		$deal_ar[$i]['end_date']=date(DATE_FORMAT." H:i:s",strtotime($deal['end_date']));
		$deal_ar[$i]['start_date']=date(DATE_FORMAT." H:i:s",strtotime($deal['start_date']));

		if($row['deal_currency'] == 'euro')
			$curr_type = '&#8364;';
		else
			$curr_type = (($row['deal_currency'] == 'pound') ? '&#163; ' : '$ ');

		$deal_ar[$i]['deal_currency_type'] = $curr_type;


		$rejected_name = $dbObj->cgs("tbl_users","first_name,last_name","userid",$deal['reject_by_id'],"","","");
		$name = @mysql_fetch_assoc($rejected_name);

		if($rejected_name!="n")
		{
		$deal_ar[$i]['rejected_name']=$name['first_name']." ".$name['last_name'];
		}
		else
		{
		$deal_ar[$i]['rejected_name']="Not Available";
		}

		if($deal['admin_userid'] != 0 )
		{
			$sql_ad = "Select u.usertypeid, u.first_name as ad_firstname, u.last_name as ad_lastname,username from tbl_users u where userid =".$deal['admin_userid'];
			$res_ad = $dbObj->customqry($sql_ad,0);
			$row_ad = @mysql_fetch_assoc($res_ad);
			$deal_ar[$i]['ad_name'] = $row_ad['ad_firstname']." ".$row_ad['ad_lastname'];
		
			$deal_ar[$i]['userType'] = (($row_ad['usertypeid'] == '3')?"Seller":"Admin");
		}

		/*//get seller user first_name and last_name as per selected seller id*/
		if(($deal['deal_from_seller_name'] != "") && ($deal['deal_from_seller_name'] != "other_seller") && ($deal['deal_from_seller_name'] > 0))
		{
			$sellerData = getDataFromTable('tbl_users',"userid, fullname, first_name, last_name","userid = '".$deal['deal_from_seller_name']."'");
			$seller_name = $sellerData['first_name']." ".$sellerData['last_name'];
		}else
		{
			$seller_name = $deal['deal_from_seller_name_other'];
		}
		$deal_ar[$i]['deal_from_seller_name']=$seller_name;

	
		//get city name through city id
		/*$sql_city = "Select c.* from mast_city c where city_id =".$deal['deal_city'];
		$res_city = $dbObj->customqry($sql_city,0);
		$row_city = @mysql_fetch_assoc($res_city);
		$deal_ar[$i]['city_name'] = $row_city['city_name'];*/
	
		///////////////////////////////////////////
		//START Get multiple cities as per product id
		$deal_ar[$i]['city_name'] = $dbObj->getDealMultiCities($deal['deal_unique_id']);
		//END Get multiple cities as per product id

		//get deal main type name through deal_main_type
		$sql_dlMainType = "Select dt.* from tbl_dealtype dt where typeid =".$deal['deal_main_type'];
		$res_dlMainType = $dbObj->customqry($sql_dlMainType,0);
		$row_dlMainType = @mysql_fetch_assoc($res_dlMainType);
		$deal_ar[$i]['deal_main_type'] = $row_dlMainType['dealtype'];
		$i++;
	}

      $smarty->assign("product",$deal_ar);	
}

/*----------Pagination Part-2--------------*/
// 	$rs2=$dbObj->customqry("SELECT ".$sf." FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid LEFT JOIN tbl_dealtype dt ON dt.typeid=p.deal_main_type WHERE ".$cnd." ORDER BY deal_unique_id DESC", "");

//$rs2=$dbObj->gj($tbl,"p.*,tu.username",$cnd,"","","","","");
$rs2 = $dbObj->customqry("SELECT p.*,tu.username, tu.first_name, tu.last_name, tu.fullname FROM tbl_deal as p LEFT JOIN tbl_users as tu ON p.deal_from_seller_name=tu.userid  WHERE ".$cnd." ORDER BY deal_unique_id DESC ", "");
$nums = @mysql_num_rows($rs2);
$show = 30;		
$total_pages = ceil($nums / $adsperpage);

if($total_pages > 1)
	$smarty->assign("showpaging",'yes');

$showing   = !($_GET['page'])? 1 : $_GET['page'];

if($_GET['uname'] != '')
{
      $firstlink = "rejected-deals.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
      $seperator = '&page=';
}
else
{
      $firstlink = "rejected-deals.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
      $seperator = '&page=';
}

$baselink  = $firstlink; 

$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink,$seperator, $nums);
$smarty->assign("pgnation",$pgnation);
#-------------------End ----------------------#


#---------------Get all username-------------#
$u_name=array();
$cnd = "isverified = 'yes' and usertypeid=3";
$tbl= "tbl_users";
$sf="first_name,last_name,username";
$rs_user = $dbObj->gj($tbl,$sf,$cnd, "username", "", "", "", "");

if( $rs_user !='n')
{
    while($rs_name = @mysql_fetch_assoc($rs_user))
    {
	$u_name[]['fullname']=$rs_name['first_name']." ".$rs_name['last_name'];
	$u_name[]['username']=$rs_name['username'];
    }
    $smarty->assign("user_list", $u_name);
}
#---------------Get all username-------------#

if($_SESSION['msg'])
 {
 	$smarty->assign('msg',$_SESSION['msg']);
 	unset($_SESSION['msg']);
 }
$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/rejected-deals.tpl');
$dbObj->Close();
?>