{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery-1.4.4.js"></script>
<script src="{$siteroot}/js/imageslider/js/slides.min.jquery.js"></script>
<link rel="stylesheet" href="{$siteroot}/js/imageslider/css/global.css">
{/strip}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
var imagegetid=jQuery("#imagechkid").val();
showcomments(imagegetid);
//showlikesdiskes(imagegetid);
});
function showimagegallery()
{
     jQuery.get(SITEROOT+"/modules/photos/photos.php",
     function(data)
     { 
        jQuery("#showgallery").html(data);
     });

}
function showimagecheckslider(album,imageid)
{
     var username={/literal}'{$profileinfo.username}'{literal};
     window.location=SITEROOT+"/"+username+"/albumphotosinDetails/"+album+"/"+imageid;
}
$(function(){

// var username={/literal}'{$profileinfo.username}'{literal};
var albumid={/literal}'{$albumid}'{literal};
			$('#slides').slides({
				preload: true,
				preloadImage: SITEROOT+'/js/imageslider/img/loading.gif',
				stop: 0,
				//play:50000,
				//pause: 25000,
				//hoverPause: true,
				animationStart: function(current){
					$('.caption').animate({
						bottom:-35
					},100);
					if (window.console && console.log) {
						var a=jQuery("#imgchk_"+current).val();jQuery("#imageid").val(a);//showcomments();
					};
				},
				animationComplete: function(current){
					$('.caption').animate({
						bottom:0
					},200);

					if (window.console && console.log) {
						var a=jQuery("#imgchk_"+current).val();jQuery("#imageid").val(a);
						showimagecheckslider(albumid,a);
						// 						setTimeout(window.location=SITEROOT+"/"+username+"/albumphotosinDetails/"+albumid+"/"+a,1000);
						showcomments(a);
					};
				},
				slidesLoaded: function() {
					$('.caption').animate({
						bottom:0
					},200);
				}
			});
		});

function showcomments(imageid)
{
jQuery.post(SITEROOT+"/modules/photos/ajaximageslidercomments.php",{imageid:imageid},function(data)
{
	jQuery("#commentsdiv").html(data);
});
}
function showlikesdiskes(imageid)
{
var likstatus="showlikes";
jQuery.post(SITEROOT+"/modules/photos/ajaximageslider.php",{likstatus:likstatus,imageid:imageid},function(data)
{
	return true;
});

}
function addcomments(imageid)
{
var act="add";
var comment=jQuery("#comments").val();
if(comment=="")
{
	alert("Post comment cannot be blank");return false;
}
else if((document.getElementById('comments').value.length)>25)
{
	alert("Post comment Maximum length atleast 25 characters");return false;
}
else
{
jQuery.post(SITEROOT+"/modules/photos/ajaximageslidercomments.php",{act:act,imageid:imageid,comment:comment},function(html){
	jQuery("ol#update li:first").slideDown("slow");
  	document.getElementById('comments').value='';
	jQuery('#msg').html("Post added successfully").fadeOut(1000).css('color', 'green');showcomments(imageid);
	return true;
});
}
}
function delcomments(commentid)
{
	var act="delete";
 	var my_string=confirm("Are you sure you want to remove your comment?");
	if(my_string)
	{
	jQuery.post(SITEROOT+"/modules/photos/ajaximageslidercomments.php",{act:act,commentid:commentid},function(data){
	jQuery('#li_'+commentid).slideUp();
	jQuery('#msg').html("Post deleted successfully").fadeOut(1000).css('color', 'green');
	return true;
	});
	}
	else
	{
		return true;
	}

}
function likeimage(imageid)
{
var act="likes";
var likchkcnt={/literal}'{$likcnt}'{literal};
	if(likchkcnt!="")
	{
	var likcnt=parseInt(likchkcnt)+1;
	}
	else
	{
	var likcnt=0+1;
	}
	var dischklikcnt={/literal}'{$dislikcnt}'{literal};

	if(parseInt(dischklikcnt)>1)
	{
		
		var dislikcnt=parseInt(dischklikcnt)-1;
		jQuery("#dislikcnt").html(dislikcnt);
		
	}
	jQuery.post(SITEROOT+"/modules/photos/ajaximageslider.php",{act:act,imageid:imageid},function(data)
	{
	jQuery("#likcnt").html(likcnt);
	jQuery("#liklink").html('<a href="javascript:;">Likes</a>');
	});
}

