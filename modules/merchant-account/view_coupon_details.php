<?php
	include_once("../../include.php");

//----------------------- Code for pdf generation --------------------
include_once('../../includes/pdf_generate/html2pdf.class.php');
$logo =SITEROOT."/templates/default/images/logo.jpg";
$barcode =SITEROOT."/templates/default/images/barcode.jpg";
$image =SITEROOT."/uploads/deal/".$fetch_coupon_det['deal_image'];
$bullets =SITEROOT."/templates/default/images/bullets.jpg";
$html2pdf = new HTML2PDF('P', 'A4', 'en');

$res = $dbObj->customqry("select d.*,u.fullname,u.business_name,d.posted_date as dposted_date from tbl_deals d left join tbl_users u on d.merchant_id=u.userid where   d.merchant_id='".$_SESSION['csUserId']."' and d.deal_unique_id='".$_GET['deal_id']."' group by d.deal_unique_id", "");
$mrow=mysql_fetch_array($res);


$rs=$dbObj->customqry("select u.fullname,dp.uniqueid,dp.coupon_id,d.deal_title from tbl_deal_payment_unique dp,tbl_deals d,tbl_users u where dp.deal_id=d.deal_unique_id and dp.user_id=u.userid and dp.deal_id=".$_GET['deal_id']." and d.merchant_id=".$_SESSION['csUserId'],"");
$num=@mysql_num_rows($rs);

//get the admin 

$adminperres=$dbObj->customqry("select customer_pay from tbl_merchant_pay where id=1","");
$adminperrow=@mysql_fetch_array($adminperres);

//get the admin 
$admin_paid1=($mrow['offer_price']*$adminperrow['customer_pay'])/100;
$admin_paid= number_format($admin_paid1, 1, '.', '');
$pay_to_merchant1=$mrow['offer_price']-$admin_paid;
$pay_to_merchant= number_format($pay_to_merchant1, 1, '.', '');
$offer_price1=$mrow['offer_price'];
$offer_price= number_format($offer_price1, 1, '.', '');



if($num>0){
	$list='<tr>
                <th scope="col" width="305" height="35" style="border:solid #C8C8C8; border-width:1px 1px 1px 0; background-color:#F3F3F3; font:bold 14px Arial, Helvetica, sans-serif; color:#BD1616; vertical-align:middle">Username</th>
                <th scope="col" width="130" height="35" style="border:solid #C8C8C8; border-width:1px 1px 1px 0; background-color:#F3F3F3; font:bold 14px Arial, Helvetica, sans-serif; color:#BD1616; vertical-align:middle">Coupon number</th>
                <th scope="col" width="215" height="35" style="border:solid #C8C8C8; border-width:1px 1px 1px 0; background-color:#F3F3F3; font:bold 14px Arial, Helvetica, sans-serif; color:#BD1616; vertical-align:middle">Coupon id</th>
              </tr>
';
}


$i=1;
if($num>0){
	while($voucher=@mysql_fetch_assoc($rs)){

$list.=' <tr>

                <td style="border:solid #C8C8C8; border-width:0 1px 1px 0; background-color:#F3F3F3; padding-left:10px; font:normal 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:middle" height="30" align="left">'.$voucher['fullname'].'</td>
                <td style="border:solid #C8C8C8; border-width:0 1px 1px 0; background-color:#F3F3F3; padding-left:10px; font:normal 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:middle" height="30" align="left">'.$i.'</td>
                <td style="border:solid #C8C8C8; border-width:0 1px 1px 0; background-color:#F3F3F3; padding-left:10px; font:normal 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:middle" height="30" align="left">'.$voucher['coupon_id'].'</td>
              </tr>
';
$i++;
	}
}else{
		$list.='<tr>
                <th scope="col" width="301" height="35" align="left" colspan="4">No Coupons found</th>
               
              </tr>';
}


$details='<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Deal Tagline:</span>'.$mrow['discount_in_per']." % on ".$mrow['deal_title']." at ".$mrow['business_name'].'</td>
          </tr>
			<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Date Offered:</span>'.date("j F, Y",strtotime($mrow['dposted_date'])).'</td>
          </tr>
		<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Original Price :</span>$'.$mrow['original_price'].'</td>
          </tr>
		<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Discount :</span>'.$mrow['discount_in_per'].'%</td>
          </tr>
		<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Offer Price :</span>$'.$offer_price.'</td>
          </tr>
		<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Amount Paid to OffersnPals :</span>$'.$admin_paid.'</td>
          </tr>
		<tr>
            <td width="644" style="font:bold 14px Arial, Helvetica, sans-serif; color:#020305; vertical-align:top" colspan="2"><span style="color:#2f527d">Amount To pay directly to Merchant:</span>$'.$pay_to_merchant.'</td>
          </tr>

';


$var ='
<table border="0" cellpadding="0" cellspacing="0" width="701" style="border:1px solid #000000">
  <tr>
    <td height="80" style="background-color:#000000;" colspan="3"><table width="701" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="455"><img src="'.SITEROOT.'/templates/default/images/offernpals_logo.png" width="250" height="61" title="" alt="" /></td>
          <td width="226"><img src="'.SITEROOT.'/templates/default/images/barcode.png" title="" alt=""  width="209" height="45"/></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="3"></td>
  </tr>
  <tr>
  <td width="20">&nbsp;</td>
    <td width="652" colspan="1"><table cellspacing="0" cellpadding="0" border="0" width="644">
        <tbody>

'.$details.'

        </tbody>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3"><table width="701" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20">&nbsp;</td>
          <td width="661"><table width="661" border="0" cellspacing="0" cellpadding="0">
				'.$list.'
            </table></td>
          <td width="20">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="3"></td>
  </tr>
  <tr>
    <td height="10" colspan="3"></td>
  </tr>
</table>
';


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
