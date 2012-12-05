<?php
	include_once("../../include.php");

$tbl="tbl_offer_deal d left join tbl_deal_payment_unique du on d.offer_deal_id=du.cus_dealid left join tbl_users u on d.merchant_id=u.userid left join tbl_users u1 on d.user_id=u1.userid";
$sf="d.*,u.fullname,u1.fullname";
$cd="d.offer_deal_id=".$_GET['id'];
$res=$dbObj->gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, "1");

// $selct_coupons_deatils=$dbObj->customqry('tbl_deal_payment_unique',"used",1,'uniqueid',$id,'');
$tbl="tbl_deals d left join tbl_deal_payment_unique du on d.deal_unique_id=du.deal_id left join tbl_users u on du.user_id=u.userid left join tbl_users u1 on d.merchant_id=u1.userid";
$res_user2 = $dbObj->cgs($tbl,"u1.business_start_date1,u1.business_start_date1,u1.	contact_detail,d.deal_title,d.original_price,d.discount_in_per,d.offer_price,du.coupon_id,u.first_name,u.last_name,d.conditions, 	d.why_buy1,d.deal_image,u1.first_name as fname,u1.last_name as lname ,u1.address1,d.deal_end_date,d.redeem_from,d.redeem_to	","du.uniqueid",$_GET['id'],"","","1");
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
$logo =SITEROOT."/templates/default/images/logopdf.jpg";
$barcode =SITEROOT."/templates/default/images/barcode.jpg";
$image =SITEROOT."/uploads/deal/".$fetch_coupon_det['deal_image'];
$bullets =SITEROOT."/templates/default/images/bullets.jpg";
$html2pdf = new HTML2PDF('P', 'A4', 'en');
//$html2pdf = new HTML2PDF('P','A3', 'en', array(9, 9, 10, 8));
// <img src="../../pdf/images/logo.jpg" width="187" height="74">

$var='<table width="701" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="width:701px; border:1px solid #2f527d"><table width="701" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="701" height="80" style="background-color:#2f527d">
          
          <table width="701" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="474" style="vertical-align:middle; padding-left:20px"><img src="images/logo.jpg" title="" alt=""  width="251" height="51"/></td>
                <td width="225" style="vertical-align:middle"><img src="images/barcode.png" title="" alt="" width="209" height="45"/></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td width="701" style="padding:20px 26px">
          <table width="649" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" style="font:bold 23px Arial, Helvetica, sans-serif; color:#cc0000; padding-bottom:8px">Voucher -  ___% Discount At <span style="color:#2f527d">(John Smith)</span> </td>
              </tr>
              
              <tr>
                
                <td width="701" colspan="2" style="padding:14px 20px; background-color:#f3f3f3;  font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d; line-height:20px">
                <p style="margin:0; padding:0; line-height:28px">Min Amount To Be Spent: <span style="color:#020305">$1500</span></p>
                 <p style="margin:0; padding:0; font:bold 21px Arial, Helvetica, sans-serif; color:#2f527d; line-height:28px"> Discount: <span style="color:#020305">20%</span></p>
                  <p style="margin:0; padding:0; font:bold 21px Arial, Helvetica, sans-serif; color:#cc0000; line-height:28px">Deal Price:<span style="color:#020305"> $1200</span></p>
                
                </td>
              </tr>
              
              <tr>
              <td colspan="2" height="5">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" height="48" style="background-color:#f3f3f3; border:1px solid #c8c8c8"><table width="646" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="323" style="padding-left:27px; font:bold 17px Arial, Helvetica, sans-serif; color:#bd1616; vertical-align:middle">Unique id no. : C09CCB1570</td>
                      <td width="323" style="font:bold 17px Arial, Helvetica, sans-serif; color:#020305; vertical-align:middle">Valid from 28.10.2011 to 31.01.2012</td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td style="padding:14px 0; vertical-align:top" width="323"><p style="margin:0; padding:0; font:bold 14px Arial, Helvetica, sans-serif;"><span style="color:#2f527d">Recipient’s Name:</span> <abbr style="color:#020305">John Smith</abbr></p></td>
                <td style="padding:14px 0; vertical-align:top" width="323"><p style="margin:0 0 8px; padding:0; font:bold 14px Arial, Helvetica, sans-serif; color:#2f527d">Deal Location:</p>
                  <p style="margin:0; padding:0; font:bold 12px Arial, Helvetica, sans-serif; color:#353537; line-height:18px">Goethe-Institut,<br/>
                    72 Spring Street, <br/>
                    11th Floor New York, NY 10012.</p></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:18px"><p style="margin:0 0 10px; padding:0; font:bold 14px Verdana, Geneva, sans-serifa; color:#cc0000">Deal Restriction :</p>
                  <p style="margin:0 0 3px; padding:0; font:normal 12px Verdana, Geneva, sans-serifa; color:#2b587a"><img src="images/bullets.jpg" title="" alt="" width="6" height="6" />&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel enim neque.Ut mollis tempus</p>
                  <p style="margin:0 0 3px; padding:0; font:normal 12px Verdana, Geneva, sans-serifa; color:#2b587a"><img src="images/bullets.jpg" title="" alt="" width="6" height="6" />&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel enim neque.Ut mollis tempus</p></td>
              </tr>
              <tr>
                <td colspan="2"><p style="margin:0 0 10px; padding:0; font:bold 14px Verdana, Geneva, sans-serifa; color:#cc0000">Deal terms & Conditions:</p>
                  <p style="margin:0 0 3px; padding:0; font:normal 12px Verdana, Geneva, sans-serifa; color:#2b587a"><img src="images/bullets.jpg" title="" alt="" width="6" height="6" />&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel enim neque.Ut mollis tempus</p>
                  <p style="margin:0 0 3px; padding:0; font:normal 12px Verdana, Geneva, sans-serifa; color:#2b587a"><img src="images/bullets.jpg" title="" alt="" width="6" height="6" />&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel enim neque.Ut mollis tempus</p></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td style="padding:10px 0"><p style="font:normal 12px Arial, Helvetica, sans-serif; color:#333333; text-align:center">Any questions: Customer Support: 02035100410, weekdays 9am - 6pm , Email us: support@companyname.com</p></td>
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