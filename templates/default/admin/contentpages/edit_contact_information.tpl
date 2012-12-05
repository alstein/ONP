{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/editcontactinf.js"></script>
{include file=$header2}

{if $row_result.id eq ''}
<h3>Add Contact Information</h3>
{else}
<h3>Edit Contact Information</h3>
{/if}
{if $msg}
<div align="center" id="msg">{$msg}</div>
{/if}
<div class="holdthisTop">
  <table width="97%" class="brdall">
    <td><form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data" class="fvalidator-form" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2"><font color="#FF0000">
                <center>
                  <b>{$msg1}</b>
                </center>
                </font></td>
            </tr>
            <tr>
              <td colspan="2"><input type="hidden" value="{$row_result.id}" name="id" /></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            <tr>
              <td align="right"  valign="top">Line One :&nbsp;</td>
              <td align="left"><textarea name="lineone" id="lineone" class="fValidate['required','nosp'] input-1" rows="2" cols="50" align="left">{$row_result.line_one}</textarea></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            <tr>
              <td align="right"  valign="top">Line Two :&nbsp;</td>
              <td align="left"><textarea class="" rows="2" cols="50" name="linetwo" id="linetwo">{$row_result.line_two}</textarea></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><input type="submit" name="submit" value="Save" />&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: history.back();" />
                </td>
            </tr>
				 <tr>
              <td colspan="2">&nbsp;</td>
            <tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
{include file=$footer}