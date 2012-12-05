 {literal}
<script language="JavaScript" type="text/javascript">
function redirect_to_livewire(module)
{
// alert("ok");
// var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
// window.location=SITEROOT+"/my-account/"+d+"/"+module+"/my_profile_home";
}
</script>
{/literal}
{literal}
<script type="text/javascript">
$(document).ready(function(){
	//alert("aa");
	//alert($("#sesfriend").val());
	 var sesfriend={/literal}{$smarty.session.friend}{literal};
	 var sesdealsasusual={/literal}{$smarty.session.dealsasusual}{literal};
	 var sesrightnowdeal={/literal}{$smarty.session.rightnowdeal}{literal};
	 var sesfavlocalbusiness={/literal}{$smarty.session.favlocalbusiness}{literal};			
	//alert(sesfriend);
		if(sesfriend=="1")
			$("#fdcnt").hide();
		if(sesdealsasusual=="1")
			$("#daucnt").hide();
		if(sesrightnowdeal=="1")
			$("#rndcnt").hide();
		if(sesfavlocalbusiness=="1")
			$("#fbcnt").hide();

});


	function viewFavLocalBusiness(obj)
	{
		$("#fbcnt").html("");
		
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
		//$("#fdcnt").html("");
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
		$("#daucnt").html("");	
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
		$("#rndcnt").html("");
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
				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,moduleid:'friend'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
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
				jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,photo:photo,moduleid:'friend'},function(data)
				{
		
					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'friend'},function(data)
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
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,moduleid:'friend'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
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
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,photo:photo,moduleid:'friend'},function(data)
				{
		
					$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:userid,moduleid:'friend'},function(data)
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
function add_link()
{

$('#txt_thinking').hide();
$('#txt_link').show();
$('#div_share_photo').hide();
}

</script>
{/literal}
<td width="208" valign="top"><div class="maincont-inner-lft fl">
            <!-- Edit Profile Start -->
            <div class="user-pic">
              <div class="user-pic fl">
                <div class="user-img-big" style="border:none"><a href="{if $smarty.get.id1 eq ''}{$siteroot}/my-account/my_profile{else}{$siteroot}/my-account/{$smarty.get.id1}/my_profile{/if}" class="centerAll"> <img src="{if $user.facebook_userid neq ''}http://graph.facebook.com/{$user.facebook_userid}/picture?type=large{else}{if $user.photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/thumbnail/{$user.photo}{/if}{/if}"  alt="" title="" {if $user.facebook_userid neq ''} height="190px" {/if}/></a> <!--<a href="{$siteroot}/change-profilepic" class="change-picure-txt ">Change Picture</a> --></div>
               <!-- <a href="javascript:void(0);" class="centerAll"><img src="javascript:void(0);" class="user-prfile-name">{*$user.first_name} {$user.last_name*}</a>--> </div>
              <div class="clr"></div>
            </div>
            <div class="user-nav">
              <ul class="reset user-navigation">
			{if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId}
            <!--  <li><a href="{$siteroot}/my-account/friend_request" class="friend-icon ">Friend Request</a></li>-->
                <li><a href="{$siteroot}/deal/deal-history-consumer/" class="deal-icon ">My Offers</a></li>
				  <li> <a href="{$siteroot}/my-account/myrewards">My Reward Points</a></li>
					<div class="fr" style="margin-top:-32px;">
              <ul class="reset icn-link" style="padding:0px">
                <li style="margin-bottom: 0px;"><a href="javascript:void(0);" class="icn-link01 " >What is it?</a>
                  <div class="tooltip" style="width:320px !important"> <span class="arrow">&nbsp;</span>
                    <div class="top01">
                      <div></div>
                    </div>
                    <div class="mid" style="width:298px;"><p>"You get 5 reward points for each review that you write. You get 1 reward point for each dollar you pay at offersnpals while buying an offer (If for example, an offer is priced at S$ 100, you need to pay only S$ 12 when you buy the offer. Remaining S$ 88 you would pay directly to the merchant. For this transaction, since you paid S$ 12 at offersnpals, you would receive 12 Reward Points.)
