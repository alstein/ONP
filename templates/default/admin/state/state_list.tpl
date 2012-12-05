{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/statelist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/country/country_list.php">Country List</a> &gt; County/State
</div>
<br />

<div class="holdthisTop">
    <div>
		<div class="fl width50">
			<h3>{$sitetitle} County/State</h3><br>
			<h3>Country Name: {$contryname.country|ucfirst}</h3>
		</div>
		<div style="clear:both;"></div>
		<p align="right">
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_excel.php?countryid={$contryname.countryid}">Import County/State (.CSV/.XLS file)</a>&nbsp;&nbsp;
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="{$siteroot}/admin/state/edit_state.php?countryid={$contryname.countryid}">Add County/State</a>
		</p>
	<!--<a href="add_city.php" class="thickbox">-->
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
       
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">
            <tr class="headbg">
                    <td width="2%" align="left"><input type="checkbox" id="checkall" /></td>
                    <td width="*%" align="left">County/State</td>
                    <!--<td width="*%" align="left">Country Name</td>-->
                    <td width="16%" align="left">Status (Active/Inactive)</td>
                    <td width="15%" align="left">Manage City/Town</td>         
                    <td width="15%" align="left"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$stateResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$stateResult[i].id}" name="stateid[]"/></td>
                    <td valign="top">
                        <img src="{$siteimg}/icons/{if $stateResult[i].active  eq 1}award_star_silver_2.png
                        {else}award_star_silver_1.png{/if}"
                        align="absmiddle" />{$stateResult[i].state_name|ucfirst}</a>
                    </td>
                    <!--<td valign="top">{$stateResult[i].country_name|ucfirst}</td>-->
                    <td valign="top">{if $stateResult[i].active eq 1} Active {else} Inactive {/if}</td>
                    <td valign="top"> <a href="{$siteroot}/admin/city/city_list.php?stateid={$stateResult[i].id}">City/Town({$stateResult[i].city_count})</a></td>
                    <td>
                        <div>
                            <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                                <a href="edit_state.php?stateid={$stateResult[i].id}&countryid={$contryname.countryid}" title="Edit State Details">
                                    <strong>Edit</strong>
                                </a>
                        </div>
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="5" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $stateResult}
                <tr>
		<td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left">
                        <select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="active">Active</option>
                            <option value="inactivate">Inactive</option>
                            <option value="delete">Delete</option>
                        </select>
                    <input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div></td>
                   <td align="right" colspan="3">{if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}