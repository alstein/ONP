{include file=$header1}
{include file=$header2}
<h4><a href="./manage_affilite_banner.php">Manage Banner</a> &gt;{if $banner.id eq ""} Add Banner {else} Edit Banner{/if}</h4>
{literal}
<script type="text/javascript">
function is_validData()
{
// alert(document.frm.type);

  if(document.frm.description.value=='')
 {
     alert("Please enter title");
       document.frm.description.focus();
    return false;
 }


 if(document.frm.img_id.value=='')
 {
   if(Trim(document.frm.image.value) == '' )
   {
   		alert("Please upload image.");
		document.frm.image.focus();
		return false;
   } 
  } 
var btn = valButton(document.frm.type);
//alert("button="+btn);
	if(btn=='image')
	{

		if(document.frm.vault.value =="")
		{
			alert("Please enter video.");
			return false;		
		}
		
		if(isValidImage(document.frm.vault.value))
		{
			alert("Please enter valid video file format.");
			return false;		
		}
		return true;
	}
	 if(btn=='google')
	{
		   if(document.frm.google_add.value == '')
		   {
	   		alert("Please enter embeded code.");
			document.frm.google_add.focus();
			return false;
		   }
	}
}
function valButton(btn) 
{
    var cnt = -1;
    for (var i=btn.length-1; i > -1; i--) {
        if (btn[i].checked) {cnt = i; i = -1;}
    }
    if (cnt > -1) return btn[cnt].value;
    else return null;
}   

function imag1()
{
  
    document.getElementById('imageid').style.display = "block";
   // document.getElementById('googleid').style.display = "none";
}

function goog1()
{
  
    document.getElementById('googleid').style.display = "block";
    document.getElementById('imageid').style.display = "none";
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
<form name="frm" action="" method="post" enctype="multipart/form-data" onsubmit="javascript:return is_validData();">	
<input type="hidden" name="img_id" value="{$banner.id}" />
  <table width="100%" border="0" cellspacing="2" cellpadding="2" class="Greenback">
		
	<tr>
		<td width="30%" align="right" valign="top">Image :&nbsp;</td>
		<td>		 
			<input name="type" type="radio" value="image1" onclick="javascript:return imag1()" checked="checked" />Image
			<!--<input name="type" type="radio" value="embeded_code" onclick="javascript:return goog1()" />Embeded-->
		</td>
	</tr>
	<tr>
		<td width="30%" align="right" valign="top">Title :&nbsp;</td>
		<td>		 
			<input type=text name=description value="{$banner.description}">
		</td>
	</tr>
	<tr>
	<td colspan="2" >
	<div id="imageid" style="display:block">
		<table width="100%" border="0" cellspacing="1" cellpadding="2" >
		<tr>
			<td align="right" width="30%" >Upload Image:</td>
			<td><input type="file" name="image" id="image" value="">
			</td>
		</tr>
		{if $banner.image_affilite}
		<tr>
			<TD>&nbsp;</TD>
			<td><img src="../../../uploads/banners/{$banner.image_affilite}" width=100px height=100px></td>
		</tr>
		{/if}
		</table>
	</div></td></tr>
	<!--<tr>
	<td colspan="2" align="right">
		<div id="googleid" style="display:none">
		<table width="100%" border="0" cellspacing="1" cellpadding="2">
		<tr>
		<td align="right" valign="top" width="30%">Embeded Code:&nbsp;</td>
		<td align="left"><textarea name="embeded_code1" cols="45" rows="6"></textarea></td>
		</tr>
		</table>
	</div>
	</td>
	</tr> -->
    <tr>
      <td>&nbsp;</td>
      <td align="left"><input type="submit" name="submit" class="button111111" value="Upload"/>
              
&nbsp;&nbsp;&nbsp;
      <input type="button" name="back" id="back" value="Back" class="button1111" onclick="javascript:history.back();"/>
      </td>
    </tr>
  </table>
</form>
</div>
{include file=$footer}
