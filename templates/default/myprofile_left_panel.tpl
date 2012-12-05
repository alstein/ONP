{literal}
<script type="text/javascript">
	function viewFavLocalBusiness(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'favlocalbusiness'},function(data)
		{  
			jQuery(".profile-middel").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#favbusiness').addClass("active"); 
		});
	}
	
	function viewFriends(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'friend'},function(data)
		{   
			jQuery(".profile-middel").html("");	
			//jQuery("#show_thread").html(data);
			jQuery(".profile-middel").html(data);
			$('#div_share').show();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').addClass("active");
			$('#favbusiness').removeClass("active"); 
		});
	}  
function viewDealsAsUsual(obj)
	{
		
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'dealsasusual'},function(data)
		{
			jQuery(".profile-middel").html(data);
			$('#div_share').hide();
			$('#dealasusual').addClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#favbusiness').removeClass("active"); 
		});
	}
	
	function viewRightNowDeal(obj)
	{
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'rightnowdeal'},function(data)
		{

			jQuery(".profile-middel").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').addClass("active");
			$('#friend').removeClass("active");
			$('#favbusiness').removeClass("active"); 
		});
	}  
function onfriend_page(userid)
{
	
// 	var txt_thinking=$('#txt_thinking').val();
	var txt_thinking=$.trim($('#txt_thinking').val());
	var txt_link=$.trim($('#txt_link').val());
		if(txt_thinking=='What you have been thinking?'){
		txt_thinking='';
		}
	var photo=$('#commentphoto').val();
	var newfilename=$('#new_filename').val();

		if(txt_thinking)
		{	$("#share").removeAttr("onClick");
			if(photo==undefined)
			{
				
				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,moduleid:'review'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'review'},function(data)
					{
						
						$(".profile-middel").html(data);
						$('#div_share').show();
						$('#friend').addClass("active");
						$("#txt_thinking").val("");
					});
				})
			}
			else
			{
				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,photo:photo,moduleid:'review'},function(data)
				{
		
					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'review'},function(data)
					{
						$('#div_share_photo').hide();
						$('#div_share').show();
						$(".profile-middel").html(data);
						$('#friend').addClass("active");
						$("#txt_thinking").val("");
						$("#filename").val("");
		
					});
				})
			}
		}
		else if(txt_link)
		{
			if(photo==undefined)
			{
				
				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,moduleid:'review'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'review'},function(data)
					{
						
						$(".profile-middel").html(data);
						$('#div_share').show();
						$('#friend').addClass("active");
						$("#txt_thinking").val("");
					});
				})
			}
			else
			{
				cmt_url = SITEROOT+"/modules/my-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,photo:photo,moduleid:'review'},function(data)
				{
		
					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'review'},function(data)
					{
						$('#div_share_photo').hide();
						$('#div_share').show();
						$(".profile-middel").html(data);
						$('#friend').addClass("active");
						$("#txt_thinking").val("");
						$("#filename").val("");
		
					});
				})
			}
		}
		else{ alert("Plese enter comment !");}
}
function add_photo()
{
$('#div_share_photo').show();
}
function add_text()
{
$('#div_share_photo').hide();
}
</script>
{/literal}

