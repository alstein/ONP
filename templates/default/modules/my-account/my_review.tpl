{include file=$header_start}

{literal}
<script type="text/javascript">
	$(document).ready(function(){

// 	showdate();	

		$(".showdel").mouseover(function(){
			var d = this.id;
			$("#dlid"+d).css({visibility:'visible'});
		});

		$(".showdel").mouseout(function(){
			var d = this.id;
			$("#dlid"+d).css({visibility:'hidden'});
		});


		$(".showdel1").mouseover(function(){
			var d = this.id;
			$("#msg_id"+d).css({visibility:'visible'});
		});

		$(".showdel1").mouseout(function(){
			var d = this.id;
			$("#msg_id"+d).css({visibility:'hidden'});
		});


});




function showdate()
{
var trs = document.getElementsByTagName("abbr");

	for(var i=0;i<trs.length;i++)
	{
		j=i+1;
  		jQuery("#timeago_"+j+"").timeago(); 
	}

}


function add_sub_comment(rating_id,user_id){ 

	var comment=$("#subcomment_"+rating_id).val();
	if(comment==""){
		alert("Please enter comment");
	}else{	
		jQuery.post(SITEROOT+"/modules/my-account/add_sub_comment.php",{rating_id:rating_id,user_id:user_id,comment:comment},function(data){
					//if(data==1)
						window.location=window.location.href;
		});
	}
}


function show_sub_comment_box(rating_id){ 
	$("#div_"+rating_id).toggle();
}


</script>

{/literal}

  <!-- Header starts -->
    {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" class="ovfl-hidden">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
              {include file=$profile_left}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="600" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
          <div class="user-basic-info">
          <h1>My Review</h1>
          
          </div>
{section name=i  loop=$user_activity }
	  <ul class="reset">
              <li>
                <div class="user-wall">
                  <div class="user-wall-lft fl">
					
                    <div class="user-frd-photo fl"> <img src="{if $user_activity[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/50X50/{if $smarty.get.id1 neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}" width="50" height="50" alt="" title=""  /> </div>
                  </div>
                  <div class="user-wall-rgt fr">
                    <div class="post-bg">
                      <div class="post-bg-top"> <a href="{$siteroot}/merchant-account/{$user_activity[i].merchant_id}/merchant_profile/"   class="fl">{$user_activity[i].business_name} </a>
                        <p class="fr">{if $smarty.get.id1 eq '' && $smarty.session.csUserTypeId eq '2'}
				<a href="{$siteroot}/modules/my-account/my_review.php?review_id={$user_activity[i].rating_id}" id="dlid{$user_activity[i].rating_id}" class="btn-close fr" ></a>
					{/if}</p>
						
                      </div>
                      <div class="post-bg-mid">
                        <div style="margin-bottom:10px">
                          <p class="fl ratingtxt"> Rating:</p>
                          <div class="fl"> <span class="star_1 fl"><img  {if $user_activity[i].average_rating  > 0 && $user_activity[i].average_rating  <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span>
						<span class="star_2 fl"><img alt="" {if $user_activity[i].average_rating  > 1 && $user_activity[i].average_rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
						<span class="star_3 fl"><img  alt=""  {if $user_activity[i].average_rating  > 2 && $user_activity[i].average_rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span>
						<span class="star_4 fl"><img  alt="" {if $user_activity[i].average_rating  > 3 && $user_activity[i].average_rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
						<span class="star_5 fl"><img alt="" {if $user_activity[i].average_rating  > 4 && $user_activity[i].average_rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
						<span class="rightAlign" style="margin-left:180px">{$user_activity[i].rating_date|date_format:"%e %B %Y | %I:%M %p "} </span>
                            <div class="clr"></div>
                          </div>
                          <div class="clr"> </div>
							
                        </div>
                        <div class="user-blog">
                          <p class="userblue-txt">Keyword/ Summary:</p>
                          <p class="usertxtcom">{$user_activity[i].summary}</p>
                        </div>
                        <div>
                          <p class="userblue-txt">Review:</p>
                          <p class="usertxtcom">{$user_activity[i].feedback}</p>
                        </div>
                      </div>
                    </div>
                    <div class="post-bg-btm">
                      <div class="user-com"> <a  href="javascript:void(0);" onclick="show_sub_comment_box({$user_activity[i].rating_id})" class="fl commenttxt">Comment({$user_activity[i].subcumcnt})</a>
                        <div class=" clr"></div>
                      </div>
                      <ul class="reset">
					{section name=j  loop=$user_activity[i].sub}
                        <li class="showdel1" id="{$user_activity[i].sub[j].msg_id}">
                          <div class="main-wall">
                            <div class="wall-img-lft fl"> <img src="{if $user_activity[i].sub[j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{$user_activity[i].sub[j].photo}{/if}" width="50" height="50" alt="" title=""  /> </div>
							{if $smarty.get.id1 eq '' && $smarty.session.csUserTypeId eq '2'}
								<span class="fr" style="visibility:hidden" id="msg_id{$user_activity[i].sub[j].msg_id}">
									<a href="{$siteroot}/modules/my-account/my_review.php?adel_id={$user_activity[i].sub[j].msg_id}">
										<img src="{$siteroot}/templates/default/images/btn_close.png" id="dlid{$user_activity[i].rating_id}" >
									</a>
								</span>
							{/if}
                            <div class="wall-info-rgt fl">
                              <div> <a {if $user_activity[i].sub[j].usertypeid eq 2}  href="{$siteroot}/my-account/{$user_activity[i].sub[j].userid}/my_profile" {elseif  $user_activity[i].sub[j].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_activity[i].sub[j].userid}/merchant_profile"  {/if}  class="fl">{if $user_activity[i].sub[j].usertypeid eq 2}{$user_activity[i].sub[j].first_name} {$user_activity[i].sub[j].last_name}{else if $user_activity[i].sub[j].usertypeid eq 3}{$user_activity[i].sub[j].business_name}{/if} </a> <span class="fl">{$user_activity[i].sub[j].timestamp|date_format:"%e %B %Y | %I:%M %p "}</span>
                                <div class="clr"></div>
                              </div>
                              <p>{$user_activity[i].sub[j].msg}</p>
							<p class="fl"></p>
                            </div>
                            <div class="clr"></div>
                          </div>
                        </li>
                      {/section}
					<div id="div_{$user_activity[i].rating_id}" style="display:none" >  
                        <li>
                          <div class="frd-comm">
                          <input type="text" name="subcomment_{$user_activity[i].rating_id}" id="subcomment_{$user_activity[i].rating_id}"> 
                          </div>
                        </li>
                        <li>
                          <div class="fr" style="margin-right:10px">
                            <input type="button" name="addsub" id="addsub"   value="Post" onclick="add_sub_comment('{$user_activity[i].rating_id}','{$user}')"  class="post-btn"   style="width:52px"/>
                          </div>
                        </li>
					</div>
                      </ul>
                      <div class="clr"></div>
                    </div>
                  </div>
                  <div class="clr"></div>
                </div>
              </li>
           
            </ul>
			{sectionelse}
				<div class="error" align="center">No Records Found.</div>
             {/section} 
            <div class="clr" style="height:20px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
          {include file=$profile_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->
 {include file=$footer}
