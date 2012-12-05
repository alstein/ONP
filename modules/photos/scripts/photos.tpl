{include file=$header1}
<link href="{$siteroot}/modules/photos/css/default.css" rel="stylesheet" type="text/css" />
<link href="{$siteroot}/modules/photos/scripts/uploadify.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/swfobject.js"></script>
{literal}
<script type="text/javascript">
var id = '{/literal}{$albumid}{literal}';
var user = '{/literal}{$smarty.session.csUserId}{literal}';

var album = '{/literal}{$smarty.get.album}{literal}';
var usd = '{/literal}{$smarty.get.user}{literal}';

$(document).ready(function(){
	$('#custom_file_upload').uploadify({
				'uploader'       : SITEROOT+'/modules/photos/scripts/uploadify.swf',
				'script'         : SITEROOT+'/modules/photos/scripts/uploadify.php?id='+id,
				'cancelImg'      : SITEROOT+'/modules/photos/scripts/cancel.png',
				'folder'         : '/modules/photos/uploads/',
				'multi'          : true,
				'auto'           : true,
				'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
				'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
				'queueID'        : 'custom-queue',
				'queueSizeLimit' : 10,
				'simUploadLimit' : 10,
				'removeCompleted': true,
				'onAllComplete'  : function(event,data) 
				{
					//$('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
					window.location=SITEROOT+"/"+usd+"/"+album+"/photos/";
					
    				}
		});		
});

/*
$(document).ready(function() {
	$("#uploadify").uploadify({
		'uploader'       : SITEROOT+'/modules/photos/scripts/uploadify.swf',
		'script'         : SITEROOT+'/modules/photos/scripts/uploadify.php?id='+id,
		'cancelImg'      : SITEROOT+'/modules/photos/cancel.png',
		'folder'         : 'big',
		'queueID'        : 'fileQueue',
		'auto'           : true,
		'multi'          : true,
		'fileDesc'  	 : 'Image Files',
		'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
		'buttonImg'	 :SITEROOT+'modules/photos/temp_uploads/201011171208_getphotos.gif',
		'width':120,
		'height':45,
		
		onAllComplete: function() 
		{
			window.location=SITEROOT+"/"+usd+"/"+album+"/photos/";
		}

	});
});*/
</script>{/literal}

{include file=$header2}
     <div class="ovfl-hidden fullwid">
	{include file=$profileleft}
      <div class="mid_col">
		{include file=$profilemenu}
		{*{include file=$profileright}*}
            
            <div class="photosec">
            	<div class="titletp ovfl-hidden">
                <!--	<h3 class="title2 fl">{$smarty.session.csUserName|ucfirst}'s Albums</h3> {$album_details.album_title}-->
   			<h3 class="title2 fl"><a href="{$siteroot}/{$smarty.get.user}/albumphotos/">{$user.login_name|ucfirst}'s Albums</a>{$album_details.album_title}</h3>
		{if $smarty.session.csUserId eq $user.userid}	

				<div id="showpics"></div>
				<div id="custom-queue"></div> 
			    	<div class="colrt fr">
					<input id="custom_file_upload" type="file" name="Filedata" />	
				</div>		
                    <div class="colrt fr">
                    	<a href="{$siteroot}/{$smarty.get.user}/{$smarty.get.album}/addphotos" class="button1">+ Add More photos</a>
                    </div>
		{/if}
                </div>
                <div class="ovfl-hidden">
                    <ul class="reset photo_list1 adjuster1 width1">
			{section name=d loop=$album_photos}
			 <li>
				<a href="{$siteroot}/{$smarty.get.user}/{$album_details.url_title}/{$album_photos[d].photo_id}/{$smarty.section.d.iteration}/details">
				{if $album_photos[d].thumbnail neq ""}
					<img src="{$siteroot}/uploads/album/photo/180X158/{$album_photos[d].thumbnail}"  alt="Image" />
				{else}
					<img src="{$siteroot}/uploads/album/photo/180X158/noimage.jpg"  alt="image" />
				{/if}
				</a>
                        </li>
			{sectionelse}
                        <div class="centerAll norecpad" >
				No records Found. Please 
					<a href="{$siteroot}/{$smarty.get.user}/{$smarty.get.album}/addphotos"><label>Click here </label></a>
				to upload photos. 	
				</div> 
			{/section}
                    </ul>
                </div>
            <!--    <div class="addcaptionsec ovfl-hidden">
                	<div class="image"><img src="images/imgsml05.jpg" width="46" height="47" alt="image" /></div>
                    <div class="desc">
                    	<div class="grybg">
                        	<input type="text" onblur="if(this.value=='')this.value='Comment...';" onclick="if(this.value=='Comment...')this.value='';" value="Comment..." class="input" /> <input type="submit" class="commentbtn" value="Comment" />
                        </div>
                    </div>
                </div>-->
            </div>
            
        </div>
    </div>
	

</div>
</div>
<!-- footer container -->
{include file=$footer}