<td width="208" valign="top"><div class="maincont-inner-lft fl">
            <!-- Edit Profile Start -->
            <div class="user-pic">
              <div class="user-img-big"> <img src="{if $user.facebook_userid neq ''}http://graph.facebook.com/{$user.facebook_userid}/picture?type=large{else}{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/thumbnail/{$user.photo}{/if}{/if}"  alt="" title=""  {if $user.facebook_userid neq ''} height="190px" {/if}/> </div>
              <div class="clr"></div>
            </div>
            <div class="edit-img">
{if $smarty.get.id1 eq ''}
              <div>
                <input name="name" type="button"  class="edit-btn" onclick="window.location.href='{$siteroot}/editprofile'" value="Edit Profile Image"/>
              </div>
{/if}
              <div class="edit-img-list">
                <ul class="reset">
                  <li>
                    <label class="gift-img">&nbsp;</label>
                    <p class="fl"> <span style="margin-right:5px;">Born On</span>{if $user.birthdate eq '0000-00-00 00:00:00'} - {else}{$user.birthdate|date_format}{/if}</p>
                    <div class="clr"></div>
                  </li>
                  <li>
                    <label class="home2-img">&nbsp;</label>
                    <p class="fl"> <span>Lives in</span> Singapore</p>
                    <div class="clr"></div>
                  </li>
                  <li>
                    <label>&nbsp;</label>
                    <div class="usr-info">
                      <p> <span style="margin-right:7px;">Interested In</span>{$category} </p>
                    </div>
                  </li>
                </ul>
                <div class="clr"></div>
              </div>
            </div>
            <div class="clr"></div>
            <div class="friend-photo">
              <h1>Friends</h1>
              <div>
                <ul class="reset friend-photo-list ">
      {section name=i  loop=$friend }
		{if $smarty.section.i.index le 7}
			{if $smarty.get.id1 neq ''}
				<li><a href="{$siteroot}/my-account/{if $friend[i].userid neq $smarty.get.id1}{$friend[i].userid}{else}{$friend[i].friendid}{/if}/my_profile"><img src="{if $friend[i].userid neq $smarty.get.id1}{if $friend[i].facebook_userid neq ''}http://graph.facebook.com/{$friend[i].facebook_userid}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend[i].photo1 eq ''}	profile_pic.png{else}{$friend[i].photo1}{/if}{/if}{else}{if $friend[i].facebook_userid1 neq ''}http://graph.facebook.com/{$friend[i].facebook_userid1}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend[i].photo2 eq '' }	profile_pic.png{else}{$friend[i].photo2}{/if}{/if}{/if}" title="{if $friend[i].friendid eq $smarty.session.csUserId } {$friend[i].first_name} {$friend[i].last_name} {else}{$friend[i].first_name1} {$friend[i].last_name1}{/if}" alt="" width="36" height="36" /></a></li>
				{else}
				<li><a href="{$siteroot}/my-account/{if $friend[i].userid neq $smarty.session.csUserId}{$friend[i].userid}{else}{$friend[i].friendid}{/if}/my_profile"><img src="{if $friend[i].userid neq $smarty.session.csUserId}{if $friend[i].facebook_userid neq ''}http://graph.facebook.com/{$friend[i].facebook_userid}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend[i].photo1 eq ''}	profile_pic.png{else}{$friend[i].photo1}{/if}{/if}{else}{if $friend[i].facebook_userid1 neq ''}http://graph.facebook.com/{$friend[i].facebook_userid1}/picture?type=large{else}{$siteroot}/uploads/user/{if $friend[i].photo2 eq '' }profile_pic.png{else}{$friend[i].photo2}{/if}{/if}{/if}" title="{if $friend[i].friendid eq $smarty.session.csUserId } {$friend[i].first_name} {$friend[i].last_name} {else}{$friend[i].first_name1} {$friend[i].last_name1}{/if}" alt="" width="36" height="36" /></a></li>
			{/if}
		{/if}
      {sectionelse}
     	 <div class="error" align="center">No Record Found</div>
      {/section}
          
                </ul>
                <div class="clr"></div>
              </div>
			{if $friend_count gt 0}
             {if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_friend" class="viewall">{else}<a href="{$siteroot}/friend/view_all_friend" class="fr viewtxt-black">{/if} View More</a>
			{/if}
            
              <div class="clr"></div>
            </div>
            <div class="friend-photo">
              <h1>FAV LOCAL BUSINESS</h1>
              <div>
                <ul class="reset friend-photo-list ">
                  {section name=j  loop=$fan  } 
				{if $smarty.section.j.index le 7}
				<li><a href="{$siteroot}/merchant-account/{$fan[j].userid}/merchant_profile">{if $fan[j].photo1 eq '' } <img src="{$siteroot}/templates/default/images/profile_pic.png" title="{if $fan[j].usertypeid eq '2' }{$fan[j].fullname} {else}{$fan[j].business_name}{/if}" alt="" width="43" height="42" />  {else}<img src="{$siteroot}/uploads/user/{$fan[j].photo1}" title="{if $fan[j].usertypeid eq '2' }{$fan[j].fullname}{else}{$fan[j].business_name}{/if}" alt="" width="43" height="42" />{/if}</a></li>
				{/if}
				{sectionelse}
				<div class="error" align="center">No Record Found</div>
			  {/section}
                 
                </ul>
                <div class="clr"></div>
              </div>
            {if $fan_count gt 0}
              {if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_fav_places" class="viewall">{else}<a href="{$siteroot}/friend/view_all_fav_places"   class="fr viewtxt-red">{/if}View More</a>
			{/if}
              <div class="clr"></div>
            </div>
          </div>
          <!-- Edit Profile End --></td>

