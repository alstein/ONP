{include file=$header1}

{literal}
<script language="javascript">
function is_validData()
{
   if(Trim(document.frm.product_name.value)== '')
   {
   		alert("Please enter product");
		document.frm.product_name.focus();
		return false;
   }
   
   
    if(Trim(document.frm.product_description.value)== '')
   {
   		alert("Please enter description");
		document.frm.product_description.focus();
		return false;
   }

if (document.frm.image.value =='' && ($_FILES['photo']['name'])=='')
 if(Trim(document.frm.photo.value)== '')
    {
    		alert("Please select Image");
 		document.frm.photo.focus();
		return false;
    }
	if(Trim(document.frm.price.value)== '')
   {
   		alert("Please enter price");
		document.frm.price.focus();
		return false;
   }
if(Trim(document.frm.quantity.value)== '')
   {
   		alert("Please enter quantity");
		document.frm.quantity.focus();
		return false;
   }
   return true;

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
<div class="holdthisTop">

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Add Image</div>
<br />

<h3> &nbsp; Add Image</h3>

{if $msg}<div align="center">{$msg}</div>{/if}

  <table width="97%" class="brdall">
    
    <td>
	 <form name="frm" action="" id="exA"  method="post" enctype="multipart/form-data" class="fvalidator-form" onsubmit="return is_validData();">
		
     <table width="100%" border="0" cellspacing="6" cellpadding="0">
       
	   <tr><td colspan="2"><font color="#FF0000"><center><b>{$message}</b></center></font></td></tr>
	   
       <tr><td colspan="2"><input type="hidden" value="{$row_result.cat_id}" name="cat_id" /></td></tr>

       
	
		<tr>
		  <td width="20%" align="right" valign="top">Image:&nbsp;<label class="error">*</label></td>
		  <td align="left" valign="top"><input type="file" value="{$row_result.product_image}"  name="photo" id="exA_img"><br><br>
		{if $image|@count > 0}  <img name="photo1" id="photo1" src="{$siteroot}/display_image.php?path=uploads/product/thumbnail/{$image[0].thumbnail}&amp;width=200&amp;height=150" /> {/if}
		  </td>
	   </tr>
	
	<tr>
		<td>&nbsp;</td>
        <td align="left"><input type="submit" name="submit" value="Submit" class="button1">
        &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" class="button1" onclick="javascript: location='{$siteroot}/admin/sitemodules/product/manage_cat_product.php?cat_id={$smarty.get.cat_id}'" />
        </td>
    </tr>	
</table>

</form>

</td>
    </tr>
  </table>
</div>

{include file=$footer}

