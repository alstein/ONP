{include file=$header1}

<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqcategorylist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Package List 
</div>
<div class="holdthisTop">
        <h3>{$sitetitle} Package List</h3><br/>
        <span  class="fr"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_package.php">Add New Package</a></span>
        {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
        <div class="clr"></div>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" /></td>
                    <td width="20%" align="left">Package Name</td>
                   
                     <td width="20%" align="left">Package Price&#163;</td>
                      <td width="20%" align="left">Pack Duration (Months)</td>
                    <td width="20%" align="left">Status (Active/Inactive)</td> 
                    <td align="left"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$packageResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$packageResult[i].id}" name="catid[]"/></td>
                    <td><img src="{$siteimg}/icons/{if $packageResult[i].status  eq '0'}award_star_silver_1.png
                                {else}award_star_silver_2.png{/if}"
                                align="absmiddle" />{$packageResult[i].pack_name}</td>
                    <td>{$packageResult[i].pack_price}</td>
                    <td valign="top">						
                    {$packageResult[i].pack_duration}	
                    </td>
                    <td valign="top"> {if $packageResult[i].status eq '1'} Active {else} Inactive {/if}</td>				
                    <td>
                      <div>
                      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                    <a href="edit_package.php?editid={$packageResult[i].id}" title="Edit Categoty Details">
                    <strong>Edit</strong></a>
                    </div>
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="6" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $packageResult}
                <tr>
                    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" width="30px" colspan="5">
			
		<table border="0" width="100%">
			<tr>
			<td width="30px" valign="top">
				<select name="action" id="action">
				<option value="">--Action--</option>
				<option value="active">Active</option>
				<option value="inactivate">Inactive</option>
				<option value="delete">Delete</option>
				</select></td><td><input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
			</td>
			</tr>
		</table>

</td>
                    <!--<td align="right" colspan="3">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>-->
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}
