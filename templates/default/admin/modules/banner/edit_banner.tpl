{include file=$header1}

<script type="text/javascript">
{literal}
$(document).ready(function()
{
    $("#frm").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                location_name:
                                                                {
                                                                       required: true
                                                                },
                                                                url_loc:
                                                                {
                                                                       required: true
                                                                }

                                                            },
                                                messages:
                                                        {
                                                            location_name:
                                                            {
                                                                    required: "Please select location."

                                                            },
                                                            url_loc:
                                                            {
                                                                    required: "Please enter url"

                                                            }

                                                        }
                                });

});
{/literal}
</script>



{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{/strip}
{include file=$header2}

<h2>{if $id}Edit{else}Add{/if} Advertisement</h2><br>
<!-- Edit Content Panel -->
{if $id}

<input type="hidden" id="id" name="id" value="{$id}">

{strip}
	<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
	<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{/strip}
{else}
{strip}
<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script language="javascript" src = "{$siteroot}/js/addbanner.js"></script>
{/strip}
{/if}

<div Id="Content">
   <form name="frm" id="frm" method="post" action="" enctype="multipart/form-data" >
   <table width="100%"  border="0" cellspacing="0" cellpadding="5" class="Greenback">
	<tr>
	</tr>
	<tr>
		<td colspan="100%" align="right"><a href="banner_list.php">
		<strong>Back</strong></a></td>
	</tr>
	
	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>
	<tr>
      	<td width="20%" align="right"><span class="red"></span>
			<span class="frmtxt style1" >Advertisement location :</span></td>
      	<td>
		<select name="location_name" id="location_name" {if $id} disabled="true" {/if}>
					<option value="">Select Location</option>
					<option value="Left Side" {if $banner.location_name eq "Left Side"}selected='selected'{/if} >Left Side</option>
					<option value="Footer" {if $banner.location_name eq "Footer"}selected='selected'{/if} >Footer</option>
				</select>
			</td>
			<td>
		{if $id}
			<input type="hidden" name="location_name" id="location_name" value="{$banner.location_name}">
		{/if}
			</td>
	</tr>
	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>
	<tr>
			
			<td width="20%"  align="right" colspan="1">Start date:</td> 
			<td align="left" >
				{if $banner.start_date}
				<script type="text/javascript">DateInput('start_date', true, 'YYYY-MM-DD' ,'{$banner.start_date|date_format:"%y-%m-%d"}');</script>
				{else}
				<script type="text/javascript">DateInput('start_date', true, 'YYYY-MM-DD');</script>
				{/if}
			</td>
	 </tr>

	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>
		<tr>
			<td width="20%" valign="top" align="right" colspan="1">Expired date: </td>
			<td colspan="2" align="left" valign="top">
				{if $banner.expired_date}
				<script type="text/javascript">DateInput('expired_date', true, 'YYYY-MM-DD','{$banner.expired_date|date_format:"%y-%m-%d"}');</script>
				{else}
				<script type="text/javascript">DateInput('expired_date', true, 'YYYY-MM-DD');</script>
				{/if}
			</td>
	 </tr>

	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>


	<tr>
      <td align="right" valign="top" width="20%" colspan="1">URL Location</td>
      <td colspan="2" align="left" width="80%"><input type="text" name="url_loc" id="url_loc" class="textbox width50" value="{$banner.urllocation}"></td>
	</tr>

	<tr>
		<TD colspan="100%">&nbsp;</TD>
	</tr>


	<tr>
      <td align="right" valign="top" width="20%" colspan="1">Image</td>
      <td colspan="2" align="left" width="80%"><input type="file" name="product_image" id="product_image" value="{$banner.product_image}">
      <div id="error1"></div>
      <input type="hidden" name="h_product_image" id="h_product_image" value="{$banner.product_image}">
			{if $banner.product_image}
			<br>
			<img src="{$siteroot}/uploads/banner/{$banner.product_image}" height="100" width="100">
			<!--<img src="{$siteroot}/display_image.php?path=uploads/banner/{$banner.product_image}&width=200&height=150" >-->
			{/if}
      </td>
	</tr>


	<tr>
		<TD>&nbsp;</TD>
	</tr>
	
	<tr>
		<TD colspan="100%"></TD>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="100%">
			<div align="left">

			<input name="Submit" type="submit" value="{if $id}Update{else}Add{/if} Banner">
			</div>
		</td>
	</tr>
  </table>
</form>
</div>
{include file=$footer}