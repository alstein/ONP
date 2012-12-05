<?php
	include_once("../../include.php");

$tbl="tbl_offer_deal d left join tbl_deal_payment_unique du on d.offer_deal_id=du.cus_dealid left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid";
$sf="d.*,u.fullname,u.fullname as merchant_name,u1.fullname as cust_name,du.coupon_id,u.address1 as merchant_address,u.contact_detail as phone,u.userid as merchant_userid,u.business_name";
$cd="d.offer_deal_id=".$_GET['id'];
$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, "");
$row=@mysql_fetch_array($res);

$qres=$dbObj->customqry("select * from tbl_deal_condition where merchant_id=".$row['merchant_userid'],"");
$qrow=mysql_fetch_array($qres);

if($row['redeemtype']=="0")
	$redeem='Redeem from '.date("j F Y",strtotime($row['redeem_from'])).' to '.date("j F Y",strtotime($row['redeem_to']));
else
	$redeem='Redeem on '.date("j F Y",strtotime($row['redeem_from']));

//----------------------- Code for pdf generation --------------------
include_once('../../includes/pdf_generate/html2pdf.class.php');
$logo =SITEROOT."/templates/default/images/logopdf.jpg";
$barcode =SITEROOT."/templates/default/images/barcode.jpg";
$image =SITEROOT."/uploads/deal/".$fetch_coupon_det['deal_image'];
$bullets =SITEROOT."/templates/default/images/bullets.jpg";
$html2pdf = new HTML2PDF('P', 'A3', 'en');


$outflow1=$row['outflow'];
$outflow= number_format($outflow1, 1, '.', '');
$amt_to_pin1=$row['amt_to_pin'];
$amt_to_pin= number_format($amt_to_pin1, 1, '.', '');
$accepted_to_paid1=$row['accepted_to_paid'];
$accepted_to_paid= number_format($accepted_to_paid1, 1, '.', '');
//$html2pdf = new HTML2PDF('P','A4', 'en', array(9, 9, 10, 8));
// <img src="../../pdf/images/logo.jpg" width="187" height="74">

$var='<table border="0" cellpadding="0" cellspacing="0" width="701" style="border:1px solid #000000">
  <tr>
    <td height="80" style="background-color:#000000;" colspan="2" ><table width="701" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20"></td>
          <td width="455" ><img src="'.SITEROOT.'/templates/default/images/offernpals_logo.png" title="" alt="" width="250" height="61"/></td>
          <td width="226"><img src="'.SITEROOT.'/templates/default/images/barcode.png" title="" alt=""  width="209" height="45"/></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td  width="681" style="font:bold 23px Arial, Helvetica, sans-serif; color:#cc0000">Voucher - '.$row['discount'].'% Discount At <span style="color:#2f527d">('.$row['business_name'].')</span></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td  width="681"><table width="644" border="0" cellspacing="0" cellpadding="0" style="background-color:#f3f3f3">
        <tr>
          <td width="644"  height="10" colspan="2" ></td>
        </tr>
        <tr>
          <td width="17"></td>
          <td width="627" style="font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d">
			<p style="margin:0; ">Amount to be Spent: <span style="color:#020305">$'.$row['amount_spend'].'</span></p>
            <p style="margin:0; ">Discount: <span style="color:#020305">'.$row['discount'].'%</span></p>
            <p style="margin:0">Net Amount To Pay:<span style="color:#020305">$'.$outflow.'</span></p>
			<p style="margin:0">Amount Paid to OffersnPals:<span style="color:#020305">$'.$amt_to_pin.'</span></p>
			<p style="margin:0">Amount to Pay directly to Merchant:<span style="color:#020305">$'.$accepted_to_paid.'</span></p>
		  </td>
        </tr>
        <tr>
          <td width="644"  height="10" colspan="2"></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="2" ></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td  width="701"><table width="652" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="652" ></td>
        </tr>
        <tr>
          <td height="10" ></td>
        </tr>
        <tr>
          <td height="48"  style="background-color:#f3f3f3; border:1px solid #c8c8c8; vertical-align:middle"><table width="644" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="27"></td>
                <td width="296" style="vertical-align:middle; font:bold 17px Arial, Helvetica, sans-serif; color:#bd1616">Unique id no. : '.$row['coupon_id'].'</td>
                <td width="320" style="vertical-align:middle; font:bold 17px Arial, Helvetica, sans-serif; color:#020305">'.$redeem.'</td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="10" ></td>
        </tr>
        <tr>
          <td ><table width="644" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="316" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top"><span style="color:#2f527d">Merchant Name:</span>'.$row['business_name'].'<br><br><span style="color:#2f527d">Customer Name:</span>'.$row['cust_name'].'</td>

                <td width="316" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top"><span style="color:#2f527d; display:block;">Deal Location:</span> <br/>
                  <p style="margin:0; font:bold 12px Arial, Helvetica, sans-serif; color:#353537; line-height:20px">'.$row['merchant_address'].'</p>
                  <br/>
                  <span style="color:#2f527d; display:block;">Vendor Phone:</span> <br/>
                  <p style="margin:0; font:bold 12px Arial, Helvetica, sans-serif; color:#353537; line-height:20px">'.$row['phone'].'</p></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="20" ></td>
        </tr>
         <tr>
          <td height="10" ></td>
        </tr>
        <tr>
          <td style="vertical-align:top; font:normal 12px Arial, Helvetica, sans-serif; color:#2b587a; line-height:18px"><span style="font:bold 14px Arial, Helvetica, sans-serif; color:#cc0000">Deal terms & Conditions:</span><br/>
            <p style="margin:0"><img src="'.SITEROOT.'/templates/default/images/bullets.jpg" title="" alt="" width="6" height="6"/>&nbsp;'.$qrow['condition'].' </p>
		</td>
        </tr>
        <tr>
          <td height="10"></td>
        </tr>
      </table></td>
  </tr>
</table>';


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