{include file=$header1}
{include file=$header2}

<script type="text/css">

</script>

<br />
<h3> &nbsp; Feedback</h3>
{if $msg}
<div align="center">{$msg}</div>
{/if}
<div class="holdthisTop">
<table width="97%" border="0" class="brdall"><TR><TD align="right"><a onclick="history.back();"><b>Back</b></a></TD></TR></table>
  <table width="97%" class="brdall" border="0" style="border:1px solid #000000;">
    
    <tr><td colspan="2">&nbsp;</td></tr>
    <tr>
      <td align="right" width="20%" valign="top"><strong>From:</strong></td>
      <td align="left" width="80%">{$feedback.first_name|capitalize}</td>
    </tr>
    <tr>
    <td colspan="2">&nbsp;</td></tr>



	<tr>
      <td align="right"  valign="top"><strong>Feedback:</strong></td>
      <td align="left">{$feedback.feedback}</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>

	   
	<tr>
      <td align="right" width="20%" valign="top"><strong>Posted Date:</strong></td>
	
	 <td align="left" width="80%">{$feedback.posted_date|date_format:"%A, %B %e, %Y"}</td>
	
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>

<tr>
      <td align="right" width="20%" valign="top"><strong> Delivery Rating:</strong></td>
	
	 <td align="left" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback.delivery}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback.delivery_grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>
	
    </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
<tr>
      <td align="right" width="20%" valign="top"><strong> Item Rating:</strong></td>
	
	 <td align="left" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback.item}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback.item_grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>
	
    </tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
      <td align="right" width="20%" valign="top"><strong> Average Rating:</strong></td>
	
	 <td align="left" valign="top">
		<div class="col6" class="rating">
			<span style="display:block">
				{section name=l loop=$feedback.rating}
					<img src="{$siteroot}/templates/default/images/rating.png" alt="" border="0"/>
				{/section}
				{section name=m loop=$feedback.grey}
					<img src="{$siteroot}/templates/default/images/rating_gray.png" alt="" />
				{/section}
			</span>
		</div>
	     </td>
	
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>

	
  </table>
<br>

</div>
{include file=$footer}