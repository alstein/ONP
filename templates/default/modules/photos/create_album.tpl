{include file=$header_start}
{strip}
<link href="{$siteroot}/modules/photos/scripts/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.js"></script>
<!--<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.min.js"></script>-->
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/swfobject.js"></script>
<script type="text/javascript" src="{$sitejs}/validation/createalbum.js"></script>
{/strip}
{literal}
<script type="text/javascript">
var id = '{/literal}{$albumid}{literal}';
var user = '{/literal}{$smarty.session.csUserId}{literal}';

var album = '{/literal}{$smarty.get.album}{literal}';
var usd = '{/literal}{$smarty.get.user}{literal}';
var abltitle = document.getElementById('album_name');
var cnt  = 1;

$(document).ready(function(){

	$('#msg').fadeOut(5000);
	$('#custom_file_upload').uploadify({
				'uploader'       : SITEROOT+'/modules/photos/scripts/uploadify.swf',
				'script'         : SITEROOT+'/modules/photos/scripts/uploadify.php',
				'scriptData'     : {'id':user,'abltitle':abltitle},
				'cancelImg'      : SITEROOT+'/modules/photos/scripts/cancel.png',
				'folder'         : '/modules/photos/uploads/',
				'multi'          : true,
				'auto'           : true,
				'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
				'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
			//	'queueID'        : 'custom-queue',
				'queueSizeLimit' : 200,
				'simUploadLimit' : 200,
				'removeCompleted': true,
// 				'onAllComplete'  : function(event,data)
// 				{
//       				//	$('#frmprofile').submit();
//     				},
				'onSelectOnce'   : function(event,data) 
				{
					$('#status-message').text(data.filesSelected + ' files have been added to the queue. Wait untill success message.');
				},
//           			'onComplete'  : function(event,data) 
//            			{
//                			$('#status-message').text(cnt + ' files uploaded successfully,');
//                  			var cnt =  cnt + 1;
//            			}, 
				'onAllComplete'  : function(event,data) 
				{
					$("#temp").val("yes");
					var cnt = data.filesUploaded + data.errors;
					$('#status-message').text(data.filesUploaded+' out of '+cnt+ ' files uploaded successfully.' + data.errors + ' files get errors. You can select save button and finalise your upload.');
					{/literal} {php} unset($_SESSION['newupload']); {/php} {literal}
				},
				'onError'     : function (a, b, c, d) 
				{
					if (d.status == 404)
					alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');
					else if (d.type === "HTTP")
					alert('error '+d.type+": "+d.status);
					else if (d.type ==="File Size")
					alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
					else
					alert('error '+d.type+": "+d.text);
				}
      });
});

function check(){
	$("#frmprofile").validate();
	if($("#frmprofile").valid()){
		var str = $("#temp").val(); 
		if(str == 'no'){
			$("#chkp").show();
			return false;
		}else{
			$("#chkp").hide();
			$("#frmprofile").submit();
			return true;
		}
	}
}
</script>
<script type="text/javascript">
function backtoprofile()
{
var username={/literal}'{$profileinfo.username}'{literal};
var albumtitle={/literal}'{$album_details.album_title}'{literal};

window.location=SITEROOT+"/"+username+"/albumphotos/";
}
</script>
{/literal}

<!-- main continer of the page -->
  <!-- header container starts here-->
  {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->

   <form name="frmprofile" id="frmprofile" method="post" action="" enctype="multipart/form-data">
		
        <input type="hidden" name="albumid" id="albumid" value="{$smarty.get.id1}" />
        <input type="hidden" name="previmage" id="previmage" value="{$albumdetails.thumbnail}" />	
		<input type="hidden" name="temp" id="temp" value="{if $smarty.get.id1 neq '' && $smarty.get.id2 eq 'edit'}yes{else}no{/if}">

  <div id="maincont" class="ovfl-hidden">
    <div class="about-us">
      <h1><a href="{$siteroot}/{$profileinfo.username}/{$album_details.url_title}/photos/">{$username|ucfirst} - {if $smarty.get.id1 eq ""} Create Album {else} Edit Album {/if}</a></h1>
	
			<div style="color:green;" align="center" id="msg">{$msg}</div>
	
      <div class="photo-wrap">
        <div class="photo-head">
           <p class="fl"><a href="{$siteroot}/{$profileinfo.username}/albumphotos">View Gallery</a></p>
          <div class="clr"></div>
        </div>
        <ul class="reset deal-from" style="margin:15px 0 0 0">
          <li>
            <label>Album Name: </label>
            <div class="fl textbox">
              <input  name="album_name" id="album_name" value="{$albumdetails.album_title}" type="text" style="width:265px" />
            </div>
            <div class="clr"></div>
          </li>
          <li>
            <label>Description:</label>
            <div class="fl add-textbox">
              <textarea cols="34" rows="4" class="add-inpout" name="description" id="description" >{$albumdetails.album_description}</textarea>
            </div>
            <div class="clr"></div>
          </li>


			<!--<li>  <input type="hidden" name="previmage" id="previmage" value="{$albumdetails.thumbnail}" />
            {if $albumdetails.thumbnail neq ''}
               <img src="{$siteroot}/uploads/album/thumbnail/{$albumdetails.thumbnail}" border="0" class="active">
            {else}
               {if $smarty.get.id2 eq 'edit'}
                  <img src="{$siteroot}/uploads/album/photo//180X158/noimage.jpg" border="0" class="active"> 
               {/if}
            {/if}</li>-->
		
        </ul>
        <div class="clr"></div>
  {if $smarty.get.id1 eq ""}
        <p>You can select multiple photos in the following "Select Photos" dialog by holding down on "ctrl" while clicking on the photos.</p>
        <p>You can upload a maximum of 200 photos (under 50MB in total) at a time.</p>
        <p>By clicking the OK button in the following "Select Photos" dialog, you agree that your public gallery photos will NOT contain nudity. </p>
        <p> Also no violent, Repulsive, Hateful, or Abusive content is Permitted.</p>
        <br  />
{/if}
        <strong {if $smarty.get.id1 neq ''} style="padding-left:178px" {/if}>Select Files to upload</strong>
        <div class="result-rgt" style="margin:15px 0 0 0; {if $smarty.get.id1 neq ''} padding-left:178px" {/if}"  >
         <!-- <button class="greybtn"  style="width:120px"> <span class="greybtn-lft"><span class="greybtn-rgt">Select Files</span></span> </button>-->
		  <input id="custom_file_upload" type="file" name="Filedata" />  
		<div style="display:none;width:300px" id="chkp" class="error">Please Uplaod at least one file.</div>
        </div>
				
        <div {if $smarty.get.id1 neq ''} style="padding-left:178px" {/if}>
          <div class="fl" style="margin-left:10px">
 			<input name="postbtn" id="postbtn" value="Save" class="previe-btn" type="button" onclick="check()" />

			
            
          </div>
          <div class="fl" style="margin-left:10px">
 			<input class="previe-btn"  name="delete" id="delete" value="Cancel" class="submintbtn" type="button" onclick="backtoprofile();"/>
          </div>
		

			<!--{if $smarty.get.id1 eq ""}
				<div id="custom-queue"></div>
				<input id="custom_file_upload" type="file" name="Filedata"/>
				{else}
				<input name="postbtn" id="postbtn" value="Save" class="submintbtn" type="submit"/>
            {/if}-->

          <div class="clr"></div>
        </div>
      </div>
    </div>
  </div>
</form>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
{include file=$footer}