</p>


					You could redeem 10 reward points to get an off of 1 S$." </div>
                    <div class="bot01">
                      <div></div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
			   {/if}
                <li><a href="{$siteroot}/my-account/my_profile_home/" class="wire-icon ">Live Wire</a>
                  <ul class="reset">
                    <li style="background:none">
                      <div class="user-nav-inn">
                        <ul class="reset">
                          <li><a href="javascript:void(0);"  onclick="javascript:viewFriends(this);" class="fl">Friends</a>
							 <div class="count fr">
                              <div class="count-lft fl">&nbsp;</div>
                              <div class="count-mid fl">+{if $fdcnt gt 0}{$fdcnt}{else}0{/if} </div>
                              <div class="count-rgt fl">&nbsp;</div>
                              <div class="clr"></div>
                            </div>
							</li>
                          <li><a href="javascript:void(0);"  onclick="javascript:viewFavLocalBusiness(this);" class="fl">Fav Local Business</a>
                            <div class="count fr">
                              <div class="count-lft fl">&nbsp;</div>
                              <div class="count-mid fl">+{if $fbcnt gt 0}{$fbcnt}{else}0{/if} </div>
                              <div class="count-rgt fl">&nbsp;</div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li><a href="javascript:void(0);"   onclick="javascript:viewDealsAsUsual(this);"  class="fl">My Fav Offers</a>
                            <div class="count fr">
                              <div class="count-lft fl">&nbsp;</div>
                              <div class="count-mid fl">+{if $daucnt gt 0}{$daucnt}{else}0{/if}</div>
                              <div class="count-rgt fl">&nbsp;</div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li><a href="javascript:void(0);"  onclick="javascript:viewRightNowDeal(this);"  class="fl">“Hurry Up” Offers</a>
                            <div class="count fr">
                              <div class="count-lft fl">&nbsp;</div>
                              <div class="count-mid fl">+{if $rndcnt gt 0}{$rndcnt}{else}0{/if}</div>
                              <div class="count-rgt fl">&nbsp;</div>
                              <div class="clr"></div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </li>
                <li>{if $smarty.get.id1 neq ''}<a href="{$siteroot}/my-account/{$smarty.get.id1}/my_review " class="review-icon ">{else}<a href="{$siteroot}/my-account/my_review" class="review-icon ">{/if}My Reviews</a></li>
               {if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId} <li><a href="{$siteroot}/my-account/friend_request" class="friend-icon fl" >Friend Requests</a>
				{if $numfrendsq gt 0}
				 <div class="count fr">
					<div class="count-lft fl">&nbsp;</div>
					<div class="count-mid fl">+{$numfrendsq}</div>
					<div class="count-rgt fl">&nbsp;</div>
					<div class="clr"></div>
				</div>
				{/if}
			</li>{/if}
				{if $smarty.get.id1 eq '' || $smarty.get.id1 eq $smarty.session.csUserId}
               	 <li><a href="{$siteroot}/message/messages/inbox/" class="inbox-icon ">Inbox
							{if $new_messages gt 0}
									<div class="count fr">
											<div class="count-lft fl">&nbsp;</div>
											<div class="count-mid fl">+{$new_messages}</div>
											<div class="count-rgt fl">&nbsp;</div>
											<div class="clr"></div>
									</div>
							{/if}
						</a>
						<!--<span {if $new_messages gt 0} style="color:red;weight:bold" {/if}><b>({$new_messages})</b></span>--></li>
				 {/if}
              </ul>
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
				{if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_friend" class="viewall">{else}<a href="{$siteroot}/friend/view_all_friend" class="fr viewtxt-black">{/if}View More</a>
			 {/if}
              <div class="clr"></div>
            </div>
            <div class="friend-photo">
              <h1>FAV LOCAL BUSINESS</h1>
              <div>
                <ul class="reset friend-photo-list ">
                    {section name=j  loop=$fan }
					{if $smarty.section.j.index le 7}
					<li><a href="{$siteroot}/merchant-account/{$fan[j].userid}/merchant_profile"><img src="{if $fan[j].photo1 eq ''}{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{$fan[j].photo1}{/if}" title="{if $fan[j].usertypeid eq '2' }{$fan[j].fullname}{else}{$fan[j].business_name}{/if}" alt="" width="43" height="42" /></a></li>
					{/if}
					{sectionelse}
					<div class="error" align="center">No Record Found</div>
					{/section}
                </ul>
                <div class="clr"></div>
              </div>
			 {if $fan_count gt 0}
				{if $smarty.get.id1 neq ''}<a href="{$siteroot}/friend/{$smarty.get.id1}/view_all_fav_places" class="viewall">{else}<a href="{$siteroot}/friend/view_all_fav_places" class="fr viewtxt-red">{/if}View More</a>
			 {/if}
              <div class="clr"> </div>
            </div>
          </div>
          <!-- Edit Profile End --></td>