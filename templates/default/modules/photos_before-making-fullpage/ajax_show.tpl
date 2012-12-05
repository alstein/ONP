{strip}
        <script src="{$siteroot}/js/galleria/galleria-1.2.5.min.js"></script>

{/strip}
{literal}
  <style>
            /* Demo styles */
          /*  html,body{background:#222;margin:0;}
            body{border-top:4px solid #000;}*/
            .content{color:#777;font:12px/1.4 "helvetica neue",arial,sans-serif;width:620px;margin:20px auto;}
            h1{font-size:12px;font-weight:normal;color:#ddd;margin:0;}
            p{margin:0 0 20px}
            a {color:#22BCB9;text-decoration:none;}
            .cred{margin-top:20px;font-size:11px;}

            /* This rule is read by Galleria to define the gallery height: */
           /* #galleria{height:420px;width:655px}*/

        </style>
{/literal}
				<div class="titletp ovfl-hidden">
						<strong><a href="{$siteroot}/{$profileinfo.username}/albumphotos/">{$profileinfo.username|ucfirst}'s Albums</a>&nbsp;{$album_details.album_title}</strong>
				</div>
    {if $photo_details neq ''} <div id="galleria">
 	{section name = sec1 loop=$photo_details}
            <a href="{$siteroot}/uploads/album/photo/600X600/{$photo_details[sec1].thumbnail}" id="{$photo_details[sec1].photo_id}">
            	<img title="{$photo_details[sec1].photo_title}"
            	     alt="{$photo_details[sec1].photo_id}"
            	     src="{$siteroot}/uploads/album/photo/600X600/{$photo_details[sec1].thumbnail}">
      	   </a>
	{/section}
	</div>{else}

 				<div align="center" style="margin-top:10px;">
				No records Found. Please 
					<a href="{$siteroot}/{$profileinfo.username}/{$albumname}/addphotos">Click here</a>
				to upload photos. 	
				</div> 
{/if}
<input type="hidden" name="albumid" id="albumid" value="{$albumid}" /> 
  <input type="hidden" name="imageid" id="imageid" value="{$smarty.post.photoid}">
<span style="float:right;margin-top:10px;">
  {if $photo_details neq ''}{if $profileinfo.userid eq $smarty.session.csUserId} 
<a href="javascript:;"  onclick="confirmdeleteimage();">Delete this photo</a>
{/if}
<br/>
<!--<a href="javascript:;"  onclick="javascript:var idsimg = jQuery('#imageid').val();tb_show('Whom You Want To Tag in this photo', '{$siteroot}/modules/photos/ajax_tag.php?idimg='+idsimg+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=360&width=630&modal=false', tb_pathToImage);">Tag this photo</a>-->
</span>
 <!-- <div class="ovfl-hidden ncoment" style="margin-top:10px;">
		        		<div class="addcaptionsec ovfl-hidden">
					
						 <div class="desc">
							<div class="grybg">
								<input type="text"  name="Comments" id="Comments"  class="input" /> 
								<input type="button" class="commentbtn" name="postphotocomment" id="postphotocomment" onclick="addcomment();" value="Post">
						        </div>
						 </div>
               				</div>

				
			            <table  cellpadding="2" cellspacing="2" id="ajaxphotocomment">
			            </table>
   	 	</div>-->
{/if}
    {literal}
    <script type="text/javascript">
var path={/literal}'{$siteroot}'{literal};
    // Load the classic theme
	Galleria.loadTheme(''+path+'/js/galleria/themes/classic/galleria.classic.min.js');
    jQuery("#galleria").galleria
    ({
  	width: 552,
        height: 420,
        extend: function(options) 
	{
            var gallery = this; // "this" is the gallery instance
            this.bind(Galleria.IMAGE, function(e) 
	    {
		var current = gallery.getData(gallery.getIndex());
		var currImg = current.original;
		var altText = $(currImg).attr('alt');
		if (typeof console == "undefined") var console = { log: function() {} };
		console.log(altText, current.title);
		showimg(altText);
            });
        }
    });
function showimg(imageid)
{
	jQuery.get(SITEROOT+"/modules/photos/ajax_show.php",{imageid:imageid},
	function(data)
	{
		return true;
	});
	seeComment('3',imageid);
	jQuery("#imageid").val(imageid);
}
function addcomment()
{
	var retval = validatecomment();
	if(retval===true)
	{
		var imageid1=jQuery("#imageid").val();
		funpostcomment('3',imageid1,'add');
	}
	else
	{
		return false;
	}
}
function confirmdeleteimage()
{
        var imageid1=jQuery("#imageid").val();
	var albumid=jQuery("#albumid").val();
	var my_string=confirm("Are you sure you want to remove this photo from your Album?");
	if(my_string)
	{
		deletephoto(imageid1,albumid);
	}
	else
	{
	return true;
	}
}
function deletephoto(imageid1,albumid)
{
     var act="delete";
		alert(imageid1);
		alert(albumid);
     jQuery.get(SITEROOT+"/modules/photos/ajax_show.php",{imageid1:imageid1,albumid:albumid,act:act},
     function(data)
     {
       refreshpage(albumid);
       return true;
     });
}
function tagimage(strcheckuser,xpos,ypos)
{

    var imageid1=jQuery("#imageid").val();
    var albumid=jQuery("#albumid").val();
     var act="tag";
     jQuery.get(SITEROOT+"/modules/photos/ajax_show.php",{imageid1:imageid1,albumid:albumid,strcheckuser:strcheckuser,xpos:xpos,ypos:ypos,act:act},
     function(data)
     {
       return true;
     });
}

function closebox()
{
javascript: window.parent.tb_remove();
}
    </script>
{/literal}