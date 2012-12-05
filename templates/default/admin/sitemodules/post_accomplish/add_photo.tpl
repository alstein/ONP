{include file=$header1}

<!--<script type="text/javascript" src="{$siteroot}/js/common.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>
{*strip}
   <script language="javascript" src="{$siteroot}/js/multifile.js" type="text/javascript"></script>
{/strip*}
<link href="{$siteroot}/admin/sitemodules/post_accomplish/scripts/uploadify.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="{$siteroot}/admin/sitemodules/post_accomplish/scripts/jquery.uploadify.v2.1.4.js"></script>
<script type="text/javascript" src="{$siteroot}/admin/sitemodules/post_accomplish/scripts/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="{$siteroot}/admin/sitemodules/post_accomplish/scripts/swfobject.js"></script>
{literal}
<script type="text/javascript">
function trim(val)
{
	var val1=val;
	val1=val1.replace(/^\s*$/g,"");
	return val1;
}
var user = '{/literal}{$smarty.session.duAdmId}{literal}';
var acc_id = '{/literal}{$smarty.get.acc_id}{literal}';
var album_id = '{/literal}{$smarty.get.album_id}{literal}';
var cnt  = 1;
//alert(SITEROOT);

jQuery(document).ready(function(){
	jQuery('#custom_file_upload').uploadify({
				'uploader'       : SITEROOT+'/admin/sitemodules/post_accomplish/scripts/uploadify.swf',
				'script'         : SITEROOT+'/admin/sitemodules/post_accomplish/scripts/uploadify.php',
				'scriptData'     : {'userid':user,'acc_id':acc_id,'album_id':album_id},
				'cancelImg'      : SITEROOT+'/admin/sitemodules/post_accomplish/scripts/cancel.png',
				'folder'         : '/uploads/post_accomplish',
				'multi'          : true,
				'auto'           : true,
				'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
				'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
				'queueID'        : 'custom-queue',
				'queueSizeLimit' : 20,
				'simUploadLimit' : 20,
				'removeCompleted': true,
				'onSelectOnce'   : function(event,data)
				{
					jQuery('#status-message').text(data.filesSelected + ' files have been added to the queue. Wait untill success message.');
				},
				'onComplete'  : function(event,data)
				{
					jQuery('#status-message').text(cnt + ' files uploaded successfully,');
					var cnt =  cnt + 1;
					
				},
				'onAllComplete'  : function(event,data)
				{
					var cnt = data.filesUploaded + data.errors;
					jQuery('#status-message').text(data.filesUploaded+' out of '+cnt+ ' files uploaded successfully.' + data.errors + ' files get errors. ');
					
                        		//window.location=SITEROOT+"/admin/sitemodules/post_accomplish/edit_photo.php?acc_id="+acc_id+"&album_id="+album_id;
				}
// 				'onError'     : function (a, b, c, d) 
// 				{
// 						if (d.status == 404)
// 						alert('Could not find upload script. Use a path relative to: '+'');
// 						else if (d.type === "HTTP")
// 						alert('error '+d.type+": "+d.status);
// 						else if (d.type ==="File Size")
// 						alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
// 						else
// 						alert('error '+d.type+": "+d.text);
// 				}
      	});
	jQuery("#msg").fadeOut(5000);
});

</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<input type="hidden" name="aid"  id="aid" value="{$smarty.get.aid}" />
	<h1 class="type2">Add Accomplishment Photo</h1>
	<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;<a href="{$siteroot}/admin/sitemodules/post_accomplish/award.php">Accomplishment</a>&nbsp;&raquo;&nbsp;Add Photo </div> <br/>
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}

	<div class="holdthisTop">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datagrid">
    		<tr>
      			<td valign="top">
					<form name="frmPhoto" id="frmPhoto" method="post" action="" enctype="multipart/form-data" >
      						<table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" class="conttable" style="padding-left : 20px;">
       								
							<tr>
								
								<td valign="top"><strong>Upload Photos</strong></td>
								
							</tr>
							<tr>
								
								<td valign="top"><strong>Album :</strong>&nbsp;{$album.album_title}</td>
								
							</tr>
							<tr>
								<td><p>You can select multiple photos in the following "Select Photos" dialog by holding down on "ctrl" while clicking on the photos.</p><p>You can upload a maximum of 20 photos (under 50MB in total) at a time.</p></Td>
							</tr>
							<tr>
								<td><div id="status-message" class="fl statmess"> Select Files to upload.</div></td>
							</tr>
							<tr>
								
								<td><input id="custom_file_upload" type="file" name="Filedata"/></td>
							</tr>
							
							</table>
						</form>
					</td>
				</tr>
			</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
{include file=$footer} 