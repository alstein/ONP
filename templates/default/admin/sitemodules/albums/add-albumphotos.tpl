{include file=$header1}
<!--<script type="text/javascript" src="{$siteroot}/js/common.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#frmBlog").validate({
       errorElement:'p',
       rules:{
        title:{
            required:true
        },
        photo:{
            required: function(element){
                            if(jQuery('#blogid').val()=="")
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }
                }
        }
       },
       messages:{
            title:{
                required: "Please enter title"
            },
            photo:{
                required: "Please upload image"
            }
       }
    });
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">

	<h1 class="type2">{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Blog</h1>
	<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/blogs/blog-list.php">Album</a>&nbsp;&raquo;&nbsp;{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Blog </div> <br/>
	<div class="holdthisTop">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datagrid">
    		<tr>
      			<td valign="top">
					<form name="frmBlog" id="frmBlog" method="post" action="" enctype="multipart/form-data">
    					<input type="hidden" name="blogid"  id="blogid" value="{$blog.blogid}" />
      						<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="conttable">
       							<tr>
									<td width="30%" align="right" >Album Title :&nbsp;<label class="error">*</label></td>
									<td align="left"><input type="text" name="album_title" id="album_title" size="35"  value="{$category.album_title}" /></td>
								</tr>
								<tr>
									<td width="30%" align="right" >Location :&nbsp;<label class="error">*</label></td>
									<td align="left"><input type="text" name="location" id="location" size="35"  value="{$category.location}" /></td>
								</tr>
								<tr> 
									<td align="right"  valign="top">Album Description :&nbsp;<label class="error">*</label></td>
									<td align="left"><textarea name="album_description" rows="5" cols="50">{$category.album_description}</textarea></td>
								</tr>
								<tr> 
									<td align="right"  valign="top">Privacy :&nbsp;<label class="error">*</label></td>
									<td>
										<select name="privacy">
											<option value=""{if $category.privacy eq ''} selected="true" {/if}>Select privacy</option>
											<option value="public"{if $category.privacy eq 'public'} selected="true" {/if}>Public</option>
											<option value="private"{if $category.privacy eq 'private'} selected="true" {/if}>Private</option>
										</select>
									</td>
								</tr>
								{if $category.thumbnail neq''}
								<tr>
										<td align="right"  valign="top">Current Image :&nbsp;<label class="error"></label></td>
										<td align="left" >
										<img src="{$siteroot}/uploads/album/thumbnail/{$category.thumbnail}" width="90px;" height="90px;"></td>
									</tr>
								{/if}
								<tr>
										<td align="right"  valign="top">Image :&nbsp;<label class="error">*</label></td>
										<td align="left" valign="top"><input type="file" name="photo"  id="photo" size="15" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align="left"><input type="submit" name="submit" value="Save" class="button1"/> &nbsp; &nbsp; &nbsp;
									<label>
									<input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: history.go(-1);"  />
									</label></td>
								</tr>
      						</table>
    					</form>
 				 </div>
			</td>
		</tr>
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
{include file=$footer} 