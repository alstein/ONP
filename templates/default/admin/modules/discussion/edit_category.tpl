{include file=$header1}
<!--<link rel="stylesheet" href="{$siteroot}/templates/{$templatedir}/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="{$siteroot}/js/thick_js/thickbox.js"></script>-->
{literal}
<script language="javascript">
function is_validData()
{
   if(Trim(document.frm.category.value) == '')
   {
   		alert("Enter Discussion Category Name ");
		document.frm.category.focus();
		return false;
   }
//    else
//    if(Trim(document.frm.description.value) == '')
//    {
//    		alert("Enter description");
// 		document.frm.description.focus();
// 		return false;
//    }
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
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/modules/discussion/categories.php">Discussion Categories List</a> &gt; {if $smarty.get.categoryid}Edit{else}Add{/if} Discussion Category  </div>
<div class="holdthisTop">
<h3 class="fl">&nbsp;&nbsp; {if $smarty.get.categoryid}Edit{else}Add{/if} Discussion Category</h3>
<br/>
           <div> &nbsp;&nbsp;{if $msg != ""}<div align="center" id="msg">{$msg}</div>{/if}</div>


  <form name="frm" action="" method="post" enctype="multipart/form-data" onsubmit="return is_validData();">
  <input type="hidden" name="categoryid" value="{$category.categoryid}" />
    <table width="100%" border="0" cellspacing="2" cellpadding="6">
      <tr>
        <td width="20%" align="right" ><span style="color:red">*</span>Discussion Category:&nbsp;</td>
        <td align="left"><input type="text" name="category"  value="{$category.category}"></td>
      </tr>
      <!--<tr>
        <td align="right"  valign="top">Description:&nbsp;</td>
        <td align="left"><textarea name="description" rows="4" cols="30" align="right">{$category.description}</textarea></td>
      </tr>-->
      
	<tr>
    <td width="20%" align="right">Status: </td>
    <td><select name="status" >
        <option value="Active" {if $category.status eq "Active"}selected="selected"{/if}}>Active</option>
        <option value="Inactive" {if $category.status eq "Inactive"}selected="selected"{/if}>Inactive</option>
      </select></td>
  </tr>
	
      <tr>
        <td>&nbsp;</td>
        <td align="left"><input type="submit" name="submit" value="Save"> <input type="button"  value="Cancel" onclick="javascript: location='categories.php';"></td>
      </tr>
    </table>
  </form>
</div>
{include file=$footer}