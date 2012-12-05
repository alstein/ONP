{include file=$header1}
{include file=$header2}

<h3>Seller information</h3>

<div class="holdthisTop">
      <span style="float:right;"> <h3><!-- <a href="{$siteroot}/admin/user/seller_list.php">--> <a href="javascript:void(0);" onclick="javascipt:history.go(-1);">Back <!--| <a href="{$siteroot}/admin/user/seller_information.php?userid={$smarty.get.userid}">Edit</a>--></h3> </span>

      <table width="100%" cellpadding="2" cellspacing="5" border="0" class="conttableDkBg conttable">
      <tr><td >
        <table width="100%" cellpadding="4" cellspacing="5" border="0">
          <tr><td width="25%" align="right"><strong>Member Type:</strong> </td><TD  align="left"> {if $user.usertypeid eq 1}Admin{/if}</td></tr>
          <tr><td width="25%" align="right"><strong>Username: </strong></td><TD  align="left"> {$user.username}</td></tr>
          <tr><td width="25%" align="right"><strong>First Name:</strong> </td><td  align="left"> {$user.first_name|@ucfirst}</td></tr>
          <tr><td width="25%" align="right"><strong>Last Name: </strong></td><TD  align="left"> {$user.last_name|@ucfirst}</td></tr>
          <tr><td align="right"><strong>Email Address: </strong></td><TD  align="left">{$user.email}</td> </tr>
                    <tr><td align="right"><strong>Postal Code: </strong></td><TD  align="left">{$user.postalcode}</td> </tr>
          <tr><td align="right"><strong>Registered Date:</strong> </td> <td align="left">{if $user.signup_date}{$user.signup_date|date_format} at {$user.signup_date|date_format:"%H:%M:%S"}{/if}</td></tr>
          <tr><td align="right"><strong>IP Address:</strong> </td> <td align="left">{$user.ipaddress}</td></tr>
          <tr><td align="right"><strong>Last Login:</strong> </td> <td align="left">{if $user.last_login}{$user.last_login|date_format} at {$user.last_login|date_format:"%H:%M:%S"}{/if}</td></tr>
          <tr>
              <td align="right" valign="top"><strong>Messages:</strong> </td>
              <td  align="left">
	      {if $user.tot_msg}<a href="{$siteroot}/admin/modules/user-message/user-message.php?uname={$user.username}" target="_blank">{$user.tot_msg}{else}0{/if}</a>
              </td>
          </tr>
          <tr>
	      <td align="right"><strong>History Of Purchases: </strong></td>
              <td>{if $user.tot_purchase}<a href="{$siteroot}/admin/globalsettings/deal/deal-purchase.php?uname={$user.username}&status=pending" target="_blank">{$user.tot_purchase}</a>{else}0{/if}</td> 
          </tr>
          <tr>
	      <td align="right"><strong>History Of Order: </strong></td>
              <td>{if $user.tot_order}<a href="{$siteroot}/admin/globalsettings/deal/deal-order.php?uname={$user.username}&status=pending" target="_blank">{$user.tot_order}</a>{else}0{/if}</td> 
          </tr>
          <tr>
              <td align="right"><strong>Rejected Listings: </strong></td>
              <td  align="left">{if $user.tot_cancel}<a href="{$siteroot}/admin/globalsettings/deal/rejected-deals.php?uname={$user.username}" target="_blank">{$user.tot_cancel}</a>{else}0{/if}</td>
          </tr>
          <tr>
              <td align="right" valign="top"><strong>Sold Product: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php?seller_id={$user.userid}&type=product" target="_blank">{$user.tot_soldproduct}{else}0{/if}</a> 
              </td>
           </tr>
          <tr>
              <td align="right" valign="top"><strong>Sold Voucher: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/globalsettings/deal/manage_complete_deal.php?seller_id={$user.userid}&type=service" target="_blank">{$user.tot_soldordr}</a>{else}0{/if} 
              </td>
           </tr>

          <tr>
              <td align="right" valign="top"><strong>Feedback: </strong></td>
              <td  align="left">
                  {if $user.tot_feedback}<a href="{$siteroot}/admin/modules/feedback/feedback.php?uname={$user.username}" target="_blank">{$user.tot_feedback}{else}0{/if}</a> 
              </td>
           </tr>
          <tr><td align="right"><strong>Disputes: </strong></td><TD  align="left"></td> </tr>
          <tr>
              <td align="right" valign="top"><strong>Forum Participation: </strong></td>
              <td  align="left">{if $user.tot_forum}<a href="{$siteroot}//admin/modules/forum/index.php?uname={$user.username}" target="_blank">{$user.tot_forum}</a>{else}0{/if}</td> 
          </tr>
          <tr><td align="right"><strong>Total Listing Fees Paid: </strong></td><TD  align="left">{$user.tot_paid}</td></tr>
           <tr><td align="right"><strong>Payment Method: </strong></td><TD  align="left">{$payment.payment_method}</td></tr>
           <tr><td align="right"><strong>Payment Details: </strong></td>
                <td  align="left">{$payment.details}</td></tr>
          <!--<tr><td align="right" valign="top"><strong>Status: </strong></td><td>{$user.status}</td></tr> -->
        </table>
      </TD></TR>
      </table> 

</div>
{include file=$footer}