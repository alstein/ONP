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
<h3 class="fl width50">Manage User Type</h3><br>
<div class="holdthisTop">
	
	<div class="fl width50 "><img src="{$siteimg}/icons/add.png" align="absmiddle" /> <a href="javascript: void(0);" onclick="javascript: tb_show('<strong>Add User Type</strong>', 'add_usertype.php?op=1&{$states[i].stateid}&TB_iframe=true&height=145&width=550&modal=false', tb_pathToImage);" class="thickbox">Add User Type</a></div>
	<div class="clr"></div>
	<div id="msg" align="center">{$msg}</div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
        <form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
            <td width="60%" align="left" valign="top">User Type</td>
           <!-- <td width="40%" align="left" valign="top">Arabic Title</td>-->
            <td width="39%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$type}
          <tr class="grayback" id="tr_{$type[i].typeid}">
            <td align="center" valign="top"><input type="checkbox" name="typeid[]" value="{$type[i].typeid}" /></td>
            <td align="left" valign="top">{$type[i].usertype}</td>
           <!-- <td align="right" valign="top" >{$pages[i].title_arabic}</td>-->
		<td align="left" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> 
		<a href="javascript: void(0);" onclick="javascript: tb_show('<strong>Add User Type</strong>', 'add_usertype.php?typeid={$type[i].typeid}&op=1&{$states[i].stateid}&TB_iframe=true&height=145&width=550&modal=false', tb_pathToImage);" class="thickbox">
		<strong>Edit</strong></a></td>
          </tr>
		  {sectionelse}
		  <tr><td colspan="4"><strong>No Pages Found.</strong></td></tr>
          {/section}
		  <tr><td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td><td colspan="3" align="left"><select name="action" id="action"><option value="">Action</option><option value="delete">Delete</option></select>
      <input type="submit" name="submit" id="submit" value="Go" class="button1" />&nbsp;&nbsp;<span id="acterr" class="error"></span></td></tr>
        </table></form></td>
    </tr>
  </table>
</div>
{include file=$footer}