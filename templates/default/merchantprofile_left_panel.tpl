{literal}
<script language="JavaScript" type="text/javascript">
function viewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			var id1='{/literal}{$smarty.get.id1}{literal}';
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review',id1:id1},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#review').addClass("active");
		});

	}  
function remove_menu(){
	$.post(SITEROOT+"/modules/merchant-account/delete_menu_price_list.php",{act:"act"},function(data){
		window.location=window.location.href;
	});
}
</script>
{/literal} 


		<td width="208" valign="top"><div class="maincont-inner-lft fl">
            <!-- Edit Profile Start -->
            <div class="user-pic">
              <div class="user-pic">
              <div class="user-img-big">
				
			{if $smarty.get.id1 eq ''}
			<a href="javascript:void(0);" class="centerAll"><img src="{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/thumbnail/{$user.photo}{/if}" title="" alt="" width="190" height="190" />  </a> 
			{else}
			
			<a href="{$siteroot}/merchant-account/{$smarty.get.id1}/merchant_profile" class="centerAll"><img src="{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/thumbnail/{$user.photo}{/if}" title="" alt="" width="190" height="190" />  </a>
			{/if}

			</div>
              <div class="clr"></div>
            </div>
{if $smarty.get.id1 eq ''}
            <div style="margin:5px 0 0 5px">
                <input name="name" type="button"  class="edit-btn" onclick="window.location.href='{$siteroot}/merchant-account/edit_profile_picture'" value="Edit Profile Image"/>
              </div>
{/if}              
              <div class="clr"></div>
            </div>
            
            <div class="user-nav">
              <ul class="reset user-navigation-new">
                
                <li style="border:none">
				{if $user.menu_price_file neq ''}<a class="photo-icon fl" href="{$siteroot}/uploads/menu_price_list/{$user.menu_price_file}">{else}<a  class="photo-icon fl" href="javascript:void(0);" onclick="alert('Menu Price List is Not Available.');">{/if}Menu/ Price List{if $user.menu_price_file neq '' && $smarty.get.id1 eq ""}<a href="javascript:void(0)" onclick="javascript:remove_menu();"> <abbr  class="remove-icon"></abbr></a>{/if}</a> </li>


                <li><a href="{$siteroot}/photos/{$username.username}/albumphotos" class="photos-icon ">Photos</a></li>
			{if $smarty.session.csUserId neq '' && $smarty.session.csUserTypeId eq '3'}
			{if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId}
                <li><a href="{$siteroot}/merchant-account/{$smarty.session.csUserId}/offer_deal_request/" class="deal2-icon ">Deal History</a></li>
			{/if}
			{/if}
                <li><a href="javascript:void(0);"  onclick="javascript:viewReview(this);" id="review1" class="review-icon "> Reviews</a></li>
                
              </ul>
            </div>
            <div class="friend-photo">
              <h1>FAN</h1>
              <div>
                <ul class="reset friend-photo-list ">
			
				  {section name=k  loop=$merchants_fan  }
					{if $smarty.section.k.index le 9}
                  <li> <a href="{$siteroot}/my-account/{$merchants_fan[k].fan_id}/my_profile"><img src="{if $merchants_fan[k].facebook_userid neq ''}http://graph.facebook.com/{$merchants_fan[k].facebook_userid}/picture?type=large{else}{if $merchants_fan[k].photo1 neq '' }{$siteroot}/uploads/user/50X50/{$merchants_fan[k].photo1}{else}{$siteroot}/templates/default/images/profile_pic.png {/if}{/if}" width="36" height="36" alt="" title=""  /></a> </li>
					{/if}
				{sectionelse}
					<div class="error" align="center">No Record Found</div>
				{/section}
                 
                </ul>
                <div class="clr"></div>
              </div>
              <div class="viewtxt-red fr">    {if $merchants_fan_count  gt 0} {if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_merchants_fan" class="fr">{else}<a href="{$siteroot}/friend/view_all_merchants_fan" class="fr">{/if}View all</a>{/if}
                <div class="clr"></div>
              </div>
            </div>
          </div>
          <!-- Edit Profile End --></td>
