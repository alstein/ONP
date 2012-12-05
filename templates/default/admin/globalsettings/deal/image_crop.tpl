{include file=$header1}
<script type="text/javascript" src="{$sitejs}/jquery-pack.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.imgareaselect-0.3.min.js"></script>
{literal}
<script type="text/javascript">
function del()
{
	if(confirm('Are you sure you want to delete this thumbnail?'))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function preview(img, selection) { 
	var scaleX = {/literal}{$thumb_width}{literal} / selection.width;

	var scaleY = {/literal}{$thumb_height}{literal} / selection.height;
	var img_width = {/literal}{$current_large_image_width}{literal};
	var img_height = {/literal}{$current_large_image_height}{literal};
	$('#thumbnail + div > img').css({ 
		width: Math.round(scaleX * img_width) + 'px',
		height: Math.round(scaleY * img_height) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function () { 
	$('#save_thumb').click(function() {

		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			return true;
		}
	});
}); 

$(window).load(function () { 
	$('#thumbnail').imgAreaSelect({ aspectRatio: '64:29', onSelectChange: preview }); 
});
</script>
{/literal}
{include file=$header2}
<h3>Image crop</h3>
<input type="hidden" id="siteroot" value="{$siteroot}" />
<div class="holdthisTop">
{if $large_photo_exists && $thumb_photo_exists}	
	{$thumb_photo_exists}<br>
	<a href='{$siteroot}/admin/sitemodules/deal/image_crop.php?productid={$productid}&act=del' onclick="javascript: return del();"><strong>Delete</strong></a>
{else}	
    <table width="70%" border="0" cellspacing="2" cellpadding="6">
      <tr>
        	<td align="left">
			<img src="{$siteroot}/uploads/product/{$image}" id="thumbnail" style="float: left; margin-right: 10px;" alt="Create Thumbnail" />
			<div style="float:left; position:relative; overflow:hidden; width:{$thumb_width}px; height:{$thumb_height}px;">
				<img src="{$siteroot}/uploads/product/{$image}" style="position: relative;" alt="Thumbnail Preview" />
			</div><br><strong>Crop Preview</strong>
        	</td>
      </tr>
    </table>
	<form name="thumbnail" method="post" action="">
		<input type="hidden" name="x1" value="" id="x1" />
		<input type="hidden" name="y1" value="" id="y1" />
		<input type="hidden" name="x2" value="" id="x2" />
		<input type="hidden" name="y2" value="" id="y2" />
		<input type="hidden" name="w" value="" id="w" />
		<input type="hidden" name="h" value="" id="h" />	
		<table width="70%" border="0" cellspacing="2" cellpadding="6">
		<tr>
			<td><input type="submit" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" /></td>
		</tr>
		</table>
  	</form>
{/if}
</div>
{include file=$footer}
