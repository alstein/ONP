{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header2}
<div class="holdthisTop">
  <h3 class="fl width50">Manage Feedback</h3>

  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>

  <div class="fr">
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
  </div>
  <div class="clr">&nbsp;</div>
  <form name="frmAction" id="frmAction" method="post" action="">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<table width="100%"  border="0" cellpadding="10" cellspacing="2" class="listtable">
	    <tr class="headbg">
	      <td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
	      <td width="15%" align="left" valign="top">Username</td>
	      <td width="15%" align="left" valign="top">Deal Name</td>
	      <td width="15%" align="left" valign="top">Feedback Recived</td>	
	      <td width="24%" align="left" valign="top">Review</td>	
	      <td width="11%" align="left" valign="top">Posted Date</td>	
	      <td width="25%" align="left" valign="top">Action</td>	 
	  </tr>
	  {section name=i loop=$feed_info}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}">
	    <td><input type="checkbox" value="{$feed_info[i].id}" name="mesgid[]"/></td>
	    <td align="left" valign="top">{$feed_info[i].user_name}</td>
	    <td align="left" valign="top">{$feed_info[i].deal_name}</td>
	    <td  valign="top" >{$feed_info[i].total}%</td>	
	    <td valign="top">{$feed_info[i].review|truncate:50}</td>		
	    <td valign="top" >{$feed_info[i].posted_date}</td>
	    <td valign="top" ><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/feedback/view-feedback.php?id={$feed_info[i].id}"><strong>View</strong></a> |
           <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/modules/feedback/deal-feedback.php?id={$feed_info[i].deal_id}"><strong>User Feedback</strong></a>

        </td>			
	  </tr>
	  {sectionelse}
	  <tr><td colspan="5" align="center"><strong>No feedback(s) found.</strong></td></tr>
	  {/section}
	  {if $feed_info}
	  <tr>
	      <td align="right"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
	      <td align="left" width="30px" colspan="3">
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