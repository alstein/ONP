<?php
	include_once("../../include.php");
	
	$id = $_GET['id'];

	$rs = $dbObj->cupdt('tbl_deal_payment_unique',"used",1,'uniqueid',$id,'');

	$payu = $dbObj->cgs("tbl_deal_payment_unique d left join tbl_offer_deal o on d.cus_dealid=o.offer_deal_id left join tbl_users u on d.	user_id =u.userid ","d.*,o.*,u.fullname","o.offer_deal_id",$id,"","","1");
	$payunique = @mysql_fetch_assoc($payu);
$product_name=	$payunique['product_name'] ;
$amount_spend =	$payunique['amount_spend '] ;
$discount=	$payunique['discount'] ;
$outflow =	$payunique['outflow'] ;
$redeem_from =	$payunique['redeem_from'] ;
$redeem_to=	$payunique['redeem_to'] ;
$bid_validity 	=	$payunique['bid_validity'] ;
$accepted_to_paid =	$payunique['accepted_to_paid'] ;
$coupon_id =	$payunique['coupon_id'] ;
$user_name=	$payunique['fullname'] ;
/*
	$dealpay_res = $dbObj->customqry("SELECT SUM(deal_quantity) qty FROM tbl_deal_payment WHERE deal_id = ".$payunique['deal_id'],"");
	$dealpay_row = @mysql_fetch_assoc($dealpay_res);

	$dealpayment_res = $dbObj->customqry("SELECT * FROM tbl_deal_payment WHERE pay_id = ".$payunique['pay_id'],"");
	$dealpayment_row = @mysql_fetch_assoc($dealpayment_res);

	$res_user2 = $dbObj->cgs("tbl_users","*","userid",$payunique['user_id'],"","","");
	$userData = @mysql_fetch_assoc($res_user2);

	$res_deal4 = $dbObj->cgs("tbl_deal","*","deal_unique_id",$payunique['deal_id'],"","","");
	$dealData = @mysql_fetch_assoc($res_deal4);

	if(is_numeric($dealData['deal_from_seller_name']))
	{
		$res_seller = $dbObj->cgs("tbl_users","*","userid",$dealData['deal_from_seller_name'],"","","");
		$sellerData = @mysql_fetch_assoc($res_seller);
	}else
	{
		$sellerData['fullname'] = $dealData['deal_from_seller_name_other'];
	}
//echo $dealData['qr_code_image']."hello";


//////// START Assigning all variables ///////////

	// if($dealData['deal_currency'] == 'euro') $curr_type = '&#8364;'; else $curr_type = (($dealData['deal_currency'] == 'pound') ? '&#163;' : '$');

	if($dealData['deal_currency'] == 'euro') $curr_type = "<img src='".SITEROOT."/pdf/images/euro.jpeg' height='18'>"; else $curr_type = (($dealData['deal_currency'] == 'pound') ? "<img src='".SITEROOT."/pdf/images/pound.jpeg' height='18'>" : '$');

	$purchaseQty = $dealpay_row['qty'];

	if($dealData['range_1'] == 'true')
	{
		if($dealData['min_buyer_1'] <= $purchaseQty && $dealData['max_buyer_1'] >= $purchaseQty)
			$buy_price = $dealData['buy_price_1'];
		else
		{
			if($dealData['range_2'] == 'true')
			{
				if($dealData['min_buyer_2'] <= $purchaseQty && $dealData['max_buyer_2'] >= $purchaseQty)
					$buy_price = $dealData['buy_price_2'];
				else
				{
					if($dealData['range_3'] == 'true')
					{
						if($dealData['min_buyer_3'] <= $purchaseQty && $dealData['max_buyer_3'] >= $purchaseQty)
							$buy_price = $dealData['buy_price_3'];
						else
						{
							if($dealData['range_4'] == 'true')
							{
								if($dealData['min_buyer_4'] <= $purchaseQty && $dealData['max_buyer_4'] >= $purchaseQty)
									$buy_price = $dealData['buy_price_4'];
								else
								{
									if($dealData['range_5'] == 'true')
									{
										if($dealData['min_buyer_5'] <= $purchaseQty && $dealData['max_buyer_5'] >= $purchaseQty)
											$buy_price = $dealData['buy_price_5'];
									}else
										$buy_price = $dealData['groupbuy_price'];
								}
							}else
								$buy_price = $dealData['groupbuy_price'];
						}
					}else
						$buy_price = $dealData['groupbuy_price'];
				}
			}else
				$buy_price = $dealData['groupbuy_price'];
		}
	}else
		$buy_price = $dealData['groupbuy_price'];


	$dealCurr 			=	 $curr_type;
	$yourPrice 			=	 $buy_price;
	$deliveryCharg			=	 $dealpayment_row['delivery_charges'];
	$dealTitle 			=	 html_entity_decode($dealData['title']);
	$dealDesc 			=	 html_entity_decode($dealData['description']);
	$couponId 			=	 $payunique['coupon_id'];
	$validFrom 			=	 date('d-m-Y', strtotime($dealData['validfrom']));
	$validTo 				=	 date('d-m-Y', strtotime($dealData['validto']));
	if($dealData['medium_image']){
		$dealImgPath 		=	 SITEROOT."/uploads/product/thumb332X290/".$dealData['medium_image'];
	}else{
		$dealImgPath 		=	 SITEROOT."/templates/default/images/thumb332X290.jpg";
	}
	$sellerName 			=	 $sellerData['fullname'];
	$finePrint 			=	 html_entity_decode($dealData['fineprint']);
	$voucherDesc 			=	 $dealData['voucher_text'];
	$how_it_work 			=	 html_entity_decode($dealData['howitwork']);
	if($dealData['qr_code_image']){
		$deal_qrimg_Path 	=	 SITEROOT."/uploads/qr_code/real/".$dealData['qr_code_image'];
	}else{
		$deal_qrimg_Path 	=	 SITEROOT."/templates/default/images/thumb332X290.jpg";
	}*/

