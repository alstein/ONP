{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header2}
<div class="holdthisTop">
  <h3 class="fl width50">Manage Deal Order</h3>

  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

  <div class="fr">
    <form id="frm" name="frm" method="GET">
	<table>
	    <tr>
		<td>
		    <strong>Username: </strong> 
		      <select id="uname" name="uname" style="width:150px;" onchange="javascript:$('#frm').submit();">
			<option value="">Select</option>
			{section name=i loop=$user_list}
			{if $user_list[i].username}<option value="{$user_list[i].username}" {if $smarty.get.uname eq $user_list[i].username} selected="selected"{/if}>{$user_list[i].username}</option>{/if}
			{/section}
		      </select>
		</td>
                <td width="10px"></td>
		<td>
		  <strong> Deal Type: </strong> 
		    <select id="status" name="status" style="width:150px;" onchange="javascript:$('#frm').submit();">
		      <option value="pending" {if $smarty.get.status eq 'pending'} selected="selected" {/if}>Available</option>
		      <option value="expire" {if $smarty.get.status eq 'expire'} selected="selected" {/if}>expire</option>
		      <option value="all" {if $smarty.get.status eq 'all'} selected="selected" {/if}>All</option>
		    </select>
		</td>
	      </tr>
	  </table>
      </form>
  </div>
  <div class="clr">&nbsp;</div>
  <form name="frmAction" id="frmAction" method="post" action="">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<table width="100%"  border="0" cellpadding="10" cellspacing="2" class="listtable">
	    <tr class="headbg">
	      <!--<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>-->
	      <td width="15%" align="left" valign="top">Username</td>
	      <td width="15%" align="left" valign="top">Deal Name</td>
	      <td width="5%" align="left" valign="top">Qunitity</td>
	      <td width="10%" align="center" valign="top">Price</td>
	      <td width="10%" align="center" valign="top">Payment Confimed</td>	
	      <td width="10%" align="center" valign="top">Deal Type</td>	
	      <td width="15%" align="center" valign="top">Voucher Code</td>	
	      <td width="20%" align="center" valign="top">Dispatched</td>	 
	  </tr>
	  {section name=i loop=$product}
            {if $product[i].deal_quantity}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}">
	      <!--<td><input type="checkbox" value="{$feed_info[i].id}" name="mesgid[]"/></td>-->
	      <td align="left" valign="top">{$product[i].username }</td>
	      <td align="left" valign="top">{$product[i].title1}</td>
  	      <td align="center" valign="top">{$product[i].deal_quantity}</td>
	      <td align="center" valign="top" >&pound;{$product[i].deal_price}</td>	
	      <td align="center" valign="top">{$product[i].charge_date|date_format}</td>
	      <td align="center" valign="top" >{if $product[i].deal_type eq 'product'}Product {else} Voucher {/if}</td>		
	      <td align="center" valign="top" >{$product[i].pay_unique_id}</td>
	      <td align="center" valign="top" >{$product[i].charge_date|date_format}</td>			
	     </tr>
            {/if}
	  {sectionelse}
	  <tr><td colspan="5" align="center"><strong>No deal puchase order found.</strong></td></tr>
	  {/section}
          {if $showpaging eq 'yes'}<tr><td colspan="8" align="right">{$pgnation}</td></tr>{/if}
        </form>
	</table>
      </td>
    </tr>
  </table>
</div>
{include file=$footer}