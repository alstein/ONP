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
			$("#acterr").text("Please select atleast one option.").show().fadeOut(3000);
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

<div class="holdthisTop">
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Discussion</div><br/>

  <h3 class="fl width50">Manage Discussion</h3>
  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

  <div>
    <form name="frmSearch"  id="frmSearch" action="" method="get">
      <table width="100%" cellspacing="0" cellpadding="0">
	<tr>
          <td align="right" width="100%">
	      <span style="vertical-align:middle;"><strong>Username: </strong> </span>
	      <select id="uname" name="uname" style="width:200px;" onchange="javascript:$('#frmSearch').submit();">
		<option value="">Select</option>
		{section name=i loop=$user_list}
		{if $user_list[i].username}<option value="{$user_list[i].username}" {if $smarty.get.uname eq $user_list[i].username} selected="selected"{/if}>{$user_list[i].username}</option>{/if}
		{/section}
	      </select>
	  </td>
<!--	  <td align="right"><table width="35%" align="right" cellpadding="0" cellspacing="0">
	      <tr>
		<td width="73%" align="right"><label>
		  <input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search" />
		  </label></td>
		<td width="27%" align="left"><input type="submit" name="button" id="button" value="Submit" class="searchbutton" /></td>
	      </tr>
	    </table>
          </td>-->
	</tr>
      </table>
    </form>
  </div>
  <div class="clr">&nbsp;</div>
  <div>
    <table width="100%" cellpadding="3" cellspacing="2" border="0">
      <tr>
	<td width="100%" valign="top" align="center" colspan="2"><form name="frmAction" id="frmAction" method="post" action="">
	    <table width="100%" cellpadding="6" cellspacing="2" align="center" class="listtable">
	      <tr class="headbg">
		<td width="1%" align="center" valign="top"><input type="checkbox" id="checkall"  /></td>
		<td align="left" >Discussion</td>
		<td width="25%" valign="top" align="left">Started By</td>
		<td width="8%" align="left">Last Post </td>
		<td width="5%"  valign="top" align="left">Threads</td>
		<!--<td width="6%" align="center" valign="top">Replies</td>-->
		<td width="10%" align="left" valign="top">Action</td>
	      </tr>
	      {section name=i loop=$forumarray}
	      <tr class="grayback">
		<td colspan="7"><div style="float:left; width:80%" align="left"> <strong>{$forumarray[i].category|ucwords}</strong><br />
		    {$forumarray[i].description} </div>
		  <div style="float:right; width:16%" align="right"> <img src="{$siteroot}/templates/{$templatedir}/images/icons/add.png" align="absmiddle">&nbsp;<a href="{$siteroot}/admin/modules/forum/create_forum.php?categoryid={$forumarray[i].categoryid}">New Discussion</a> </div>
		  <div class="clr"></div></td>
	      </tr>
	      {section name=j loop=$forumarray[i].forums}
	      {if $forumarray[i].forums}
	      <tr class="grayback" id="tr_{$forumarray[i].forums[j].forumid}">
		<td width="1%" align="left" valign="top">
                <input type="checkbox" name="forumid[]" value="{$forumarray[i].forums[j].forumid}"/></td>
		<td align="left" valign="top">
                <!--<img src="{$siteroot}/templates/{$templatedir}/images/icons/{if $forumarray[i].forums[j].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />-->
                 <a href="{$siteroot}/admin/modules/forum/thread_list.php?forumid={$forumarray[i].forums[j].forumid}"> {$forumarray[i].forums[j].title}</a>
        <!--{if $forumarray[i].forums[j].verification eq 'no'}<div class="error">[not approved]</div>{/if}-->
                 </td>
		<td align="left" valign="top"><span class="orangeTitle">{$forumarray[i].forums[j].username}</span><br />
		  {$forumarray[i].forums[j].posted_date|date_format:$smarty_date_format}</span></td>
		<td align="left" valign="top">{$forumarray[i].forums[j].lastpostedon|date_format:$smarty_date_format}</td>
		<td align="left" valign="top" class="greenTitle">{$forumarray[i].forums[j].threads}</td>
		<!--<td align="center" valign="top" class="greenTitle">{$forumarray[i].forums[j].replys}</td>-->
		<td align="left" valign="top" class="greenTitle"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" />&nbsp;<a href="create_forum.php?forumid={$forumarray[i].forums[j].forumid}&act=edit">Edit</a> {if $forumarray[i].verification eq 'no'}
		  {/if} </td>
	      </tr>
	      {else}
		  <tr class="grayback">
		    <td colspan="7" align="center" class="error"> Record(s) not found</td>
		  </tr>
	      {/if}
	      {sectionelse}
	      <tr class="grayback">
		<td colspan="7" align="center" class="error"> Record(s) not found</td>
	      </tr>
	      {/section}
	      {/section}
	      <tr>
		<td align="left"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		<td align="left"><select name="action" id="action">
		    <option value="">--Action--</option>
		    <option value="delete">Delete</option>
		   <!-- <option value="approve">Approve</option>
		    <option value="active">Active</option>
		    <option value="inactive">Inactive</option>-->
		  </select>
		  <input type="submit" name="submit" id="submit" value="Go" />
		  <span id="acterr" class="error"></span></td>
		<td colspan="3">{$paging}</td>
	      </tr>
	    </table>
	  </form></td>
      </tr>
    </table>
  </div>
  </div>

{include file=$footer} 