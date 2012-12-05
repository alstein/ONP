{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/undermainpage.js"></script>

<!--{literal}
<script language="javascript" type="text/javascript">
	function chkform(){
	var subchr = document.getElementById('undermaintenance_name').value;
		if(subchr ==''){
		alert("Enter the title")
		document.getElementById("undermaintenance_name").focus();
		return false;
		}else{
		return true
		}
	}
</script>

{/literal}-->
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Under Maintenance Page
</div>
<br />
{if $msg}<br/><div align="center" id="msg">{$msg}</div>{/if}
  <table width="82%"  align="center">
    <tr><td> <h3>Under Maintenance Page</h3><br/></td></tr>
    <tr>
      <td>
        <form name="frmPage" id="frmPage" method="post" action="" enctype="multipart/form-data"><!--//onsubmit="javascript:return chkform();"-->
          <input type="hidden" name="pageid" value="{$page.pageid}" />
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
            <tr>
              <td width="15%" align="right" valign="top">Title: </td>
              <td align="left"><input type="text" name="undermaintenance_name" id="undermaintenance_name" size="60" maxlength="100" value="{$page.undermaintenance_name}"  align="left" />
              <!--<br /><small>While Editing Page do not change Page Title, this will cause error on displaying Page at User Side.</small>--></td>
            </tr>
            <tr>
              <td valign="top" align="right" >Description:</td>
              <td valign="top">
                {*oFCKeditor->Create*} {$oFCKeditorDesc}
                </td>
            </tr>
{if $dec_msg neq ''}
		<tr>
              		<td valign="top" align="right" >&nbsp;</td>
              		<td valign="top">
                	<span style="color:red">{$dec_msg}</span>
                	</td>
            	</tr>
{/if}
       <tr>
              <td valign="top" align="right" >Status: </td>
              <td valign="top"><select name="status">
                  <option value="Active" {if $page.undermaintenance_status eq "Active"}selected="selected"{/if}>Active</option>
                  <option value="Inactive" {if $page.undermaintenance_status eq "Inactive"}selected="selected"{/if}>Inactive</option>
                </select></td>
            </tr>

            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" value="Save"  /> &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" onclick="javascript: location='undermaintenance.php';" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>

{include file=$footer}