{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/citylist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; 
<a href="{$siteroot}/admin/country/country_list.php">Country List</a> &gt; 
<a href="{$siteroot}/admin/state/state_list.php?stateid={$state.id}&contryid={$country.countryid}">County/State</a> &gt; City/Town
</div>

<div class="holdthisTop">
	<div>
		<div class="fl width50">
			<h3>{$sitetitle} City/Town</h3><br>
			<h3>Country Name: {$country.country|ucfirst}</h3><br>
			<h3>County/State: {$state.state_name|ucfirst}</h3>
		</div>
		<div style="clear:both;"></div>
		<p align="right">
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_excel.php?stateid={$state.id}&contryid={$country.countryid}">Import City/Town (.CSV/.XLS file)</a>&nbsp;&nbsp;
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="{$siteroot}/admin/city/add_city.php?stateid={$state.id}&contryid={$country.countryid}">Add City/Town</a>
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
                    <td width="*%" align="left">City/Town</td>
                    <td width="16%" align="left">Status (Active/Inactive)</td>         
                    <td width="15%" align="left"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$cityResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$cityResult[i].city_id}" name="cityid[]"/></td>
                    <td valign="top">
                        <img src="{$siteimg}/icons/{if $cityResult[i].status  eq 'Inactive'}award_star_silver_1.png
                        {else}award_star_silver_2.png{/if}"
                        align="absmiddle" />
                        {$cityResult[i].city_name|ucfirst}
                    </td>
                    <td valign="top">{if $cityResult[i].status eq 'Active'} Active {else} Inactive {/if}</td>
                    <td>
                        <div>
                           <!-- <img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
                                <a href="city_view.php?ctid={$cityResult[i].city_id}" title="Show category Details">
                                    <strong>View</strong>
                                </a> &nbsp; &nbsp; -->
                            <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                                <a href="add_city.php?cid={$cityResult[i].city_id}&stateid={$state.id}&contryid={$country.countryid}" title="Edit City Details">
                                    <strong>Edit</strong>
                                </a>
                        </div>
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="4" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $cityResult}
                <tr>
							<td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" colspan="2">
                        <select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="active">Active</option>
                            <option value="inactivate">Inactive</option>
                            <option value="delete">Delete</option>
                        </select>
                    <input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div></td>
                   <td align="right" colspan="2">{if $showpgnation eq "yes"}{$pagenation}{/if}</td>
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}