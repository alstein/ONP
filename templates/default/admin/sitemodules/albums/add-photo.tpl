{include file=$header1}

<!--<script type="text/javascript" src="{$siteroot}/js/common.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{*strip}
   <script language="javascript" src="{$siteroot}/js/multifile.js" type="text/javascript"></script>
{/strip*}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
    jQuery("#frmBlog").validate({
       errorElement:'p',
       rules:{
        photo_title:{
            required:true
        },
        file1:{
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
        }
       },
       messages:{
            photo_title:{
                required: "Please enter the decription"
            },
            file1:{
                required: "Please upload image"
            }
       }
    });
jQuery("#msg").fadeOut(5000);
});
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<input type="hidden" name="aid"  id="aid" value="{$smarty.get.aid}" />
	<h1 class="type2">{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Photo</h1>
	<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/albums/album.php">Album</a>&nbsp;&raquo;&nbsp;{if $smarty.get.act eq "edit"}Edit{else}Create{/if} Photo </div>
 <br/><div style="margin-left:770px"><a href="javascript:void(0);" onclick="javascript:history.go(-1);"><strong>Back</strong></a></div>
	{if $msg}
	<div align="center"  class="successMsg" id="msg">{$msg}</div>
	{/if}

	<div class="holdthisTop">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datagrid">
    		<tr>
      			<td valign="top">
					<form name="frmBlog" id="frmBlog" method="post" action="" enctype="multipart/form-data">
    					<input type="hidden" name="photo_id"  id="photo_id" value="{$photorec.photo_id}" />





						
						<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="conttable">
       							<tr>
									<td width="30%" align="right" >Description:&nbsp;<label class="error">*</label></td>
									<td align="left"><textarea name="photo_description" id="description_{$photorec[i].photoid}">{$photorec.description}</textarea>

<!--<input type="text" name="photo_title" id="photo_title" size="35"  value="{$photorec.description}" />--></td>
								</tr>
						
								<tr>
									<td width="30%" align="right" >Tag others in photo:&nbsp;<label class="error">*</label></td>
									<td align="left">
									<!--<select name="{$photorec[i].photoid}[]" id="{$smarty.section.index.i}" multiple="true" style="width:287px; height:87px" >
									
										<option name="i" value="i">hello</option>
										<option name="i" value="i">hello</option>

									</select>-->
  <select name="tag_{$photorec[i].photoid}[]" id="tag_{$smarty.section.i.index}" class="" multiple="true" style="width:287px; height:87px;">
{section name=k loop=$cat11}
                   <option value="{$cat11[k].friendid}">
{$cat11[k].first_name|ucfirst}{$cat11[k].last_name|ucfirst}
							
							</option>
					{sectionelse}
                   <option> No Friends </option>
					{/section}
                   </select>
					</td>
					</tr>


								<tr>
								<td width="30%" align="right">Assign To Accomplisment:&nbsp;</td><label class="error">*</label>
                                <td align="left">
								<select name="{$photorec[i].photoid}[]" id="{$smarty.section.index.i}" multiple="true" style="width:287px; height:87px">
{section name=m loop=$newr}
								<option value="{$newr[m].userid}">{$newr[m].award_title}</option>
{sectionelse}
<option>NO records</option>
{/section}
								</select>
											

											
								</td>
                                </tr>

								
								<tr>
								{if $photorec.image}
								<tr>
									<td align="right"  valign="top">Current Image :&nbsp;<label class="error"></label></td>
									<td align="left" ><input type="hidden" name="oldphoto" id="oldphoto" size="15" value="{$photorec.image}"/>
{if $photorec.image!=''}
									<img src="{$siteroot}/uploads/post_accomplish/thumbnail/{$photorec.image}" width="100px;" height="100px;">
									{else}
									<img src="{$siteroot}/uploads/post_accomplish/thumbnail/noimage.jpg">
									{/if}
									</td>
								</tr>
								{/if}
								<tr>
									<td align="right"  valign="top">Picture :&nbsp;<label class="error">*</label></td>
									<td align="left">
										<div id='divbox' >
										<input  class="file" type="file" name="file" id="my_file_element" size="15" contenteditable="false"/><br/><div id="fileerror" style="display:none;" class="redclr"><b>Please select valid files.</b>
										</div>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td align="left">
										<div class="buttons"><input type="submit" name="submit" value="Save" class="button1"/></div>
										<div class="buttons"><input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: history.back();"  /></div>
										<input type="hidden" name="thumbnail_hidden" value="{$photorec.thumbnail}">
										
									</td>
									
								</tr>
							</table>






							
						</form>
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
{include file=$footer} 