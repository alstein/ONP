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

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; IP Ban

</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} IP Ban </h3>
        </div>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_ip.php">Add IP Banning</a></p>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>

    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable">   
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" /></td>
		    <td width="80%" align="left">Banned IP</td>
		    <td width="18%" align="left">Action</td>
                </tr>
                {section name=i loop=$ip}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                 <td align="center" width="2%"><input type="checkbox" name="ipid[]" value="{$ip[i].ip_id}" /></td>
		    <td valign="top"> {$ip[i].domain}</td>
		    <td>
			    <div>
			    <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
				    <a href="add_ip.php?id={$ip[i].ip_id}" class="frmtxt">Edit</a>
			    </div>
		    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="3" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $ip}
                <tr>
                    <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" colspan="2">
				<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="delete">Delete</option>
				</select> 
				<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
                    	{if $pgnation}<span class="fr">{$pgnation}</span>{/if}</td>
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}