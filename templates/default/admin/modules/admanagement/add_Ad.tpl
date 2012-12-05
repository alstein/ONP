{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/jquery-1.2.6.min.js" /></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script> 
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/validation/check_create_ad.js"></script> 
{/strip}
{literal}
<script type="text/javascript" >
function embd()
{
    document.getElementById('embdedid').style.display = "block";
    document.getElementById('imageid').style.display = "none";
}

function img()
{
    document.getElementById('imageid').style.display = "block";
    document.getElementById('embdedid').style.display = "none";
}
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb">
    <a href="{$siteroot}/admin/index.php">Home</a> &gt;&nbsp;<a href="{$siteroot}/admin/modules/admanagement/Ads.php">Ad Manage List</a> &gt;New Ad
</div> <br />

<div class="holdthisTop">
  <table width="100%"  align="center" border="0">
    <tr>
      <td>
        <form name="frmAd" id="frmAd" method="post" action="" enctype="multipart/form-data">
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
            
	    <tr>
		<td align="left"><h2><input type="hidden" name="ad_id" value="{$ad_id}" />New Ad</h2>
		</td>
                <td align="right"><b><a href="Ads.php">Back</a></b></td>
	     </tr>
	      <tr>
		<td width="15%" align="right" valign="top">
                    <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Title:
		</td>
		<td align="left">
                    <input type="text" name="tittle" id="tittle" size="50" maxlength="100" value="" />
                </td>
	      </tr>

	      <tr>
		<td valign="top" align="right" >
		  <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Description:
		</td>
		<td valign="top">
		    <textarea name="desc" cols="58" rows="8"></textarea>
		</td>
              </tr>
	<!--      <tr>
		<td width="15%" align="right" valign="top">
                    <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Accounts receivable: 
		</td>
		<td align="left">
                    <input type="text" name="acc_rec" id="acc_rec" size="50"  value="" />
                </td>
	      </tr>
	      <tr>
		<td width="15%" align="right" valign="top">
                    <span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Contact Info: 
		</td>
		<td align="left">
                    <input type="text" name="c_info" id="c_info" size="50" value="{$ad.ad_title}" />
                </td>
	      </tr>
	      <tr>
		  <td valign="top" align="right" >Align:</td>
		  <td valign="top"> 
		      <input type="radio" name="align" value="Right_Top" checked="true" >Right Top
		      <input type="radio" name="align" value="Right_Footer" checked="true">Right Footer
		</td>
	      </tr>-->
	      <tr>
		  <td valign="top" align="right" >Ad Type:</td>
		  <td valign="top">
		    <input name="type1" type="radio" id="type1" value="code" onclick="javascript:return embd();" checked="true" />Embedded Code
		    <input name="type1" type="radio" id="type2" value="image" onclick="javascript:return img();" >Image </td>
	      </tr>	
	      <tr>
		<td colspan="2">
		  <div id="embdedid" style="display:block">
		    <table width="100%" border="0" cellspacing="6" cellpadding="6" >
			<tr>
			    <td width="12%" align="right"  valign="top"><span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Embedded Code:</td>
			    <td width="77%" align="left"><textarea name="embed" id="embed" cols="58" rows="8" ></textarea></td>	  
			</tr>
		      </table>
		  </div>			 
		</td>
	      </tr>
	      <tr>
		<td colspan="2">
		  <div id="imageid" style="display:none">
		    <table width="100%" border="0" cellspacing="6" cellpadding="6">
			<tr>
			  <td width="12%" align="right"  valign="top"><span id="mesg" class="mesg_red" style="color :red;">*</span>&nbsp;Image:</td>
			  <td width="77%" align="left">
			    <input type="file" name="image1" id="image1"/></td>
			  </tr>
			  <tr>
			    <td width="12%" align="right"  valign="top">Link:</b></td>
			    <td width="77%" align="left">
			      <input type="text" name="link1" id="link1" size="50" value="">
			    </td>		
			  </tr>
		    </table>
		  </div>
		</td>
            </tr>
	<tr height="25">	
	    <td valign="top" align="right"><span class="red">*</span>Add Start Date: </td>
	    <td align="left" valign="top">
	      {if $start_date}
	      <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
	      {else}
	      <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
	      {/if}
	    </td>
	  </tr>	
	<tr height="25">
	      <td valign="top" align="right"><span class="red">*</span>Add End Date: </td>
	      <td colspan="2" align="left" valign="top">
		{if $end_date}
		<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
		{else}
		<script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
		{/if}
	      </td>
	  </tr>					
            <tr>
              <td align="right" valign="top"></td>
             <td><input type="submit" name="Submit" id="Submit" value="Save" class="button1"/><div class="buttonEnding1"></div>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="Cancel" value="Cancel" class="button1" onclick="javascript: history.back();" /><div class="buttonEnding1"></div>
		</td>
            </tr>
          </table>
 	</form>
      </td>
    </tr>
  </table>
</div>

{literal}
<script language="javascript">
{/literal}
	{if $ad.ad_type eq image}
		{literal}
			img();
		{/literal}
	{else}
		{literal}
			embd();
		{/literal}
	{/if}
{literal}
</script>
{/literal}

{include file=$footer}
