{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addfaq.js"></script>
{literal}
<script language="JavaScript" type="text/javascript">
$(document).ready(function()
{
    $("#frmtooltip").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                title:
                                                                {
                                                                       required: true
                                                                },
                                                                module:
                                                                {
                                                                        required: true,
                                                                        minlength: 1,
                                                                        maxlength:200,
                                                                },
                                                                desc:
                                                                {
                                                                        required: true
                                                                     
                                                                        
                                                                }
                                                            },
                                                messages:
                                                        {
                                                            title:
                                                            {
                                                                    required: "Please enter title"

                                                            },
                                                            module:
                                                            {
                                                                    required: "Please enter module name",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")
                                                            },
                                                            desc:
                                                            {
                                                                    required: "Please enter description"
                                                                   
                                                            }
                                                        }
                                });

});


</script>
{/literal}

{include file=$header2}
<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} ToolTip</h3>
        </div>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg" style="color:red">{$msg}</div>{/if}
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv" >
        <div>
        <form name="frmtooltip" id="frmtooltip" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
 	       <tr>
             <td colspan="2" align="right"><a href="{$siteroot}/admin/modules/tooltip/tooltipList.php">Back</a></td>
            </tr>
	
          
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">{if $smarty.get.cid ==""}*{/if}</span> Title:</td>
                <td align="left" width="60%">
				<input type="text" name="title" id="title" class="textbox" size="43" value="{$row.tooltip_title}" {if $smarty.get.cid !=""} disabled="true" {/if} />
		</td>
            </tr>
	<tr>
             <td colspan="2" align="right">&nbsp;</td>
            </tr>
            

            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">{if $smarty.get.cid ==""}*{/if}</span> Module Name:</td>
                <td align="left" width="60%"><input name="module" type="text" id="module" value="{$row.module_name}" {if $smarty.get.cid !=""} disabled="true" {/if}  size="43" class="textbox"/></td>
            </tr>
		<tr><TD colspan="2">&nbsp;</TD></tr>
		<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span> Description:</td>
			<td align="left" width="60%">
			<textarea name="desc" id="desc" class="textbox" rows="4" cols="50">{$row.description}</textarea>
			</td>
		</tr>

            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
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