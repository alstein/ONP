{include file=$header_start}
{strip}
<script type="text/javascript" src="{$siteroot}/php_ajax_image_upload/scripts/ajaxupload.js"></script>
<script type="text/javascript" src="{$sitejs}/lightbox.js"></script>
<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
{/strip}
{literal}
<script type="text/javascript">
    jQuery(document).ready(function()
    {
		var moduleid = '{/literal}{$smarty.get.id2}{literal}';
	    jQuery('#show_thread').html("<img src='"+SITEROOT+"/templates/default/images/site/coming_soon/loadingAnimation.gif' alt='loading' />");
		viewReview();
    });
	
	
	
	function viewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review'},function(data)
		{
			
			//jQuery("#show_thread").html(data);
			jQuery(".profile-middel").html(data);
			jQuery("#div_share").show();
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
	}  
	
// 	function onfriend_page(userid)
// {
// 
// // 	var txt_thinking=$('#txt_thinking').val();
// 	var txt_thinking=$.trim($('#txt_thinking').val());
// 	var txt_link=$.trim($('#txt_link').val());
// 		if(txt_thinking=='What you have been thinking?'){
// 		txt_thinking='';
// 		}
// 	var photo=$('#commentphoto').val();
// 	var newfilename=$('#new_filename').val();
// 
// 		if(txt_thinking)
// 		{
// 			if(photo==undefined)
// 			{
// 				
// 				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
// 				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,moduleid:'review'},function(data)
// 				{
// 					
// 					$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
// 					{
// 						
// 						$("#show_thread").html(data);
// 						$("#txt_thinking").val("");
// 					});
// 				})
// 			}
// 			else
// 			{
// 				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
// 				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,photo:photo,moduleid:'friend'},function(data)
// 				{
// 		
// 					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'friend'},function(data)
// 					{
// 						$('#div_share_photo').hide();
// 						$("#show_thread").html(data);
// 						$("#txt_thinking").val("");
// 						$("#filename").val("");
// 		
// 					});
// 				})
// 			}
// 		}
// 		else if(txt_link)
// 		{
// 			if(photo==undefined)
// 			{
// 				
// 				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
// 				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,moduleid:'review'},function(data)
// 				{
// 					
// 					$.get(cmt_url,{userid:userid,moduleid:'review'},function(data)
// 					{
// 						
// 						$(".profile-middel").html(data);
// 						$('#friend').addClass("active");
// 						$("#txt_thinking").val("");
// 					});
// 				})
// 			}
// 			else
// 			{
// 				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
// 				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,photo:photo,moduleid:'review'},function(data)
// 				{
// 		
// 					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'review'},function(data)
// 					{
// 						$('#div_share_photo').hide();
// 						$(".profile-middel").html(data);
// 						$('#friend').addClass("active");
// 						$("#txt_thinking").val("");
// 						$("#filename").val("");
// 		
// 					});
// 				})
// 			}
// 		}
// 		else{ alert("Plese enter comment !");}
// }
function add_photo()
{
// document.getElementById("div_share_photo").style.display='block';
 $('#div_share_photo').show();
}
function add_text()
{
$('#div_share_photo').hide();
}
</script>
<script>
function appr(user)
{  
	document.forms["profile"].act.value = "Insert";
	
	if(confirm("Would you like to add "+user+" as a Friend?"))
	{
		document.forms["profile"].submit();
	}
}
function  clear_photo()
{
viewReview();
}
function add_link()
{
$('#txt_thinking').val="";
$('#txt_thinking').hide();
$('#txt_link').show();
$('#div_share_photo').hide();
}
</script>
{/literal}

<!-- main continer of the page -->

  <!-- Header starts -->
    {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
         {include file=$myprofile_left_panel}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="580" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="profile-detail">
              <h1>{$user.first_name} {$user.last_name}</h1>
              <div class="profile-menu">
                <ul class="reset">
                  <li style="border:none"><a {if $smarty.get.id1 neq ''} href="{$siteroot}/my-account/{$smarty.get.id1}/my_profile_home" {else} href="{$siteroot}/my-account/my_profile_home" {/if} >LIVE WIRE</a></li>
                 <!-- <li><a href="{$siteroot}/about-us">ABOUT </a></li>-->
                  <li>{if $smarty.get.id1 eq $smarty.session.csUserId}<a href="{$siteroot}/photos/album">{else if $smarty.get.id1 eq '' || $smarty.get.id1 neq $smarty.session.csUserId || ($privacy_setting.photo_setting eq 'public' && $friend_acc.count_friend_acc gt 0)}<a href="{$siteroot}/photos/{$username.username}/albumphotos" >{/if}PHOTOS </a></li>
                  <li>{if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_friend">{else}<a href="{$siteroot}/friend/view_all_friend"  >{/if}FRIENDS </a></li>
                  <li style="padding: 0 15px 0 27px;">{if $smarty.get.id1 neq ''}<a href="{$siteroot}/my-account/{$smarty.get.id1}/my_review ">{else}<a href="{$siteroot}/my-account/my_review" >{/if}REVIEWS</a></li>
                </ul>
                <div class="clr"></div>
              </div>
              <div class="profile-gallery">
				{if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId || ($smarty.session.csUserTypeId eq '2' && ($privacy_setting.photo_setting eq 'public' || $friend_acc.count_friend_acc gt 0)) || ($smarty.session.csUserTypeId eq '3' && ($privacy_setting.merchant_setting eq 'public' && $fan_acc.count_fan_acc gt 0 )) }
	{if ($smarty.session.csUserTypeId eq '2' && ($privacy_setting.photo_setting eq 'public' || $friend_acc.count_friend_acc gt 0)) || ($smarty.session.csUserTypeId eq '3' && $privacy_setting.merchant_setting eq 'public' && $privacy_setting.photo_setting eq 'public')}
                <ul class="reset">
			 {section name=i loop=$albums}
                  <li>
                    <div class="gallery-img"> <a href="{$siteroot}/{$username1}/{$albums[i].url_title}/photos"> <img src="{$siteroot}/uploads/album/photo/132X101/{$albums[i].thumbnail}" width="121" height="120" alt="" title=""  /> </a> </div>
                   <!-- <a href="#" class="photo-name">Photo Name</a> --></li>
                
			 {/section}
             {if $anums lt 3}
				{section name=bar loop=$anums1 max=$anums1 step=1} 
                  <li>
                    <div class="gallery-img"> 
					{if $smarty.get.id1 eq $smarty.session.csUserId}<a href="{$siteroot}/{$username1}/create-album"><img src="{$siteroot}/templates/default/images/no_image.jpg" title="" alt="" width="121" height="120"  /></a>{else}<a href="javascript:void(0)"><img src="{$siteroot}/templates/default/images/no_image.jpg" title="" alt="" width="121" height="120" /></a>{/if}</div>
                 <!--   <a href="#" class="photo-name">Photo Name</a> --></li>
               
				{/section}
			{/if}
                   
                </ul>
				{/if}
				{/if}
                <div class="clr"></div>
              </div>
            </div>
          
           <div id="show_thread" class="profile-middel" style="border:none;margin-top:0px;padding: 2px 1px 0;"> </div>
            <div class="clr" style="height:193px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
        {include file=$myprofile_right_panel}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
  {include file=$footer}