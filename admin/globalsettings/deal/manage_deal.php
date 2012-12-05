<?php
date_default_timezone_set('Europe/London');
include_once('../../../include.php');
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");
include_once('../../../includes/class.message.php');
include_once('../../../includes/function.php');

if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

//**********************************Find All Seller***********************************************//
$res_sellerDet = $dbObj->cgs("tbl_users","userid, fullname, first_name, last_name,business_name, email",array("isDeleted","usertypeid"),array(0,3),"first_name","ASC","");
$num_seller = @mysql_num_rows($res_sellerDet);
$row_sellerDet = array();
while($row = @mysql_fetch_assoc($res_sellerDet))
{
	$row_sellerDet[] = $row;
}
$smarty->assign("deal_from_seller_names",$row_sellerDet);
//**********************************End Of Find All Seller***********************************************//


#------------Check For access----------#
if(!(in_array("10", $arr_modules_permit)))
{
      unset($_SESSION['duAdmId']);
      $s=$msobj->showmessage(166);
      $_SESSION['msg']="<span class='".$s['msgtype']."'>".$s['msgtext']."</span>";

      header("location:".SITEROOT . "/admin/login/index.php");
      exit;
}
#----------End Check For access----------#
//********************************************Action on records*******************************************************//
 if($_POST['action'])
   {
      extract($_POST);
      $deal_ids = @implode(", ", $deal_id);
      if($deal_ids)
      {
         if($_POST['action'] == "delete")
         {
		$sel= $dbObj->customqry("SELECT * FROM tbl_deals WHERE deal_unique_id IN (".$deal_ids.")","");
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
		
		
		  $temp = $dbObj->customqry("delete from tbl_deals where deal_unique_id IN (".$deal_ids.")","");
                  $_SESSION['msg']="<span class='success'>Deal deleted successfully</span>";

         }
      	elseif($_POST['action'] == "active")
         {
               $temp = $dbObj->customqry("update tbl_deals set status = 'active' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal activated successfullly </span>";
         }
	elseif($_POST['action'] == "inactivate")
         {
               $temp = $dbObj->customqry("update tbl_deals set status = 'inactive' where deal_unique_id IN (".$deal_ids.")","");
               $_SESSION['msg']="<span class='success'>Deal inactivated successfullly </span>";
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
     if($_GET['xlsid']!=""){
         $dealid=$_GET['xlsid'];
         $res = $dbObj->customqry("SELECT tdl.user_id,u.fullname,u.shippingaddress_send 
                                  from tbl_deal_payment as tdl JOIN tbl_users as u
                                  on tdl.user_id=u.userid
                                  where tdl.deal_id=".$dealid);
//         $resultsetxls=mysql_fetch_array($res);
         
         while($row = @mysql_fetch_assoc($res))
	{
		$feed[] = $row;
        }
 
        $outs ="Address";		
	$outs .="\n";
	$outs .="\n";		
	$outs .="\n";
	$outs .="\n";
        foreach($feed as $f){ //echo $re['shippingaddress_send']; exit;
           $outs .= ' Username :'.$f['fullname']."  ".$f['shippingaddress_send'].'"';
			$outs .= "\n\n\n";
        }
        
        @header("Content-type: text/x-csv");
	@header("Content-type: application/csv");
	@header("Content-Disposition: attachment; filename=Address-users.csv");	
	echo $outs;
	exit;
         
     }

   #--------Pagination1-------------------------#
   $getpage=$_GET['page'];
   if(!isset($getpage))
      $page =1;
      else
      $page = $getpage;
      $adsperpage =20;
    $StartRow = $adsperpage * ($page-1);
     $l =  $StartRow.','.$adsperpage;
   #----------------------------------------#
   
   #-------- Show Testimonails -------------------#
   

	if($_GET['view'] == 'excel')
	{
	$out ="Deal Report";		
	$out .="\n";
	$out .="\n";
	$out .='Deal Name,Merchant Name,Deal End Date,Deal Category,Original Price,Discount In %,Offer Price';				
	$out .="\n";
	$out .="\n";
	$l="";
	}


$ob="deal_unique_id"; $ot="DESC";	
if($_GET['sortby'])
{
    switch($_GET['sortby'])
    {
          case deal_title:
                        $ob = "p.deal_title"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_title", "DESC");
                        else
                          $smarty->assign("sorttype_title", "ASC");
                        break;
          case fullname:
                        $ob = "tu.business_name"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_email", "DESC");
                        else
                          $smarty->assign("sorttype_email", "ASC");
                        break;
         
          case deal_end_date:
                        $ob = "p.deal_end_date 	"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_end_date", "DESC");
                        else
                          $smarty->assign("sorttype_end_date", "ASC");
                        break;
          case deal_category:
                        $ob = "p.deal_category"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_category", "DESC");
                        else
                          $smarty->assign("sorttype_category", "ASC");
                        break;
	case original_price:
                        $ob = "p.original_price "; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_original_price", "DESC");
                        else
                          $smarty->assign("sorttype_original_price", "ASC");
                        break;
          case discount_in_per:
                        $ob = "p.discount_in_per"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_saved", "DESC");
                        else
                          $smarty->assign("sorttype_saved", "ASC");
                        break;
	 case offer_price:
                        $ob = "p.offer_price"; $ot = $_GET['sorttype'];

                        if($_GET['sorttype'] == 'ASC')
                          $smarty->assign("sorttype_offer_price", "DESC");
                        else
                          $smarty->assign("sorttype_offer_price", "ASC");
                        break;
         
    }
}

$date = date("Y-m-d H:i:s");	

   //$tbl = "tbl_deal as p left Join tbl_users u on u.userid = p.seller_id";
   $tbl = "tbl_deals as p, tbl_users as tu, tbl_dealtype dt ";
   $sf = "p.*,tu.business_name,tu.deal_cat,md.category";
   
  $cnd="p.deal_end_date >= '$date' ";
if($_GET['exel_id'] != "")
{
    $cnd.= " and p.deal_unique_id='".$_GET['exel_id']."'";
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
				$cnd .= "and p.	merchant_id ='".$getdeal_from_seller_name."'";
			}else
			{
				$cnd .= "and p.	merchant_id ='".$getdeal_from_seller_name."'";
			}
		}
	}
}

if(isset($_GET['search']))
{
	$cnd .= " AND (p.deal_title LIKE '%".$_GET['search']."%' OR tu.first_name LIKE '%".$_GET['search']."%' OR tu.last_name LIKE '%".$_GET['search']."%' OR tu.fullname LIKE '%".$_GET['search']."%' OR p.deal_category LIKE '%".$_GET['search']."%' OR p.	original_price 	 LIKE '%".$_GET['search']."%' OR p.discount_in_per LIKE '%".$_GET['search']."%' OR p.offer_price LIKE '%".$_GET['search']."%')";
}
	
// 	$res = $dbObj->gj($tbl,$sf,$cnd,"deal_unique_id","","DESC",$l, "");
	if($_GET['view'] == 'excel')
	{
	$res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deals as p LEFT JOIN tbl_users as tu ON p.merchant_id=tu.userid left join mast_deal_category md on tu.deal_cat=md.id WHERE ".$cnd." ORDER BY $ob $ot LIMIT ".$l, "");
	}
	else
	{
	$res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deals as p LEFT JOIN tbl_users as tu ON p.merchant_id=tu.userid left join mast_deal_category md on tu.deal_cat=md.id WHERE ".$cnd." ORDER BY $ob $ot LIMIT ".$l, "");
	}
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
		$feed[] = $row;
		
		if($_GET['view'] == 'excel')
		{
			if($row['deal_category']=='deal_as_usual')
			{
			$deal_cat="Deal As Usual";
			}
			else
			{
			$deal_cat="Right Now Deal";
			}
			#---code for csv report-----#
			$out .= '"'.$row['deal_title'].'","'.$row['fullname'].'","'.date(DATE_FORMAT." H:i:s",strtotime($row['deal_end_date'])).'","'.$deal_cat.'","'.$row['original_price'].'","'.$row['discount_in_per'].'%","'.$row['offer_price'].'"';
			$out .= "\n";
			#----code end---#
		}
		$sel_count_deal=$dbObj->customqry("select count(deal_id) as count_deal from tbl_deal_payment_unique where deal_id='".$row['deal_unique_id']."'","");
		$res_count=@mysql_fetch_assoc($sel_count_deal);
		$feed[$i]['count_deal']=$res_count['count_deal'];
		$i++;
        } 


   $smarty->assign("deal",$feed);
   #-------------End------------------------#
   
   #------------Pagination2-----------------#   
   //$res = $dbObj->gj($tbl,$sf,$cnd,"","","","", "");
   $res = $dbObj->customqry("SELECT ".$sf." FROM tbl_deals as p LEFT JOIN tbl_users as tu ON p.merchant_id=tu.userid LEFT JOIN  WHERE ".$cnd." ORDER BY deal_unique_id DESC ", "");
   $nums = @mysql_num_rows($res);
   $show = 10;    
   $total_pages = ceil($nums / $adsperpage);
   if($total_pages > 1)
      $smarty->assign("showpaging", "yes");
      
   $showing = !($getpage)? 1 : $getpage;
   if($search)
      $firstlink = "manage_deal.php?deal_from_seller_name=ssdf&uname={$_GET['uname']}&dltype=".$_GET['dltype'];
   else
      $firstlink = "manage_deal.php?deal_from_seller_name=".$_GET['deal_from_seller_name']."&dltype=".$_GET['dltype'];
   $seperator = '&page=';
   $baselink = $firstlink;
   $pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
   
   $smarty->assign("pgnation",$pgnation);
   
   #----------------------------------------#
   
   #----------Success message=--------------#
   if($_SESSION['msg'])
   {
   $smarty->assign("msg", $_SESSION['msg']);
   $_SESSION['msg'] = NULL;
   unset($_SESSION['msg']);
   }
   #--------------End-----------------------#
   
  
   #----------Success message=--------------#
	
	#----code for csv report-------#
	if($_GET['view'] == 'excel')
	{ 
	@header("Content-type: text/x-csv");
	@header("Content-type: application/csv");
	@header("Content-Disposition: attachment; filename=Deal-details.csv");	
	echo $out;
	exit;
	}
	#----code end------#
   $smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/manage_deal.tpl'); 
?>
