{include file=$header1}
<!--<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/validation/admin/addfaqcategory.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/faq/faqcategory_list.php"> FAQ List</a>
 &gt;{if $smarty.get.cid} Edit FAQ Category{else} Add FAQ Category{/if}
 
</div>
<br />


<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} FAQ Category</h3>
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
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/modules/faq/faqcategory_list.php">Back</a></td>
            </tr>
            <tr>
                <td align="right" width="40%" valign="top"><span style="color:red">*</span> Category Name: </td>
                <td align="left" width="60%" valign="top"><input name="faqcname" type="text" id="faqcname" value="{$row.faq_cat}"  size="25" class="textbox"/></td>
            </tr>
		<tr><TD colspan="2">&nbsp;</TD></tr>
		<!--<tr>
			<td align="right" valign="top" width="40%"><span style="color:red">*</span>Description:</td>
			<td align="left" width="60%">
			<textarea name="catdec" id="catdec" class="textbox" rows="4" cols="40">{*$row.cat_descr*}</textarea>
			</td>
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