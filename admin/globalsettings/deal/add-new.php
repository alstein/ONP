<?php 
	include_once("../../../include.php");
        include_once('../../../includes/CCV/ccvs.inc');
if(!isset($_SESSION['duAdmId']))
	header("location:".SITEROOT . "/admin/login/index.php");


	$user=$dbObj->cgs("tbl_users","usertypeid,userid,first_name,last_name,email","userid",$_SESSION['UserId'],"","","");//exit;
	$row1=@mysql_fetch_assoc($user);
	$smarty->assign("getuser", $row1);

        if(isset($_POST['submit']))
        {
		//print_r($_POST);exit;
		$re1 = $dbObj->cgs("tbl_deal_payment","sum(deal_quantity) as deals",array("deal_id","cancel_order"),array($_GET['dealid'],"no"),"","group by deal_id","");
 		$_row1 = @mysql_fetch_assoc($re1);
		$smarty->assign("total",$_row1['deals']);
 		$re22 = $dbObj->cgs("tbl_deal","max_buyer","deal_unique_id",$_POST['dealid'],"","","");
 		$row22 = @mysql_fetch_assoc($re22);
 
 		$finalsum = $_row1['deals'];
		if($finalsum>0 && $row22['max_buyer'] != 0)
 		{
 			if($finalsum == $row22['max_buyer'])
 			{
                                $_SESSION['Error_MSG'] = "You can not order more than the limit";
 				header("location:".SITEROOT."/deal/".$_POST['dealid']."/buy/");
 				exit;
 			}
 		}	

// 		echo $_POST['firstname'];exit;
             $userid1 = $_SESSION['UserId'];
	            if(($_SESSION['UserId'] != "") and ($_POST['firstname'] != ""))
            {
                $field1 = array(
                    "first_name"=>$_POST['firstname'],
		    "fullname" =>$_POST['firstname']." ".$_POST['surname'],	
                    "last_name"=>$_POST['surname'],
                    "address1"=>$_POST['addrline1'],
                    "address2"=>$_POST['addrline2'],
                    "city"=>$_POST['city'],
                    "postalcode"=>$_POST['postcode'],
                    "email"=>$_POST['email1'],
		    "contact_detail"=> $_POST['phone']	
                    //"password"=>md5($_POST['password1'])
                );
                $userid = $dbObj->cupdtii("tbl_users",$field1,"userid= '{$userid1}'","");//exit;
            }

            $field3 = array(
                "userid"=>$_SESSION['UserId'],
                "card_type"=>$_POST['cardType'],
                "card_holder_name"=>$_POST['namecard'],
                "card_holder_email"=>$_POST['email1'],
                "card_number"=>base64_encode($_POST['cardno']),
                "cvv_code"=>base64_encode($_POST['cvvno']),
                "card_expire_month"=>$_POST['expiry_month'],
                "card_expire_year"=>$_POST['expiry_year'],
                "added_date"=>date('Y-m-d')
            );
	    //echo "<pre>"; print_r($field3); echo "</pre>"; 
            $cardid = $dbObj->cgii("tbl_credit_card",$field3,""); 
//             

            $uniqueId = "GB".uniqueId(7);
            $field4 = array(
                "pay_unique_id"=>$uniqueId,
                "encrypt_unique_id"=>md5($uniqueId),
                "redemption_code"=>uniqueId(7),
                "deal_id"=>$_POST['dealid'],
                "user_id"=>$_SESSION['UserId'],
                "card_id"=>$cardid,
                "deal_quantity"=>$_POST['qty'],
                "deal_price"=>$_POST['totalamount'],
                "order_date"=>time(),
            );

            if(isset($_SESSION['gift_emailid']))
            {
                $field5 = array(
                    "gift_to"=>$_SESSION['gift_to'],
                    "gift_message"=>$_SESSION['gift_msg'],
                    "deal_type"=>"gift",
                    "emailid"=>$_SESSION['gift_emailid'],
                    "gift_from"=>$_SESSION['gift_from']
                );
                $field4 = array_merge($field4,$field5);
            }
            //echo "<pre>"; print_r($field4); echo "</pre>"; exit;
            $payid = $dbObj->cgii("tbl_deal_payment",$field4,"");//exit;

            $field2 = array(
                "first_name"=>$_POST['firstname'],
                "last_name"=>$_POST['surname'],
                "userid"=>$_SESSION['UserId'],
                "address1"=>$_POST['addrline1'],
                "address2"=>$_POST['addrline2'],
                "city"=>$_POST['city'],
                "postalcode"=>$_POST['postcode'],
                "email"=>$_POST['email1'],
                "phone"=>$_POST['phone'],
                "payid"=>$payid
            );
            $dbObj->cgii("tbl_billing_address",$field2,"");//exit;

            $_SESSION['to'] = "";
            unset($_SESSION['to']);
            $_SESSION['deal_id'] = "";
            unset($_SESSION['deal_id']);
            $_SESSION['to'] = "";
            unset($_SESSION['to']);
            $_SESSION['from'] = "";
            unset($_SESSION['from']);
            $_SESSION['email_id'] = "";
            unset($_SESSION['email_id']);
            $_SESSION['msg'] = "";
            unset($_SESSION['msg']);
	    $_SESSION['UserId'] = "";
            unset($_SESSION['UserId']);
            header("Location:".SITEROOT."/admin/globalsettings/deal/view_product.php?id1=".$_GET['dealid']."&type=".$_GET['type']."&act=view");
            exit;
        }

    


