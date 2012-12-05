{include file=$header1}

{strip}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>
{/strip}
{include file=$header2}


<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Photo Album List</div>
<br />
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Photo Album</h3>
	  </div>
          <div class="clr">&nbsp;</div>

     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

	  
  	</div>
	<div class="fr">
	   <form name="frmSearch" action="" method="get">
		  <table width="25%" align="right" cellpadding="0" cellspacing="0" border="0">
		    <tr>
		      <td align="right" width="20%">
			<label>
			    <input name="searchuser" type="text" id="searchuser" value="{$smarty.get.searchuser}" size="35" class="search" style="float:left"/> 
			</label>
		      </td>
		      <td width="20%" align="left">
			<input type="submit" name="button" id="button" value="Search" class="searchbutton" style="float:left"/>
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
		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		<td width="20%" align="left">Album Title</td>
		<td width="20%" align="left">User Name</td>
		<td width="40%" align="left">Album Photo</td>
		<td width="20%" align="center">Action</td>
	    </tr>
		{section name=i loop=$users}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		  <td rowspan="2" valign="top"><input type="checkbox" value="{$users[i].album_id}" name="albumid[]" id="userid"/></td>
		  <td rowspan="2" valign="top">	  <img src="{$siteimg}/icons/{if $users[i].status  eq 'Inactive'}award_star_silver_1.png
		  {else}award_star_silver_2.png{/if}" align="absmiddle" />{$users[i].album_title }</td>
		 
		  <td valign="top" rowspan="2">
			{$users[i].fullname}
                   </td>
		  <td valign="top" rowspan="2"><img src="{$siteroot}/uploads/album/thumbnail/{$users[i].image}" width="100px;" height="100px;"></td>
		
			<td rowspan="2" align="left"><img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
		      <a href="seller_photo.php?album_id={$users[i].album_id}&user_id={$smarty.get.userid}" title="Show Seller Details">
		      <strong>View</strong></a>
                </td>
		</tr>
		<tr>
			<td colspan="7" align="center"><b><!--Seller Unique URL :--> </b>
				<!--<a style="color:blue" href="{$siteroot}/seller/{$users[i].username}/{$users[i].userid}" target="_blank">{$siteroot}/seller/{$users[i].username}/{$users[i].userid}</a>-->
			</td>
		</tr>
		{sectionelse}
		    <tr><td colspan="12" class="error" align="center">No Records Found.</td></tr>
		{/section}
		{if $users}
		<tr>
		    <td align="left"><!-- <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />--></td>
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
