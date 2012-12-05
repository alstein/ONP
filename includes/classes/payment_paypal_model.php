<?php
class Payment_Paypal_Model{

	var $PAYPAL_API_USERNAME = 'sdk-three_api1.sdk.com';
	var $PAYPAL_API_PASSWORD = 'QFZCWN5HZM8VBG7Q';
	var $PAYPAL_API_SIGNATURE = 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI';
	var $PAYPAL_API_ENDPOINT = 'https://api-3t.sandbox.paypal.com/nvp';
	var $PAYPAL_SUBJECT = '';
	var $PAYPAL_USE_PROXY = FALSE;
	var $PAYPAL_PROXY_HOST = '127.0.0.1';
	var $PAYPAL_PROXY_PORT = '808';
	var $PAYPAL_PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
	var $PAYPAL_VERSION = '61.0';
	var $PAYPAL_ACK_SUCCESS = 'SUCCESS';
	var $PAYPAL_ACK_SUCCESS_WITH_WARNING = 'SUCCESSWITHWARNING';
	
    public function Payment_Paypal_Model(){
	/*
		if($this->config->item('PAYMENT_MODE') != 'TEST')
		{
			$this->PAYPAL_API_USERNAME = 'sdk-three_api1.sdk.com';
			$this->PAYPAL_API_PASSWORD = 'QFZCWN5HZM8VBG7Q';
			$this->PAYPAL_API_SIGNATURE = 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI';
			$this->PAYPAL_API_ENDPOINT = 'https://api-3t.paypal.com/nvp';
			$this->PAYPAL_SUBJECT = '';
			$this->PAYPAL_USE_PROXY = FALSE;
			$this->PAYPAL_PROXY_HOST = '127.0.0.1';
			$this->PAYPAL_PROXY_PORT = '808';
			$this->PAYPAL_PAYPAL_URL = 'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
			$this->PAYPAL_VERSION = '61.0';
			$this->PAYPAL_ACK_SUCCESS = 'SUCCESS';
			$this->PAYPAL_ACK_SUCCESS_WITH_WARNING = 'SUCCESSWITHWARNING';
		}
	*/


		//get paypal payment gatwway details as per set by admin from admin end
		$query = "select * from tbl_payment_setting";
            	$result = mysql_query($query);
		$row = mysql_fetch_assoc($result);
		if($row['paymentmode'] == 0) //sandbox test mode
      		{
			$this->PAYPAL_PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
			$this->PAYPAL_API_USERNAME = 'sdk-three_api1.sdk.com'; //$row['autho_login'];
			$this->PAYPAL_API_PASSWORD = 'QFZCWN5HZM8VBG7Q'; //$row['password'];
			$this->PAYPAL_API_SIGNATURE = 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI'; //$row['signature'];
			$this->PAYPAL_API_ENDPOINT = 'https://api-3t.sandbox.paypal.com/nvp';
			$this->PAYPAL_SUBJECT = '';
			$this->PAYPAL_USE_PROXY = FALSE;
			$this->PAYPAL_PROXY_HOST = '127.0.0.1';
			$this->PAYPAL_PROXY_PORT = '808';
			$this->PAYPAL_PAYPAL_URL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
			$this->PAYPAL_VERSION = '61.0';
			$this->PAYPAL_ACK_SUCCESS = 'SUCCESS';
			$this->PAYPAL_ACK_SUCCESS_WITH_WARNING = 'SUCCESSWITHWARNING';

		}else //live mode
		{
			$this->PAYPAL_API_USERNAME = $row['autho_login'];
			$this->PAYPAL_API_PASSWORD = $row['password'];
			$this->PAYPAL_API_SIGNATURE = $row['signature'];
			$this->PAYPAL_API_ENDPOINT = 'https://api-3t.paypal.com/nvp';
			$this->PAYPAL_SUBJECT = '';
			$this->PAYPAL_USE_PROXY = FALSE;
			$this->PAYPAL_PROXY_HOST = '127.0.0.1';
			$this->PAYPAL_PROXY_PORT = '808';
			$this->PAYPAL_PAYPAL_URL = 'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
			$this->PAYPAL_VERSION = '61.0';
			$this->PAYPAL_ACK_SUCCESS = 'SUCCESS';
			$this->PAYPAL_ACK_SUCCESS_WITH_WARNING = 'SUCCESSWITHWARNING';
		}

	}

	/*
		papal payment transcation by credit card
	*/
	//	$paymentType="Sale"
	//	$paymentType="Authorization"

