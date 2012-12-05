{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/js/validation/admin/edit_home_image.js"></script>-->
{literal}
<script language="JavaScript">
$(document).ready(function()
{
                $.validator.addMethod("valid_editor", function(value, element) {
               	var editorcontent = CKEDITOR.instances[element.name].getData().replace(/<[^>]*>/gi, '');
		if (editorcontent.length)
		{
			return true;
		}else
		{
			return false;
		}
     }, "Please enter description");

// 	$.validator.addMethod("valid_editor", function(value, element){
// 		var oEditor = FCKeditorAPI.GetInstance(element.name);
// 		var fieldvalue = oEditor.GetXHTML(true);
// 		if(fieldvalue=="")
// 		{
// 			return false;
// 		} else {
// 			return true;
// 		}
// 	}, "Please enter editor decription");

	$("#home_form").validate({
		errorElement:'div',
		rules: {
				description:
				{
					valid_editor: true
				}
			},
		messages:
			{
				description:
				{
					valid_editor: "Please enter contents."
				}
			}
		});
});
</script>
{/literal}




{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/home/manage_lightbox_page_list.php"> Manage Lightbox Page List</a> &gt;
{if $smarty.get.edit_id} Edit Manage Lightbox Page{else} Add Manage Lightbox Page {/if}</div><br/>

    <div class="holdthisTop">
                    <div>
                            <div class="fl width50">
                                <h3>{$sitetitle}  Manage Lightbox Page Edit</h3>
                            </div>
                            <div class="clr">&nbsp;</div>
                        {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
                    </div>
                        <div class="clr">&nbsp; </div>
          <div id="UserListDiv" name="UserListDiv">  
                 <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
                           <input type="hidden" value="{$smarty.get.edit_id}" name="id_name" id="id_name" />
                                <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
                                        <tr> 
                                                <td width="20%" align="right" valign="top" >Section Title :</td> 
                                                <td align="left" width="40%"><b>{$section_title}</b><input type="hidden" name="sectiontitle" id="sectiontitle" value="{$section_title}"   style="width:268px;" maxlength="255" />
                                                </td> 
                                        </tr> 
                                        <tr>
                                                <td width="20%" align="right" valign="top">Text Contents :</td> 
                                                <td align="left" width="40%">{*oFCKeditor->Create*} {$oFCKeditorDesc} </td>
                                        </tr>
                                        <tr>
                                                <td align="right"  valign="top"><span style="color:red;">*</span>Status:&nbsp;</td>
                                                <td align="left">
                                                    <input type="radio" name="status" id="status" value="1" {if $status eq "1"}  checked="true"{/if}>
                                                    Active &nbsp;&nbsp;
                                                    <input type="radio" name="status" id="status" value="0" {if $status eq "0"}  checked="true"{/if}/>
                                                    Inactive 
                                                    <div class="error" htmlfor="status" generated="true"></div>
                                                </td>
                                        </tr>	
                                        <tr>
                                                    <td>&nbsp;</td>
                                                    <td align="left">
                                                        <div style="width:150px"> 
                                                            <div id="buttonregister" style="overflow:hidden">
                                                                    <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                                                                    <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='manage_lightbox_page_list.php'" 
                                                                    class="but_new fl"/>
                                                            </div>
                                                        </div>
                                                    </td>
                                        </tr>
                                </table>
                </form> 
            </div>
    </div>
{include file=$footer}
