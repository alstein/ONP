{include file=$header1}
{include file=$header2} 
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/sitemodules/deal/manage_comment_deal.php">Deal</a> &gt; {if $smarty.get.act != "edit"}
Add comment
{else}
Edit comment
{/if}</div>
<br />

{if $smarty.get.act != "edit"}
<h3> &nbsp; Add comment</h3>
{else}
<h3> &nbsp; Edit comment</h3>
{/if}
{if $msg}<div align="center">{$msg}</div>{/if}
{literal}
<script type="text/javascript">
function is_validData()
{
   
   if(Trim(document.frm.comment.value) == '')
   {
   		alert("Enter Comment");
		document.frm.comment.focus();
		return false;
   }
   else
   {
   		return true;
   }
}
function Trim(s) 
{
// Remove leading spaces and carriage returns
while ((s.substring(0,1) == ' ') || (s.substring(0,1) == '\n') || (s.substring(0,1) == '\r'))
 { s = s.substring(1,s.length); }
 
// Remove trailing spaces and carriage returns
while ((s.substring(s.length-1,s.length) == ' ') || (s.substring(s.length-1,s.length) == '\n') || (s.substring(s.length-1,s.length) == '\r'))
 { s = s.substring(0,s.length-1); }
 
return s;
}
</script>
{/literal}

<div class="holdthisTop">
  <table width="97%" class="brdall">
    <td>
	<form name="frm" action="" method="post" enctype="multipart/form-data" onsubmit="return is_validData();">		
  <input type="hidden" value="{$category.id}" name="id" />
  <table width="100%" border="0" cellspacing="2" cellpadding="6">
    <tr>
      <td width="30%" valign="top" align="right">Comment:&nbsp;<label class="error">*</label></td>
      <td align="left"><textarea name="comment" id="comment" rows="6" cols="30">{$category.comment}</textarea></td>
    </tr>
   
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="submit" name="submit" value="Save" class="button1"/> &nbsp; &nbsp; &nbsp;
      <label>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: location='{$siteroot}/admin/sitemodules/deal/manage_comment_deal.php'"  />
      </label></td>
    </tr>
  </table>
</form>

</td>
    </tr>
  </table>
</div>{include file=$footer}

