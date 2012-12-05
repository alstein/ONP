<?php
class PaymentModel{
	public $USERNAME = "demo";
	public $PASSWORD = 'password';
	
	public function PaymentModel(){
		$query = "select * from tbl_payment_setting";	
		$res = mysql_query($query);
		$row = mysql_fetch_assoc($res);
		$this->USERNAME = $row['autho_login'];
		$this->PASSWORD = $row['password'];
	}

	/*
		papal payment transcation by credit card
	*/

	public function payPaymentByCreditCard($ccnumber,$ccexp,$cvv,$amount,$address1="",$city="",$state="",$zip="",$type="sale"){

		$authnet_values	= array(
			"username"					=> $this->USERNAME,
			"password"					=> $this->PASSWORD,
			"type"						=> "sale",
			"ccnumber"					=> $ccnumber,
			"ccexp"						=> $ccexp,
			"cvv"							=> $cvv,
			"amount"						=> $amount,
			"address1"					=>	$address1,
			"city"						=>	$city,
			"state"						=> $state,
			"zip"							=>	$zip
		);

		$fields = "";
		foreach( $authnet_values as $key => $value ) $fields .= "$key=" . urlencode( $value ) . "&";
	
		$ch = curl_init("https://secure.merchantonegateway.com/api/transact.php");
		curl_setopt($ch, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim( $fields, "& " )); // use HTTP POST to send form data
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response. ###
		$resp = curl_exec($ch); //execute post and get results

		curl_close ($ch);
		$arr =  explode("&",$resp);
		$response = 0;
		if(is_array($arr)){
			$response = explode("=",$arr[0]);
			$response = $response[1];
		}
		return $response;
	}	//	end function payPaymentByCreditCard

	
	
} //end class Payment_Model

?>
