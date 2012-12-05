<?php
	include_once("../../include.php");
	
	$id = $_GET['id'];

	$rs = $dbObj->cupdt('tbl_deal_payment_unique',"used",1,'uniqueid',$id,'');

	$payu = $dbObj->cgs("tbl_deal_payment_unique","","uniqueid",$id,"","","");
	$payunique = @mysql_fetch_assoc($payu);

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
	}

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
                <td width="279"><img alt="Deal Image" src="'.$dealImgPath.'" width="279" height="146"></td>
                <td width="20">&nbsp;</td>
                <td width="376" valign="top"><table width="376" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; font-weight:bold; color:#4d4d4d;">'.$dealTitle.'</td>
                  </tr>
                  <tr>
                    <td width="376" height="12"></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:12px;">'.$dealDesc.'</td>
                  </tr>
                  <tr>
                    <td width="376" height="26"></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; color:#cc0000; font-weight:bold;">Buy Value: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dealCurr.' '.$yourPrice.'</td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; color:#cc0000; font-weight:bold;">Delivery Charges: '.$dealCurr.' '.$deliveryCharg.'</td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; color:#cc0000; font-weight:bold;"><hr/></td>
                  </tr>
                  <tr>
                    <td width="376" style="font-size:21px; color:#cc0000; font-weight:bold;">Total: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dealCurr.' '.($yourPrice+$deliveryCharg).'</td>
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
              <tr>
                <td width="31" height="40" align="left" valign="top"></td>
                <td width="607" align="left" style="font-size:17px; font-weight:bold; color:#485d07;">Voucher Code: '.$couponId.'</td>
                <td width="37" align="left" valign="top"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="15"></td>
          </tr>
          <tr>
            <td><table width="675" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="675" style="font-size:14px; font-weight:bold;">The merchant: '.$sellerName.'</td>
              </tr>
              <tr>
                <td width="675"><table width="675" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="543" style="font-size:12px;">'.$finePrint.'</td>
                    <td width="20">&nbsp;</td>
                    <td id="qrCode" width="112" align="center">
                       <img src="'.$deal_qrimg_Path.'" width="64" height="64">
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        </td>
      </tr>
       <tr>
        <td width="687" height="43" style="font-size:23px; color:#333333; font-weight:bold;">how it works</td>
      </tr>
      <tr>
        <td width="687" align="center" style="background:#FFFFFF; padding:6px;">'.$how_it_work.'
        </td>
      </tr>
      <tr>
        <td height="7"></td>
      </tr>
      <tr>
   <td width="687" align="center" style="background:#FFFFFF; font-size:13px; padding:6px;">Any questions: Customer Support: 02035100410, weekdays 9am - 6pm , Email us: support@gmail.com</td>
      </tr>
      <tr>
        <td width="687" height="7"></td>
      </tr>
      <tr>
        <td width="687" style="font-size:12px;"><strong>Right to cancel</strong><br>
          Once we send you the Usortd, you may cancel the transaction at any time within 7 working days from the day after the day that you receive the Usortd (where a working day is any day that is not a Saturday, Sunday or public holiday). If you do want to cancel, you must do so by sending us an email to tell us you are cancelling to: support(at) usortd.co.uk or writing to us - in each case, always provided of course that you have not yet redeemed the Voucher. Usortd UK, No1 Liverpool Street, London, EC2M 7QD.</td>
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