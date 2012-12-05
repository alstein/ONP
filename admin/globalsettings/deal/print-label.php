<?php
include_once("../../../include.php");
include_once('../../../includes/SiteSetting.php');
if(!$_SESSION['duAdmId'])
{
    header("location:".SITEROOT . "/admin/login/index.php");
    exit;
}

			$sql_contri2 = "select * from tbl_billing_address where payid = ".$_GET['pay_id_info'];
			$qry_contri2 = @mysql_query($sql_contri2);
			$user_det=@mysql_fetch_assoc($qry_contri2);
         		$getuserid=$user_det['userid'];
 			$smarty->assign("user",$user_det);

        		$sql_user = "select username from tbl_users where userid = '$getuserid'";
			$qr_user = @mysql_query($sql_user);
			$user_record=@mysql_fetch_assoc($qr_user);
			$smarty->assign("user_array",$user_record);

      

        
			
	

  // Retrieving from tbl deal payment
  $fields1 = array(  "pay_id" , "pay_unique_id" , "deal_id" , "user_id" , "deal_quantity" , "deal_price" , "transaction_id" );
 $wf1     = array( "pay_id");
 $wv1     =  array($_GET['pay_id_info']);
 $ob1     =  "pay_id"; 
 $ot1     = 'asc'; 
 $prn1    =  0; 
 $result1  = $dbObj ->cgs('tbl_deal_payment', $fields1, $wf1, $wv1, $ob1, $ot1, $prn1); 
 $deal_pay=@mysql_fetch_assoc($result1);

//echo "<pre>";print_r($deal_pay);
	
 $smarty->assign("deal_pay_info",$deal_pay);

 // Retrieving from tbl deal
 $fields2 = array(  "deal_unique_id" , "seller_id" , "title" , "groupbuy_price" , "sub_delivery_cost" , "notes","deal_type");
 $wf2     = array("deal_unique_id");
 $wv2     =  array($deal_pay['deal_id']);
 $ob2    =  "deal_unique_id"; 
 $ot2     = 'asc'; 
 $prn2    =  0; 
 $result2  = $dbObj ->cgs('tbl_deal', $fields2, $wf2, $wv2, $ob2, $ot2, $prn2); 
 $deal=@mysql_fetch_assoc($result2);

 $getprototal=$deal_pay['deal_quantity']*$deal['groupbuy_price'];

  $smarty->assign("deal",$deal);

 // Retrieving from tbl users	
  $fields3 = array(  "userid" , "first_name" , "last_name" , "email" , "address1" ,"username" );
 $wf3    = array(  "userid");
 $wv3     =  array( $deal['seller_id']);
 $ob3     =  "userid"; 
 $ot3     = 'asc'; 
 $prn3    =  0; 
 $result3  = $dbObj ->cgs('tbl_users', $fields3, $wf3, $wv3, $ob3, $ot3, $prn3); 	
 $seller=@mysql_fetch_assoc($result3);
 $smarty->assign("seller",$seller);
			
			

			 $delivery_cost=$deal_pay['deal_quantity']*$deal['sub_delivery_cost'];
					if($delivery_cost == 0 || $delivery_cost == "" )
					{
						$delivery_cost=0;
					}
			 $smarty->assign("delivery",$delivery_cost);

	
 			if( ($deal['deal_type'] == "product") && ($deal['seller_id'] != '1') )
			{
			
					$without_del_cost=$getprototal;
					$subtotal=$delivery_cost+$getprototal;
						
			}
			else
			{	
					$without_del_cost=$deal_pay['deal_price']-$delivery_cost;
					$subtotal=$deal_pay['deal_price'];
              		}
			
			$smarty->assign("total",$without_del_cost);
			$smarty->assign("subtotal",$subtotal);

$smarty->display(TEMPLATEDIR.'/admin/globalsettings/deal/print-label.tpl'); 
$dbObj->Close();
?>
