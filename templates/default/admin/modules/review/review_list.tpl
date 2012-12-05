{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Review List 
</div>
<br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Review</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	<!--  <div class="fl width50">
	     <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="add_user.php">Add New Buyer</a>
          </div>-->
  	</div>

      <div class="clr">&nbsp;
	<!--<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/user/users_list.php?view=excel"><strong>Rating Info</strong></a>-->
	</div>
    <div id="UserListDiv" name="UserListDiv">
    <!--{if $msg}<div align="center" id="msg">{$msg}</div>{/if}-->
       <form name="frmAction" id="frmAction" method="post" action="review_list.php">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="1%" align="center"><input type="checkbox" id="checkall"/></td>
		  <td width="15%" align="left">Deal Name</td>
		  <td width="15%" align="left">Review text</td>
		  <td width="15%" align="left">Date</td>
		 <td width="15%" align="left">Reviewer Name</td>		 
		  <td width="10%" align="left">Action</td>
	    </tr>
		{section name=i loop=$ratingmark}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">
		
		  <td valign="top"><input type="checkbox" value="{$ratingmark[i].review_id}" id="review_id[]" name="review_id[]"/></td>
		  
		  <td valign="top">
                      <!--<img src="{$siteimg}/icons/{if $users[i].status  eq 'inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />-->
                     <a href="review_view.php?review_id={$ratingmark[i].review_id}" title="Show Review Details"><!--{$ratingmark[i].deal_id}{$dealname}-->{$ratingmark[i].title}</a>
		  </td>
		  
		  <td valign="top"></a> {$ratingmark[i].review_text|truncate:100}</td>
		  
		  <td valign="top">{$ratingmark[i].review_date|date_format:$smarty_date_format}	</td>
		  
		 <td valign="top"><!--{$ratingmark[i].review_text}-->{$ratingmark[i].review_name}</td>		 
		  <td valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/>
		      <a href="review_view.php?review_id={$ratingmark[i].review_id}" title="Show Review Details">
		      <strong>View</strong></a>
                </td>
		</tr>
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $ratingmark}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="3">
			<select name="action" id="action">
			<option value="">--Action--</option>
			<option value="delete">Delete</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="6">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}
