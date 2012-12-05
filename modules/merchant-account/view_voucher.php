<?php
	include_once("../../include.php");

// $selct_coupons_deatils=$dbObj->customqry('tbl_deal_payment_unique',"used",1,'uniqueid',$id,'');
$tbl="tbl_deals d left join tbl_deal_payment_unique du on d.deal_unique_id=du.deal_id left join tbl_users u on du.user_id=u.userid left join tbl_users u1 on d.merchant_id=u1.userid";
$res_user2 = $dbObj->cgs($tbl,"u1.business_start_date1,u1.business_start_date1,u1.	contact_detail,u1.business_name,d.deal_title,d.original_price,d.discount_in_per,d.offer_price,du.coupon_id,u.first_name,u.last_name,d.conditions, 	d.why_buy1,d.why_buy2,d.why_buy3,d.why_buy4,d.why_buy5,d.deal_image,u1.first_name as fname,u1.last_name as lname ,u1.address1,d.deal_end_date,d.redeem_from,d.redeem_to	","du.uniqueid",$_GET['id'],"","","");
$fetch_coupon_det=@mysql_fetch_assoc($res_user2);
$arr=explode(" ",$fetch_coupon_det['redeem_from']);
$redeem_from=explode("-",$arr[0]);
$redeem_from1=$redeem_from[2]."-".$redeem_from[1]."-".$redeem_from[0];
$arr1=explode(" ",$fetch_coupon_det['redeem_to']);
$redeem_to=explode("-",$arr1[0]);
$redeem_to1=$redeem_to[2]."-".$redeem_to[1]."-".$redeem_to[0];
$arr=explode(":",$fetch_coupon_det['business_start_date1']);
$business_start_date1=$arr[0].":".$arr[1];
$arr1=explode(":",$fetch_coupon_det['business_end_date1']);
$business_end_date1=$arr1[0].":".$arr1[1];
//----------------------- Code for pdf generation --------------------
include_once('../../includes/pdf_generate/html2pdf.class.php');
$logo =SITEROOT."/templates/default/images/offernpals_logo.png";
$barcode =SITEROOT."/templates/default/images/barcode.jpg";
$image =SITEROOT."/uploads/deal/".$fetch_coupon_det['deal_image'];
$bullets =SITEROOT."/templates/default/images/bullets.jpg";
$html2pdf = new HTML2PDF('P', 'A4', 'en');
//$html2pdf = new HTML2PDF('P','A3', 'en', array(9, 9, 10, 8));
// <img src="../../pdf/images/logo.jpg" width="187" height="74">

if($fetch_coupon_det['why_buy1']!="")
	$why_buy= '<p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['why_buy1'].'</p>';
if($fetch_coupon_det['why_buy2']!="")
	$why_buy.= '<p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['why_buy2'].'</p>';
if($fetch_coupon_det['why_buy3']!="")
	$why_buy.= '<p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['why_buy3'].'</p>';
if($fetch_coupon_det['why_buy4']!="")
	$why_buy.= '<p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['why_buy4'].'</p>';
if($fetch_coupon_det['why_buy5']!="")
	$why_buy.= '<p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['why_buy5'].'</p>';



$var ='
<table border="0" cellpadding="0" cellspacing="0" width="701" style="border:1px solid #000000">
  <tr>
    <td height="80" style="background-color:#000000;" colspan="2"><table width="701" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20">&nbsp;</td>
          <td width="455"><img src="'.$logo.'" title="" alt="" width="251" height="51"/></td>
          <td width="226"><img src="'.$barcode.'" title="" alt=""  width="209" height="45"/></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td width="681" style="font:bold 23px Arial, Helvetica, sans-serif; color:#cc0000"><b>Voucher - "'.$fetch_coupon_det['business_name'].' "</b></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td colspan="0" width="681" style="font:bold 21px Arial, Helvetica, sans-serif; color:#2b587a"><b>'.$fetch_coupon_det['discount_in_per'].'% Off On '.$fetch_coupon_det['deal_title'].'</b><br><span style="font:normal 17px Arial, Helvetica, sans-serif; color:#404040; display:block">Deal Tagline: "'.$fetch_coupon_det['deal_title'].'" </span></td>
  </tr>
  <tr>
    <td height="10" colspan="2"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td colspan="0" width="701">
    <table width="652" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="287"><img src="'.$image.'" title="" alt="" width="287" height="" /></td>
          <td width="20">&nbsp;</td>
          <td width="345">
          <table width="345" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d" width="345"><b> Deal Value:</b> <span style="color:#020305"><b>$'.$fetch_coupon_det['original_price'].'</b></span></td>
              </tr>
              <tr>
                <td style="font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d" width="345"><b> Discount:</b> <span style="color:#020305"><b>'.$fetch_coupon_det['discount_in_per'].'%</b></span></td>
              </tr>
              <tr>
                <td height="5" width="345">&nbsp;</td>
              </tr>
              <tr>
                <td height="84" width="345" style="background-color:#f4f3f8"><p style="font:bold 21px Arial, Helvetica, sans-serif; color:#cc0000; text-align:center; margin:0"><b>Deal Price:</b> </p>
                  <p style="font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d; text-align:center; margin:0"><b>$'.$fetch_coupon_det['offer_price'].'</b></p></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="10" colspan="3"></td>
        </tr>
        <tr>
          <td height="48" colspan="3" style="background-color:#f3f3f3; border:1px solid #c8c8c8; vertical-align:middle">
          <table width="644" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="27">&nbsp;</td>
                <td width="296" style="vertical-align:middle; font:bold 17px Arial, Helvetica, sans-serif; color:#bd1616"><b>Unique id no. : '.$fetch_coupon_det['coupon_id'].'</b></td>
                <td width="320" style="vertical-align:middle; font:bold 17px Arial, Helvetica, sans-serif; color:#020305"><b>Redeem From :-'.$redeem_from1.'  To:- '.$redeem_to1.'</b></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="10" colspan="3"></td>
        </tr>
        <tr>
          <td colspan="3">
          <table width="644" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="316" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top"><span style="color:#2f527d"><b>Recipients Name:</b></span><b>'.$fetch_coupon_det['first_name'].' '.$fetch_coupon_det['last_name'].'</b></td>
                <td width="316" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top"><span style="color:#2f527d; display:block;"><b>Deal Location:</b></span> <br/>
                  <p style="margin:0; font:bold 12px Arial, Helvetica, sans-serif; color:#353537; line-height:20px">'.$fetch_coupon_det['address1'].'</p></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="20" colspan="3"></td>
        </tr>
        
        <tr>
          <td height="10" colspan="3"></td>
        </tr>
        <tr>
          <td colspan="3" style="vertical-align:top; font:normal 12px Arial, Helvetica, sans-serif; color:#2b587a; line-height:18px"><span style="font:bold 14px Arial, Helvetica, sans-serif; color:#cc0000"><b>Deal terms & Conditions:</b></span><br/>
            <p style="margin:0"><img src="'.$bullets.'" title="" alt="" width="6" height="6"/>&nbsp;'.$fetch_coupon_det['conditions'].' </p></td>
        </tr>
        <tr>
          <td height="10" colspan="3"></td>
        </tr>
      </table></td>
  </tr>
</table>';



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