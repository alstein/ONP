{include file=$header_start}
{strip}
<!--<link rel="stylesheet" href="{$siteroot}/js/Gplusalbum/css/reset.css" media="screen">-->
<link rel="stylesheet" href="{$siteroot}/js/Gplusalbum/css/style.css" media="screen">
<script type="text/javascript" src="{$sitejs}/jquery-1.4.4.js"></script>
<script src="{$siteroot}/js/Gplusalbum/js/app.js"></script>
{/strip}
{literal}
<style type="text/css">
ul#pics li {
	background: none repeat scroll 0 0 #FFFFFF;
	box-shadow: 1px 1px 1px #999999;
	display: inline-block;
	width: 153px;
	height:157px;
 -webkit-transition: all .2s ease-in-out;
 -moz-transition: all .2s ease-in-out;
 -o-transition: all .2s ease-in-out;
 -ms-transition: all .2s ease-in-out;
 transition: all .2s ease-in-out;
}
ul#pics li img {
	width: 150px;
	height:150px;
	display: block;
        
}
ul#pics li:hover {/*css style for the single photo only **/
	-moz-transform: scale(1.1) rotate(0deg);
	-webkit-transform: scale(1.1) rotate(0deg);
	-o-transform: scale(1.1) rotate(0deg);
	-ms-transform: scale(1.1) rotate(0deg);
	transform: scale(1.1) rotate(0deg);
}

h3 {
	margin:25px;
}
/*a, a:visited, a:hover {
	color: #54A6DE;
	outline: medium none;
	text-decoration: none;
}*/
.single_photo {/*css style for the single photo only **/
	margin-top : 60px;
	margin-left:5px;
	position: absolute;

}
/*#text {
	margin-top:10px;
	margin-left:10px;
	color: #DD4B39;
	font-type: arial, sans-serif;
	font-size:17px;
}*/
</style>
<script type="text/javascript">
jQuery(document).ready(function() 
{
        jQuery("#msg").fadeOut(5000);
	
});
function confirmdelete()
{
	var check=confirm("Are you sure to delete this photo");
	if(check==true)
	{
		return true;
	}
	if(check==false)
	{
		return false;
	}

}
function craete_album(){
window.location='{/literal}{$siteroot}/{$profileinfo.username}/create-album{literal}';
}
</script>
{/literal}

  <!-- header container starts here-->
   {include file=$profile_header2}
  <!-- / header container ends here-->
  <!-- Header ends -->

  <div id="maincont" >
    <!-- Left content Start here -->
   {if $smarty.session.csUserTypeId eq 3}{*include file=$merchantprofile_left_panel*}{elseif $smarty.session.csUserTypeId eq 2}  {*include file=$myprofile_left_panel*}{/if}
    <!-- Middel content Start here -->
    <div class="creat-alubum-main">
	<h2 style="margin-left:20px;color: #2B587A" >Photo Gallery</h2><br>
<!--<div align="right" style="color: #2B587A;"><a href="{$siteroot}/{$profileinfo.username}/">Back</a></div>-->

<div class="fullwid" style="padding:0 20px">

				<div>&nbsp;</div>

				<div class="titletp ovfl-hidden fl" style="width:400px;color: #2B587A;">
					<strong><a href="{if $username.usertypeid eq 3}{$siteroot}/merchant-account/{$username.userid}/merchant_profile {else}{$siteroot}/my-account/{$username.userid}/my_profile {/if}" >{if $username.usertypeid eq 3}{$username.business_name|ucfirst}'s{else}{$username.fullname|ucfirst}'s{/if}</a> Albums ({if $albcnt neq ""}{$albcnt}{else}0{/if} Albums)</strong>
				<!--  <div align="right">
					{if $username.userid eq $smarty.session.csUserId}
						<a href="{$siteroot}/{$profileinfo.username}/create-album" class="submintbtn" style="width:79px">+ Upload New Photos</a>
					{/if}
				</div>-->
				</div>
				{if $username.userid  eq $smarty.session.csUserId}
				<div class="fr" align="left" style="width:126px">
				<input type="button"  name="becomeafan" id="becomeafan" value="Create Album"  class="previe-btn" onclick="craete_album();"></span></span>
				<!--<a href="{$siteroot}/{$profileinfo.username}/create-album">Create Album</a>--></div>
				{/if}
		<div>&nbsp;</div>
		{if $msg}
		<div id="msg" class="success centerAll">
			{$msg}
                </div>{/if}
		
