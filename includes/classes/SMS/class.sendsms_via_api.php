<?php 

/// Simple SMS send class


class SendSMS
{
	private static $URL = "http://www.textmarketer.biz/gateway/"; 
	private static $SHORT_CODE="88802";
	private $usingShortCode=false;
 	private $my_url;
	private $error;
	private $numberOfCreditsRemaining,$creditsUsed;
	private $transaction_id;
 
	
	function __construct($username,$password)
	{
		// Use the same username and password you have for your main account
		$this->my_url = self::$URL."?username=$username&password=$password&option=xml";
	}

	
	public function send($number,$message,$originator)
	{
		// sends an SMS to the gateway, the message length must be between 1 and 640 characters long.
		$this->error = null;

		$query_string .="&number=".$number;
		$query_string .="&message=".urlencode($message);

		$query_string .="&orig=".urlencode($originator);

		$fp =fopen($this->my_url.$query_string,"r");
		$response = fread($fp,1024);

		return $this->processResponse($response);
	}


	
	public function getError()
	{
		// returns an array of error messages	
		$arr = each($this->error);
		return $arr['value'];
	}
	
	
	public function getCreditsRemaining()
	{
		// the total of credits you have left in your account
		return $this->numberOfCreditsRemaining;
	}
	
	public function getTransactionID()
	{
		// This is the unique code that represents your send, you need this code to match up delivery reports
		return $this->transaction_id;
	}

	public function getCreditsUsed()
	{
		// how many credits were used for the send, a message that uses more than 160 characters will use more credits. 1 CR = 160 characters
		return $this->creditsUsed;
	}
	
	//////// PRIVATE FUNCTIONS
	
	private function processResponse($r)
	{
		$xml=simplexml_load_string($r);
		if($xml['status']=="failed"){
			foreach($xml->reason as $index => $reason) $this->error[] = $reason; /// parse the errors into an array
			return false;
		}
		else{
			$this->transaction_id = $xml['id'];
			$this->numberOfCreditsRemaining = $xml->credits;
			$this->creditsUsed = $xml->credits_used;
			return true;
		}
		
	}
}

/*
 * Example of use

$sms = new SendSMS("myUsername","myPassword");
if($sms->send("4477777777","My test message","TextMessage")){
 	echo "I have ".$sms->getCreditsRemaining()." left and I used  ".$sms->getCreditsUsed()." credits";
}
else {
     while($error = $sms->getError())
     {
         echo $error;
     }
}
 */
?>