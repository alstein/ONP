{include file=$header_start}
{strip}
	<link rel="StyleSheet" href="{$siteroot}/templates/default/css/lightbox.css" type="text/css"/>	
	<link rel="stylesheet" type="text/css" href="{$siteroot}/js/zoomimage/zoomer.css" media="screen" />

	<!--<script type="text/javascript" src="{$siteroot}/alpha/js/thick_js/thickbox.js"></script>-->

{/strip}
{literal}

<script type="text/javascript">

var siteurl= {/literal}'{$siteroot}'{literal};  
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
   $("body").addClass("slide-shows");
     var username={/literal}'{$profileinfo.username}'{literal};
            
    
     //window.location=SITEROOT+"/"+username+"/albumphotosinDetails/"+album+"/"+imageid;
	
	 tb_show('', siteurl+'/modules/photos/ajaximageslider.php?user='+username+'&album='+album+'&imageid='+imageid+'&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=500&width=984&modal=false',tb_pathToImage);

}


</script>
<script type="text/javascript">
	
// 		document.observe('dom:loaded', function () { 
// 			 $$('.contact-link').each(
// 				function(e){
// 			 		Event.observe( e, 'click', function(){ 
// 						var foo = ('lokes' + 'h.dhakar@' + 'gmail.c' +'om')				
// 						window.location.href = 'mailto:' + foo; return false;
// 					})	
// 				 }
// 			 );
// 		});
		
	</script>
{/literal}

   {include file=$profile_header2}


  <!-- Header ends -->

  <!-- Maincontent starts -->

  <div id="maincont" class="ovfl-hidden">

    <div class="about-us">

      <div class="photo-wrap">

        <div class="photo-head">

          <p><a href="{$siteroot}/{$user.username}/albumphotos/">{if $user.usertypeid eq 2}{$user.fullname|ucfirst}'s{else if $user.usertypeid eq 3}{$user.business_name}{/if} Albums</a></p>

			<input type="hidden" name="albumid" id="albumid" value="{$albumid}" /> 
          <div class="clr"></div>

        </div>

					{if $smarty.session.csUserId eq $UserId}
						<div class="colrt fr" align="right">
								<a href="{$siteroot}/{$profileinfo.username}/{$smarty.get.album}/addphotos" class="submintbtn" style="width:79px">+ Upload More photos</a>
						</div>
					{/if}

        <h2 class="album-head">Album Name- {$album_details.album_title|ucfirst}</h2>

        <ul class="reset album-thumb">

				{section name=d loop=$album_photos}
          					<li style="margin-bottom:10px;">
								{if $album_photos[d].thumbnail neq ""}
									<a href="javascript:;"  onclick="showimagecheckslider('{$albumid}','{$album_photos[d].photo_id}');" title="{$album_photos[d].album_title}"><img src="{$siteroot}/uploads/album/photo/180X158/{$album_photos[d].thumbnail}" alt="{$album_photos[d].photo_title}" width="180" height="135"/></a>
								{else}
									<a href="#"><img src="{$siteroot}/uploads/album/photo/180X158/noimage.jpg"  alt="image" /></a>
								{/if}
							</li>

							
				{sectionelse}
					<li>
						<div class="centerAll norecpad" >
						No records Found. Please 
							<a href="{$siteroot}/{$smarty.get.user}/{$smarty.get.album}/addphotos"><label>Click here </label></a>
						to upload photos. 	
						</div> 
					</li>
				{/section} 
        </ul>

        <div class="clr"></div>

      </div>

      <h2 class="album-head-txt ">Album Description: {$album_description.album_description}</h2>

    </div>

  </div>

  <!-- Maincontent ends -->

</div>

<!-- Footer starts -->

{include file="$footer"}