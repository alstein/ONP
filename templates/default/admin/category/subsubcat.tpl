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
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/category/category_list.php">Main Categories</a> &gt;<a href="{$siteroot}/admin/category/subcat.php?cat_id={$main_cat_id}">Sub Categories List</a> &gt;Sub Sub Categories List</div><br />
	<table cellpadding="6" cellspacing="2" align="center" width="80%" border="0">
	   <!-- <tr>
		<td colspan="2"><h3>Main Category : {$maincatname}</h3></td>
	    </tr>
	     <tr>
		<td colspan="2"><h3>Sub Category : {$subcatname}</h3></td>
	    </tr>-->
	    
	      {$categoryHirarchy}
	      <tr>
		<td colspan="2"><h3>Sub Sub Categories List</h3></td>
	    </tr>
	    <tr>
		<td align="left">
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_sub_sub_cat_excel.php?cat_id={$smarty.get.cat_id}">Import Sub Sub Categories (.CSV/.XLS file)</a>&nbsp;&nbsp;
			{*<!--<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/category/subsubcat.php?cat_id={$smarty.get.cat_id}&view=excel">Deal Sub Sub Categories Report</a>&nbsp;&nbsp;-->*}
			<img src="{$siteroot}/templates/default/images/icons/add.png"  align="absmiddle"/> 
			<a href="add_subsubcat.php?cat_id={$smarty.get.cat_id}"> Add Sub Sub Categories</a>
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
			<td width="25%" align="left">Sub Sub Category Name</td>
			<td width="23%" align="left" style="display:none">Category Type</td>
               		<td width="20%" align="center">No of Category</td>
		    	<td width="20%" align="center">Category Images</td>
			<td width="10%" align="center">Add Date</td>
			<td width="10%" align="center">Status</td>
			<td width="10%" align="center">Action</td>
		    </tr>
    
		    {section name=i loop=$sub_cat}
		    <tr class="grayback" id="chk{$smarty.section.i.iteration}">
			<td><input type="checkbox" value="{$sub_cat[i].id}" name="catid[]"/></td>
			<td valign="top"><img src="{$siteroot}/templates/default/images/icons/{if $sub_cat[i].active eq '0'}award_star_silver_1.png {else}award_star_silver_2.png {/if}" align="absmiddle" /> {$sub_cat[i].category}
			</td>	
			<td valign="top" style="display:none">{$sub_cat[i].category_type|ucfirst} </td>
              		<td  align="center" valign="top" id="cnt1"><a href="{$siteroot}/admin/category/subsubsubcat.php?cat_id={$sub_cat[i].id}">Add / View ({$sub_cat[i].tot})</a></td>
             		<td  align="center" valign="top" id="cnt1"><a href="{$siteroot}/admin/category/subsubsubcatimage.php?cat_id={$sub_cat[i].id}">Image ({$sub_cat[i].imgTot})</a></td>
			<td valign="top" align="center">{$sub_cat[i].date|date_format:$smarty_date_format}</td>
			<td valign="top" align="center">{if $sub_cat[i].active eq '1'} Active {else} Inactive {/if}</td>
			<td align="center">
			  <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
			  <a href="add_subsubcat.php?act=edit&amp;id={$sub_cat[i].id}&cat_id={$smarty.get.cat_id}" class="frmtxt">
			      <strong>Edit</strong>
			  </a>
			</td>
		    </tr>
  

		    {sectionelse}
		    <tr align="center" class="trbgprj02">
			<td colspan="6" class="success" align="center"><b>No sub categories found .</b></td>
		    </tr>
		    {/section}
		    <tr>
			<td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
			<td align="left" colspan="2">
			    <select name="action" id="action">
				<option value="">--Action--</option>
				<option value="delete">Delete</option>
				<option value="active">Active</option>
				<option value="inactive">Inactive</option>
			    </select>
			    <input type="submit"  value="Go" />
			    <span id="acterr" class="error"></span>
			</td> 
			{if $showpgnation eq 'yes' }
			<td colspan="4" align="right">{$pgnation}</td>
			{/if}
		    </tr>
		  </table>
		</form>
	      </td>
	    </tr>
        </table>
{include file=$footer}