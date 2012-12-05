{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Lightbox Page List 
</div>
<br/>
    <div class="holdthisTop">
	<div>
             <div class="fl width50">
                    <h3>{$sitetitle} Manage Lightbox Page List </h3>
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
                                    <td width="90%" align="left">Section Title</td>
                                    <td width="8%" align="left">Action</td>
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
                                                {/if}&nbsp;&nbsp;{$list[i].section_title}
                                            </td>
                                            <td valign="top">
                                                <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                                                <a href="manage_lightbox_page_edit.php?edit_id={$list[i].id}" title="Show Rating Details">
                                                <strong>Edit</strong></a>
                                            </td>
                                </tr>
                        {sectionelse}
                                <tr>
                                    <td colspan="3" class="error" align="center">No Records Found.</td>
                                </tr>
                            {/section}			
                            {if $list}
                                <tr>
                                        <td align="left" valign="top">
                                            <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  />
                                        </td>
                                        <td align="left" colspan="2" >
                                            <div style="float:left;">
                                                <select name="action" id="action">
                                                        <option value="">--Action--</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactivate">Inactive</option>
                                                 </select>
                                                 <input type="submit" name="submit" id="submit" value="Go"/>
                                            </div>
                                            <div style="float:right;">
                                                {if $showpgnation eq "yes"}{$pagenation}{/if}
                                            </div> <div class="clr"></div> <div id="acterr" class="error" style="display: none;"> </div>
                                        </td>
                                </tr>
                            {/if}
                </table>
            </form>
        </div>
    </div>
{include file=$footer}
