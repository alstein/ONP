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
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Refer a Friend</div><br/>
<h3>Refer a Friend List</h3>

 {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
 
    <div class="holdthisTop">
    </div>
        <div class="holdthisTop"> 
            <form name="frmAction" id="frmAction" method="post" action="">
                <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
                    <tr class="headbg">
                        <td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"/></td>
                        <td width="15%" align="left" valign="top"><strong>Deal Name</strong></td>
                        <td width="15%" align="left" valign="top"><strong>User Name</strong></td>
                        <td width="15%" align="left" valign="top"><strong>User Email</strong></td>
                        <td width="15%" align="left" valign="top"><strong>Date</strong></td>
                        <td width="5%" align="left" valign="top">Action</td>
                    </tr>
                {section name=i loop=$list}
                <tr class="grayback"  id="tr_{$smarty.section.i.list}">
                     <td align="left" valign="top"><input name="dau_id[]" id="dau_id[]" value="{$list[i].dau_id}" type="checkbox" /> </td>
                     <td align="left" valign="top">{$list[i].title|html_entity_decode}</td>
                     <td align="left" valign="top">{$list[i].first_name}&nbsp;{$list[i].last_name}</td>
                     <td align="left" valign="top">{$list[i].email}</td>
                     <td align="left" valign="top">{$list[i].dau_date|date_format:$smarty_date_format}</td>
                    <td><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /> <a href="view_refer_friend.php?dau_id={$list[i].dau_id}" title="View">View</a></td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="6" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $list}
                    <tr>
                        <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                        <td align="left" colspan="2"><select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="delete">Delete</option>
                        </select>
                        <input type="submit" name="submit" id="submit" value="Go" />
                        <span id="acterr" class="error"></span></td>
                        <td colspan="3" align="right">{if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                    </tr>
                {/if}
                </table>
            </form>
        </div>
{include file=$footer} 

