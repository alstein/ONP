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
		
		var alen = $("input[id=log]:checked").length;
		if(alen<=0)
			flag=false;

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
{literal}
<script type="text/javascript">
function sort_all(s_name,s_type)
{
    var str_url = SITEROOT+"/admin/login/admin-login-log.php?sortby="+s_name+"&sorttype="+s_type;

    var pg=document.getElementById('pg').value;
    if(pg)
        str_url = str_url+"&page="+pg;

    window.location=str_url;
}
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Admin Login List</div><br/>

 {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
<div class="holdthisTop"> </div>
<div class="holdthisTop"> 
<!--<div><img src="{$siteimg}/icons/excel.gif" align="top"> <a href="{$siteroot}/admin/login/user-login-log.php?view=excel"><strong>Export Report </strong></a></div>-->
  <form name="frmAction" id="frmAction" method="post" action="">
  <input type="hidden" id="pg" name="pg" value="{if $smarty.get.page}{$smarty.get.page}{else}1{/if}">
    <table width="100%" cellspacing="2" cellpadding="6" class="listtable">
      <tr class="headbg">
        <td width="1%" align="left" valign="top"><input type="checkbox" id="checkall"  /></td>
        <td width="20%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('first_name',document.getElementById('sorttype_name').value);"><strong>User Name</strong></a>
			<input type="hidden" name="sorttype_name" id="sorttype_name" value="{if $sorttype_name}{$sorttype_name}{else}ASC{/if}"/></td>
        <td width="20%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('signup_date',document.getElementById('sorttype_signup').value);"><strong>Last Login</strong></a>
      	<input type="hidden" name="sorttype_signup" id="sorttype_signup" value="{if $sorttype_signup}{$sorttype_signup}{else}ASC{/if}"/></td>
        <td width="20%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('signup_out',document.getElementById('sorttype_out').value);"><strong>Log Out Time</strong></a>
      	<input type="hidden" name="sorttype_out" id="sorttype_out" value="{if $sorttype_out}{$sorttype_out}{else}ASC{/if}"/></td>
        <td width="15%" align="left" valign="top"><a href="javascript:void(0)" onclick="sort_all('ip_address',document.getElementById('sorttype_ipaddress').value);"><strong>IP Address</strong></a>
      	<input type="hidden" name="sorttype_ipaddress" id="sorttype_ipaddress" value="{if $sorttype_ipaddress}{$sorttype_ipaddress}{else}ASC{/if}"/></td>
		  <td width="15%" align="left" valign="top">Success</td>
      </tr>
      {section name=i loop=$users}
      <tr class="grayback"  id="tr_{$users[i].id}">
        <td align="left" valign="top"><input name="log[]" id="log" value="{$users[i].id}" type="checkbox" />
        </td>
        <td align="left" valign="top">{$users[i].username}</td>
        <td align="left" valign="top">{$users[i].login_date|date_format:$smarty_date_format}  {$users[i].login_date|date_format:"%I:%M %p"}</td>
        <td align="left" valign="top">{if $users[i].logout_date eq '0000-00-00 00:00:00'}0000-00-00 00:00:00{else}
        {$users[i].logout_date|date_format:$smarty_date_format}  {$users[i].logout_date|date_format:" %I:%M %p"}{/if}</td>
        <td align="left" valign="top">{$users[i].ipaddress}&nbsp;</td>
        <td align="left" valign="top">{$users[i].success}&nbsp;</td>
      </tr>
      {sectionelse}
      <tr>
        <td colspan="10" class="error" align="center">No Records Found.</td>
      </tr>
      {/section}
      <tr>
            <td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
            <td align="left"><select name="action" id="action">
                <option value="">--Action--</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" id="submit" value="Go" /><br>
              <span id="acterr" class="error"></span></td>
            <td colspan="3" align="right">{$pagenation}</td>
          </tr>
    </table>
  </form>
</div>
{include file=$footer} 