<ul  {if $count eq 0} style="float: left;list-style: none;margin-top:10px; padding:0px;" {else} style="float: left;list-style: none;margin-top:10px; padding:0px;width: 802px;" {/if} class="reset">
{section name=d loop=$photodetails}
						
<li  style="margin: 0; padding:0px;float: left;position: relative; width: 185px; height:250px;">
									{if $photodetails[d].thumbnail neq ""} 
								{if $photodetails[d].maxph eq '3'}
								
			<div class="image_stack">  
				<a href="{$siteroot}/{$photodetails[d].username}/{$photodetails[d].url_title}/photos">
										{section  name=k loop=$photodetails[d].photoids max=1}
										{if $photodetails[d].photoids[k] neq ''}<!--<img src="{$siteroot}/uploads/album/180X158/{$photodetails[d].photoids[k]}" class="stackphotos" id="photo{$smarty.section.k.iteration}"/>--><img src="{$siteroot}/uploads/album/180X158/{$photodetails[d].photoids[k]}" id="photo{$smarty.section.k.iteration}"/>{else}
										<img src="{$siteroot}/uploads/album/180X158/noimage.jpg" class="stackphotos" id="photo{$smarty.section.k.iteration}"  />
										{/if}
										{sectionelse}<img src="{$siteroot}/uploads/album/180X158/noimage.jpg"/>
										{/section}
				</a>
			</div>	

								{else}
					<div class="single_photo" style="margin-top:60px;">
						<div id="pics" style="margin: 0; padding:0px;float: left;position: relative; width:180px;">
					<!--<li>-->
								<a href="{$siteroot}/{$profileinfo.username}/{$photodetails[d].url_title}/photos">
					
					
											{section  name=k loop=$photodetails[d].photoids max=1}
											{if $photodetails[d].photoids[k] neq ''} <img src="{$siteroot}/uploads/album/180X158/{$photodetails[d].photoids[k]}">
											{else}<img src="{$siteroot}/uploads/album/180X158/noimage.jpg"/>{/if}{sectionelse}<img src="{$siteroot}/uploads/album/180X158/noimage.jpg"/>{/section}
			
								</a>
					<!--</li>

<ul>-->				                </div>
				       </div>
								{/if}{/if}
									<div style="position: absolute; top:0px; left:10px;">
										<div>
											<div class="fl">
												<a href="{$siteroot}/{$profileinfo.username}/{$photodetails[d].url_title}/photos" style="color:#000000">
												<strong>{$photodetails[d].album_title|ucfirst} &nbsp;({$photodetails[d].photocnt} photos)</strong>
												</a>
											</div>
										</div>
									<br/>
									{if $photodetails[d].user_id eq $smarty.session.csUserId}
										<div>
											
											<a href="{$siteroot}/photos/{$photodetails[d].album_id}/edit/create-album/">
												Edit &nbsp;
											</a>
											<a href="{$siteroot}/photos/{$photodetails[d].album_id}/del/album/" onClick="return confirm('Do you want to delete this album?');">
											|	Delete
											</a>
											
										</div>		
									{/if}
							</div>	
			  </li>
	{sectionelse}
		<div class="error" align="center">No Record Found.</div>
	{/section}
</ul>
<div class="clr"></div>
<div align="right" style="margin-top:50px; float:left;">{*$pgnation*}
</div>



	</div>


 </div>
  <!-- Maincontent ends -->
  <!-- Maincontent ends -->

</div>

<!-- Footer starts -->

      {include file=$footer}