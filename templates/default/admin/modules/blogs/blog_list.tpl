{include file=$header1}

<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqcategorylist.js"></script>

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Manage Blog
</div>
<br />

<div class="holdthisTop">
        <h3 class="fl">{$sitetitle} Manage Blog</h3>
        <span  class="fr"><img src="{$siteimg}/icons/add.png" align="absmiddle" /><a href="edit_blog.php">Add Blog</a></span><br><br><br>
        {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
        <div class="clr"></div>
    <div id="UserListDiv" name="UserListDiv">
        <form name="frmAction" id="frmAction" method="post" action="">
            <table cellspacing="2" cellpadding="3" class="listtable" width="100%" border="0">   
                <tr class="headbg">
                    <td width="2%" align="center"><input type="checkbox" id="checkall" /></td>
                    <td width="20%" align="left"><!--<a href="javascript: void(0);" onclick="javascript: changeord('name');">-->Blog Title<!--</a>--></td>
				<td width="10%" align="left">Blog Date</td>
				<td width="10%" align="left">City</td>
				<td width="35%" align="left">Description</td>
                    <td width="10%" align="left">Added Date</td>
                    <td align="left"><div style="width:80px;">Action</div></td>
                </tr>
			{section name=i loop=$blogResult}
			<tr class="grayback" id="chk{$smarty.section.i.iteration}">
				<td><input type="checkbox" value="{$blogResult[i].id}" name="blogid[]"/></td>
				<td valign="top">
					<img src="{$siteimg}/icons/{if $blogResult[i].status eq '0'}award_star_silver_1.png
					{else}award_star_silver_2.png{/if}"
					align="absmiddle" />
					{$blogResult[i].title}
				</td>
				<td valign="top">{$blogResult[i].date|date_format:$smarty_date_format}</td>
				<td valign="top">{$blogResult[i].city_name|@ucfirst}</td>
				<td valign="top">{$blogResult[i].description|substring:1:40}....</td>
				<td valign="top">{$blogResult[i].posted_date|date_format:$smarty_date_format}</td>
				<td>
					<div>
						<img src="{$siteroot}/templates/default/images/icons/film.png" align="absmiddle" />
						<a href="view_blog.php?bid={$blogResult[i].id}" title="View Blog Details">
							<strong>View</strong>
						</a>
					
						<img src="{$siteroot}/templates/default/images/icons/application_edit.png" align="absmiddle" />
						<a href="edit_blog.php?bid={$blogResult[i].id}" title="Edit Blog Details">
							<strong>Edit</strong>
						</a>
					</div>
				</td>
			</tr>
			{sectionelse}
                <tr>
                    <td colspan="7" class="error" align="center">No Records Found.</td>
                </tr>
                {/section}
                {if $blogResult}
                <tr>
                    <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
                    <td align="left" width="30px" colspan="6">
					<table border="0" width="20%">
						<tr>
						<td>
							<select name="action" id="action">
							<option value="">--Action--</option>
							<option value="Active">Active</option>
							<option value="inactivate">Inactive</option>
							<option value="delete">Delete</option>
							</select>&nbsp;
							<input type="submit" name="submit" id="submit" value="Go"  /><div id="acterr" class="error"></div>
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
