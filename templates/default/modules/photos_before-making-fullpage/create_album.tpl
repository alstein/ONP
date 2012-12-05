{include file=$header_start}
{strip}
<link href="{$siteroot}/modules/photos/scripts/uploadify.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="{$siteroot}/modules/photos/scripts/swfobject.js"></script>
<script type="text/javascript" src="{$sitejs}/validate/photocreate.js"></script>

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
				'queueID'        : 'custom-queue',
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

</script>
<script type="text/javascript">
function backtoprofile()
{
var username={/literal}'{$profileinfo.username}'{literal};
var albumtitle={/literal}'{$album_details.album_title}'{literal};

window.location=SITEROOT+"/"+username+"";
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
  <div id="maincont" >
    <!-- Left content Start here -->
     {if $smarty.session.csUserTypeId eq 3}{include file=$merchantprofile_left_panel}{elseif $smarty.session.csUserTypeId eq 2}  {include file=$myprofile_left_panel}{/if}
    <!-- Middel content Start here -->
    <div class="profile-middel" style="width: 551px;">
<h2 style="margin-left:20px;color: #2B587A" >{$username|ucfirst} - {if $smarty.get.id1 eq ""} Create Album {else} Edit Album {/if}</h2><br>
<div align="right"><a href="{$siteroot}/{$profileinfo.username}/albumphotos">Back</a></div>
<div align="left"><a href="{$siteroot}/{$profileinfo.username}/albumphotos">View Gallery</a></div>
     	<form name="frmprofile" id="frmprofile" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" name="albumid" id="albumid" value="{$smarty.get.id1}" /> 
		<input type="hidden" name="previmage" id="previmage" value="{$albumdetails.thumbnail}" /> 
 		<div class="" style="padding-top:10px; width:100%">
			<ul class="reset eventinfo">
         		   <li >
				<label class="profile-name">Album Name :</label>
				<input class="signinput" name="album_name" id="album_name" value="{$albumdetails.album_title}" type="text" style="width:265px"/>
           <div class="error" htmlfor="album_name" generated="true" align="center" style="padding-right:11px;"></div>
           <!-- <span id="album_error"></span>-->
			   </li>

	 		    <li >
				 <label class="profile-name">Description :</label>
				 <textarea name="description" id="description"  class="signinput" cols="34" rows="4" style="width:265px">{$albumdetails.album_description}</textarea>
             <div class="error" htmlfor="description" generated="true" align="center" style="padding-right:12px;" ></div>
				<br><br>
			    </li>
			
			    {if $smarty.get.id1 eq ""}
			                   <li class="">
                        <!--        No nudity is permitted in your Public Gallery.-->
                     <p style="padding-left:32px;">You can select multiple photos in the following "Select Photos" dialog by holding down on "ctrl" while clicking on the photos.</p><br>
                     <p style="padding-left:32px;">You can upload a maximum of 200 photos (under 50MB in total) at a time.</p><br>
                            </li>
            {/if}

      
         {if $smarty.get.id1 eq ""}
         <li class="">
                        <!--        No nudity is permitted in your Public Gallery.-->
                     <p style="padding-left:32px;">By clicking the OK button in the following "Select Photos" dialog, you agree that your public gallery photos will NOT contain nudity.</p><br>
                     <p style="padding-left:32px;"> Also no violent, Repulsive, Hateful, or Abusive content is Permitted.</p><br>
         </li> 
         {/if}
      {if $smarty.get.id1 eq ""}
             <li style="margin-left:88px;">
                  <label>&nbsp;</label>
                  <div id="status-message" class="fl statmess"> <strong>Select Files to upload.</strong></div>
            </li>

             <li style="margin-left:88px;">
             <label>&nbsp;</label>
            <div>
     
                  <input id="custom_file_upload" type="file" name="Filedata" />  
           </div>
             </li>
      {/if}
         <li style="margin-left:88px;">
				   <label>&nbsp;</label>

{*
{if $smarty.get.id1 eq ""}
                      <div id="custom-queue"></div> 
                      <input id="custom_file_upload" type="file" name="Filedata"/>  
{else}
               <input name="postbtn" id="postbtn" value="Save" class="submintbtn" type="submit"/>
{/if}
*}
                      <span class="sitesub-btn-lft"><span class="sitesub-btn-right"><input class="loc_busines fl" name="postbtn" id="postbtn" value="Save" class="submintbtn" type="submit" onsubmit="javascript:jQuery('#postbtn').hide();"/> </span></span>
                     <span class="sitesub-btn-lft" style="margin-left:10px;"><span class="sitesub-btn-right"> <input class="loc_busines fl"  name="delete" id="delete" value="Cancel" class="submintbtn" type="button" onclick="backtoprofile();"/> </span></span> 
   		 		       <!--<input name="cancel" id="cancel" value="Back" class="button02" type="button"  onclick="javascript:history.go(-1)"/>-->
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
