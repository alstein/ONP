{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Photo Comment List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Comment On {$firstname|ucfirst} Photo</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  
  	</div>
	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="50%" align="right" cellpadding="0" cellspacing="0" border="0">
			<input type="hidden" name="userid" id="userid" value="{$userid}">
			<input type="hidden" name="photoid" id="photoid" value="{$photoid}">
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

    <br><br>
    <div id="UserListDiv" name="UserListDiv">
      <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<input type="hidden" name="userid" id="userid" value="{$userid}">
		<input type="hidden" name="photoid" id="photoid" value="{$photoid}">
 		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		<td width="25%" align="left">Posted By</td>
		<td width="25%" align="left">Photo</td>
		<td width="25%" align="left">Comment</td>
		
		<td width="25%" align="left">Posted On</td>
		
	    </tr>
		{section name=i loop=$comment}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		 <td rowspan="2" valign="top"><input type="checkbox" value="{$comment[i].comment_id}" name="comment_id[]"/></td>
		  <td rowspan="2" valign="top">	  <img src="{$siteimg}/icons/{if $comment[i].status  eq 'inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$comment[i].fullname}</td>
		 
		<td valign="top" rowspan="2">
			<img  src='{$siteroot}/uploads/album/thumbnail/{$comment[i].thumbnail}'  width="100px" height="100px"></a>
			
                   </td>
		  <td valign="top" rowspan="2">
			{$comment[i].comment}
			
                   </td>
		  <td valign="top" rowspan="2">{$comment[i].posted_on|date_format:"%Y-%m-%d"}</td>
		
		
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				<!--<a style="color:blue" href="{$siteroot}/seller/{$users[i].username}/{$users[i].userid}" target="_blank">{$siteroot}/seller/{$users[i].username}/{$users[i].userid}</a>-->
			</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="12" class="error" align="center">No Records Found.</td></tr>
		{/section}
		{if $comment}
		<tr>
		    <td align="left"> <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			  <option value="">--Action--</option>
			  <option value="Active">Active</option>
			  <option value="inactivate">Inactive</option>
			  <option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="9">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>
      </form>
  </div>
</div>
{include file=$footer}
