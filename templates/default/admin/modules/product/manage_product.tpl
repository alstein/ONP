{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/managedeals.js"></script>

{include file=$header2}

 <h3 align="left"><b>Manage Product</b></h3>
{if $smarty.post.city}<br>{/if}
<div align="center" id="msg">{$msg}</div>
<table cellpadding="2" cellspacing="0" border="0" width="100%">

<tr><td colspan="2" align="right"><a href="add_product.php" ><img src="{$siteroot}/templates/default/images/icons/add.png" alt="add" /> Add product</a></TD></tr>
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
								<!--<input type="checkbox" id="checkall" />-->
							</td>
<!--<td width="5%" align="center" valign="top">Sr.No</td>-->
<!--<td width="15%" align="center" valign="top">User</td>-->
							<td width="10%" align="center" valign="top">Product Title</td>

	
<!--							<td width="10%" align="center" valign="top">Start date</td>	
							<td width="10%" align="center" valign="top">End date</td>	-->



	    					<td width="25%" align="center" valign="top">Product Category</td>
	    					<!--<td width="8%" align="center" valign="top">City</td>-->
	    					<td width="5%" align="center" valign="top">Original Price</td>
            			<td width="5%" align="center" valign="top">Discount<br/>(%)</td>	
	    					<td width="10%" align="center" valign="top">Action</td>
          			</tr>
          			{section name=i loop=$deal}
         			 <tr class="grayback" id="tr_{$deal[i].product_id}">
            			<td align="center" valign="top">
								<input type="checkbox" name="prod_id[]" value="{$deal[i].product_id}" />
							</td>
							<td align="left" valign="top">{if $deal[i].status eq 'Active'}<img align="absmiddle" src="{$siteimg}/icons/award_star_silver_2.png"/>{else}<img align="absmiddle" src="{$siteimg}/icons/award_star_silver_1.png"/>{/if} {$deal[i].product_name}</td>


							<!--<td align="left" valign="top">{$deal[i].deal_start_date|date_format:"%e %b %Y"}</td>
							<td align="left" valign="top">{$deal[i].deal_end_date|date_format:"%e %b %Y"}</td>-->




            			<td align="left" valign="top">{$deal[i].product_description|strip_tags|substr:0:40|html_entity_decode}</td>
	   	 				<!--<td align="left" valign="top">{$deal[i].product_city}</td>	-->
            			<td align="left" valign="top">{$deal[i].product_act_price}</td>
            			<td align="center" valign="top">{$deal[i].product_disc_price}</td>	
	    					<td align="center" valign="top">
								<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/globalsettings/deal/add_product.php?id={$deal[i].product_id}&act=Edit"><strong>Edit</strong></a>|<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href="{$siteroot}/admin/globalsettings/deal/view_product.php?id={$deal[i].product_id}&act=view"><strong>View</strong></a></td>
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
                					<option value="">--Action--</option>
                					<option value="active">Active</option>
                					<option value="inactive">Inactivate</option>
                					<option value="delete">Delete</option>

              					</select>
              						<input type="submit" name="submit" id="submit" value="Go"/>
              						<span id="acterr" class="error"></span></td>
            					<td colspan="4" align="right">
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