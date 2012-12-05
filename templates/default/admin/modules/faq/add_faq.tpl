{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addfaq.js"></script>
<!--{if $admin neq ''}
{else}-->

<!--{/if}-->
{literal}
<script language="JavaScript">
	$(document).ready(function()
{
$('#frmRegistration').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Submit').hide(); 
                $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Save' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/faq/faq_list.php"> FAQ List</a>
 &gt;{if $smarty.get.cid} Edit FAQ{else} Add FAQ{/if} 
</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} FAQ</h3>
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
        <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
 	<tr>
             <td colspan="2" align="right"><a href="{$siteroot}/admin/modules/faq/faq_list.php">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category:</td>
                <td align="left" width="60%">
			<select id="catname" name="catname">
			<option value="">select</option>
			 {section name=i loop=$category}
				<option value="{$category[i].faq_cat_id}" {if $row.faq_cat_id eq $category[i].faq_cat_id} selected="selected"{/if}>{$category[i].faq_cat}</option>
			{/section}
			</select>
		</td>
            </tr>
	<tr>
             <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Question:</td>
                <td align="left" width="60%"><input name="qes" type="text" id="qes" value="{$row.faqquestion}"  size="43" class="textbox"/></td>
            </tr>
		<tr><TD colspan="2">&nbsp;</TD></tr>
		<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span> Answer:</td>
			<td align="left" width="60%">
			<textarea name="ans" id="ans" class="textbox" rows="4" cols="50">{$row.faqanswer}</textarea>
			</td>
		</tr>
            <tr>
                <td colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="left">  <span id="buttonregister"><input type="submit" name="Submit" id="Submit" value="Save" /></span></td>
            </tr>
            </table>
        </form>
        </div>
    </div>
</div>
{include file=$footer}