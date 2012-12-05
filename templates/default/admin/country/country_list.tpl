 {include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/countrylist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Country List</div>
<br />
<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} Country</h3>
        </div>
		<p align="right">
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_excel.php">Import Countries (.CSV/.XLS file)</a>&nbsp;&nbsp;
			<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="{$siteroot}/admin/country/edit_country.php">Add Country</a></p><br>
	<!--<a href="edit_country.php" class="thickbox">-->
<div class="fr">
		<form name="frmSearch" action="" method="get">
			<table  align="right" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="right">
						<label>
							<input name="search" type="text" id="search" value="{$smarty.get.search}" size="35" class="search"/> 
						</label>
					</td>
					<td align="left">
						<input type="submit" name="button" id="button" value="Search" class="searchbutton" />
					</td>
				</tr>
			</table>
		</form>
	</div>
    </div>
        <div class="clr">
        </div><br/>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>

    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%">
            <tr class="headbg">
                    <td width="2%" align="left"><input type="checkbox" id="checkall" /></td>
                    <td width="30%" align="left">Country Name</td>
                    <td width="*%" align="left">Status (Active/Inactive)</td>
                    <td width="*%" align="left">Manage County/State</td>
                    <td width="10%" align="left">VAT</td>
                    <td width="15%" align="left"><div style="width:80px;">Action</div></td>
                </tr>
                {section name=i loop=$countryResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$countryResult[i].countryid}" name="countryid[]"/></td>
                    <td valign="top">
                        <img src="{$siteimg}/icons/{if $countryResult[i].status eq "Active"}award_star_silver_2.png
                        {else}award_star_silver_1.png{/if}"
                        align="absmiddle" />{$countryResult[i].country|ucfirst}</a>
                    </td>
                    <td valign="top">{if $countryResult[i].status eq "Active"} Active {else} Inactive {/if}</td>
                    <td valign="top">
                    <a href="{$siteroot}/admin/state/state_list.php?contryid={$countryResult[i].countryid}">
                    County/State({$countryResult[i].country_count})</a></td>
                    <td valign="top">{if $countryResult[i].vat} {$countryResult[i].vat}{else}-----{/if}</td>
                    
                    <td>
                        <div>
                            <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
                                <a href="edit_country.php?countryid={$countryResult[i].countryid}" title="Edit Country Details">
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
                {if $countryResult}
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
                   <td align="right" colspan="4">{if $showpgnation eq "yes"}{$pgnation}{/if}</td>
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}