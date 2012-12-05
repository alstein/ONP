<?php
class sendmail extends DBTransact{
	function send_comman_mail($to,$subject,$message,$fromname,$from){
     	$headers="MIME-Version: 1.0\r\n";
		$headers.="X-Mailer: New Member App PHP Script\r\n";
		$headers.="Content-type: text/html; charset=iso-8859-1\r\n";
		$headers.= "From:".$fromname."<".$from.">"."\r\n";

		$suc = mail($to, $subject, $message,$headers);
		if($suc==1)
		{ return true; }
		else
		{ return false; }
	}

	function send_comman_mail_attachment($to,$subject,$message,$fromname,$from,$files=''){
		//$files = array("../../uploads/send_message.doc","../../uploads/send_Detail.doc");
		$message = $message;
		$headers = "From:".$fromname."<".$from.">";

		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed; \n" . " boundary=\"{$mime_boundary}\"";

		$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";

		$message .= "--{$mime_boundary}\n";

		for($x=0;$x<count($files);$x++){
			$file = @fopen($files[$x],"rb");
			$data = @fread($file,filesize($files[$x]));
			@fclose($file);
			$data = chunk_split(base64_encode($data));
			$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" .
			"Content-Disposition: attachment;\n" . " filename=\"$files[$x]\"\n" .
			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			$message .= "--{$mime_boundary}\n";
		}

		$suc = mail($to, $subject, $message,$headers);
		if($suc==1)
		{ return true; }
		else
		{ return false; }

	}
}
?>