function dislikeimage(imageid)
{
var act="dislikes";
var likchkcnt={/literal}'{$likcnt}'{literal};
var dischklikcnt={/literal}'{$dislikcnt}'{literal};
	if(dischklikcnt!="")
	{
	var dislikcnt=parseInt(dischklikcnt)+1;
	}
	else
	{
	var dislikcnt=0+1;
	}
	if(parseInt(likchkcnt)>1)
	{
		
		var likcnt=parseInt(likchkcnt)-1;
		jQuery("#dislikcnt").html(dislikcnt);
	}
	jQuery.post(SITEROOT+"/modules/photos/ajaximageslider.php",{act:act,imageid:imageid},function(data)
	{
		jQuery("#dislikcnt").html(dislikcnt);
		jQuery("#disliklink").html('<a href="javascript:;">Dislikes</a>');
	});
}
function sortOrder(page,pageno,imageid)
{
	var newpage = page;
        if(pageno=="")
	{
	pageno=1;
	}
	if(newpage == 'Next')
	{
		var pack = parseInt(pageno) + 1;
	}
	else
	{
		var pack = parseInt(pageno) - 1;
	}

	jQuery.post(SITEROOT+"/modules/photos/ajaximageslidercomments.php?page="+pack,{imageid:imageid}, function(data)
	{
		jQuery("#commentsdiv").html(data);
	});
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
<h2 style="margin-left:20px;color:#2B587A;" ><a style="color:#2B587A;"  href="{$siteroot}/{$user.username}/albumphotos/">{$user.username|ucfirst}'s Albums</a>&nbsp;</h2><br>
<!--<div align="right"><a href="{$siteroot}/{$profileinfo.username}/albumphotos">Back</a></div>-->
<div>&nbsp;</div>
		<input type="hidden" name="albumid" id="albumid" value="{$albumid}" /> 
		{if $smarty.session.csUserId eq $user.userid}
			<div class="colrt fr" align="right">
					<a href="{$siteroot}/{$profileinfo.username}/{$smarty.get.album}/addphotos" class="submintbtn" style="width:79px">+ Upload More photos</a>
			</div>
		{/if}
<h3 style="margin-left:20px;color:#2B587A;">Album Name- {$album_details.album_title|ucfirst}</h3>
<!-- slider-->
	<input type="hidden" name="imageid" id="imageid">
	<input type="hidden" name="imagechkid" id="imagechkid" value={$smarty.get.imageid}>
	<div id="container">
		<div id="example">
			<img src="{$siteroot}/js/imageslider/img/new-ribbon.png" width="112" height="112" alt="New Ribbon" id="ribbon">
			<div id="slides">
				<div class="slides_container">
					{section name=d loop=$album_photos}
						<div class="slide">
							
								{if $album_photos[d].thumbnail neq ""}
								<a href="{$siteroot}/uploads/album/photo/bigimage/{$album_photos[d].thumbnail}" rel="lightbox[plants]" title="{$album_photos[d].album_title}"><img src="{$siteroot}/uploads/album/photo/600X600/{$album_photos[d].thumbnail}" alt="{$album_photos[d].photo_title}" width="480" height="270" /></a>
								<input type="hidden" name="imgchk" id="imgchk_{$smarty.section.d.iteration}" value="{$album_photos[d].photo_id}">
								{else}
								<a href="#"><img src="{$siteroot}/uploads/album/photo/180X158/noimage.jpg"  alt="image" width="480" height="270"/></a>
								{/if}
								<table width="100%">
								<tr><td id="msg">&nbsp;</td></tr>
								<tr>
								<td>&nbsp;</td><td valign="top" align="center"> <span id="likcnt">{if $likcnt neq ''}{$likcnt}{else}0{/if}</span>
									<span id="liklink">
									{if $flaguserlikchk eq '1'}
									<a href="javascript:;">Likes</a>
									{else}
									<a href="javascript:;" onclick="likeimage('{$album_photos[d].photo_id}');">Likes</a>
									{/if}
									</span>
									<span id="dislikcnt">{if $dislikcnt neq ''}{$dislikcnt}{else}0{/if}</span>
									{if $flaguserdislikchk eq '1'}
									<span id="disliklink">
									<a href="javascript:;">Dislikes</a>
									{else}
									<a href="javascript:;" onclick="dislikeimage('{$album_photos[d].photo_id}')">Dislikes</a>{/if}
									</span>

									</td>


								</tr>
								<tr><td>Comments</td>
								</tr>
								
								<tr><td colspan="2">Leave your comments here</td></tr>
								<tr><td colspan="2">
								<input class="signinput" type="text" id="comments" name="comments" style="width:450px;"></td></tr>
								<tr><td colspan="2">
									<span class="sitesub-btn-lft">
									<span class="sitesub-btn-right">
									<input class="loc_busines fl" type="button" value="Share" name="Submit" onclick="addcomments('{$album_photos[d].photo_id}');"/>
									</span>
									</span>
									</td>
								</tr>
								<tr>
									<td colspan="2">
									<ol id="update" class="reset">
									<div  id="commentsdiv"></div>
									</ol>
									</td>
								</tr>
								
								</table>
						</div>
								
				{/section}
				</div>
				<a href="#" class="prev"><img src="{$siteroot}/js/imageslider/img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="{$siteroot}/js/imageslider/img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
		
		</div>
	</div>
			<!-- slider--> 
	</div>
    <!-- Right content Start here -->
       {if $smarty.session.csUserTypeId eq 3} {include file=$merchantprofile_right_panel}{elseif $smarty.session.csUserTypeId eq 2} {include file=$myprofile_right_panel}{/if}
    <!-- footer container Start-->
    <div id="footerwrap" class="ovfl-hidden">
	<div id="footer" class="normTxt" style="width:800px"> 
	<p class="fl"><a href="{$siteroot}/help">Help</a> : <a href="{$siteroot}/about-us">About </a> : <a href="{$siteroot}/privacy-policy">Privacy</a> : <a href="{$siteroot}/terms">Terms</a> : <a href="{$siteroot}/contact-us">Contact Us</a></p>
	<p class="fr">© 2012 Company Name. All Rights Reserved.</p>
	<div class="clr"></div>
	</div>
   </div>
    <!-- footer container End-->
  </div>
  </div>
</body>
</html>
