{include file=$header1}
{strip}
<link href="{$siteroot}/modules/photos/css/default.css" rel="stylesheet" type="text/css" />
<link href="{$siteroot}/modules/photos/css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/swfobject.js"></script>
<!-- <script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery-1.3.2.min.js"></script> -->
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.0.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
{/strip}
{literal}
<style type="text/css">
/*.swfupload:hover {background: url(../images/site/bg3.png) 0 0 repeat-y; color:#f00;} */
.swfupload{vertical-align:top;}
</style>

<script type="text/javascript">

var url = SITEROOT+"/modules/photos/ajax-upload-photos.php";
jQuery.ajax({ url: url, success: function(data) { 
	jQuery('#showpics').html(data);
}   });

// 		var id = '{/literal}{$smarty.get.id1}{literal}';
var id = '{/literal}{$session_id}{literal}';
jQuery(document).ready(function() {
	
	jQuery("#uploadify").uploadify({
		'uploader'       : SITEROOT+'/modules/photos/scripts/uploadify.swf',
		'script'         : SITEROOT+'/modules/photos/scripts/uploadify.php?id='+id+'STRING_SEPARATER'+SITEROOT,
		'cancelImg'      : SITEROOT+'/templates/default/images/site/close.png',
		'folder'         : 'big',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'fileDesc'  	 : 'Image Files',
		'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
		'buttonImg'	 :SITEROOT+'/templates/default/images/site/browsebtn.png',
		'width':120,
		'height':45,
		
		onAllComplete: function() {
			jQuery('#loadingimg').show();
			var url = SITEROOT+"/modules/photos/ajax-upload-photos.php";
			jQuery.ajax({ url: url, success: function(data) {
				jQuery('#showpics').html(data);
		 }   });
			jQuery('#loadingimg').hide();
		}
	});
});



	function removepic(photoid)
	{
		jQuery.facebox({ajax:SITEROOT + '/modules/common/common-popup.php?page=removepic&ph_id='+photoid});
	}

	</script>
{/literal}
{include file=$header2}
<div id="breadcrumb">
   <p><a href="{$siteroot}/profile/" title="HOME">HOME</a>  /  <a href="{$siteroot}/profile/" title="Profile">{$smarty.session.csFirstName|upper} {$smarty.session.csLastName|upper}’S PROFILE</a> / <a href="{$siteroot}/photos/search-photos/" title="PHOTOS">PHOTOS</a> / <!--<a href="{$siteroot}/photos/create-album/" title="CREATE AN ALBUM">--><span style="font-size:10px;">CREATE AN ALBUM</span><!--</a>--></p>
</div>
<form name="frmPhoto" id="frmPhoto" method="post" action="" enctype="multipart/form-data" >
    <div class="createalbum">
      <div class="top3">
        <div>&nbsp;</div>
      </div>
<div class="clr" style="height:0px"></div>
      <div class="bg3">
        <div class="innerdiv">{*$msg*}
			<!--<table width="862" border="0" cellspacing="0" cellpadding="2">
			<tr>
				<td align="left"><strong>Picture</strong>
				<input  class="file" type="file" name="file" id="my_file_element" /><br/><div id="fileerror" style="display:none;" class="redclr"><b>Please select valid files.</b></div>
				</td>
				<td>
					<div id="files_list"></div>
					{literal}
					<script type="text/javascript">
						var multi_selector = new MultiSelector( document.getElementById( 'files_list' ));
						multi_selector.addElement( document.getElementById( 'my_file_element' ) );
					</script>
					{/literal}
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</table>-->
          <div>
        <div style="height:30px;">Click to upload images in this album</div>
                <form action="">
                   <!-- <div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
		</div>-->
				<div id="showpics"></div>
				<div id="loadingimg" style="display:none"><img src="{$siteroot}/templates/default/images/site/loadingAnimation.gif"></div>
				<div id="fileQueue"></div>
				<input type="file" name="uploadify" id="uploadify" />
                </form>
        </div>
	<!--<div id="divFileProgressContainer" style="height: 75px;margin-top:25px"></div>
	<div style="height:50px;"></div>
	<div id="thumbnails"></div>-->
        </div>
      </div>
      <div class="end3">
        <div>&nbsp;</div>
      </div>
      <div class="fullwid ">
        <div class="actions ovfl-hidden">
			<div class="col2">
            <input type="button" class="bigbtninput" value="Cancel and
Back to Album" onclick="javascript:history.back();"/></div>
          <div class="col3">
            <input type="submit" class="bigbtninput" name="sub" value="Save and
Back to Photos"/>
          </div>
          <div class="col2">
 <input type="submit" class="bigbtninput" name="adddet" value="Upload and Add
Album Details" />
          </div>
        </div>
      </div>
    </div>
  </form>
{include file=$footer}