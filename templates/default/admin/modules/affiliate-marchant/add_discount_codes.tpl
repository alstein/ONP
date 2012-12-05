{include file=$header1}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/discount_code.js"></script>

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(function () {
$('#frm').submit(function() {

                var docFrm=document.frm;
                var EndDate = new Date($('#end_date_Year_ID').val(), $('#end_date_Month_ID').val(), $('#end_date_Day_ID').val());
                var start_date =new Date($('#start_date_Year_ID').val(), $('#start_date_Month_ID').val(), $('#start_date_Day_ID').val());
                var error = 'no';

                $('#error_coupEndDate').hide();
                $('#error_coupon_credit_price').hide();

                $('#error_coupEndDate').html('');
                $('#error_coupon_credit_price').html('');
                
                if (EndDate < start_date) {
                     var error = 'yes';
                     $('#error_coupEndDate').show();
                     $('#error_coupEndDate').html("Discount End Date should be greater than or equal to Start Date");

                }else
                {
                     $('#error_coupEndDate').hide();
                     $('#error_coupEndDate').html('');
                }
                 if(error == 'yes')
                {
                     return false;
                }
            });
});

</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/affiliate-marchant/discount_codes_list.php"> Affiliate Discount Code</a>
&gt;{if $smarty.get.mid} Edit Discount Code{else} Add Discount Code{/if}
</div><br/>


<div class="holdthisTop">
	<div>
		<div class="fl width50">
			<h3>{$sitetitle} {if $smarty.get.mid}Edit{else}Add{/if} Discount Code</h3>
		</div>
		<div class="clr">&nbsp;</div>
		{if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}
    </div><br/>

	<div id="UserListDiv" name="UserListDiv" >
		<form name="frm" action="" id="frm" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{$id}" name="id" id="id" />
      <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
       <tr>
            <td colspan="2" align="right"><a href="discount_codes_list.php">
             <strong>Back</strong></a></td>
	</tr>
       <tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>MerchantId :&nbsp;</td>
            <td align="left">
		<input type="text" name="iMerchantId" id="iMerchantId"  style="width:313px" value="{$iMerchantId}" />
            <!--{*<select name="marchant_name" style="width:250px;">
                {section name=i loop=$marchant_info}
                <option value="{$marchant_info[i].marchant_id}" {if $marchand_id eq $marchant_info[i].marchant_id}selected="selected"
                {/if}>{$marchant_info[i].marchant_name}:{$marchant_info[i].marchant_id}</option>
                {/section}
           </select>*}-->
            </td>
	</tr>
	 <tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Merchant Name :&nbsp;</td>
            <td align="left">
                <input type="text" name="iMerchantName" id="iMerchantName"  style="width:313px" value="{$iMerchantName}" />
            </td>
	</tr>
	 <tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Discount Code :&nbsp;</td>
            <td align="left">
                <input type="text" name="discount_code" id="discount_code"  style="width:313px" value="{$code}" />
            </td>
	</tr>
	 
	 <tr>
            <td width="20%" align="right" valign="top" ><span style="color:red;">*</span>Details :&nbsp;</td>
            <td align="left"><textarea id="discution" name="discution" cols="42" rows="5">{$disscution}</textarea>
            </td>
	</tr>
	 <tr>
            <td width="20%" align="right" valign="top" >Image :&nbsp;</td>
            <td align="left">
             <input type="hidden" value="{$image}" name="image_chk" id="image_chk" />
                <input type="file" name="image" id="image" value="{$image}" onkeypress="return false" onkeydown="return false" onselect="return false"/>&nbsp;&nbsp;
                <br/>[Please upload image with .jpg,.gif,.png,.jpeg only]
                {if $image}
                 <br>
                <div> <img src="{$siteroot}/uploads/discount_codes_image/{$image}" title="Active" align="middle" style="float:left;" width="50" height="50"  /></div>
		{else}
                 <br>
                <div> <img src="{$siteroot}/templates/default/images/no_image.gif" title="Active" align="middle" style="float:left;" width="70" height="70"  /></div>
		{/if}
            </td>
	</tr>
	 <tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Url :&nbsp;</td>
            <td align="left">
                <input type="text" name="url" id="url"  style="width:313px" value="{$url}" />
            </td>
	</tr>
	<tr>
            <td width="20%" align="right" valign="top"><span style="color:red;">*</span>Start Date :&nbsp;</td>
            <td align="left">
                {if $start_date}
                        <script type="text/javascript">
                            DateInput('start_date', true, 'YYYY-MM-DD' ,'{$start_date|date_format:"%y-%m-%d"}');
                        </script>
                {else}
                        <script type="text/javascript">DateInput('start_date', true, 'YYYY-MM-DD');</script>
                {/if}
                  <!--  <div class="error" id="error_coupEndDate" style="display:none;"></div>-->
             </td>
	</tr> 
	<!-- <tr height="25">
	      <td valign="top" align="right"> Start Time: </td>
	      <td align="left" valign="top">
		<select name="start_hour" id="start_hour">
		{section name=i loop=$hr}
		<option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
		{/section}
		</select>&nbsp;&nbsp;&nbsp;
		<select name="start_min" id="start_min">
		{section name=i loop=$min}
		<option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
		{/section}
		</select>
	      </td>
	  </tr>-->
	
        <tr>
            <td width="20%" align="right" valign="top" ><span style="color:red;">*</span>End Date :&nbsp;</td>
            <td align="left">
                {if $end_date}
                        <script type="text/javascript">
                            DateInput('end_date', true, 'YYYY-MM-DD' ,'{$end_date|date_format:"%y-%m-%d"}');
                        </script>
                {else}
                        <script type="text/javascript">DateInput('end_date', true, 'YYYY-MM-DD');</script>
                {/if}
                    <div class="error" id="error_coupEndDate" style="display:none;"></div>
             </td>
	</tr> 
	 <tr height="25">
	    <td width="20%" align="right" valign="top"><span class="red">*</span>End Time :&nbsp;</td>
	    <td align="left" >
	      <select name="end_hour" id="end_hour">
	      {section name=i loop=$rev_hr}
	      <option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
	      {/section}
	      </select>&nbsp;&nbsp;
	      <select name="end_min" id="end_min">
	      {section name=i loop=$rev_min}
	      <option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
	      {/section}
	      </select> 
	    </td>
	</tr>
        <tr>
            <td>&nbsp;</td>
            <td align="left">
                    <div style="width:140px"> 
                        <div id="buttonregister" style="overflow:hidden">
                {if $id neq ""}
                                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 {else}
                                <input type="submit" name="submit" id="submit" value="Save" class="but_new fl"/>
                  {/if}
                                <input type="button"  value="Cancel" class="but_new fr" onclick="history.go(-1)">
                        </div>
                    </div>
            </td>
        </tr>
  </table>
  </form> 
	</div>
</div>
{include file=$footer}
