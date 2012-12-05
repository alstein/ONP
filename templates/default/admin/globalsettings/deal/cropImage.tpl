{include file=$header1}

<script src= "{$siteroot}/js/jquery-1.2.6.pack.js"></script>
<script src="{$siteroot}/js/jquery.Jcrop.min.js"></script>
{literal}
<script type="text/javascript" language="javascript"> 
$(function(){

   $('#cropbox').Jcrop({
      aspectRatio: 609/353,
      onSelect: updateCoords
   });
});

function updateCoords(c)
{
   $('#x').val(c.x);
   $('#y').val(c.y);
   $('#w').val(c.w);
   $('#h').val(c.h);
}

</script>
{/literal}

{include file=$header2}
<h3>Crop Image</h3>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<div align="center">{$msg_success}</div> 
	<tr>
		<td>
		<FORM action="" method="post" id="frmCrop" name="frmCrop" onsubmit="return checkCoords();" enctype="multipart/form-data" >
			
			
		<div style="overflow:scroll;width:930px;height:400px" valign="top">
			<img src="{$siteroot}/uploads/{$smarty.session.img_path}" id="cropbox">
		</div>
			<br>
			<span style="font-family:sans-serif,arial,helvetica;font-size:13px;color:#000000">Drag the required part for image croping</span>
			<br><br>
			<input type="hidden" name="original_image" value="{$smarty.session.img_path}"><input type="hidden" id="x" name="x" /><input type="hidden" id="y" name="y" /><input type="hidden" id="w" name="w" /><input type="hidden" id="h" name="h" />
			<input  type="submit" name="crop_photo" class="button" value="save"/>
		</FORM>
		</td>
	</tr>
</table>