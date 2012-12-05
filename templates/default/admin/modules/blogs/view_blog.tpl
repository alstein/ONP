{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>

{literal}
<script language="JavaScript">
	$(document).ready(function()
{
    $("#frmRegistration").validate({
		errorElement:'div',
		rules: {
				comment:
				{
					required: true
				}
			},
		messages:
			{
				comment:
				{
					required: "Please enter comment"
				}
			}
	});
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/blogs/blog_list.php"> Manage Blog</a>
 &gt;View Blog
 
</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} View Blog</h3>
        </div>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv" >
        <div>
        <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="8" cellpadding="1" style="border:1px solid gray;">
			<tr>
				<td colspan="2" align="right"><a href="{$siteroot}/admin/modules/blogs/blog_list.php"><b>Back</b></a></td>
			</tr>
			<tr>
				<td width="60%">
					<table width="100%" border="0" cellspacing="8" cellpadding="1">
						<tr>
							<td align="left" width="28%" valign="middle"><b>Blog Title </b></td>
							<td align="left" width="2%" valign="middle"> : </td>
							<td align="left" width="70%" valign="top">
								<b>{$row.title}</b>
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle"><b>Date </b></td>
							<td align="left" valign="middle"> : </td>
							<td align="left" valign="top">
								{$row.date|date_format:$smarty_date_format}
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle"><b>City </b></td>
							<td align="left" valign="middle"> : </td>
							<td align="left" valign="top">
								{$row.city_name|@ucfirst}
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>Description </b></td>
							<td align="left" valign="top"> : </td>
							<td align="left" valign="top">
								{$row.description}
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>Meta Description </b></td>
							<td align="left" valign="top"> : </td>
							<td align="left" valign="top">
								{$row.meta_description}
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>Meta Keyword </b></td>
							<td align="left" valign="top"> : </td>
							<td align="left" valign="top">
								{$row.meta_keyword}
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2">&nbsp;<hr/><hr/></td></tr>
			{section name=i loop=$comments}
			<tr>
				<td width="60%">
					<b>Comments :</b>
					<table width="100%" border="0" cellspacing="8" cellpadding="1">
						<tr>
							<td align="left" width="30%" valign="middle">{$comments[i].comment}</td>
						</tr>
						<tr>
							<td align="left" width="30%" valign="top"><b>Posted On : {$comments[i].posted_date|date_format:$smarty_date_format}</b></td>
						</tr>
						<tr>
							<td align="left" width="30%" valign="top"><b>By : {$comments[i].name}</b></td>
						</tr>
					</table>
				</td>
				<td align="right" valign="top">
					{if $smarty.session.duAdmId eq 1 || $smarty.session.duAdmId eq $comments[i].userid}
					<a href="{$siteroot}/admin/modules/blogs/view_blog.php?bid={$smarty.get.bid}&cid={$comments[i].id}&act=rmv"><b>Remove</b></a>
					{/if}
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;<hr/></td></tr>
			{/section}
			<tr>
				<td width="60%">
					<b>Add Comments :</b>
					<table width="100%" border="0" cellspacing="8" cellpadding="1">
						<tr>
							<td colspan="2" align="left" width="30%" valign="middle">{$comments[i].comment}</td>
						</tr>
						<tr>
							<td colspan="1" align="left" width="30%" valign="top"><span style="color:red;">*</span> Comments : </td>
							<td align="left" width="30%" valign="top">
								<textarea name="comment" id="comment" rows="5" cols="50" class="textbox"></textarea>
								<input type="hidden" name="bid" id="bid" value="{$row.id}"/>
							</td>
						</tr>
						<tr>
							<td align="left" width="30%" valign="top">&nbsp;</td>
							<td align="left" width="30%" valign="top">
								<input type="submit" name="submit" value="Post" />
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
            </table>
        </form>
        </div>

    </div>
</div>
{include file=$footer}