{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/managedeals.js"></script>
{literal}
<script type="text/javascript">

function reject()
                {

                var reject=confirm("Are you sure to reject this deal ?");
                if(reject ==true){
                                        return true;
                                }
                else
                                {
                                        return false;
                                }
                
                }
</script>

{/literal}

{include file=$header2}

 		<h3 align="left"><b>Deals To Be Reviewed</b></h3>

	{if $smarty.post.city}<br>{/if}
<!--<div align="left">Symbol for recommended deal <img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/></div>-->
		
		<div align="center" id="msg">{$msg}</div>
	
	<table cellpadding="2" cellspacing="0" border="0" width="79%">

<!--<tr><td colspan="2" align="right"><img src="{$siteroot}/templates/default/images/icons/add.png" alt="add" /><a href="add_product.php" > Add deal</a></TD></tr>
<tr><TD colspan="12">&nbsp;</TD></tr>-->

  		<tr>
	  	<td align="right">
	 	<form name="form1" method="post" id="form1" action="">
		</form>
		</td>
		</tr>
		
		<tr>
		<td colspan="2" valign="top" align="center">
			<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
     			
			<table cellpadding="2" cellspacing="1" border="0" width="100%" class="listtable">
          		<tr class="headbg">
            		<td width="1%" align="center" valign="top">
				<input type="checkbox" id="checkall" />
			</td>
			<td width="10%" valign="top">Deal Name</td>
			<td width="10%" valign="top">Seller Name</td>
			<td width="10%" valign="top">Start Date</td>	
			<td width="10%" valign="top">End Date</td>	
	    		<td width="5%" valign="top">Description</td>
	    		<td width="8%" valign="top">City</td>
	    		<td width="5%"  valign="top">Price In &#163;</td>
            		<td width="5%" valign="top">Original Price In&nbsp;&#163;</td>
                        <td width="5%">Quote Date</td>
                        <td width="5%">Admin Name</td>
                        <td width="5%">Status</td>		
	    		<td width="35%" valign="top">Action</td>
          		</tr>
          		
			{section name=i loop=$deal}
         		<tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
            		<td align="center" valign="top">
			<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" />
			</td>
			<td align="left" valign="top">
			{if $deal[i].recommend eq '1'}
			<img align="absmiddle" src="{$siteimg}/icons/bullet-fingerpoint.gif"/>
			{/if}
			{if $deal[i].admin_approve eq 'yes'}
			<img align="absmiddle" src="{$siteimg}/icons/award_star_silver_2.png"/>
			{else}
			<img align="absmiddle" src="{$siteimg}/icons/award_star_silver_1.png"/>
			{/if} 
			{$deal[i].title|ucfirst}
			</td>
			  <td align="left" valign="top"><a href="{$siteroot}/admin/user/seller_view.php?userid={$deal[i].seller_id}" >{$deal[i].username}</a></td>
			<td align="left" valign="top">{$deal[i].start_date|date_format:"%d-%b-%Y at %I:%M %p"}</td>
			<td align="left" valign="top">{$deal[i].end_date|date_format:"%d-%b-%Y at %I:%M %p"}</td>
            		<td align="left" valign="top">
			{$deal[i].description|strip_tags|substr:0:40|html_entity_decode}
			</td>
	   	 	<td align="left" valign="top">{$deal[i].deal_city}</td>	
            		<td align="left" valign="top">{$deal[i].groupbuy_price}</td>
            		
                        <td valign="top">{$deal[i].orignal_price}</td>	
                        <td valign="top">
                        {if $deal[i].quote_date eq 0} Not Quoted Yet {else} {$deal[i].quote_date|date_format:"%d-%b-%Y at %I:%M %p"} {/if}</td>	
                       <td align="center" valign="top">
                        {if $deal[i].admin_name eq ''} Not Available {else}{$deal[i].admin_name} {/if}
                        </td>
                         <td align="left" valign="top">
                        {if $deal[i].quote_date eq 0}
                         No Comment Received       
                        {else}
                        {if $deal[i].new eq 1}Seller Comment Received{else}Negotiations are on{/if}
                        {/if}
                        </td>	
	    		<td valign="top">
			<img align="absmiddle" src="{$siteroot}/templates/default/images/icons/add.png" alt="add" /><a href="{$siteroot}/admin/globalsettings/deal/deal-quote.php?id={$deal[i].deal_unique_id}" ><strong>Quote</strong></a> <br/>
			<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
			<a {if $deal[i].new eq 1} style="color:green"{/if} href="{$siteroot}/admin/globalsettings/deal/deal-quote-reply.php?id={$deal[i].deal_unique_id}" ><strong>Quote Comment</strong></a><br/>
	
			<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		<!--<a target="_blank" href="{$siteroot}/admin/globalsettings/deal/preview-deal.php?id={$deal[i].deal_unique_id}&act=view">-->
			<a target="_blank" href="{$siteroot}/deal/{$deal[i].url_title}/deal-preview/">		

		<strong>Preview</strong>
		</a>
			{if $deal[i].deal_unique_id|@in_array:$autho}
                        <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a target="_blank" href="{$siteroot}/admin/globalsettings/deal/get_autho_release.php?id={$deal[i].deal_unique_id}"><strong>Release</strong></a>
                        {/if} &nbsp;
                        
                        <a style="color:red" href="reject-popup.php?id={$deal[i].deal_unique_id}&amp;placeValuesBeforeTB_=savedValues&amp;TB_iframe=true&amp;height=350&amp;width=600&amp;modal=false" class="thickbox" title="Reject Deal" linkindex="2" set="yes"><strong>Reject</strong></a>



                      <!--  <a  style="color:red" onclick="return reject();" href="{$siteroot}/admin/globalsettings/deal/view-deal.php?id={$deal[i].deal_unique_id}&act=reject"><strong>Reject</strong></a>-->

			</td>
          		</tr>
          		{sectionelse}
          		<tr>
            		<td colspan="5" align="center" height="25" class="error">Deal not found.</td>
          		</tr>
          		{/section}
				
			{if $deal}
          			<tr>
            			<td align="right">
				<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
				</td>
            			<td align="left" colspan="3">
				<select name="action" id="action">
				<option value="">Action</option>
				<!--<option value="active">Publish</option>
				<option value="inactive">Unpublish</option>
				<option value="recommended">recommended</option>
				<option value="approve">Appprove</option>
				<option value="disapprove">Disapprove</option>-->
				<option value="delete">Delete</option>
				</select>
				
              			<input type="submit" name="submit" id="submit" value="Go"/>
              			<span id="acterr" class="error"></span>
				</td>
            			<td colspan="9" align="right">
				{if $showpaging eq "yes" }
					{$pgnation}
				{/if}
				</td>
				</tr>
				{/if}
        				
			</table>
      			</form>
			
			</td>
  			</tr>
		</table>
	<div class="clr">
</div>
{include file=$footer} 
