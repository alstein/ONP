{include file=$header1}
{include file=$header2} 
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/sitemodules/deal/manage_deal_category.php">Categories</a> &gt; {if $smarty.get.act != "edit"}
Add category
{else}
Edit category
{/if}</div>
<br />

{if $smarty.get.act != "edit"}
<h3> &nbsp; Add category</h3>
{else}
<h3> &nbsp; Edit category</h3>
{/if}
{if $msg}<div align="center">{$msg}</div>{/if}
{literal}
<script type="text/javascript">
function is_validData()
{
   if(Trim(document.frm.category.value) == '')
   {
   		alert("Enter Category Name ");
		document.frm.category.focus();
		return false;
   }
   else
   if(Trim(document.frm.description.value) == '')
   {
   		alert("Enter Description");
		document.frm.description.focus();
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
  <input type="hidden" value="{$category.f_cat_id}" name="id" />
  <table width="100%" border="0" cellspacing="2" cellpadding="6">
    <tr>
      <td width="30%" align="right" >Category:&nbsp;<label class="error">*</label></td>
      <td align="left"><input type="text" name="category" id="category"  value="{$category.category_name}" /></td>
    </tr>
    <tr>
      <td align="right"  valign="top">Description:&nbsp;<label class="error">*</label></td>
      <td align="left"><textarea name="description" rows="6" cols="30">{$category.description}</textarea></td>
    </tr>
    <tr>
      <td align="right"  valign="top">Status:&nbsp;</td>
      <td align="left"><input type="radio" name="status" value="Active" {if $category.status eq 'Active'}checked="checked"{/if} checked="checked"/>
        Active &nbsp;&nbsp;
        <input type="radio" name="status" value='Inactive'/>
        Inactive </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="submit" name="submit" value="Save" class="button1"/> &nbsp; &nbsp; &nbsp;
      <label>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="javascript: location='{$siteroot}/admin/sitemodules/categories/manage_faq_category.php'"  />
      </label></td>
    </tr>
  </table>
</form>

</td>
    </tr>
  </table>
</div>{include file=$footer}