///////// END Assigning all variables ////////////

///////// START Barcode image code ////////////

// 	$barcode_image = "";
// 	if(strlen(trim($payunique['coupon_id'])) > 0)
// 	{
// 		$barcode = $payunique['coupon_id'];
// 		$style = 164;
// 		$type = "C128A";
// 		$width = 195;
// 		$height = 68;
// 		$xres = 1;
// 		$font = 5;
// 		$barcode_image = "<img src='".SITEROOT."/includes/barcode/image.php?code=".$barcode."&style=".$style."&type=".$type."&width=".$width."&height=".$height."&xres=".$xres."&font=".$font."'>";
// // echo $barcode_image;exit;
// 	}
// '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid from '.$validFrom.' to '.$validTo.'
///////// END Barcode image code ////////////
?>

<?php
//----------------------- Code for pdf generation --------------------
include_once('../../includes/pdf_generate/html2pdf.class.php');

$html2pdf = new HTML2PDF('P', 'A4', 'en');
//$html2pdf = new HTML2PDF('P','A3', 'en', array(9, 9, 10, 8));
// <img src="../../pdf/images/logo.jpg" width="187" height="74">
$var ='
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
  <tr>
    <td  width="700" style="background:#f3f3f3; padding:6px;"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="687" height="110" align="left" valign="middle" bgcolor="#FFFFFF"><table width="687" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td width="187"></td>
            <td width="258" ><div style="padding:15px 15px; text-align:center";>'.substr(wordwrap($voucherDesc, 40, "<br>\n", true),0,250).'</div></td>
            <td width="195"></td>
            <td width="26">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td width="687" height="43" style="font-size:23px; color:#333333; font-weight:bold;">Voucher</td>
      </tr>
      <tr>
        <td width="687" style="background:#FFFFFF; padding:6px;">
        <table width="675" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="675" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="279"></td>
                <td width="20">&nbsp;</td>
                <td width="376" valign="top"><table width="376" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; font-weight:bold; color:#4d4d4d;">'.$product_name.'</td>
                  </tr>
                  <tr>
                    <td width="376" height="12"></td>
                  </tr>
                  <tr>
                     <td width="376" style="font-size:12px; color:#cc0000; font-weight:bold;">Consumer Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$user_name.'</td>
                  </tr>
                  <tr>
                    <td width="376" height="26"></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Amount Spend: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$amount_spend.'</td>
                  </tr>
                  <tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Discount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$discount.'</td>
                  </tr>
		<tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Redeem From: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$redeem_from.'</td>
                  </tr>
			<tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Redeem To: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$redeem_to.'</td>
                  </tr>
			<tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Bid Valid Till: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$bid_validity.'</td>
                  </tr>
		<tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Accepted To Paid: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$accepted_to_paid.'</td>
                  </tr>
		<tr>
                    <<td width="376" style="font-size:12px;; color:#cc0000; font-weight:bold;">Coupon Id : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$coupon_id.'</td>
                  </tr>
                 
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="7"></td>
          </tr>
          <tr>
            <td width="675" style="border:solid 1px #c8c8c8; background:#f3f3f3;"><table width="675" border="0" cellspacing="0" cellpadding="0">
              
            </table></td>
          </tr>
          
          <tr>
            <td><table width="675" border="0" cellspacing="0" cellpadding="0">
              
              <tr>
                <td width="675"><table width="675" border="0" cellspacing="0" cellpadding="0">
                  
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
      </tr>
       
     
     
      <tr>
   <td width="687" align="center" style="background:#FFFFFF; font-size:13px; padding:6px;">Any questions: Customer Support: 02035100410, weekdays 9am - 6pm , Email us: support@gmail.com</td>
      </tr>
      <tr>
        <td width="687" height="7"></td>
      </tr>
     
      <tr>
        <td width="687" height="10"></td>
      </tr>

    </table></td>
  </tr>
</table>
';


// How It Work Section HTML 
/////////////////////////////////
/*
<table width="668" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="329"><img src="../../pdf/images/howitwork-1.jpg" width="329" height="44"></td>
		<td width="10">&nbsp;</td>
		<td width="329"><img src="../../pdf/images/howitwork-2.jpg" width="329" height="44"></td>
	</tr>
	<tr>
		<td height="10"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td><img src="../../pdf/images/howitwork-3.jpg" width="329" height="44"></td>
		<td>&nbsp;</td>
		<td><img src="../../pdf/images/howitwork-4.jpg" width="329" height="44"></td>
	</tr>
</table>
*/
/////////////////////////////////


//echo $var; die();



$kl = $l+1;
//$html2pdf->WriteHTML($var,1);
$html2pdf->WriteHTML($var,0);
$pdf_newname=$payunique['coupon_id'].'.pdf';

//unlink old pdf file before create new
if(file_exists("../../pdf/".$pdf_newname))
{
	@unlink("../../pdf/".$pdf_newname);
}

$html2pdf->Output("../../pdf/".$pdf_newname,"F");

$pdfdoc=$html2pdf->Output("../../pdf/".$pdf_newname,"S");

//$attachment[$l]['pdfdoc'] = chunk_split(base64_encode($pdfdoc));

//-----------Unlink jpg image--------------------------------
if(file_exists("../../pdf/gmapimg/gmappdf_".$_SESSION['csUserId']."_.jpg"))
{
	@unlink("../../pdf/gmapimg/gmappdf_".$_SESSION['csUserId']."_.jpg");
}

header("location:../../pdf/".$pdf_newname);
?>