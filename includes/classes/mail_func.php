<?php

class mailer1
{

 	function new_email($to ,$to_name ,$from ,$from_name ,$message ,$subject)
	{
		$headers.="MIME-Version: 1.0\r\n";
		$headers.="X-Mailer: New Member App PHP Script\r\n";
		$headers.="Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 3\n";
		$headers .= "X-MSmail-Priority: Normal\n";
		$headers .= "X-mailer: php\n";
		//$headers.="To:".$toName."<".$toID.">"."\r\n ";
		//$headers.="From:".$from_name."<".$from.">"."\r\n";
		// 		$headers .= "From: <" . $from."> [". $from_name . "]"." \r\n";
		//$headers.="Cc:".$from_name."<".$from.">"."\r\n";  
// 		$headers.="MIME-Version: 1.0\r\n";
// 		$headers.="X-Mailer: New Member App PHP Script\r\n";
// 		$headers.="Content-type: text/html; charset=iso-8859-1\r\n";
// 		$headers .= "To: ". $to." [" . $to_name . "]"." \r\n ";
 		$headers .= "From: <" . $from."> (". $from_name . ")"." \r\n";
			//mail($toID, $subject, $message,$headers, "-r ".$from."");
		$sendmail = mail($to, $subject,  $message, $headers, "-r ".$from."");
		
		if($sendmail > 0)
		{
// 			echo("<p>Message successfully sent!</p>" . $to);
			return 1;
		}
		else
		{
// 			echo("<p>Message delivery failed...</p>" . $to);
			return 0;
		}
	}
}
$mail = new mailer1();
?>