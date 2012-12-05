{include file=$header1}
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
{include file=$header2}

<div class="breadcrumb">
    <h3 class="fl width20" style="color:black;">Deal Quate</h3>
<table width="100%">
<tr><TD></TD>
<td width="5%">
<a href="manage_deal.php">Back</a></td>
</tr>
</table></div>

{if $msg}<div align="center">{$msg}</div>{/if}

   
    <form action="" method="post" name='frm' id="frm" enctype="multipart/form-data">
    <input type="hidden" name="sellerid" id="sellerid" value="{$deal_info.seller_id}">
    <table width="50%" align="center">
        <col width="30%">
        <col width="70%">
        <tr>
            <td align="right"> Start Date</td>
            <td align="left" valign="top">
            {if $start_date}
            <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD','{$start_date}');</script>
            {else}
            <script type="text/javascript">DateInput('dob1', true, 'YYYY-MM-DD');</script>
            {/if}
            </td>
        </tr>
        <tr height="25">
            <td valign="top" align="right"><span class="red">*</span>Start Time : </td>
            <td align="left" valign="top">
                <select name="start_hour" id="start_hour">
                {section name=i loop=$hr}
                <option value="{$hr[i]}" {if $s_hr eq $hr[i]} selected="selected" {/if}>{$hr[i]}</option>
                {/section}
                </select>&nbsp;&nbsp;&nbsp;
                <select name="start_min">
                {section name=i loop=$min}
                <option value="{$min[i]}" {if $s_min eq $min[i]} selected="selected" {/if}>{$min[i]}</option>
                {/section}
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"> End Date</td>
            <td colspan="2" align="left" valign="top">
                {if $end_date}
                <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD','{$end_date}');</script>
                {else}
                <script type="text/javascript">DateInput('dob2', true, 'YYYY-MM-DD');</script>
                {/if}
            </td>
        </tr>
        <tr height="25">
            <td valign="top" align="right"><span class="red">*</span>End Time : </td>
            <td align="left" valign="top">
            <select name="end_hour">
            {section name=i loop=$rev_hr}
            <option value="{$rev_hr[i]}" {if $e_hr eq $rev_hr[i]} selected="selected" {/if}>{$rev_hr[i]}</option>
            {/section}
            </select>&nbsp;&nbsp;&nbsp;
            <select name="end_min">
            {section name=i loop=$rev_min}
            <option value="{$rev_min[i]}" {if $e_min eq $rev_min[i]} selected="selected" {/if}>{$rev_min[i]}</option>
            {/section}
            </select>

            </td>
        </tr>
        <tr>
            <td align="right"> Estimated fees :</td>
            <td> <input type="text" name="estimatedfees" id="estimatedfees" class="textbox" value="{$deal_info.final_value}" ></td>
        </tr>
        <tr>
            <td align="right"> Listing Fees :</td>
            <td> <input type="text" name="listingfees" id="listingfees" class="textbox" value="{$deal_info.listing_value}"></td>
        </tr>
        <tr>
            <td align="right"> % to be charged if over minimum :</td>
            <td> <input type="text" name="chargepercentage" id="chargepercentage" class="textbox" value="{$deal_info.charged_percentage}"></td>
        </tr>
        <tr>
            <td align="right" > <input type="submit" name="submit" id="submit" value="Submit"> </td>
        </tr>
    </table>
    </form>
 

{include file=$footer}