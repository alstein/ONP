{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript">
{literal}
$(document).ready(function()
{
    $("#frmRegistration").validate({
                                        errorElement:'div',
                                                    rules: {
                                                                faqcname:
                                                                {
                                                                       	required: true,
                                                                        minlength: 1,
                                                                        maxlength:30,
                                                                        nospace:true
                                                                },
                                                                catdec:
                                                                {
                                                                        required: true,
                                                                        minlength: 10,
                                                                        maxlength:250,


                                                                }


                                                            },
                                                messages:
                                                        {
                                                            faqcname:
                                                            {
                                                                    required: "Please enter category",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")
                                                            },
                                                            catdec:
                                                            {
                                                                    required: "Please enter description",
                                                                    minlength:  $.format("Enter at least {0} characters"),
                                                                    maxlength: $.format("Enter maximum {0} characters")

                                                            }

                                                        }
                                });

});
{/literal}
</script>
{include file=$header2}
<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} Add FaqCategory</h3>
        </div>
        <div class="clr">
        </div>
        <div>
            {if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}
        </div>
    </div>
    <br>
    <div id="UserListDiv" name="UserListDiv" >
    {if $smarty.get.cid == ""}
        <div>
        <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            
            <tr>
                <td colspan="2" align="right"><a href="javascript:history.go(-1);">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category Name:</td>
                <td align="left" width="60%"><input name="faqcname" type="text" id="cname" value=""  size="15" class="textbox"/></td>
            </tr>
		<tr><TD colspan="2">&nbsp;</TD></tr>
		<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span>Description:</td>
			<td align="left" width="60%">
			<textarea name="catdec" id="catdec" class="textbox" rows="4" cols="40"></textarea>
			<!--<input name="cname" type="text" id="cname" value=""  size="15" class="textbox"/>-->
			</td>
		</tr>

            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><input type="Submit" name="Submit" value="Add" /></td>
            </tr>
            
            
            </table>
        </form>
        </div>
       {else}
       <div>
       <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
            <table width="100%" border="0" cellspacing="2" cellpadding="1">
                
                <tr>
                    <td colspan="2" align="right"><a href="javascript:history.go(-1);">Back</a></td>
                </tr>
                <tr>
                    <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category Name:</td>
                    <td align="left" width="60%"><input name="cname" type="text" id="cname" value=""  size="15" class="textbox"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="left"><input type="Submit" name="Submit" value="Update" /></td>
                </tr>
            </table>
        </form>
        </div>
            {/if}
            
            
    </div>
</div>
{include file=$footer}