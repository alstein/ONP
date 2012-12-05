{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/categorylist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Affiliate Merchant

</div><br/>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Affiliate Merchant </h3>
        </div>
        <p align="right">{*<!--<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_excel.php">Add CSV file</a>&nbsp;&nbsp;-->*}<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_marchant.php">Add Merchant</a></p>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
       
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall"  /></td>
                    <td width="*%" align="left">Merchant Name</td>
                    <!--<td width="18%" align="left">Category Type</td>-->
				<td width="12%" align="left">Merchant Id</td>
				<td width="12%" align="center">Is Default</td>
                    <td width="12%" align="center">Add Date</td>
                    <td width="12%" align="center">Status</td>
                    <td width="15%" align="center">Action</td>
                </tr>
                {section name=i loop=$marchantResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$marchantResult[i].id}" name="catid[]"/></td>
                    <td valign="top"><img src="{$siteroot}/templates/default/images/icons/{if $marchantResult[i].status eq '0'}award_star_silver_1.png {else}award_star_silver_2.png {/if}" align="absmiddle" /> {$marchantResult[i].marchant_name}
                    </td>
                    <!--{*<td valign="top">{$marchantResult[i].category_type|ucfirst}</td>*}-->
				<td  align="left" valign="top" id="cnt1">{$marchantResult[i].marchant_id}</td>
				<td  align="center" valign="top">{if $marchantResult[i].is_defaulter}Yes{else}No{/if}</td>
                    <td valign="top" align="center">{$marchantResult[i].added_date|date_format:$smarty_date_format}</td>
                    <td valign="top" align="center">{if $marchantResult[i].status eq '1'} Active {else} Inactive {/if}</td>
                    <td align="center">
					<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
					<a href="add_marchant.php?mid={$marchantResult[i].id}" title="Edit Merchant Details"><strong>Edit</strong></a> &nbsp;|&nbsp;
				   {if $marchantResult[i].is_defaulter}<strong>Set as Default</strong>{else}
					<a href="marchant_list.php?act=setDef&mid={$marchantResult[i].id}" title="Edit Merchant Details">Set as Default</a>
				   {/if}
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="5" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}

                {if $marchantResult}
                <tr>
		    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" width="300px">
                        <select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="active">Active</option>
                            <option value="inactivate">Inactive</option>
                            <option value="delete">Delete</option>
                        </select> &nbsp; 
                        <input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
                    </td>
		    {if $showpgnation eq 'yes' }<td colspan="3" align="right">{$pgnation}</td>{/if}
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}