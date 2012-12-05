{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.jSuggest.1.0.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_manage_other_details.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/user/seller_list.php">Seller List</a> &gt; Manage Other Details
</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}  Manage Other Details</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
       <input type="hidden" name="userid" id="userid" value="{$userid}">
       <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span><strong>Delivery Charges</strong>:</td> 
           <td align="left" width="40%">&nbsp;</td>
        </tr>
       
       <!--<tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Delivery Charges &#163;:</td> 
           <td align="left" width="40%"><input type="text" name="delivery_charges" id="delivery_charges" value="{$delivery_charges}"   style="width:268px;" maxlength="4"/>
        </tr>-->
        
        <tr style="display:none;">
           <td width="20%" align="right" valign="top">Pound (&#163;):</td> 
           <td align="left" width="40%"><input type="text" name="delivery_charges_pound" id="delivery_charges_pound" value="{$delivery_charges_pound.value}" style="width:268px;" maxlength="4"/></td>
        </tr>
        <tr style="display:none;">
           <td width="20%" align="right" valign="top">Euro (&#8364;):</td> 
           <td align="left" width="40%"><input type="text" name="delivery_charges_euro" id="delivery_charges_euro" value="{$delivery_charges_euro.value}"   style="width:268px;" maxlength="4"/></td>
        </tr>
        <tr style="display:none;">
           <td width="20%" align="right" valign="top">Dollar ($):</td> 
           <td align="left" width="40%"><input type="text" name="delivery_charges_dollar" id="delivery_charges_dollar" value="{$delivery_charges_dollar.value}"   style="width:268px;" maxlength="4"/></td>
        </tr>

        <tr>
		<td width="20%" align="right" valign="top"><span style="color:red;">*</span>Delivery Service Options:</td>
		<td align="left" width="40%">
			<table border="1" cellpadding="5" cellspacing="1" style="border-width:3px; border-style:solid;" width="850px">
				<tr>
					<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="2%">Sr. No.</th>
					<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;" width="13%">Select / Deselect</th>
					<th rowspan="2" style="border-bottom-width:3px; border-bottom-style:solid;">Delivery Service Option Name</th>
					<th colspan="3">Delivery Charges</th>
				</tr>
				<tr>
					<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Pound (&#163;)</th>
					<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Euro (&#8364;)</th>
					<th style="border-bottom-width:3px; border-bottom-style:solid;" width="20%">Dollar ($)</th>
				</tr>
				{section name=i loop=$data_delivery_chr}
				<tr id="tr_{$smarty.section.i.iteration}">
					<th>{$smarty.section.i.iteration}</th>
					<td align="center">
						<input type="hidden" name="delivery_service_option_{$smarty.section.i.iteration}" id="delivery_service_option_{$smarty.section.i.iteration}" value="{$data_delivery_chr[i].value}">
						<input type="checkbox" name="delivery_service_option_chk_{$smarty.section.i.iteration}" id="delivery_service_option_chk_{$smarty.section.i.iteration}" onchange="onChkChange('{$smarty.section.i.iteration}')" {if $data_delivery_service_chr[i].is_selected eq 'yes'} checked="true" {elseif $data_delivery_service_chr[i].is_selected neq 'no' && $smarty.section.i.iteration eq '1'} checked="true" {/if}>
					</td>
					<td>{$data_delivery_chr[i].value}</td>
					<td align="center">
						{if $smarty.section.i.iteration == 1}
							<input type="hidden" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
						{else}
							<input type="text" name="delivery_charges_pound_{$smarty.section.i.iteration}" id="delivery_charges_pound_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_pound}" class="textbox" maxlength="4" style="width:40px;"/>
						{/if}
						<div style="clear:both;"></div>
						<div style="display:none;" htmlfor="delivery_charges_pound_{$smarty.section.i.iteration}" generated="true" class="error"></div>
					</td>
					<td align="center">
						{if $smarty.section.i.iteration == 1}
							<input type="hidden" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
						{else}
							<input type="text" name="delivery_charges_euro_{$smarty.section.i.iteration}" id="delivery_charges_euro_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_euro}" class="textbox" maxlength="4" style="width:40px;"/>
						{/if}
						<div style="clear:both;"></div>
						<div style="display:none;" htmlfor="delivery_charges_euro_{$smarty.section.i.iteration}" generated="true" class="error"></div>
					</td>
					<td align="center">
						{if $smarty.section.i.iteration == 1}
							<input type="hidden" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="0" class="textbox" maxlength="4" style="width:40px;"/>----
						{else}
							<input type="text" name="delivery_charges_dollar_{$smarty.section.i.iteration}" id="delivery_charges_dollar_{$smarty.section.i.iteration}" value="{$data_delivery_service_chr[i].delivery_charges_dollar}" class="textbox" maxlength="4" style="width:40px;"/>
						{/if}
						<div style="clear:both;"></div>
						<div style="display:none;" htmlfor="delivery_charges_dollar_{$smarty.section.i.iteration}" generated="true" class="error"></div>
					</td>
				</tr>
				{/section}
			</table>
			<input type="hidden" name="delivery_service_options" id="delivery_service_options" value=""/>
		</td>
        </tr>

        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Seller Support Email:</td>
           <td align="left" width="40%"><input type="text" name="seller_support_email" id="email" value="{$seller_support_email}"   style="width:268px;"/>
        </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Tracking URL Code:</td>
           <td align="left" width="40%"><input type="text" name="tracking_URL" id="tracking_URL" value="{$tracking_url_code}"   style="width:268px;"/>
        </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Delivered Tracking URL Code:</td>
           <td align="left" width="40%"><input type="text" name="delivered_tracking_URL" id="delivered_tracking_URL" value="{$delivered_tracking_url_code}"   style="width:268px;"></td>
	   </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Affiliate URL:</td>
           <td align="left" width="40%"><input type="text" name="affiliate_URL" id="affiliate_URL" value="{$affiliate_url}"   style="width:268px;"/>        </td>
        </tr>
        <tr>
           <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Affiliate Code:</td>
           <td align="left" width="40%">
			<textarea name="affiliate_code" id="affiliate_code" cols="40" rows="5">{$affiliate_code}</textarea>
			{*<input type="text" name="affiliate_code" id="affiliate_code" value="{$affiliate_code}" style="width:268px;"/>*}
		 </td>
        </tr>
        <tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Refund Policy:</td>
            <td align="left" width="40%">{*oFCKeditor->Create*} {$oFCKeditorDesc}</td>
        </tr>
        <tr>
         <!-- <td>&nbsp;</td>-->
         <td align="middle" colspan="2">
          <div style="width:34%"> 
          <div id="buttonregister">
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" /> 
                 <!--&nbsp;<input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='{$siteroot}/admin/index.php'" 
                 class="but_new fl"/>--> </div>
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