//----------------get city-------------------*/
    $sf="c.city_name";
    $rs=$dbObj->cgs("mast_city c",$sf,"status", "Active", "", "", "");
    $city = array();
    while($row=@mysql_fetch_array($rs))
    {
        $city[]=$row;
    }

    $smarty->assign("city",$city);
/*---------------end get city-------------------*/

    if($_GET['dealid'] != "")
    {
        
        $deal_rs = $dbObj->gj("tbl_deal as d LEFT JOIN tbl_users as u ON d.seller_id = u.userid","d.*,u.first_name,u.last_name,u.username","d.deal_unique_id = '".$_GET['dealid']."'","","","","","");
        if($deal_rs != "n") 
        {
            $dealarr = mysql_fetch_assoc($deal_rs);
        }
        $deal_img = explode(",",$dealarr['small_image']);
        $smarty->assign("deal_img",$deal_img[0]);
        $smarty->assign("dealarr",$dealarr);
        $deliveryAmt = $dealarr['groupbuy_price'] + $dealarr['sub_delivery_cost'];
        $smarty->assign("deliveryAmt",$deliveryAmt);

        $re2 = $dbObj->cgs("tbl_deal_payment","sum(deal_quantity) as deals",array("deal_id","cancel_order"),array($dealarr['deal_unique_id'],"no"),"","group by deal_id","");
 	$_row2 = @mysql_fetch_assoc($re2);
	$smarty->assign("total",$_row2['deals']);

        if($_SESSION['UserId'] != "")
        {
           
            $sf = "userid,first_name,last_name,address1,address2,city,postalcode,email,contact_detail";
            $cnd = "userid = '".$_SESSION['UserId']."'";
            $billing_rs = $dbObj->gj("tbl_users",$sf,$cnd,"","","","","");
            $row = @mysql_fetch_assoc($billing_rs);
          
            $smarty->assign("billingaddr",$row);
        }
    }
    else
    {
        header("Location:".$_SERVER['HTTP_REFERER']);
        exit;
    }

    if($_SESSION['email_id'])
    {
        $_SESSION['to'] = "";
        unset($_SESSION['to']);
        $_SESSION['deal_id'] = "";
        unset($_SESSION['deal_id']);
        $_SESSION['to'] = "";
        unset($_SESSION['to']);
        $_SESSION['from'] = "";
        unset($_SESSION['from']);
        $_SESSION['email_id'] = "";
        unset($_SESSION['email_id']);
        $_SESSION['msg'] = "";
        unset($_SESSION['msg']);
    }
    
	if($_SESSION['Error_MSG'])
 	{
 		$smarty->assign("error_msg",$_SESSION['Error_MSG']);
 		unset($_SESSION['Error_MSG']);
 	}
	$smarty->display(TEMPLATEDIR . '/admin/globalsettings/deal/add-new.tpl');
	$dbObj->Close();
?>
