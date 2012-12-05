{include file=$header1}
<!--<script type="text/javascript" src="{$siteroot}/js/common.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#frmBlog").validate({
       errorElement:'p',
       rules:{
        album_title:{
            required:true
        },
        admin_album_title:{
            required:true
        }
/*	location: {
            required:true
        },
	album_description: {
            required:true
        },
	privacy: {
            required:true
        },
	photo :{
            required: function(element){
                            if(jQuery('#oldphoto').val()=="")
                            {
                                return true;
                            }
                            else
                            {
                                return false;
                            }
                }
        }*/
       },
       messages:{
            album_title:{
                required: "Please enter title"
            },
            admin_album_title:{
                required: "Please enter title"
            }
/*	    location: {
                required: "Please enter location"
            },
	    album_description: {
                required: "Please enter description"
            },
	    privacy: {
            	required: "Please select Privacy"
            },
            photo:{
                required: "Please upload image"
            }*/
       }
    });
jQuery("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">

	<h1 class="type2">{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Album</h1>
	<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/albums/album.php">Album</a>&nbsp;&raquo;&nbsp;{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Album </div> <br/>
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}

	<div class="holdthisTop">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datagrid">
    		<tr>
      			<td valign="top">
					<form name="frmBlog" id="frmBlog" method="post" action="" enctype="multipart/form-data">
    					<input type="hidden" name="id"  id="id" value="{$category.album_id}" />
      						<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="conttable">
       							<tr>
								<td width="30%" align="right" >Filtered Album Title :&nbsp;<label class="error">*</label></td>
								<td align="left"><input type="text" name="album_title" id="album_title" size="35"  value="{$category.album_title}" /></td>
							</tr>
       							<tr>
								<td width="30%" align="right" >Original Album Title :&nbsp;<label class="error">*</label></td>
								<td align="left"><input type="text" name="admin_album_title" id="admin_album_title" size="35"  value="{$category.admin_album_title}" /></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td align="left"><div class="buttons"><input type="submit" name="submit" value="Save" class="button1"/></div>
								<div class="buttons">
								<input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: history.go(-1);"  />
								</div></td>
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