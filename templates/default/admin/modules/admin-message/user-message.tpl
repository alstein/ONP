{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header2}
<div class="holdthisTop">
  <h3 class="fl">Manage Admin Messages</h3>

  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

  <div class="fr">
    <form id="frm" name="frm" method="GET">
      <table>
      <tr>
	  <td valign="middle"><strong>Username: </strong></td>
          <td>
	    <select id="mtype" name="mtype" style="width:150px;" onchange="javascript:$('#frm').submit();">
	      <option value="Inbox" {if $smarty.get.mtype eq 'Inbox'} selected="selected"{/if}>Inbox</option>
	      <option value="Sent" {if $smarty.get.mtype eq 'Sent'} selected="selected"{/if}>Sent</option>
	    </select>
          </td>
        </tr>
      </table>
      </form>
  </div>
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
	      <td width="15%" align="left" valign="top">Subject</td>	
	      <td width="27%" align="left" valign="top">Message</td>	
	      <td width="13%" align="left" valign="top">Posted Date</td>	
	      <td width="15%" align="left" valign="top">Action</td>	  
	  </tr>
	  {section name=i loop=$msg_info}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}" 
                {if $msg_info[i].is_RRead eq 'No' and $smarty.get.mtype neq 'Sent'}
		    style="font-weight:bold;"
	    {/if}>
	    <td><input type="checkbox" value="{$msg_info[i].id}" name="mesgid[]"/></td>
	    <td align="left" valign="top">{$msg_info[i].user_name}</td>
	    <td align="left" valign="top">{$msg_info[i].from_name}</td>
	    <td align="left" valign="top" >{$msg_info[i].subject|substr:0:50}</td>	
	    <td align="left" valign="top">{$msg_info[i].message|truncate:30}</td>		
	    <td align="center" valign="top" >{$msg_info[i].posted_date}</td>
	    <td align="center" valign="top" >
              <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/admin-message/view-message.php?id={$msg_info[i].id}{if $smarty.get.mtype neq 'Sent'}&type=inbox{/if}"><strong>View</strong>&nbsp;</a>
	      <!--<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/admin-message/compose.php?id={$msg_info[i].id}"><strong>Reply</strong></a>-->
            </td>			
	  </tr>
	  {sectionelse}
	  <tr><td colspan="5" align="center"><strong>No message(s) found.</strong></td></tr>
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