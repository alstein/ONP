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
	
	$("#frmAction").submit(function(){
		var flag = false;
		if($("#action").attr('value')=='')
		{
			//$("#acterr").text("Please Select Action.").show().fadeOut(3000);
			alert("Please Select Action");
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
		//	$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			alert("Please Select Checkbox");
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
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Site modules &gt; Categories </div>
<br />
<h3> &nbsp; Category </h3>
<div align="center"><span class="success">{$msg}</span></div>
<table cellpadding="6" cellspacing="2" align="center" width="100%" border="0">
    <tr>
    <td align="left"><img src="{$siteroot}/templates/default/images/icons/add.png" align="absmiddle" /> <a href=" {$siteroot}/admin/sitemodules/deal/add_deal_cat.php">Add category</a></td>
    <td align="right"></td>
  </tr>
  <tr>
    <td  colspan="2"><form name="frmAction" id="frmAction" method="post" action="">
        <table cellpadding="6" cellspacing="2" align="center" width="100%" border="0" class="listtable">
          <tr class='headbg'>
            <td align="center" width="1%"><input type="checkbox" id="checkall" /></td>
            <td align="left" width="50%">Category</td>
            <td align="left" width="20%">Description </td>
            <td align="left" width="12%">Status</td>
            <td align="left" width="18%">Action</td>
          </tr>
          {section name=i loop=$category}
          <tr class="grayback" id="tr_{$category[i].cate_id}">
            <td align="center" valign="top" width="1%"><input type="checkbox" name="categoryid[]" value="{$category[i].cate_id}" /></td>
            <td align="left" valign="top" width="50%"><img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $category[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />{$category[i].category_name|capitalize}</td>
            <td align="left" valign="top" width="20%">{$category[i].description|truncate:100}...<a href="{$siteroot}/admin/sitemodules/deal/view_deal_category.php?id={$category[i].cate_id}">Read more</a></td>

            <td width="12%" align="left" valign="top">{if $category[i].status eq 'Active'} Active {elseif $category[i].status eq 'Inactive'} Inactive{/if}</td>
            <td align="left" valign="top" width="18%"> { if $msi eq "" } <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="{$siteroot}/admin/sitemodules/deal/add_deal_cat.php?act=edit&amp;id={$category[i].cate_id}" >Edit</a>{/if}</td>
          </tr>
          {sectionelse}
          <tr align="center" class="trbgprj02">
            <Td colspan="7"><b> No record(s) found. </b></Td>
          </tr>
          {/section}
          <tr>
            <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go" class="button1" />
              <span id="acterr" class="error"></span></td>
            <td colspan="3" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>
		<!--<td colspan="2" align="right">{if $showpaging eq "yes" }{$pgnation}{/if}</td>-->
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</form>
{include file=$footer}