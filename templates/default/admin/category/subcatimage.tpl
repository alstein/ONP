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

$("input[@type=checkbox]").click(function()
 	{
		var i=0;
		var flag=0;
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			i++;
			if(this.checked && i!=1)
			{
			flag++;
			}
			else if(i!=1)
			{
			flag--;
			}
		});
		if(flag==(i-1))
		{
			$("#checkall").attr('checked',true);
		}
		else
		{
			$("#checkall").attr('checked',false);
		}
		change(this);
 	});


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
</script>
{/literal}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/category/category_list.php">Main Categories</a> &gt;Image List </div><br />
	<table cellpadding="6" cellspacing="2" align="center" width="80%" border="0">
	    <!--<tr>
		<td colspan="2"><h3>Main Category : {$mainCatname}</h3></td>
	    </tr>-->
	    {$categoryHirarchy}
	    <tr>
		<td colspan="2"><h3>Image List</h3></td>
	    </tr>
	    <tr>
		<td align="left">
<!--			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_sub_cat_excel.php?cat_id={$smarty.get.cat_id}">Import Sub Categories (.CSV/.XLS file)</a>&nbsp;&nbsp;-->
			{*<!--<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/category/subcat.php?cat_id={$smarty.get.cat_id}&view=excel">Deal Sub Categories Report</a>&nbsp;&nbsp;-->*}
			<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/> <a href="add_subcatimage.php?cat_id={$smarty.get.cat_id}"> Add Image</a>
		</td>
		<td align="right">
		{if $msg}<div align="left" id="msg">{$msg}</div>{/if} </td>
	    </tr>
	    <tr>
	      <td  colspan="2">
		<form name="frmAction" id="frmAction" method="post" action="">
		  <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
		    <tr class="headbg">
			<td width="2%" align="center"><input type="checkbox" id="checkall"  /></td>
			<td width="25%" align="left">Sub Image Title</td>
<!--			<td width="23%" align="left" style="display:none">Image</td>-->
              		<td width="20%" align="center">Image</td>
			<td width="10%" align="center">Add Date</td>
<!--			<td width="10%" align="center">Status</td>-->
			<td width="10%" align="center">Action</td>
		    </tr>
 		 {section name=i loop=$list}
		<tr class="grayback" id="tr_{$smarty.section.i.iteration}">
		
		  <td><input type="checkbox" name="id[]" value="{$list[i].id}" onclick="javascript:uncheckMainCheckbox();"/></td>
		  
		  
		  <td valign="middle">{if $list[i].status  eq '0'}
		            <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_1.png" align="absmiddle" title="Inactive" 
		            style="float:left; "/>
                     {else}
                          <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_2.png" title="Active" align="absmiddle" style="float:left;" />
                    {/if}&nbsp;&nbsp;{$list[i].img_title}
                </td>
		  <td valign="middle" align="center">
		  <img src="{$siteroot}/uploads/subcat_image/{$list[i].img_name}" title="{$list[i].img_name}" align="middle" style="float:left;" width="35" height="36" /> </td>
		  <td valign="middle" align="center">{$list[i].added_date|date_format:$smarty_date_format}</td>
<!--		  <td valign="middle">Order
                    <input type="text" size="2" name="{$list[i].id}" id="{$list[i].id}" value="{$list[i].sort_no}" />
                 </td>	-->	 	 
		 	 
		  <td valign="middle">
		   <div>
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                        <a href="add_subcatimage.php?edit_id={$list[i].id}&cat_id={$smarty.get.cat_id}" title="Edit">
                    <strong>Edit</strong></a>
                    </div>
                 </td>
                
		</tr>		
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $list}
		<tr>
		
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="3">
			 <select name="action" id="action">
                           <option value="">--Action--</option>
                           <option value="active">Active</option>
                           <option value="inactivate">Inactive</option>
                           <option value="delete">Delete</option>
                        </select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
<!--		    <td align="left" colspan="2"><input type="submit" name="sort_ords" id="sort_ords" value="update"/></td>-->
		</tr>
		<tr>
		    <td align="right" colspan="6">{if $showpgnation eq "yes"}{$pagenation}{/if}{$pgnation}</td>
		</tr>
		{/if}
	</table>
</form>
</div>
</div>
{include file=$footer}