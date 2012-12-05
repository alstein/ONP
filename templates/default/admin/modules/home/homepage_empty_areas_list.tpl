{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Homepage Empty Areas List 
</div>
<br/>

<div class="holdthisTop">
	<div>
             <div class="fl width50">
                    <h3>{$sitetitle} Homepage Empty Areas List </h3>
             </div>
            <div class="clr">&nbsp;</div>
        </div>
        <div class="clr">&nbsp;</div>
    <div id="UserListDiv" name="UserListDiv">
    {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
       <form name="frmAction" id="frmAction" method="post" action="">
	<table cellspacing="2" cellpadding="3" class="listtable" width="100%">	
	    <tr class="headbg">			
		<td width="2%" align="center"><input type="checkbox" id="checkall"/></td>
		  <td width="30%" align="left">Section Title</td>
		  <td width="60%" align="left">Display As</td>
		  <td width="10%" align="left">Action</td>
	    </tr>
		{section name=i loop=$list}
		<tr class="grayback" id="chk{$smarty.section.i.iteration}">		
                    <td><input type="checkbox" value="{$list[i].id}" id="id[]" name="id[]"/></td>
                    <td valign="top">
                    {if $list[i].status  eq '0'}
		            <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_1.png" align="absmiddle" title="Inactive" 
		            style="float:left; "/>
                     {else}
                          <img src="{$siteroot}/templates/{$templatedir}/images/icons/award_star_silver_2.png" title="Active" align="middle" style="float:left;" />
                    {/if}&nbsp;&nbsp;{$list[i].section_title}</td>
                    <td valign="top" width="30%">
                    {if $list[i].display_by  eq 'none'}
                             {$list[i].display_by}
                    {elseif $list[i].display_by  eq 'image'}
                            <img src="{$siteroot}/uploads/home/{$list[i].image_file}" title="{$list[i].image_file}" align="middle" style="float:left;" width="51" height="33" />
                    {else}
                           <p style="width:500px; word-wrap:break-word;">{$list[i].text_message|html_entity_decode}</p>
                    {/if}

                    </td>
                    <td valign="top">
                        <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                        <a href="homepage_empty_areas_edit.php?edit_id={$list[i].id}" title="Show Rating Details">
                        <strong>Edit</strong></a>
                    </td>
		</tr>
		{sectionelse}
			<tr><td colspan="3" class="error" align="center">No Records Found.</td></tr>
		{/section}			
		{if $list}
		<tr>
		    <td align="left">
		        <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
		    </td>
		    <td align="left" colspan=1>
			<select name="action" id="action">
			 <option value="">--Action--</option>
                           <option value="active">Active</option>
                           <option value="inactivate">Inactive</option>
			</select>
			<input type="submit" name="submit" id="submit" value="Go"/>
		        <div id="acterr" class="error"></div>
		    </td>
		    <td align="right" colspan="2">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
		</tr>
		{/if}
	</table>

</form></div>
</div>
{include file=$footer}
