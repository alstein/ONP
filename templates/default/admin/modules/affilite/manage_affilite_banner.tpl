{include file=$header1}
<script type="text/javascript">
{literal}
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
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
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
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>
{include file=$header2}
<div class="holdthisTop">
	<h3 class="fl width50">Manage Banners</h3>
	<div class="fr width50 ar"><img src="{$siteimg}/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/affilite/add_banner.php" rel ="contentarea">Add Banner</a></div>
	<div class="clr"></div>
	<div id="msg" align="center">{$msg}</div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
            <td width="30%" align="left" valign="top">Image</td>
            <td width="40%" align="left" valign="top">Title</td>

            <td width="29%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$banner}
	
          <tr class="grayback" id="tr_{$banner[i].id}">
            <td align="center" valign="top"><input type="checkbox" name="bannerid[]" value="{$banner[i].id}" /></td>
            <td align="left" valign="top">
		{if $banner[i].image_affilite}<img src="../../../uploads/banners/{$banner[i].image_affilite}" width=200px height=160px>{else}NO Image{/if}</td>
		<td align="left" valign="top">{$banner[i].description}</td>
            <td align="center" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /><a href="{$siteroot}/admin/modules/affilite/add_banner.php?id={$banner[i].id}" class="admintxt"><strong>Edit</strong></a></td>
          </tr>
		  {sectionelse}
		  <tr><td colspan="4"><strong>No Pages Found.</strong></td></tr>
          {/section}
	<tr>
		<td align="right">
			<img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		</td>
		<td  align="left">
			<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="Delete">Delete</option>
				<option value="Active">Active</option>
				<option value="Inactive">Inactive</option>
				
			</select>
			<input type="submit" name="submit" id="submit" value="Go" />
			<span id="acterr" class="error"></span>
		</td><td align=right>{$pgnation}</td>
	</tr>
        </table></form></td>
    </tr>
  </table>
</div>
{include file=$footer}