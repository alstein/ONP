{include file=$header1}
<!--<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>-->
<!--<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Rating Question List</div><br/>
<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle} Manage Rating Question List</h3>
	  </div>
          <div class="clr">&nbsp;</div> <span  class="fr"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_rating_question.php">Add New Rating Question</a></span>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
  	</div>

      <div class="clr">&nbsp;
    </div>
    <div id="UserListDiv" name="UserListDiv">  
       <form name="frmAction" id="frmAction" method="post" action="" enctype="multipart/form-data">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="2%" align="center"><input type="checkbox" id="checkall" name="checkall"/></td>
		  <td width="68%" align="left">Rating Question</td>		  
		   <td width="15%" align="left">Date</td>		 
		  <td width="15%" align="left">Action</td>
	    </tr>	    
		 {section name=i loop=$list}
		<tr class="grayback" id="tr_{$smarty.section.i.iteration}">
		
		  <td><input type="checkbox" name="id[]" id="id[]" value="{$list[i].id}"/></td>
		  
		  
		  <td valign="middle">{if $list[i].status  eq 'inactive'}
		            <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_1.png" align="absmiddle" title="Inactive" 
		            style="float:left; "/>
                     {else}
                          <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_2.png" title="Active" align="middle" style="float:left;" />
                    {/if}&nbsp;&nbsp;{$list[i].rating_question}		  
                </td>
		 <td valign="middle">{$list[i].added_date|date_format:$smarty_date_format}</td>	
		  <td valign="middle">
		   <div>
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                        <a href="add_rating_question.php?edit_id={$list[i].id}" title="Edit">
                    <strong>Edit</strong></a>
                    </div>
                 </td>
		</tr>		
		{sectionelse}
			<tr><td colspan="6" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $list}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan="2">
			 <select name="action" id="action">
                           <option value="">--Action--</option>
                           <option value="active">Active</option>
                           <option value="inactivate">Inactive</option>
                           <option value="delete">Delete</option>
                        </select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="7">{if $showpgnation eq "yes"}{$pagenation}{/if}{$pgnation}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}
