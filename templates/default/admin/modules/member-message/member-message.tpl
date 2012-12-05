{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header2}
<div class="holdthisTop">
  <h3 class="fl">Manage Member Messages</h3>

  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

 <!-- <div class="fr">
    <form id="frm" name="frm" method="GET">
      <table>
      <tr>
	  <td valign="middle"><strong>Username: </strong></td>
          <td>
	  <select id="uname" name="uname" style="width:150px;" onchange="javascript:$('#frm').submit();">
	    <option value="">Select</option>
	    {section name=i loop=$user_list}
	    {if $user_list[i].username}<option value="{$user_list[i].username}" {if $smarty.get.uname eq $user_list[i].username} selected="selected"{/if}>{$user_list[i].username}</option>{/if}
	    {/section}
	  </select>
          </td>
        </tr>
      </table>
      </form>
  </div>-->
  <div class="clr">&nbsp;</div>
  <form name="frmAction" id="frmAction" method="post" action="">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<table width="100%"  border="0" cellpadding="10" cellspacing="2" class="listtable">
	    <tr class="headbg">
	      <td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
	      <td width="15%" align="left" valign="top">Receiver's Name</td>
	      <td width="15%" align="left" valign="top">Sender's Name</td>
	      <td width="15%" align="left" valign="top">Question Topic</td>	
	      <td width="27%" align="left" valign="top">Question</td>	
	      <td width="12%" align="center" valign="top">Posted Date</td>	
	      <td width="15%" align="center" valign="top">Action</td>	 
	  </tr>
	  {section name=i loop=$msg_info}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}">
	    <td><input type="checkbox" value="{$msg_info[i].id}" name="mesgid[]"/></td>
	    <td align="left" valign="top">{$msg_info[i].user_name}&nbsp;&nbsp;&nbsp;
		
		{if $msg_info[i].user_id neq 1}
		<a href=" {$siteroot}/admin/modules/member-message/compose.php?id={$msg_info[i].id}&user=receiver"><strong>Reply</strong></a>
		{/if}
		</td>
	    <td align="left" valign="top">{$msg_info[i].from_name} &nbsp;&nbsp;&nbsp;
	{if $msg_info[i].from_id neq 1}	
 <a href=" {$siteroot}/admin/modules/member-message/compose.php?id={$msg_info[i].id}"><strong>Reply</strong></a>
	{/if}
		</td>
	    <td align="left" valign="top" >{$msg_info[i].subject|substr:0:50}</td>	
	    <td align="left" valign="top">{$msg_info[i].message|truncate:30}</td>		
	    <td align="left" valign="top" >{$msg_info[i].posted_date}</td>
	    <td  valign="top"  align="center">
              <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/member-message/view-member-message.php?id={$msg_info[i].id}"><strong>View</strong>&nbsp;</a>
	     <!-- <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/member-message/compose.php?id={$msg_info[i].id}"><strong>Reply {$msg_info[i].from_name}</strong></a><br/>
		<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		<a href=" {$siteroot}/admin/modules/member-message/compose.php?id={$msg_info[i].id}&user=receiver"><strong>Reply {$msg_info[i].user_name}</strong></a>-->
            </td>			
	  </tr>
	  {sectionelse}
	  <tr><td colspan="5" align="center"><strong>No user message(s) found.</strong></td></tr>
	  {/section}
	  {if $msg_info}
	  <tr>
	      <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
	      <td align="left" colspan="2">
		  <select name="action" id="action">
-		    <option value="">--Action--</option>
		    <option value="delete">Delete</option>
		  </select>
		  <input type="submit" name="submit" id="submit" value="Go"  />
		  <div id="acterr" class="error"></div>
	      </td>
	      {if $showpaging eq 'yes'}<td colspan="4" align="right">{$pagenation}</td>{/if}
	  </tr>
	  {/if}
        </form>
	</table>
      </td>
    </tr>
  </table>
</div>
{include file=$footer}