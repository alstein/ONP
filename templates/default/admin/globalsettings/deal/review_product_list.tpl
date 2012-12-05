{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/managedeals.js"></script>

{include file=$header2}

 <h3 align="left"><b>Review Deals</b></h3>

	<div align="center" id="msg">{$msg}</div>

	<table cellpadding="2" cellspacing="0" border="0" width="79%">
		
		<tr><TD colspan="12">&nbsp;</TD></tr>
		<tr>
	  	<td align="right">
	 	<form name="form1" method="post" id="form1" action="">

		</form>
		</td>
		</tr>
		<tr>
			<td colspan="2" valign="top" align="center">
				<form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
     				<table cellpadding="6" cellspacing="2" border="0" width="100%" class="listtable">
          			<tr class="headbg">
            			<td width="1%" align="center" valign="top">
					<input type="checkbox" id="checkall" /></td>
					<td width="10%" align="center" valign="top">Deal Name</td>
		  			<td width="20%" align="center" valign="top">Review Text</td>
	    			<td width="8%" align="center" valign="top">Reviewer</td>
	    			<td width="5%" align="center" valign="top">Review URL </td>
	    			<td width="20%" align="center" valign="top">Action</td>
          			</tr>
          			{section name=i loop=$deal}
         			 <tr class="grayback" id="tr_{$deal[i].deal_unique_id}">
            			<td align="center" valign="top">
				<input type="checkbox" name="deal_id[]" value="{$deal[i].deal_unique_id}" />
				</td>
					<td align="left" valign="top"> {$deal[i].title|ucfirst}</td>
					<td align="left" valign="top">{$deal[i].review_text}</td>
					<td align="left" valign="top">{$deal[i].review_name}</td>
					<td align="left" valign="top">{$deal[i].review_url}</td>
	    			<td align="center" valign="top">
					<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href="{$siteroot}/admin/globalsettings/deal/review
					_product.php?id={$deal[i].deal_unique_id}&act=view"><strong>View</strong></a></td>
          				</tr>
          			{sectionelse}
          				<tr>
            				<td colspan="5" align="center" height="25" class="error">
					Deal not found.
					</td>
          				</tr>
          			{/section}
				{if $deal}
          				<tr>
            				<td align="right">
				<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
					</td>
            				<td align="left" colspan="3">
					<select name="action" id="action">
					<option value="">--Action--</option>
					<option value="delete">Delete</option>
					</select>
              				<input type="submit" name="submit" id="submit" value="Go"/>
              				<span id="acterr" class="error"></span></td>
            				<td colspan="4" align="right">
					{if $showpaging eq "yes"}
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