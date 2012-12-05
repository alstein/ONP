<?php
include_once('../../../includes/SiteSetting.php');
include_once("../../../includes/barcode/sample.php");
include_once('../../../includes/pdf_generate/html2pdf.class.php');
include_once("../../../includes/phpqrcode/index.php");



$sql = "select deal_unique_id,min_buyer,title,groupbuy_price,seller_id,description,fineprint,highlight,medium_image,validfrom,validto,howitwork,shop_location,
deal_address,option_website from tbl_deal where deal_unique_id=".$_GET['id'];
$deal_rs = $dbObj->customqry($sql,"");
$row = @mysql_fetch_array($deal_rs);
#--end---#

//$rs = $dbObj->gj("tbl_deal_payment","*","deal_id = '".$row['deal_unique_id']."' and payment_done = 'no' and cancel_order = 'no'","","","","","");


$seller_rs = $dbObj->gj("tbl_users","userid,first_name,last_name,address1,address2,city,postalcode,email","userid='".$row['seller_id']."'","","","","","");
            $seller = @mysql_fetch_assoc($seller_rs);
           $sellernames=$seller['first_name']." ".$seller['last_name'];

$user_rs = $dbObj->gj("tbl_users","userid,first_name,last_name,address1,address2,city,postalcode,email","userid='".$row2['user_id']."'","","","","","");
            $user = @mysql_fetch_assoc($user_rs);

		$old_date1 = $row['validfrom'];             
                  $middle1 = strtotime($old_date1);              
                  $date1 = date('d-M-Y', $middle1);

		  $old_date2 =$row['validto'];             
                  $middle2 = strtotime($old_date2);              
                  $date2=date('d-M-Y', $middle2);	

		// Shop location
		if($row['shop_location'] != "")
                 {
			$delcity=wordwrap($row['shop_location'],30,"<br />\n");
                 }
		else
		{
			$delcity="";
		} 
                // deal address
		if($row['deal_address']	 != "")
                 {
			$deladdr=wordwrap($row['deal_address'],30,"<br />\n");
                 }
		else
		{
			$deladdr="";
		} 
		
		//website
		if($row['option_website'] != "")
                 {
			$webaddr=$row['option_website']	;
                 }
		else
		{
			$webaddr="";
		} 
		

#----barcode generation----#
$barcode=barcode($row2['order_date']);
$src=SITEROOT."/includes/phpqrcode/".$barcode;
$src='<img src="'.$src.'" />';  
#---end---#
	



		    $pdf = new FPDF();
		    $html2pdf = new HTML2PDF();
                    $html2pdf = new HTML2PDF('P', 'A3', 'fr', array(5, 10, 10, 10));


            $filedata = file_get_contents(SITEROOT."/email/pdftemplateview.html");
            $title="Group Buy It voucher for your deal -".$row['title'];
            $message = str_replace("[siteroot]",SITEROOT,$filedata);
            $message = str_replace("[buyer_name]",ucfirst($user['first_name'])." ".ucfirst($user['last_name']),$message);
           $message = str_replace("[seller_name]",$sellernames,$message);
            $message = str_replace("[deal_image]","default.jpg",$message);
            $message = str_replace("[amount]",$row2['deal_price'],$message);
            $message = str_replace("[voucher_code]",$row2['pay_unique_id'],$message);
            //$message = str_replace("[date1]",date('m-d-Y',$row2['charge_date']),$message);
            //$exp_date = explode("-",$row2['expiry_date']);
            //$message = str_replace("[date2]",$exp_date[1]."-".$exp_date[2]."-".$exp_date[0],$message);
	      $message = str_replace("[date1]",$date1,$message);
            $message = str_replace("[date2]",$date2,$message);	
            $message = str_replace("[title]",$row['title'],$message);
            $message = str_replace("[description]",stripslashes(html_entity_decode($row['description'])),$message);
           
            $message = str_replace("[src]",$src,$message);
	     $message = str_replace("[dealcity]",ucfirst($delcity),$message);
	      $message = str_replace("[shopaddr]",ucfirst($deladdr),$message);	
	      $message = str_replace("[webaddr]",$webaddr,$message);		
	    $message = str_replace("[howitwork]",html_entity_decode($row['howitwork']),$message);  	    
            $message = str_replace("[highlight]",($row['highlight']),$message);
            $docs= str_replace("[fineprint]",($row['fineprint']),$message);
					
            	 //echo $docs;exit; 
               	$html2pdf->WriteHTML($docs,0);
		$html2pdf->Output(time().'.pdf'); exit;



?>
