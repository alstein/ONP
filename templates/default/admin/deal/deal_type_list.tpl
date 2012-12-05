{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/categorylist.js"></script>
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Deal Type</div><br/>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle|ucfirst} Manage Deal Type </h3>
        </div>
        <p align="right">{*<!--<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_excel.php">Add CSV file</a>&nbsp;&nbsp;-->*}<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="{$siteroot}/admin/deal/add_deal_type.php">Add Deal Type</a></p>
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
                    <td width="25%" align="left">Deal Type</td>
                    <td width="5%" align="left">Price Option</td>
		               <!--<td width="20%" align="center">No of Category</td>	
                    <td width="15%" align="center">Add Date</td>
                    <td width="10%" align="center">Status</td>-->
                    <td width="3%" align="left">Action</td>
                </tr>
                {section name=i loop=$categoryResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td align="center">{if in_array($categoryResult[i].typeid, array(1,2,3))}#{else}<input type="checkbox" value="{$categoryResult[i].typeid}" name="catid[]"/>{/if}</td>
                    <td valign="top"> {$categoryResult[i].dealtype}
                    </td>

                   <td valign="top">{$categoryResult[i].price_option}</td>
		   <!-- <td  align="center" valign="top" id="cnt1"><a href="{$siteroot}/admin/category/subcat.php?cat_id={$categoryResult[i].id}">Add / View ({$categoryResult[i].tot})</a></td>	
                    <td valign="top" align="center">{$categoryResult[i].date|date_format:"%d/%m/%Y"} {*$categoryResult[i].date|date_format:"%I:%M %p"*}</td>
                    <td valign="top" align="center">{if $categoryResult[i].active eq '1'} Active {else} Inactive {/if}</td>-->

                    <td align="left">
		      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="add_deal_type.php?dt_id={$categoryResult[i].typeid}" title="Edit Categoty Details">
			  <strong>Edit</strong>
		      </a>
                    </td>
                </tr>
                {sectionelse}
                <tr>
                    <td colspan="5" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}

                {if $categoryResult}
                <tr>
		    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" colspan="2">
                        <select name="action" id="action">
                            <option value="">--Action--</option>
                            <!--<option value="Active">Active</option>
                            <option value="Suspended">Inactive</option>-->
                            <option value="delete">Delete</option>
                        </select> &nbsp; 
                        <input type="submit" name="submit" id="submit" value="Go"/><div id="acterr" class="error"></div>
                    </td>
		    {if $showpgnation eq 'yes' }<td colspan="4" align="right">{$pgnation}</td>{/if}
                </tr>
                {/if}
            </table>
        </form>
    </div>
</div>
{include file=$footer}