{include file=$header1}
{literal}
<script language="javascript" type="text/javascript">

function validateFCK()
{	

	var fckBody= FCKeditorAPI.GetInstance("description");
        //The variable "editorname" is name given in php file to FCKeditor.
	var checkeditor = fckBody.GetXHTML(true);
	if(!(checkeditor))
	{
		alert("Editor should not blank!");
		document.getElementById("description").focus();
		return false;
	}	
}

</script>

{/literal}
{include file=$header2}

  <table width="82%"  align="center">
    <tr>
      <td>
        <form name="frmPage" method="post" action="" enctype="multipart/form-data" onsubmit="javascript:return validateFCK();">
          <input type="hidden" name="id" value="{$dem.id}" />
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
            <tr>
              <td width="15%" align="right" valign="top">Product Name: </td>
              <td align="left"><input type="text" name="product_name" id="product_name" size="60" maxlength="100" value="{$dem.product_name}"  align="left" />
              <!--<br /><small>While Editing Page do not change Page product_name, this will cause error on displaying Page at User Side.</small>--></td>
            </tr>

            <tr>
              <td valign="top" align="right" >Description: </td>
              <td valign="top">
                {oFCKeditor->Create}
                </td>
            </tr>
            <tr>
              <td valign="top" align="right" >Status: </td>
              <td valign="top"><select name="status">
                  <option value="Active" {if $dem.status eq "active"}selected="selected"{/if}>Active</option>
                  <option value="Inactive" {if $dem.status eq "inactive"}selected="selected"{/if}>Inactive</option>
                </select></td>
            </tr>

            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" value="Save"  /> &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" onclick="javascript: location='In-demand.php';" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>

{include file=$footer}