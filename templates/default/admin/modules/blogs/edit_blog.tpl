{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/add_blog.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/blogs/blog_list.php"> Manage Blog</a>
 &gt;{if $smarty.get.cid} Edit Blog{else} Add Blog{/if}
 
</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} {if $smarty.get.bid}Edit{else}Add{/if} Blog</h3>
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
		<table width="100%" border="0" cellspacing="8" cellpadding="1">
			<tr>
				<td colspan="2" align="right">
				<input type="hidden" name="bid" id="bid" value="{$smarty.get.bid}"/>
				<a href="{$siteroot}/admin/modules/blogs/blog_list.php">Back</a></td>
			</tr>
			<tr>
				<td align="right" width="40%" valign="top"><span style="color:red">*</span> Blog Title: </td>
				<td align="left" width="60%" valign="top"><input name="title" id="title" value="{$row.title}"  size="25" class="textbox"/></td>
			</tr>
			
			<tr>
				<td align="right" width="40%" valign="top"><span style="color:red">*</span> Meta Description: </td>
				<td align="left" width="60%" valign="top">
					<textarea name="metadescription" id="metadescription" class="textbox" rows="5" cols="50">{$row.meta_description}</textarea>
				</td>
			</tr>
			
			<tr>
				<td align="right" width="40%" valign="top"><span style="color:red">*</span> Meta Keyword: </td>
				<td align="left" width="60%" valign="top">
					<textarea name="metakeyword" id="metakeyword" class="textbox" rows="5" cols="50">{$row.meta_keyword}</textarea>
				</td>
			</tr>
			<tr>
				<td align="right" width="40%" valign="middle"><span style="color:red">*</span>Blog Date: </td>
				<td align="left" width="60%" valign="top">
					{if $row.date}
						<script type="text/javascript">DateInput('date', true, 'YYYY-MM-DD','{$row.date|date_format:"%Y-%m-%d"}');</script>
					{else}
						<script type="text/javascript">DateInput('date', true, 'YYYY-MM-DD');</script>
					{/if}
					<div class="error" id="err_date" style="display:none;"></div>
				</td>
			</tr>
			<tr>
				<td align="right" width="40%" valign="top"><span style="color:red">*</span>Blog City: </td>
				<td align="left" width="60%" valign="top">
					<select name="city_id" id="city_id">
						<option value="">Select City</option>
						{section name=j loop=$city}
							<option {if $row.city_id eq $city[j].city_id} selected="selected" {/if} value="{$city[j].city_id}">{$city[j].city_name}</option>
						{/section}
					</select>
				</td>
			</tr>
			<tr>
				<td align="right" width="40%" valign="top"><span style="color:red">*</span> Blog Description: </td>
				<td align="left" width="60%" valign="top">
					<textarea name="description" id="description" class="textbox" rows="10" cols="50">{$row.description}</textarea>
				</td>
			</tr>
			<!--<tr><TD colspan="2">&nbsp;</TD></tr>-->
		<!--<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span>Description:</td>
			<td align="left" width="60%">
			<textarea name="catdec" id="catdec" class="textbox" rows="4" cols="40">{*$row.cat_descr*}</textarea>
			</td>
		</tr>-->

           <!-- <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>-->
            <tr>
                <td></td>
                <td align="left"><input type="submit" name="submit" value="Save" /></td>
            </tr>
            </table>
        </form>
        </div>

    </div>
</div>
{include file=$footer}