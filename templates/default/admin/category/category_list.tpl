{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/categorylist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Merchant Category

</div><br/>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} Merchant Category </h3>
        </div>
	<p align="right">
		<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_cat_excel.php">Import Categories (.CSV/.XLS file)</a>&nbsp;&nbsp;
		{*<!--<img align="top" src="{$siteroot}/templates/default/images/icons/excel.gif">&nbsp;<a href="{$siteroot}/admin/category/category_list.php?view=excel">Deal Categories Report</a>&nbsp;&nbsp;-->*}
		<img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="add_category.php">Add Category</a>
	</p>
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
                    <td width="40%" align="left">Category Name</td>
					<td align="left" width="15%">Total deals in category</td>
                    <!--<td width="18%" align="left">Category Type</td>-->
		   			 <td width="15%" align="center">No of Subcategory</td>
		    <!--<td width="20%" align="center">Category Images</td>-->
                    <!--<td width="15%" align="center">Add Date</td>-->
                    <!--<td width="10%" align="center">Status</td>-->
                    <td width="15%" align="center">Action</td>
                </tr>
                {section name=i loop=$categoryResult}
                <tr class="grayback" id="chk{$smarty.section.i.iteration}">
                    <td><input type="checkbox" value="{$categoryResult[i].id}" name="catid[]" id="catid"/></td>
                    <td valign="top"><img src="{$siteroot}/templates/default/images/icons/{if $categoryResult[i].active eq '0'}award_star_silver_1.png {else}award_star_silver_2.png {/if}" align="absmiddle" /> {$categoryResult[i].category}
                    </td>
					<td>{$categoryResult[i].cat_cnt}</td>
                    <!--{*<td valign="top">{$categoryResult[i].category_type|ucfirst}</td>*}-->
		    <td  align="center" valign="top" id="cnt1"><a href="{$siteroot}/admin/category/subcat.php?cat_id={$categoryResult[i].id}">Add / View ({$categoryResult[i].tot})</a></td>
		 <!--   <td  align="center" valign="top" id="cnt1"><a href="{$siteroot}/admin/category/subcatimage.php?cat_id={$categoryResult[i].id}">Image ({$categoryResult[i].imgTot})</a></td>		
                    <td valign="top" align="center">{$categoryResult[i].date|date_format:$smarty_date_format} {*$categoryResult[i].date|date_format:"%I:%M %p"*}</td>-->
                    <!--<td valign="top" align="center">{if $categoryResult[i].active eq '1'} Active {else} Inactive {/if}</td>-->
                    <td align="center">
		      <img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
		      <a href="add_category.php?cid={$categoryResult[i].id}" title="Edit Categoty Details">
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