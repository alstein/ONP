<?php
include_once('../../../include.php');

	if ($_POST['flag'] == 'getSellData')
	{
		$retResultArray = array();
		$retSellerDeliveryCharges = "0.00";
		$retSellerSupportEmail = "";
		$retSellerTrackingUrlCode = "";
		$retSellerDeliveredTrackingUrlCode = "";
		$retSellerRefundPolicy = "";
	
		$userId = $_POST["userId"];
		$selCurrency = $_POST["selCurrency"];

		if($userId > 0)
		{
			//get data from tabl_users of seller like delivery_charges, refund_policy, seller_support_email, tracking_url_code, delivered_tracking_url_code
			$sellerData = getDataFromTable('tbl_users',"userid, delivery_charges_pound, delivery_charges_euro, delivery_charges_dollar, refund_policy, seller_support_email, tracking_url_code, delivered_tracking_url_code","userid = '".$userId."'");

			if($selCurrency == "pound")
			{
				$retSellerDeliveryCharges = $sellerData['delivery_charges_pound'];
			}elseif($selCurrency == "euro")
			{
				$retSellerDeliveryCharges = $sellerData['delivery_charges_euro'];
			}elseif($selCurrency == "dollar")
			{
				$retSellerDeliveryCharges = $sellerData['delivery_charges_dollar'];
			}

			$retSellerSupportEmail = $sellerData['seller_support_email'];
			$retSellerTrackingUrlCode = $sellerData['tracking_url_code'];
			$retSellerDeliveredTrackingUrlCode = $sellerData['delivered_tracking_url_code'];
			$retSellerRefundPolicy = html_entity_decode($sellerData['refund_policy']);

			////START getting data from tbl_delivery_service_charges of this seller////
			$res_delivery_opt_chr = $dbObj->customqry('SELECT tdsc.* FROM tbl_delivery_service_charges tdsc WHERE tdsc.user_id = '.$userId,"");
			$sellerData_delivery_opt_chr = array();
			while($row = @mysql_fetch_assoc($res_delivery_opt_chr))
			{
				$sellerData_delivery_opt_chr[] = $row;
			}
			/////END getting data from tbl_delivery_service_charges of this seller/////
		}

		$retResultArray = array("retSellerDeliveryCharges" => $retSellerDeliveryCharges, "retSellerSupportEmail" => $retSellerSupportEmail, "retSellerTrackingUrlCode" => $retSellerTrackingUrlCode, "retSellerDeliveredTrackingUrlCode" => $retSellerDeliveredTrackingUrlCode, "retSellerRefundPolicy" => $retSellerRefundPolicy, "deliverySerOpt" => $sellerData_delivery_opt_chr);

		echo json_encode($retResultArray);
	}
?>