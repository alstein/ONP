{include file=$header1}
{literal}
<script type="text/javascript">
$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Please select action.").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Please select checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action?'))
			return true;
		else
			return false;
    });
	$("#mg").fadeOut(5000);
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb">
		<a href="{$siteroot}/admin/index.php">Home</a> &gt;&nbsp;Ad Manage List
	</div> <br />
<h4>AD Management</h4>

<div class="holdthisTop">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    {if $msg} <tr id="mg"><td class="red"> <center>{$msg}</center></td></tr>{/if}

    <!--<tr><td><img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/admanagement/Edit-Ad.php" rel ="contentarea">Create Ad</a></td></tr>-->

    <tr><TD>	
      <form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
	    <td width="40%" align="left" valign="top">Title</td>
	    <td  width="24%" align="center" valign="top">Start Date</td>
	    <td  width="20%" align="center" valign="top">End Date</td> 
	    <!--<td width="8%" align="left" valign="top">Alignment</td>	
            <td width="10%" align="center" valign="top">Size<br><h5>(Width,Height)</h5></td>	-->
            <td width="20%" align="center" valign="top">Action</td>
          </tr>
	  {section name=i loop=$ads}
	  <tr class="grayback" id="tr_{$ads[i].ad_id}">
                  <td align="center" valign="top">
                        <input type="checkbox" name="ad_id[]" value="{$ads[i].ad_id}" />
                  </td>
		  <td align="left" valign="top">
                    <img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $ads[i].status eq 'inactive'}award_star_silver_1.png {else}award_star_silver_2.png{/if}" align="absmiddle" />
			  {$ads[i].ad_title}
		  </td>
		  <td align="center" valign="top">
			  {$ads[i].start_date|date_format:"%d-%b-%Y"}
		  </td>
		  <td align="center" valign="top">
			  {$ads[i].end_date|date_format:"%d-%b-%Y"}
		  </td>
		 <!-- <td align="left" valign="top">
			  {$ads[i].ad_align}
		  </td>
	           <td align="center" valign="top">{$ads[i].width} x {$ads[i].height}</td>-->	
		  <td align="center" valign="top">
		    <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="View-Ad.php?ad_id={$ads[i].ad_id}" class="admintxt">
			<strong>View</strong></a> | 
		    <img src="{$siteroot}/templates/{$templatedir}/images/icons/application_edit.png" align="absmiddle" /> <a href="Edit-Ad.php?ad_id={$ads[i].ad_id}" class="admintxt">
                          <strong> Edit </strong> </a><!-- |
		    <img src="{$siteroot}/templates/{$templatedir}/images/icons/delete.png" align="absmiddle" /> 
			<a href="Delete_Ad.php?ad_id={$ads[i].ad_id}" class="admintxt" onclick="return confirm('Do you want to delete this Ad?');">
                          <strong> Delete </strong> </a>-->
		  </td>
		</tr>
		{sectionelse}
		<tr>
		    <td colspan="5" class="error" align="center">
			    <strong>Sorry, Record not found in database.</strong>
		    </td>
		</tr>
		{/section}
                 {if $ads}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left" colspan="5"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go" class="button1" /><div class="buttonEnding1"></div>
              <!--<input type="submit" name="submit" id="submit" value="Go" class="button1"/><div class="buttinEnding1"/>-->
             </td>
            <td colspan="5" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
          </tr>
	{/if} 
	<tr><td></td><td><span  id="acterr" class="error">&nbsp;</span></td></tr>	
        </table>
	</form>
	</td>
    </tr>
  </table>
</div>
{include file=$footer}
