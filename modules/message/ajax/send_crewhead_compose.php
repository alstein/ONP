<?php
/* INCLUDE REQUIRED FILES */
define('PREFIX', '../../../');
include_once("../../../includes.php");
include_once(PREFIX."includes/classes/input.class.php");

define(TABLENAME,'messages me, user us ,inbox ib');
define(TABLENAME1,'messages me, user us ,outbox ob');


#============ Send message to crew head by any user  ==============================#

	$input = new input();
	$ids = array();
	
	$encrypted_to_id = $_GET['to_id'];

	$get_to_id = (int)str_replace("SC","=",base64_decode(base64_decode(urldecode($encrypted_to_id))));

	if($get_to_id >0)
	{
		$getnames = "select crewname,UID from crew where ID=".$get_to_id;
		$get_rs = $db->customqry($getnames,"");
		$rows = mysql_fetch_assoc($get_rs);
		$crename = $rows['crewname'];
		$cr_ownerid = urlencode(str_replace("=","SC",base64_encode(base64_encode($rows['UID'])))) ;
		
	}
	
	//******* send message module ********* //
	if($_POST['message']!='' ||  !empty($_FILES))
	{
		
		$to_id = (int)str_replace("SC","=",base64_decode(base64_decode(urldecode($input->post('to_id'))))); //  msg is send to this userid

//				$to_id = $input->post('demo_input_local_custom_formatters');

		//$subject =  $input->post('subject');
		$crew_name =  $input->post('name'); // sender of message

		$message = "Hello ".$crew_name." (Crew) you have a message :<br>". $input->post('message');	
	//	$db->data("subject", $subject);

		$db->data("message", $message);
		$db->data("mtype", "1");
		$db->data("cdate", date("Y-m-d : H:i:s"));
		$targetPath = ABSPATH. "/uploads/attachments";
		$from_id = $_SESSION['usrS_user_id']; 
		if(!empty($_FILES))
		{
			$from_id = $input->post('from_id'); 
			function get_file_extension($file_name)
			{
				return substr(strrchr($file_name, '.'),1);
			}	

			$file_name = $_FILES['Filedata']['name'];
			$fileExtention = get_file_extension($file_name);


			$vdofileArray = array("flv", "FLV", "3gp", "3GP","mp4","MP4","mpeg","MPEG","wmv","WMV","avi","AVI","divx","DivX","MOV","mov");
			$photofileArray = array("jpg", "JPG", "jpeg", "JPEG","bmp","BMP","gif","GIF","png","PNG");
			$adofileArray	 = array("mp3", "MP3", "mp4", "MP4");

						if(in_array($fileExtention, $vdofileArray))
						{
							/** Type:video */
							if($ext!="flv")
								{
									$uploaded_file = $db ->generalfileupload($_FILES['Filedata'] , $targetPath."/videos/temp", 1);
			
									$nf = explode(".",$uploaded_file);
			//						$newfile = date("YmdHis");//$nf[0];
									$newfile = $nf[0];
									$file_name = $newfile .".flv";
									$thumbfile = $newfile .".jpg";
									$cmd = "/usr/local/bin/ffmpeg -i  /home/starcrew/public_html/uploads/attachments/videos/temp/". $uploaded_file." -s 320x240 -ar 44100 -r 12  /home/starcrew/public_html/uploads/attachments/videos/".$file_name; 
									exec($cmd);
									$gocmd = "/usr/local/bin/ffmpeg -i /home/starcrew/public_html/uploads/attachments/videos/temp/".$uploaded_file." -f mjpeg -t 0:0:1.000 -s 180x150 /home/starcrew/public_html/uploads/attachments/videos/thumbnail/".$thumbfile;
									exec($gocmd);
									unlink("../uploads/attachments/videos/temp/".$uploaded_file);
								}//file ext
								else{
									$file_name = $db ->generalfileupload($_FILES['Filedata'] , $targetPath, 1);
								}
								$db->data("video", $file_name);
						}
						elseif(in_array($fileExtention, $adofileArray))
						{
							/** Type:Audio */
							$file_name = $db ->generalfileupload($_FILES['Filedata'] , $targetPath."/audio/", 1);
							$db->data("audio", $file_name);
						}
						elseif(in_array($fileExtention, $photofileArray))
						{		
			
							/** Type:photo */
							$file_name = $db ->generalfileupload($_FILES['Filedata'] , $targetPath."/photo/", 1);
							$db->data("photo", $file_name);
						}
					}
//		$db->data("attachments", $file_name);
	
			$MID=$db->cgi("messages", "");
		unset($db->SQL);unset($db->fl);unset($db->vl);
			// ******   ****** //

		$db->fl = array();$db->vl = array();


			#========== For single entry at a time ============= #
			$otto  = $to_id;		// since one entry at a time
			//print_r($to);echo"<br><br>";

			#========== For multiple entries at a time ============= #
			//	$to = explode(",",$to_id);
			//$to = array_unique($to);
			//	$otto = implode(",",$to);

				//echo $otbx."====>";exit;
		
				// 			for($i=0;$i<sizeof($to);$i++)
				// 			{
				// 				//implode array for mutliple recored entered through 1 qury
				// 
				// 				if($to[$i] != $from_id)
				// 				{	// user cannot send message to himself
				// 					$inbx .="(". $to[$i].",".$MID.",".$from_id .",0),";
				// 					//$otbx .="(". $to[$i].",".$MID.",".$from_id .",0),";
				// 				}
				// 			}
				// 				$inbx = substr($inbx,0,-1); 
				// 				$otbx = "('".$otto."',". $MID.",".$from_id.",0)";

			#========== For single entry at a time ============= #
			$inbx  = "(". $to_id.",".$MID.",".$from_id .",0)";
			$otbx  = "(". $to_id.",".$MID.",".$from_id .",0)";

			// 		$fp = fopen("sam.txt","w");
			// 		fwrite($fp,$inbx ."==" . $otbx);
			// 		fclose($fp);

			$inbox_sql = "insert into inbox(TO_ID,MID,FROM_ID,flag) VALUES".$inbx;
			$outbox_sql = "insert into outbox(TO_ID,MID,FROM_ID,flag) VALUES".$otbx;
	
			$inboxrs = $db->customqry($inbox_sql,"0");
			$outboxrs = $db->customqry($outbox_sql,"0");
		exit;
	}

$filename = basename($_SERVER['PHP_SELF']);
include_once(ABSPATH."/templates/".TEMPLATEDIR."/modules/message/ajax/".$filename);
?>