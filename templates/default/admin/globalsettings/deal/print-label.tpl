<html>
<body>
<div style="border:1px solid #000; width:940px; margin:0 auto;">
  <div style="padding-left:20px; padding-top:20px"><img src="{$siteroot}/templates/default/images/template_logo.png" alt="logo" /></div>
  <div style="float:left; width:470px">
    <h2 style="color:#87B400; font-size:20px;margin-left:20px;">Packing Slip</h2>
    <div style="padding-left:20px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30px;" style="vertical-align:top;"  align="right"><strong>Deliver To:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$user.first_name}&nbsp;{$user.last_name}</td>
        </tr>
	 
        <tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Address:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$user.address1|wordwrap:30:"<br />\n"}</td>
        </tr>
        <tr>
          <td height="30px;" style="vertical-align:top;padding-top:3px;" align="right"><strong>Email:&nbsp;</strong></td>
          <td style="vertical-align:top;padding-top:3px;">{$user.email}</td>
        </tr>
	 <tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Username:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$user_array.username}</td>
        </tr>		
       
      </table>
    </div>
  </div>
  <div style="float:left; width:470px; margin-top:56px">
    <div style="padding-left:3px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="30px;" style="vertical-align:top;" width="25%" align="right"><strong>From:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$seller.first_name}&nbsp;{$seller.last_name}</td>
        </tr>
        <tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Address:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$seller.address1|wordwrap:30:"<br />\n"}</td>
        </tr>
        <tr>
          <td height="30px;" style="vertical-align:top;padding-top:3px;" align="right"><strong>Email:&nbsp;</strong></td>
          <td style="vertical-align:top;padding-top:3px;">{$seller.email}</td>
        </tr>
	 <tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Username:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$seller.username}</td>
        </tr>
        <!--<tr>
          <td><strong>Auction ID</strong></td>
          <td>12345</td>
        </tr>-->
        
      </table>
    </div>
  </div>
	<table style="padding-left:20px; padding-top:20px">
	<tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Deal Name:&nbsp;</strong></td>
          <td height="30px;" style="vertical-align:top;">{$deal.title}</td>
        </tr>
        <tr>
          <td height="30px;" style="vertical-align:top;" align="right"><strong>Transaction ID:&nbsp;</strong></td>
          <td style="vertical-align:top;">{$deal_pay_info.transaction_id}</td>
        </tr>

	</table>

	<div style="float:left;padding-left:20px;margin-top:20px;width:95%">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <col width="147" />
      <col width="147" />
      <col width="147" />
      <tr>
        <td width="15%" height="30px;"><strong>Item #</strong></td>
        <td width="35%"><strong>Item Title</strong></td>
        <td width="10%" align="center"><strong>Qty</strong></td>
	 <td width="10%" align="center"><strong>Price</strong></td>
	<td width="10%" align="center"><strong>Total</strong></td>
	<td width="10%" align="center"><strong>Delivery</strong></td>
        <td width="10%" align="center"><strong>Subtotal</strong></td>
      </tr>
      <tr>
        <td><strong>{$deal.deal_unique_id}</strong></td>
        <td><strong>{$deal.title}</strong></td>
        <td align="center"><strong>{$deal_pay_info.deal_quantity}</strong></td>
	<td align="center"><strong>&pound;{$deal.groupbuy_price}</strong></td>
	  <td align="center"><strong>&pound;{$total}</strong></td>
	  <td align="center"><strong>&pound;{$delivery}</strong></td>
        <td align="center"><strong>&pound;{$subtotal}</strong></td>
      </tr>
	<tr><td colspan="7" style="border-bottom:1px solid #000;">&nbsp;</td></tr>
	<tr>
		<td style="vertical-align:top;padding-top:15px;"><strong>Note:</strong></td>
		<td colspan="6" style="vertical-align:top;padding-top:15px;">{$deal.notes}</td>
	</tr>
	
	<tr><td colspan="7" style="border-bottom:1px solid #000;">&nbsp;</td></tr>
      <tr>
        <td align="right" colspan="7" style="padding-top:18px;"><a  onClick="window.print();"><img src="{$siteroot}/templates/default/images/print.png" alt="image" style="border:none" /></a></td>
      </tr>
    </table>
  </div>
  <div style="clear:both">&nbsp;</div>
  
</div>
</body>
</html>