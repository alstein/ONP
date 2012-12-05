{include file=$header_start}
{strip}
<!--<link rel="stylesheet" href="{$siteroot}/lightbox/lightbox.css" type="text/css" media="screen" />-->
<!--<script type="text/javascript" src="{$siteroot}/lightbox/lightbox.js"></script>-->

	<link rel="stylesheet" href="{$siteroot}/lightbox1/css/screen.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{$siteroot}/lightbox1/css/lightbox.css" type="text/css" media="screen" />
	<!--<script src="{$siteroot}/lightbox1/js/prototype.js" type="text/javascript"></script>
	<script src="{$siteroot}/lightbox1/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
	<script src="{$siteroot}/lightbox1/js/lightbox.js" type="text/javascript"></script>-->
	<link href="{$siteroot}/modules/photos/bk/css/default.css" rel="stylesheet" type="text/css" />
	<link href="{$siteroot}/modules/photos/scripts/uploadify.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="{$siteroot}/js/MyAjax.js"></script>
	<script type="text/javascript" src="{$siteroot}/js/rating.js"></script>
	<link rel="stylesheet" type="text/css" href="{$siteroot}/js/zoomimage/zoomer.css" media="screen" />
{/strip}
{literal}

<script type="text/javascript">
function showimagegallery()
{
     jQuery.get(SITEROOT+"/modules/photos/photos.php",
     function(data)
     { 
        jQuery("#showgallery").html(data);
     });

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
			<h3 style="margin-left:20px;color:#2B587A;">Album Name- {$album_details.album_title|ucfirst}</h3><br>
	<div id="showgallery">
                <div id="content">
		<div class="container">
			<ul class="thumb"  {if $count eq 0} style="width:580px;height:100px;" {else} style="width:580px;"{/if}>
			{section name=d loop=$album_photos}
					<li>
						{if $album_photos[d].thumbnail neq ""}
						
						<a href="{$siteroot}/{$profileinfo.username}/albumphotosinDetails/{$albumid}/{$album_photos[d].photo_id}" title="{$album_photos[d].album_title}"><img src="{$siteroot}/uploads/album/photo/180X158/{$album_photos[d].thumbnail}" alt="{$album_photos[d].photo_title}"/></a>
						{else}
						<a href="#"><img src="{$siteroot}/uploads/album/photo/180X158/noimage.jpg"  alt="image" /></a>
						{/if}

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
	</div>
          
            <div align="right">{$pgnation}</div>
</div>
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
