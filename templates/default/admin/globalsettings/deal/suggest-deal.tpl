{include file=$header1}
{strip}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}

{include file=$header2}
<div class="holdthisTop">
  <h3 class="fl width50">Manage Suggest Deal</h3>

  {if $msg}<div align="left" id="msg">{$msg}</div>{/if}

  <div class="clr">&nbsp;</div>
<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
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
              <td width="15%" align="left" valign="top">Product Name</td>
	      <td width="20%" align="left" valign="top">Username</td>
	      <td align="left" valign="top">Comment</td>	
	      <td width="15%" align="left" valign="top">Posted Date</td>	
	      <td width="15%" align="left" valign="top">Action</td>	 
	  </tr>
	  {section name=i loop=$msg_info}
	    <tr class="grayback" id="chk{$smarty.section.i.iteration}" >
	    <td><input type="checkbox" value="{$msg_info[i].id}" name="mesgid[]"/></td>
            <td align="left" valign="top">{$msg_info[i].product_name}<a href="{$siteroot}//admin/globalsettings/deal/suggest-deal.php?searchuser={$msg_info[i].product_name}&button=Search">&nbsp;({$msg_info[i].title1})</a></td>
	    <td align="left" valign="top">{$msg_info[i].user_name}</td>
	    <td align="left" valign="top">{$msg_info[i].comment|truncate:30}</td>		
	    <td align="left" valign="top" >{$msg_info[i].posted_date}</td>
	    <td align="left" valign="top">
              <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" /><a href=" {$siteroot}/admin/globalsettings/deal/view-suggest-deal.php?id={$msg_info[i].id}"><strong>View</strong>&nbsp;</a>
            </td>			
	  </tr>
	  {sectionelse}
	  <tr><td colspan="5" align="center"><strong>No records(s) found.</strong></td></tr>
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