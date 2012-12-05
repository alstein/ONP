{include file=$header_start}
{strip}
<link href="{$siteroot}/modules/photos/bk/css/default.css" rel="stylesheet" type="text/css" />
<link href="{$siteroot}/modules/photos/scripts/uploadify.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/swfobject.js"></script>{/strip}
{literal}
<script type="text/javascript">
var id = '{/literal}{$albumid}{literal}';
var user = '{/literal}{$smarty.session.csUserId}{literal}';

var albums = '{/literal}{$albums}{literal}';
var usd = '{/literal}{$smarty.get.user}{literal}';

$(document).ready(function(){
   $('#custom_file_upload').uploadify({
            'uploader'       : SITEROOT+'/modules/photos/scripts/uploadify.swf',
            'script'         : SITEROOT+'/modules/photos/scripts/uploadify.php?id='+user+'&album='+albums,
            'scriptData'     : {'id':user,'album':albums},
            'cancelImg'      : SITEROOT+'/modules/photos/scripts/cancel.png',
            'folder'         : '/modules/photos/uploads/',
            'multi'          : true,
            'auto'           : true,
            'fileExt'        : '*.jpg;*.png;*.jpeg;*.gif;*.JPG;*.PNG;*.JPEG;*.GIF',
            'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
           // 'queueID'        : 'custom-queue',
            'queueSizeLimit' : 200,
            'simUploadLimit' : 200,
            'removeCompleted': true,
//             'onAllComplete'  : function(event,data)
//                {
//                   //   window.location=SITEROOT+"/"+usd+"/public/albumphotos/";
//                },

      'onSelectOnce'   : function(event,data) 
            {
                  $('#status-message').text(data.filesSelected + ' files have been added to the queue. Wait untill success message.');
            },
            'onAllComplete'  : function(event,data) 
            {
                  var cnt = data.filesUploaded + data.errors;
                  $('#status-message').text(data.filesUploaded+' out of '+cnt+ ' files uploaded successfully.' + data.errors + ' files get errors. You can select save button and finalise your upload.');
            },
  
          'onError' : function (a, b, c, d) 
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
</script>
<script type="text/javascript">
function backtophotos()
{
var username={/literal}'{$profileinfo.username}'{literal};
var albumtitle={/literal}'{$album_details.url_title}'{literal};

window.location=SITEROOT+"/"+username+"/"+albumtitle+"/photos";
}
</script>
{/literal}

<!-- main continer of the page -->

  <!-- header container starts here-->
   {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->

<form name="frmalbumphotos" id="frmalbumphotos" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" name="albumid" id="albumid" value="{$smarty.get.id1}" /> 
  <div id="maincont" class="ovfl-hidden">
    <div class="about-us">
      <h1><a href="{$siteroot}/{$profileinfo.username}/{$album_details.url_title}/photos/">{$username}</a> - Edit Album &nbsp;&nbsp;"{$album_details.album_title}"</h1>
      <div class="photo-wrap">
        <div class="photo-head">
          <p class="fl"><a href="{$siteroot}/{$smarty.get.user}/{$smarty.get.album}/photos">View Gallery</a> >> <a href="javascript:void(0)">Add Photos</a></p>
          <div class="clr"></div>
        </div>
        <ul class="reset deal-from" style="margin:15px 0 0 0">
         <!-- <li>
            <label>Album Name: </label>
            <div class="fl textbox">
              <input name="name" type="text" />
            </div>
            <div class="clr"></div>
          </li>
          <li>
            <label>Description:</label>
            <div class="fl add-textbox">
              <textarea name="" cols="" rows="" class="add-inpout"></textarea>
            </div>
            <div class="clr"></div>
          </li>-->

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
        <p>You can select multiple photos in the following "Select Photos" dialog by holding down on "ctrl" while clicking on the photos.</p>
        <p>You can upload a maximum of 200 photos (under 50MB in total) at a time.</p>
        <p>By clicking the OK button in the following "Select Photos" dialog, you agree that your public gallery photos will NOT contain nudity. </p>
        <p> Also no violent, Repulsive, Hateful, or Abusive content is Permitted.</p>
        <br  />
        <strong>Select Files to upload</strong>
        <div class="result-rgt" style="margin:15px 0 0 0">
         <!-- <button class="greybtn"  style="width:120px"> <span class="greybtn-lft"><span class="greybtn-rgt">Select Files</span></span> </button>-->
		  <input id="custom_file_upload" type="file" name="Filedata" />  
        </div>
        <div>
          <div class="fl" style="margin-left:10px">
			<input name="addphotobtn" id="addphotobtn" value="Save"  class="previe-btn" style="width:92px" type="submit"/>
            
          </div>
          <div class="fl" style="margin-left:10px">
			<input name="delete" id="delete" value="Cancel"  class="previe-btn" style="width:92px" type="button" onClick="backtophotos();"/>

          </div>
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