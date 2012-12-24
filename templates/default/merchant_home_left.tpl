 {literal}
<script language="JavaScript" type="text/javascript">
function viewnewReview(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review',status:'new'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#review').addClass("active");
		});

	}  
</script>
{/literal} 

{literal}
<script type="text/javascript">
   
	function viewReview_left(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'review'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#review').addClass("active");
		});

	}  
	function viewFavLocalBusiness_left(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'favlocalbusiness'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});

	}
	
	function viewFriends_left(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'friend'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').show();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').addClass("active");
			$('#review').removeClass("active");
		});

	}  
function viewDealsAsUsual_left(obj)
	{
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
		
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'dealsasusual'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
			$('#dealasusual').addClass("active");
			$('#rightnowdeal').removeClass("active");
			$('#friend').removeClass("active");
			$('#review').removeClass("active");
			
		});

	}
	
	function viewRightNowDeal_left(obj)
	{
		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'rightnowdeal'},function(data)
		{

			jQuery("#show_thread").html(data);
			$('#div_share').hide();
			$('#dealasusual').removeClass("active");
			$('#rightnowdeal').addClass("active");
			$('#friend').removeClass("active");
			$('#review').removeClass("active");
		});

	}  
	

</script>
{/literal}

<td width="208" valign="top"><div class="maincont-inner-lft fl">
            <!-- Edit Profile Start -->
            <div class="user-pic">
              <div class="user-pic-lft fl">
                <div class="user-img"> <a href="{if $smarty.get.id1 eq ''}{$siteroot}/merchant-account/merchant_profile{else}{$siteroot}/merchant-account/{$smarty.get.id1}/merchant_profile{/if}" class="centerAll"> <img src="{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/thumbnail/{$user.photo}{/if}" width="101" height="100" alt="" title="" /></a> </div>
                <div style="margin:10px 0 0 0">
                  <input name="name" type="button"  class="edit-btn"   onclick="window.location.href='{$siteroot}/merchant-account/edit_profile_picture'"  value="Edit Profile Image"/>
                </div>
              </div>
              <div class="user-pic-rgt fl"> <a href="javascript:void(0);" class="user-name-link"></a> </div>
              <div class="clr"></div>
            </div>
            <div class="merchant-rating">
              <h1>{$user.business_name|ucwords}</h1>
              <p class="fl rating">Rating:</p>
              <div class="fl" style="margin:7px 0 0 0">
		<span style="margin-left:15px;" class="star_1"><img  {if $average_rating  > 0 && $average_rating <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span>
		<span class="star_2"><img alt="" {if $average_rating > 1 && $average_rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
		<span class="star_3"><img  alt=""  {if $average_rating > 2 && $average_rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span>
		<span class="star_4"><img  alt="" {if $average_rating > 3 && $average_rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
		<span class="star_5"><img alt="" {if $average_rating > 4 && $average_rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $average_rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
		</div>
              <div class="clr"></div>
            </div>
            <div class="user-nav">
              <ul class="reset user-navigation-new">
                <li style="border:none"><a href="#" class="review-icon ">New Reviews</a></li>
				{if $smarty.session.csUserId neq '' && $smarty.session.csUserTypeId eq '3'}
					{if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId}
						<li><a href="{$siteroot}/merchant-account/{$smarty.session.csUserId}/offer_deal_request/" class="deal2-icon ">My Offers </a></li>
						<li><a href="{$siteroot}/merchant-account/deal-conditions/"  class="bulb-icon ">Incoming Offers Conditions</a></li>
					{/if}
				{/if}
                <li><a href="javascript:void(0);" class="wire-icon ">Live Wire</a></li>
                <li style="background:none">
                  <div class="user-nav-inn">
                    <ul class="reset">
                      <li><a href="javascript:void(0);"   onclick="javascript:viewReview_left(this);" id="review1" class="fl">Reviews</a></li>
                      <li><a href="javascript:void(0);"  onclick="javascript:viewFriends_left(this);" id="friend1" class="fl">Updates/ Events</a>
                       <!-- <div class="count fr">
                          <div class="count-lft fl">&nbsp;</div>
                          <div class="count-mid fl">10</div>
                          <div class="count-rgt fl">&nbsp;</div>
                          <div class="clr"></div>
                        </div>-->
                      </li>
                      <li><a href="javascript:void(0);" onclick="javascript:viewRightNowDeal_left(this);" id="rightnowdeal1" class="fl">“Hurry Up” Offers</a>
                       <!-- <div class="count fr">
                          <div class="count-lft fl">&nbsp;</div>
                          <div class="count-mid fl">10</div>
                          <div class="count-rgt fl">&nbsp;</div>
                          <div class="clr"></div>
                        </div>-->
                      </li>
                      <!--<li><a href="javascript:void(0);" onclick="javascript:viewDealsAsUsual_left(this);" id="dealasusual1" class="fl">My Fav Offers</a>-->
                      <!--  <div class="count fr">
                          <div class="count-lft fl">&nbsp;</div>
                          <div class="count-mid fl">+20</div>
                          <div class="count-rgt fl">&nbsp;</div>
                          <div class="clr"></div>
                        </div>-->
                      <!--</li>-->
                    </ul>
                  </div>
                </li>
              </ul>
            </div>
            <div class="friend-photo">
              <h1>FAN</h1>
              <div>
                <ul class="reset friend-photo-list ">
					{section name=k  loop=$merchants_fan }
					{if $smarty.section.k.index le 7}
					<li><a href="{$siteroot}/my-account/{$merchants_fan[k].fan_id}/my_profile"><img src="{if $merchants_fan[k].facebook_userid neq ''}http://graph.facebook.com/{$merchants_fan[k].facebook_userid}/picture?type=large{else}{if $merchants_fan[k].photo1 neq '' }{$siteroot}/uploads/user/50X50/{$merchants_fan[k].photo1}{else}{$siteroot}/templates/default/images/profile_pic.png{/if} {/if}" title="" alt="" width="36" height="36" /></a></li>
					{/if}
					{sectionelse}
						<div class="error" align="center">No Record Found</div>
					{/section}
                 
                </ul>
                <div class="clr"></div>
              </div>
				 {if $merchants_fan_count  gt 0}{if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_merchants_fan" class="fr viewtxt-red">{else}<a href="{$siteroot}/friend/view_all_merchants_fan" class="fr viewtxt-red">{/if}View More</a>{/if}
            
                <div class="clr"></div>
             
            </div>
          </div>
          <!-- Edit Profile End --></td>

