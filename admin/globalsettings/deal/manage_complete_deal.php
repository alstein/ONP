<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/paging.php");

if(!$_SESSION['duAdmId'])
	header("location:".SITEROOT . "/admin/login/index.php");
	
	#-----------Delete Articles--------------#
	
	if($_POST['action'])
	{
		extract($_POST);
		$deal_ids = @implode(", ", $deal_id);
		if($deal_ids)
		{
			if($action=='Past')
			{
				$temp = $dbObj->customqry("update tbl_deal set status='Active' where deal_unique_id in(".$deal_ids.")", "");
				//$s=$msobj->showmessage(296);
				$_SESSION['msg']="<span class='error'>Active sucessfully</span>";
			}
			elseif($action=='Not-Past')
			{
			
				$temp = $dbObj->customqry("update tbl_deal set status='Inactive' where deal_unique_id in(".$deal_ids.")", "");
// 				$s=$msobj->showmessage(297);
				$_SESSION['msg']="<span class='error'>Inactive sucessfully</span>";
				//$_SESSION['msg']="<span class='success'>FAQ(s) Inactivated Successfully.</span>";
			}
                        elseif($action=='delete')
			{
			
				$temp = $dbObj->customqry("delete from tbl_deal where deal_unique_id IN (".$deal_ids.")","");
// 				$s=$msobj->showmessage(297);
				$_SESSION['msg']="<span class='error'>Deal deleted successfully</span>";
				
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
	
	extract($_GET);
	

        $cnd_city = "status='Active'";
	$rs_city = $dbObj->gj("mast_city", "*",$cnd_city, "city_name", "", "ASC", "", "");
	$i=0;
	while($row_city =@mysql_fetch_assoc($rs_city))
	{
		$sel_city_arr[$i]['city'] = utf8_encode($row_city['city_name']);
		$city1 = strtolower($row_city['city_name']);
		$city2 = str_replace(" ","-",$city1);
		$sel_city_arr[$i]['assign_city'] = utf8_encode($city2);
		$i++;
	}
	$smarty->assign("city_arr", $sel_city_arr);

	
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
	$date = date("Y-m-d H:i:s");	
	
	$tbl = "tbl_deal as p";
	$sf = "*";
	
	
	if($_GET['city'] != "")
        {	
	   $cnd_arra[] = " product_city = '".$_GET['city']."' ";
        }

        if($_GET['search'])	
	{
		$cnd_arra[] = "product_name like '%".$_GET['search']."%' and  (end_date < '$date')  ";
	}
	if($_GET['seller_id'] and ($_GET['type'] != "gbi"))
        {
            $cnd_arra[] = "seller_id = '".$_GET['seller_id']."' ";
        }
        if($_GET['type'])
        {
            if($_GET['type'] == "gbi")
            {
                $cnd_arra[] = "seller_id = 1 and deal_status=3";
            }
            else
            {
                $cnd_arra[] = "deal_type = '".$_GET['type']."'";
            }
        }
	else
	{
		$cnd_arra[] = "p.end_date < '$date'";
	}
	if($cnd_arra)
	   $cnd_imp = implode(" and ", $cnd_arra);
	
        if($_GET['dealstatus']== 'not-completed')
            $cnd = "deal_status = 4 ";
        elseif($_GET['dealstatus']== 'all')
            $cnd = "deal_status in (3,4 )";
        else
	   $cnd = "deal_status =3 ";
	
	if($cnd_imp != "")
	{
		$cnd .= "and ";
		$cnd .= $cnd_imp;
	}

	
	$res = $dbObj->gj($tbl,$sf,$cnd,"deal_product_id","","DESC",$l, "");
	$i=0;
	while($row = @mysql_fetch_assoc($res))
	{
            $feed[] = $row;

            #-------------Get Seller name--------------#
            $cnd_nm = " userid =".$feed[$i]['seller_id'];
	    $res_s = $dbObj->gj("tbl_users","username",$cnd_nm,"","","","","");
	    $row_s = @mysql_fetch_assoc($res_s);
	    $feed[$i]['username'] = $row_s['username'];
            #-------------Get Seller name--------------#

            $feed[$i]['deal_start_date'] =$row['deal_start_date'];
            $feed[$i]['deal_end_date'] =$row['deal_end_date'];	
            $buyer_rs = $dbObj->gj("tbl_deal_payment","sum(deal_quantity) as buyer","deal_id = '".$row['deal_unique_id']."' and payment_done = 'yes'","","","","","");
            $buyer = @mysql_fetch_assoc($buyer_rs);
            $feed[$i]['no_buyer'] = $buyer['buyer'];
            $i++;

	}	
        
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
		$firstlink = "manage_complete_deal.php?search=" . $_GET['search'];
	else
		$firstlink = "manage_complete_deal.php?";
	$seperator = '&page=';
	$baselink = $firstlink;
	$pgnation = pagination($total_pages, $show, $showing, $firstlink, $baselink, $seperator, $nums);
	
	$smarty->assign("pgnation",$pgnation);
	
        //-------------------------get seller name--------------------------------//
        $seller_rs = $dbObj->gj("tbl_users","userid,username","usertypeid = 3","","","","","");
        $seller = array();
        while($row = @mysql_fetch_assoc($seller_rs))
        {
            $seller[] = $row;
        }
        $smarty->assign("seller",$seller);
        //--------------------------end get seller name -------------------------//

	
	#----------Success message=--------------#
	if($_SESSION['msg'])
	{
	$smarty->assign("msg", $_SESSION['msg']);
	$_SESSION['msg'] = NULL;
	unset($_SESSION['msg']);
	}
	#--------------End-----------------------#
	
	$smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/manage_complete_deal.tpl');
?>
