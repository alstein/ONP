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
            'queueID'        : 'custom-queue',
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
<body class="inner_body">
<!-- main continer of the page -->
<div id="wrapper">
  <!-- header container starts here-->
   {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont">
    <!-- Left content Start here -->
     {if $smarty.session.csUserTypeId eq 3}{include file=$merchantprofile_left_panel}{elseif $smarty.session.csUserTypeId eq 2}  {include file=$myprofile_left_panel}{/if}
    <!-- Middel content Start here -->
    <div class="profile-middel"  style="width: 551px;">
	<div align="right"><a href="javascript:void(0);" onClick="javascript: history.go(-1)">Back</a></div>
  <h3 class="title"><a href="{$siteroot}/{$profileinfo.username}/{$album_details.url_title}/photos/">{$username}'s Albums</a>&nbsp;{$album_details.album_title}</h3>
<!-- <div align="right"> <a href="#" class="submintbtn">+ Upload more photos</a> </div>-->
          <!--  <ul class="reset photo_list adjuster1 width1">-->
		<form name="frmalbumphotos" id="frmalbumphotos" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" name="albumid" id="albumid" value="{$smarty.get.id1}" /> 
 			<div  style="padding-top:10px; width:100%;">

            <ul class="reset eventinfo">
                            <li class="">
                     <p style="padding-left:32px;">You can select multiple photos in following dialog by holding down on "ctrl" while clicking on the photos.</p><br>
                     <p style="padding-left:32px;">You can upload a maximum 200 photos (Under 50 MB in total) at a time.</p>
                            </li><br>

              <li style="margin-left:80px;">
                  <label>&nbsp;</label>
                  <div id="status-message" class="fl statmess"><strong>Select Files to upload.</strong></div>
            </li><br>
                  
                <li style="margin-left:75px;">
                         <label><!--Select Photo's:-->&nbsp;</label>
                 <!--          <div id="custom-queue"></div> -->
                           <input id="custom_file_upload" type="file" name="Filedata" />  
             </li><br>
                 <li class="">
                        <!--        No nudity is permitted in your Public Gallery.-->
                    <br> <p style="padding-left:32px;">By Clicking the OK button on dialog, You agree that your public gallery photos do NOT contain nudity.</p><br>
                     <p style="padding-left:32px;">Also no violent, Repulsive, Hateful, or Abusive content is Permitted.</p><br>
               </li>

               <li style="margin-left:80px;">
             <label>&nbsp;</label>
            <input type="hidden" name="previmage" id="previmage" value="{$albumdetails.thumbnail}" />
            {if $albumdetails.thumbnail neq ''}
               <img src="{$siteroot}/uploads/album/thumbnail/{$albumdetails.thumbnail}" border="0" class="active">
            {else}
               {if $smarty.get.id2 eq 'edit'}
                  <img src="{$siteroot}/uploads/album/photo//180X158/noimage.jpg" border="0" class="active"> 
               {/if}
            {/if}
              </li>

              <li style="margin-left:80px;">
               <label>&nbsp;</label>
                  <!--   <input name="postbtn" id="postbtn" value="Save" class="button01" type="submit" onclick="javascript: return chechfields();"/> -->
                 <span class="sitesub-btn-lft"><span class="sitesub-btn-right"><input name="addphotobtn" id="addphotobtn" value="Save" class="loc_busines fl" type="submit"/></span></span>
               <span class="sitesub-btn-lft" style="margin-left:10px;"><span class="sitesub-btn-right"> <input name="delete" id="delete" value="Cancel" class="loc_busines fl" type="button" onclick="backtophotos();"/></span></span>
                 </li>
         </ul>
		</div>
	</form>
    </div>
    <!-- Right content Start here -->
      {if $smarty.session.csUserTypeId eq 3} {include file=$merchantprofile_right_panel}{elseif $smarty.session.csUserTypeId eq 2} {include file=$myprofile_right_panel}{/if}
    <!-- footer container Start-->
      {include file=$footer}
    <!-- footer container End-->
  </div>
</div>
</body>
</html>
