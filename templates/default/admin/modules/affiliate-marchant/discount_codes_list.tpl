{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/categorylist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Affiliate Discount Codes List

</div><br/>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Affiliate Discount Codes List </h3>
        </div>
        <p align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_discount_codes.php">Add Discount Code</a></p>
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
                    <td width="8%" align="left">Merchant Id</td>
                    <td width="15%" align="left">Merchant Name</td>
                    <td width="15%" align="left">Code</td>
                    <td width="15%" align="left">Details</td>
                    <td width="8%" align="left">Start Date</td>
                    <td width="14%" align="left">End Date</td>
                    <td width="10%" align="left">Added Date</td>
                    <!--<td width="10%" align="center">Status</td>-->
                    <td width="25%" align="left">Action</td>
                </tr>
                {section name=i loop=$marchantResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td valign="top"><input type="checkbox" value="{$marchantResult[i].id}" name="catid[]"/></td>
                    <td valign="top"><img src="{$siteroot}/templates/default/images/icons/{if $marchantResult[i].status eq '0'}award_star_silver_1.png {else}award_star_silver_2.png {/if}" align="absmiddle" />{$marchantResult[i].iMerchantId}         </td>
                    <td  align="left" valign="top" id="cnt1"> {$marchantResult[i].iMerchantName}</td>
                    <td valign="top">{$marchantResult[i].sCode}</td>
                    <td valign="top">{$marchantResult[i].sDescription|html_entity_decode|substr:0:50}</td>
                    <td valign="top">{$marchantResult[i].sStartDate|date_format:$smarty_date_format} {*$marchantResult[i].sStartDate|date_format:"%I:%M %p"*}</td>
                    <td valign="top">{$marchantResult[i].sEndDate|date_format:$smarty_date_format} {$marchantResult[i].sEndDate|date_format:"%H:%M:%S"}</td>
                    <td valign="top" align="center">{$marchantResult[i].added_date|date_format:$smarty_date_format}</td>
                   <!-- <td valign="top" align="center">{if $marchantResult[i].status eq '1'} Active {else} Inactive {/if}</td>-->
                    <td align="left" valign="top">
		      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="add_discount_codes.php?mid={$marchantResult[i].id}" title="Edit Marchant Details">
			  <strong>Edit</strong>  </a>&nbsp;|&nbsp;<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle"/><a href="discount_codes_view.php?mid={$marchantResult[i].id}" title="view Discount Code"><strong>View</strong></a>
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="9" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}

                {if $marchantResult}
                <tr>
		    <td align="right" valign="top"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" colspan="2" >
                        <select name="action" id="action">
                            <option value="">--Action--</option>
                            <option value="active">Active</option>
                            <option value="inactivate">Inactive</option>
                            <option value="delete">Delete</option>
                        </select>  
                        <input type="submit" name="submit" id="submit" value="Go" /><div id="acterr" class="error"></div>
                    </td>
		    {if $showpgnation eq 'yes' }<td colspan="4" align="right">{$pgnation}</td>{/if}
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}