	public function payPaymentByCreditCard($firstName,$lastName,$creditCardType,$creditCardNumber,$expDateMonth,$expDateYear,$cvv2Number,$address1,$address2,$city,$state,$zip,$amount,$x_email="",$paymentType="Authorization",$currencyCode="USD"){

		//print_r(func_get_args());die();
		$paymentType =urlencode( $paymentType);
		$firstName =urlencode( $firstName);
		$lastName =urlencode( $lastName);
		$creditCardType =urlencode( $creditCardType);
		$creditCardNumber = urlencode($creditCardNumber);
		$expDateMonth =urlencode( $expDateMonth);
		
		// Month must be padded with leading zero
		$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		
		$expDateYear =urlencode( $expDateYear);
		$cvv2Number = urlencode($cvv2Number);
		$address1 = urlencode($address1);
		$address2 = urlencode($address2);
		$city = urlencode($city);
		$state =urlencode( $state);
		$zip = urlencode($zip);
		$amount = urlencode($amount);
		//$currencyCode=urlencode($_POST['currency']);
		$currencyCode=urlencode($currencyCode);
		$paymentType=urlencode("Authorization");	
	
		// Construct the request string that will be sent to PayPal.
		//	The variable $nvpstr contains all the variables and is a
		//	name value pair string with & as a delimiter 
    $nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
		"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
		
		$getAuthModeFromConstantFile = true;
		//$getAuthModeFromConstantFile = false;
		$nvpHeader = "";
	
		if(!$getAuthModeFromConstantFile) {
			//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
			//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
			$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
		} else {
			if(!empty($this->PAYPAL_API_USERNAME) && !empty($this->PAYPAL_API_PASSWORD) && !empty($this->PAYPAL_API_SIGNATURE) && !empty($this->PAYPAL_SUBJECT)) {
				$AuthMode = "THIRDPARTY";
			}else if(!empty($this->PAYPAL_API_USERNAME) && !empty($this->PAYPAL_API_PASSWORD) && !empty($this->PAYPAL_API_SIGNATURE)) {
				$AuthMode = "3TOKEN";
			}else if(!empty($this->PAYPAL_SUBJECT)) {
				$AuthMode = "FIRSTPARTY";
			}
		}
		
		switch($AuthMode) {
			case "3TOKEN" : 
					$nvpHeader = "&PWD=".urlencode($this->PAYPAL_API_PASSWORD)."&USER=".urlencode($this->PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode($this->PAYPAL_API_SIGNATURE);
					break;
			case "FIRSTPARTY" :
					$nvpHeader = "&SUBJECT=".urlencode($this->PAYPAL_SUBJECT);
					break;
			case "THIRDPARTY" :
					$nvpHeader = "&PWD=".urlencode($this->PAYPAL_API_PASSWORD)."&USER=".urlencode($this->PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode($this->PAYPAL_API_SIGNATURE)."&SUBJECT=".urlencode($this->PAYPAL_SUBJECT);
					break;
		}
		
		$nvpstr = $nvpHeader.$nvpstr;
		
		// Make the API call to PayPal, using API signature.
		//	The API response is stored in an associative array called $resArray 
		$resArray = $this->hash_call("doDirectPayment",$nvpstr);
		
		// Display the API response back to the browser.
		//	If the response from PayPal was a success, display the response parameters'
		//	If the response was an error, display the errors received using APIError.php.
	
		$ack = strtoupper($resArray["ACK"]);
		
		return $resArray;
		
		/*
		if($ack!="SUCCESS")  {
			$resArray['ACK']."<br />";
			$resArray['CORRELATIONID']."<br />";
			$resArray['VERSION']."<br />";
			$count=0;
			while (isset($resArray["L_SHORTMESSAGE".$count])) {		
				$errorCode    = $resArray["L_ERRORCODE".$count]."<br />";
				$shortMessage = $resArray["L_SHORTMESSAGE".$count]."<br />";
				$error=$longMessage  = $resArray["L_LONGMESSAGE".$count].""; 
				$count=$count+1; 
			}
			//$data['errorMsg'] = $error;
			return $error;
			//$_SESSION['reshash']=$resArray;
			//$location = "APIError.php";
			//	header("Location: $location");
			
		}else{
			
			//echo $resArray['TRANSACTIONID']."<br />";
			//echo $currencyCode.$resArray['AMT']."<br />";
			//echo $resArray['AVSCODE']."<br />";
			//echo $resArray['CVV2MATCH']."<br />";
			return "0";
			//redirect($this->config->item('base_url').'/fund/paypalsuccess');
		}
		*/
		
	}	//	end function payPaymentByCreditCard


	public function doCapture($authorization_id,$amount,$CompleteCodeType='Complete',$invoice_id='',$currency='USD',$note=''){
	
		$authorizationID=urlencode($authorization_id);
		$completeCodeType=urlencode($CompleteCodeType);
		$amount=urlencode($amount);
		$invoiceID=urlencode($invoice_id);
		$currency=urlencode($currency);
		$note=urlencode($note);
		
		/* Construct the request string that will be sent to PayPal.
		The variable $nvpstr contains all the variables and is a
		name value pair string with & as a delimiter */
		$nvpStr="&AUTHORIZATIONID=$authorizationID&AMT=$amount&COMPLETETYPE=$completeCodeType&CURRENCYCODE=$currency&NOTE=$note";
		
		$getAuthModeFromConstantFile = true;
		//$getAuthModeFromConstantFile = false;
		$nvpHeader = "";
		
		if(!$getAuthModeFromConstantFile) {
			//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
			//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
			$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
			} else {
			if(!empty($this->PAYPAL_API_USERNAME) && !empty($this->PAYPAL_API_PASSWORD) && !empty($this->PAYPAL_API_SIGNATURE) && !empty($this->PAYPAL_SUBJECT)) {
				$AuthMode = "THIRDPARTY";
			}else if(!empty($this->PAYPAL_API_USERNAME) && !empty($this->PAYPAL_API_PASSWORD) && !empty($this->PAYPAL_API_SIGNATURE)) {
				$AuthMode = "3TOKEN";
			}else if(!empty($this->PAYPAL_SUBJECT)) {
				$AuthMode = "FIRSTPARTY";
			}
		}
		
		switch($AuthMode) {
		
			case "3TOKEN" : 
					$nvpHeader = "&PWD=".urlencode($this->PAYPAL_API_PASSWORD)."&USER=".urlencode($this->PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode($this->PAYPAL_API_SIGNATURE);
					break;
			case "FIRSTPARTY" :
					$nvpHeader = "&SUBJECT=".urlencode($this->PAYPAL_SUBJECT);
					break;
			case "THIRDPARTY" :
					$nvpHeader = "&PWD=".urlencode($this->PAYPAL_API_PASSWORD)."&USER=".urlencode($this->PAYPAL_API_USERNAME)."&SIGNATURE=".urlencode($this->PAYPAL_API_SIGNATURE)."&SUBJECT=".urlencode($this->PAYPAL_SUBJECT);
					break;		
		
		}
		
		$nvpStr = $nvpHeader.$nvpStr;
		
		/* Make the API call to PayPal, using API signature.
		The API response is stored in an associative array called $resArray */
		$resArray = $this->hash_call("DOCapture",$nvpStr);
		
		/* Next, collect the API request in the associative array $reqArray
		as well to display back to the browser.
		Normally you wouldnt not need to do this, but its shown for testing */
		
		$reqArray=$_SESSION['nvpReqArray'];
		
		/* Display the API response back to the browser.
		If the response from PayPal was a success, display the response parameters'
		If the response was an error, display the errors received using APIError.php.
		*/
		$ack = strtoupper($resArray["ACK"]);
		
		return $resArray;
	}

	/**
	* hash_call: Function to perform the API call to PayPal using API signature
	* @methodName is name of API  method.
	* @nvpStr is nvp string.
	* returns an associtive array containing the response from the server.
	*/
	
	function hash_call($methodName,$nvpStr){
		//declaring of global variables

		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->PAYPAL_API_ENDPOINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		//Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php 
		if($this->PAYPAL_USE_PROXY)
		curl_setopt ($ch, CURLOPT_PROXY, $this->PAYPAL_PROXY_HOST.":".$this->PAYPAL_PROXY_PORT); 
	
		//check if version is included in $nvpStr else include the version.
		if(strlen(str_replace('VERSION=', '', strtoupper($nvpStr))) == strlen($nvpStr)) {
			$nvpStr = "&VERSION=" . urlencode($this->PAYPAL_VERSION) . $nvpStr;	
		}
		
		$nvpreq="METHOD=".urlencode($methodName).$nvpStr;
		
		//setting the nvpreq as POST FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
	
		//getting response from server
		$response = curl_exec($ch);
	
		//convrting NVPResponse to an Associative Array
		$nvpResArray = $this->deformatNVP($response);
		$nvpReqArray = $this->deformatNVP($nvpreq);
		$_SESSION['nvpReqArray']=$nvpReqArray;
	
		if (curl_errno($ch)) {
			// moving to display page to display curl errors
			$_SESSION['curl_error_no']=curl_errno($ch) ;
			$_SESSION['curl_error_msg']=curl_error($ch);
			$location = "APIError.php";
			header("Location: $location");
		} else {
			//closing the curl
				curl_close($ch);
		}
	
	return $nvpResArray;
	}
	
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	* It is usefull to search for a particular key and displaying arrays.
	* @nvpstr is NVPString.
	* @nvpArray is Associative Array.
	*/
	
	function deformatNVP($nvpstr){
	
		$intial=0;
		$nvpArray = array();
	
	
		while(strlen($nvpstr)){
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
		}
		return $nvpArray;
	}

	
} //end class Payment_Paypal_Model


?>
