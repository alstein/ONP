{literal}
<script type="text/javascript" language="JavaScript">
	function show_comment_box(val,id)
	{
	document.getElementById("div_"+val).style.display="block";
	document.getElementById("txt_id").value=id;
	}

function viewComment_review(obj,val,id)
	{

		var profile=$("#profile_name").val();
		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
		var dmid='{/literal}{$smarty.get.moduleid}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_comment.php";
		jQuery.get(cmt_url,{userid:d,review_id:id,dmid:dmid},function(data)
		{
			
				jQuery("#show_thread_"+val).html(data);
				
		});

	} 
function viewComment(obj,val,id)
	{
		var txt_comment=$('#txt_comment').val();
		var profile=$("#profile_name").val();
		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
		var dmid='{/literal}{$smarty.get.moduleid}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_comment.php";


		jQuery.get(cmt_url,{userid:d,parentid:id,dmid:dmid},function(data)
		{

				jQuery("#show_thread_"+val).html(data);
			
		});

	} 

function viewComment_deal(obj,val,id)
	{
		var txt_comment=$('#txt_comment').val();
		var profile=$("#profile_name").val();
		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
		var dmid='{/literal}{$smarty.get.moduleid}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_comment.php";

		jQuery.get(cmt_url,{userid:d,dealid:id,dmid:dmid,profilename:profile},function(data)
		{
			
				jQuery("#show_thread_"+val).html(data);
				
		});

	} 
function sortOrder(page,pageno,userid,moduleid)
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

	jQuery.post(SITEROOT+"/modules/merchant-account/ajax_my_review.php?page="+pack+"&userid="+userid+"&moduleid="+moduleid, function(data)
	{
		jQuery("#show_thread").html(data);
	});
}

</script>
<script type="text/javascript">
//  jQuery(document).ready(function()
//     {
// 	showdate();
// 	showdate1();
//     });
// function showdate()
// {
// var trs = document.getElementsByTagName("abbr");
// 
// 	for(var i=0;i<trs.length;i++)
// 	{
// 		j=i+1;
//   		jQuery("#timeago_"+j+"").timeago(); 
// 	}
// 
// }
// function showdate1()
// {
// var trs = document.getElementsByTagName("abbr");
// 
// 	for(var i=0;i<trs.length;i++)
// 	{
// 		j=i+1;
//   		jQuery("#timeago1_"+j+"").timeago(); 
// 	}
// 
// }
function show_button(val,val1)
{

var id=$('#id').val();
var id1=$('#id1').val();
	if (id=="" || id==id1)
	{
	document.getElementById("btn_close_"+val+val1).style.display="block";
	}
}
function show_button1(val,val1)
{
document.getElementById("btn_close_"+val+val1).style.display="none";
}

			function show_buttonm(val)
			{

			
			var id=$('#id').val();
			var id1=$('#id1').val();
				if (id=="" || id==id1)
				{
				document.getElementById("mbtn_close_"+val).style.display="block";
				}
			}
				function show_buttonm1(val)
				{
				
				document.getElementById("mbtn_close_"+val).style.display="none";
				}


function deleteComment(obj,val)
{

	var answer = confirm("are you sure about this action ?")
	if (answer){
		$.get(SITEROOT+"/modules/my-account/ajax_insert_comment.php",{delid:val},function(data)
		{
			var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
			var moduleid='{/literal}{ $smarty.get.moduleid}{literal}';
			cmt_url2 = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url2,{userid:d,moduleid:moduleid},function(data)
			{
				jQuery("#show_thread").html(data);
				// box in js
				$('#div_share').hide();
			});
		});
	}
}
function share_comment(obj,val,val1,id1)
{

 		var module=document.getElementById("module").value;
// 		var d=document.getElementById("txt_id").value;
// 		if(d == "")
// 		{
		var d=document.getElementById("txt_id").value;
// 		}
		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)
			{
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
				});
			});
		}
		else if(module=='friend')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)
			{
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
				});
			});
		}
}


function share_comment1(obj,val,val1,id1,deal_id)
{

;
 		var module=document.getElementById("module").value;

		var d=document.getElementById("txt_id").value;

		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')
		{	
			$.get(SITEROOT+"/modules/merchant-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module,deal_id:deal_id},function(data)
			{ 
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
					if(module=='dealsasusual' || module=='rightnowdeal'){

						tb_show('Share Deal', SITEROOT+'/success.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=600&modal=false',tb_pathToImage);

					}
				});
			});
		}
		else if(module=='friend')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)
			{
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
					tb_show('Share Deal', SITEROOT+'/success.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=600&modal=false',tb_pathToImage);
				});
			});
		}
}

function cheers(obj,val,id1)
{


 		var module=document.getElementById("module").value;
		var d=document.getElementById("txt_id").value;	
		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_cheers.php",{shareid:val,userid:id1,module:module},function(data)
			{
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
				});
			});
		}
		else if(module=='friend')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_cheers.php",{shareid:val,userid:id1,module:module},function(data)
			{
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)
				{
					$("#show_thread").html(data);
				});
			});
		}
}
function add_review(){
	tb_show('Add Review', "{/literal}{$siteroot}{literal}/modules/merchant-account/addreview.php?merchantid={/literal}{$smarty.get.id1}{literal}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=303&width=500&modal=false", tb_pathToImage);
}
</script>
<style>
/*This is how the text will look before mouse over*/
/*.colc {
font-family: san-serif;
color: #9EFF36;
font-size:12px;

}*/

/*This is how the text will look on mouse over. Note "hover" is the most important change here*/
.colc:hover
{
font-family: san-serif;
color: #F90B27;
font-size:24px;
}
</style>
{/literal}
<input type="hidden" name="txt_comment" id="txt_comment" value="yes">
{if  $smarty.get.moduleid eq 'review'}
<!-- no one can delete rating -->
{if $smarty.session.csUserTypeId eq 2}
<div class="write-review-main">
  <input class="previe-btn ovfl-hidden"  name="write_review" id="write_review" type="button" onClick="javascript:add_review()"  value="Write a Review "/>
</div>
<p>&nbsp;</p>
{/if}
<div class="maincont-inner-mid fl">
  <div class="main-comment-wall">
    <ul class="reset">
      {section name=i  loop=$user_activity }
      {if $user_activity[i].userid neq ''}
      <li >
        <div class="user-wall">
          <div class="user-wall-lft fl">
            <div class="user-frd-photo fl"> <a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="user-photo"><img src="{if $user_activity[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}" title="" alt="" width="47" height="46" /></a> </div>
          </div>
          <div class="user-wall-rgt fr">
            <div class="post-bg">
              <div class="post-bg-top"> <a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="fl">{$user_activity[i].first_name} {$user_activity[i].last_name}</a>
                <p class="fl">{$user_activity[i].rating_date|date_format:"%e %B %Y | %I:%M %p "}
                  <!--{$user_activity[i].rating_date|date_format:$config.date}-->
                </p>
              </div>
              <div class="post-bg-mid">
                <div style="margin-bottom:10px">
                  <p class="fl ratingtxt"> Rating:</p>
                  <div class="fl"> <span class="star_1 fl"><img  {if $user_activity[i].average_rating  > 0 && $user_activity[i].average_rating  <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span> <span class="star_2 fl"><img alt="" {if $user_activity[i].average_rating  > 1 && $user_activity[i].average_rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span> <span class="star_3 fl"><img  alt=""  {if $user_activity[i].average_rating  > 2 && $user_activity[i].average_rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span> <span class="star_4 fl"><img  alt="" {if $user_activity[i].average_rating  > 3 && $user_activity[i].average_rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span> <span class="star_5 fl"><img alt="" {if $user_activity[i].average_rating  > 4 && $user_activity[i].average_rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
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
              <div class="user-com"> <a id="link_comment" href="javascript:void(0);" class="fl commenttxt" onclick="viewComment_review(this,{$smarty.section.i.index},{$user_activity[i].rating_id});" >Comments({$user_activity[i].count_sub})</a>
                <div class=" clr"></div>
              </div>
              <ul class="reset">
                {section name=j  loop=$reviewsubcomment[i] }
                {if $reviewsubcomment[i][j].review_id eq $user_activity[i].rating_id}
                <li onmouseover="javascript:show_button({$smarty.section.j.index},{$smarty.section.i.index});" onmouseout="javascript:show_button1({$smarty.section.j.index},{$smarty.section.i.index});" >
                  <div class="main-wall">
                    <div class="wall-img-lft fl"> <a  {if $reviewsubcomment[i][j].usertypeid eq 2} href="{$siteroot}/my-account/{$reviewsubcomment[i][j].userid}/my_profile" {elseif $reviewsubcomment[i][j].usertypeid eq 3} href="{$siteroot}/merchant-account/{$reviewsubcomment[i][j].userid}/merchant_profile" {/if} class="fl"> <img  src="{if $reviewsubcomment[i][j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$reviewsubcomment[i][j].photo }{else}{$reviewsubcomment[i][j].photo }{/if}{/if}" title="" alt="" width="47" height="46" /> </a> </div>
                    <div class="wall-info-rgt fl"> <a href="#" class="fl">{if $reviewsubcomment[i][j].usertypeid eq 2}{$reviewsubcomment[i][j].first_name} {$reviewsubcomment[i][j].last_name}{else if $reviewsubcomment[i][j].usertypeid eq 3}{$reviewsubcomment[i][j].business_name}{/if} </a> <span class="fl" > {$reviewsubcomment[i][j].timestamp|date_format:"%e %B %Y | %I:%M %p "} </span> {if $smarty.session.csUserId eq $reviewsubcomment[i][j].uid} <span class="fr"> <a href="javascript:void(0)" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;cursor: pointer" onclick="deleteComment(this,{$reviewsubcomment[i][j].msg_id})">x </a> </span> {/if}
                      <!--<span class="fr" style="margin-top:6px;"> <img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;cursor: pointer" onclick="deleteComment(this,{$reviewsubcomment[i][j].msg_id})" ></span>-->
                      <div class="clr"></div>
                      <p>{$reviewsubcomment[i][j].msg}</p>
                      {if $reviewsubcomment[i][j].vault neq ''}
                      <p><img src="{$siteroot}/uploads/user/{$reviewsubcomment[i][j].vault}" title="" alt="" width="150" height="150" /></p>
                      {/if} </div>
                    <div class="clr"></div>
                  </div>
                </li>
                {/if}
                {/section}
                <div id="show_thread_{$smarty.section.i.index}"></div>
              </ul>
              <div class="clr"></div>
            </div>
          </div>
          <div class="clr"></div>
        </div>
      </li>
      {/if}	
      {sectionelse}
      <li>
        <div class="error" align="center">No Record Found.</div>
      </li>
      {/section}
    </ul>
    {if $total_page gt '1'}
    <div style="text-align:right;padding-right:60px"> <strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Prev</a>&nbsp; <a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Next</a></strong> </div>
    {/if} </div>
</div>
{elseif $smarty.get.moduleid eq 'dealsasusual' || $smarty.get.moduleid eq 'rightnowdeal'}
<input type="hidden" name="module" id="module" value="{$smarty.get.moduleid}">
<input type="hidden" name="txt_id" id="txt_id" value="{$smarty.get.userid}">
<div class="offer-deal-mer">
  <ul class="reset mer-deal-list">
    {section name=k  loop=$deal}
    
    {if $deal[k].deal_unique_id neq ''}
    <li>
      <div class="mer-offer-deal">
      <a href="{if $smarty.get.userid eq $smarty.session.csUserId} {$siteroot}/buy/{$deal[k].deal_unique_id}/ {else}javascript:void(0){/if}">
      <div class="mer-offer-deal-lft fl"> <img src="{if $deal[k].deal_image eq '' }{$siteroot}/templates/default/images/no_image.jpg{else}{$siteroot}/uploads/deal/thumbnail/{$deal[k].deal_image}{/if}" title="" alt="" width="80" height="80" /><span class="now-img">&nbsp;</span> </div>
      </a>
      <div class="mer-offer-deal-rgt fr">
        <div>
          <div class="fl">
            <h1 class="fl mer-title"><a style="float:left;margin-right:8px; width:170px" href="{$siteroot}/merchant-account/{$deal[k].userid}/merchant_profile" >{$deal[k].business_name|html_entity_decode|ucfirst}</a></h1>
             <a href="{$siteroot}/merchant-account/{$deal[k].id}/view_search_merchant_cat"><p class="fl mer-txt" style="color:#F9532C">&nbsp;{$deal[k].category|substr:0:24|html_entity_decode|ucfirst}</p></a>
            <div class="clr"></div>
          </div>
          <div class="fr"> <span style="margin-left:5px;" class="star_1"><img  {if $deal[k].rating  > 0 && $deal[k].rating <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $deal[k].rating > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span> <span class="star_2"><img alt="" {if $deal[k].rating > 1 && $deal[k].rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $deal[k].rating > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span> <span class="star_3"><img  alt=""  {if $deal[k].rating > 2 && $deal[k].rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $deal[k].rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span> <span class="star_4"><img  alt="" {if $deal[k].rating > 3 && $deal[k].rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $deal[k].rating > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span> <span class="star_5"><img alt="" {if $deal[k].rating > 4 && $deal[k].rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $deal[k].rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
            <div class="clr"></div>
          </div>
          <div class="clr"></div>
        </div>
        <div class=" mer-offer-detail">
          <div>
            <div class="fl ">
              <button class="ratebtn" > <span class="ratebtn-lft"><span class="ratebtn-rgt">{if $deal[k].is_share eq '0' }{$deal[k].discount_in_per}% OFF{/if} </span></span> </button>
            </div>
            <p class="fl">on <b> {if $deal[k].is_share eq '0' } <a href="{$siteroot}/buy/{$deal[k].deal_unique_id}/" target="_blank" style="color:#044EA2"> {/if}
              {$deal[k].deal_title|html_entity_decode}
              {if $deal[k].is_share eq '0' } </a> {/if} </b> </p>
            <div class="clr"></div>
           <!-- <p>{$deal[k].offer_details}</p>-->
            <div class="clr"></div>
          </div>
          <div class="date-txt fl">
            <p class="fl">{$deal[k].posted_date|date_format:"%e %B %Y | %I:%M %p "}</p>
            </div>
            <div class="clr"></div>
        </div>
        <div class="grey-btm-box">
          
            <a href="javascript:void(0);" class="fl" onclick="share_comment1(this,'{$deal[k].deal_title}','{$deal[k].deal_image}','{$smarty.get.userid}','{$deal[k].deal_unique_id}')">Share</a> <span class="fl">.</span> {if  $deal[k].count_cheer gt 0} <a href="javascript:void(0);"  class="fl">Cheered</a> ({$deal[k].count_cheer})
            {section name=c loop=$cheer1[k]}
            {if $smarty.section.c.iteration lt 2}
            
            {if $cheer1[k][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer1[k][0].fullname}</a> {else if $cheer1[k][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[k][0].userid}/merchant_profile">{$cheer1[k][0].business_name}</a> {/if}
            {if $cheer1[k][1].fullname neq '' || $cheer1[k][1].business_name neq ''} and {/if} 
            {if $cheer1[k][1].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer1[k][1].fullname}</a> {elseif $cheer1[k][1].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[k][0].userid}/merchant_profile">{$cheer1[k][1].business_name}</a> {/if}
            {if $deal[k].count_cheer gt 2}and <a href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/merchant-account/show_cheer_user.php?dealid={$deal[k].deal_unique_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false', tb_pathToImage);">others </a>{/if}  {if $deal[k].count_cheer gt 0}cheered this{/if} 
            {/if}
            {/section}
            {else} <a href="javascript:void(0);" onclick="cheers(this,'{$deal[k].deal_unique_id}','{$smarty.session.csUserId}')" class="fl">Cheer({$deal[k].count_cheer})</a> {section name=c loop=$cheer1[k]}
            {if $smarty.section.c.iteration lt 2}
            
            {if $cheer[k][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer[k][0].fullname}</a> {else if $cheer[k][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[k][0].userid}/merchant_profile">{$cheer[k][0].business_name}</a> {/if}
            {if $cheer[k][1].fullname neq '' || $cheer[k][1].business_name neq ''} and {/if} 
            {if $cheer[k][1].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer[k][1].fullname}</a> {elseif $cheer[k][1].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[k][0].userid}/merchant_profile">{$cheer[k][1].business_name}</a> {/if}{if $deal[k].count_cheer gt 2}and <a href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/merchant-account/show_cheer_user.php?dealid={$deal[k].deal_unique_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false', tb_pathToImage);">others </a>{/if}  {if $deal[k].count_cheer gt 0}cheered this{/if} 
            {/if}
            {/section}
            {/if}
            <div class=" clr"></div>
          </div>
        </div>
        <div class="clr"></div>
      </div>
    </li>
    {/if}
    {sectionelse}
    <li>
      <div style="text-align:center">No record found.</div>
    </li>
    {/section}
  </ul>
  {if $total_page gt '1'}
  <div style="text-align:right;padding-right:60px"> <strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Prev</a>&nbsp; <a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Next</a></strong> </div>
  {/if} </div>
{elseif $smarty.get.moduleid eq 'friend'}
<input type="hidden" name="module" id="module" value="{$smarty.get.moduleid}">
<input type="hidden" name="txt_id" id="txt_id" value="{$smarty.get.userid}">
<div class="main-comment-wall">
  <ul class="reset wall-comm-list">
    {section name=i  loop=$user_activity}
    {if $user_activity[i].userid neq ''}
    {if $user_activity[i].vault_t neq 'deal' }
    <li onmouseover="javascript:show_buttonm({$smarty.section.i.index});" onmouseout="javascript:show_buttonm1({$smarty.section.i.index});">
      <div class="user-wall">
        <div class="user-wall-lft fl">
          <div class="user-frd-photo fl"> <a {if $user_activity[i].usertypeid eq 2} href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" {elseif $user_activity[i].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile" {/if} class="user-photo"> <img src="{if $user_activity[i].photo eq ''} {$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}" title="" alt="" width="50" height="50" /> </a> </div>
        </div>
        <div class="user-wall-rgt fr">
          <div class="post-bg">
            <div class="post-bg-top"> <a href="javascript:void(0);" class="fl">{if $user_activity[i].usertypeid eq 2}{$user_activity[i].first_name} {$user_activity[i].last_name}{else}{$user_activity[i].business_name}{/if}</a>
              <p class="fl" style="line-height: 34px;" >{$user_activity[i].timestamp|date_format:"%e %B %Y | %I:%M %p "} </p>
              {if $smarty.session.csUserId eq $user_activity[i].uid || $smarty.session.csUserId eq $user_activity[i].fid} <span class="fr" style="margin-right:10px;"><a href="javascript:void(0)" name="mbtn_close_{$smarty.section.i.index}" id="mbtn_close_{$smarty.section.i.index}"  onclick="deleteComment(this,{$user_activity[i].msg_id})">x</a></span> {/if} </div>
            <!--{if $smarty.session.csUserId eq $user_activity[i].uid || $smarty.session.csUserId eq $user_activity[i].fid}
				<span class="fr"><img src="{$siteroot}/templates/default/images/btn_close.png" name="mbtn_close_{$smarty.section.i.index}" id="mbtn_close_{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;cursor: pointer" onclick="deleteComment(this,{$user_activity[i].msg_id})" ></span>
				{/if}-->
            <div class="post-bg-mid">
              <p> {if $user_activity[i].vault_t eq 'link'} <a href="{$user_activity[i].msg}" target="_blank" >{$user_activity[i].msg}</a>{else}{$user_activity[i].msg}
                {/if} <br>
                {if $user_activity[i].vault neq ''}
                
                {if $user_activity[i].vault_t eq 'deal' || $user_activity[i].vault_t eq 'buy_deal'} <img src="{$siteroot}/uploads/deal/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /> {else} <img src="{$siteroot}/uploads/user/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /> {/if}
                
                {/if} </p>
            </div>
            <div class="post-bg-btm">
              <div class="user-com"> {if $count_fan_or_not gt 0 || $smarty.session.csUserId eq $user_activity[i].uid || $smarty.session.csUserId eq $user_activity[i].fid } <a href="javascript:void(0)" onclick="viewComment(this,{$smarty.section.i.index},{$user_activity[i].msg_id});" class="fl commenttxt" id="link_comment">Comment({$user_activity[i].count_sub})</a> <span class="fl">.</span> <a href="javascript:void(0)" {if $user_activity[i].vault eq '' } onclick=share_comment(this,{$user_activity[i].msg_id},'no_image','{$user_activity[i].uid}'){else} onclick=share_comment(this,{$user_activity[i].msg_id},'{$user_activity[i].vault}','{$user_activity[i].uid}') {/if} class="fl commenttxt">Share</a> <span class="fl">.</span> {if $user_activity[i].count_cheer1 gt 0}
                <div class="fl" style="width:80px"><a href="javascript:void(0);"  class="commenttxt">Cheered</a> ({$user_activity[i].count_cheer})</div>
                {section name=c loop=$cheer[i]}
                {if $smarty.section.c.iteration lt 2} <a href="javascript:void(0);" onClick="javascript:tb_show('Show User', '{$siteroot}/modules/merchant-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=500&modal=false', tb_pathToImage);"> {if $cheer[i][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][0].first_name} {$cheer[i][0].last_name}</a> {else if $cheer[i][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a> {/if}	
                {if $cheer[i][1].first_name neq '' || $cheer[i][1].business_name neq ''} and {/if} 
                {if $cheer[i][1].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].first_name} {$cheer[i][0].last_name}</a> {elseif $cheer[i][1].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a> {/if}{if $user_activity[i].count_cheer gt 2}and<a href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);">others </a>{/if}  {if $user_activity[i].count_cheer gt 0}cheered this{/if} 
                {/if}
                {/section}
                {else} <a href="javascript:void(0);" onclick="cheers(this,{$user_activity[i].msg_id},'{$smarty.session.csUserId}')" class="cheer">Cheer</a> ({$user_activity[i].count_cheer})
                {section name=c loop=$cheer[i]}
                {if $smarty.section.c.iteration lt 2}
                
                {if $cheer[i][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][0].fullname}</a> {else if $cheer[i][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a> {/if}
                {if $cheer[i][1].fullname neq '' || $cheer[i][1].business_name neq ''} and {/if} 
                {if $cheer[i][1].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].fullname}</a> {elseif $cheer[i][1].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a> {/if}{if $user_activity[i].count_cheer gt 2}and <a href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);">others </a>{/if}  {if $user_activity[i].count_cheer gt 0}cheered this{/if} 
                {/if}
                {/section}
                {/if}
                
                {/if}
                <div class=" clr"></div>
              </div>
              <ul class="reset">
                {section name=j  loop=$user_subactivity[i]}
                {if $user_subactivity[i][j].parent_id eq $user_activity[i].msg_id }
                <li onmouseover="javascript:show_button({$smarty.section.j.index},{$smarty.section.i.index});" onmouseout="javascript:show_button1({$smarty.section.j.index},{$smarty.section.i.index});">
                  <div class="main-wall">
                    <div class="wall-img-lft fl"> <a style="margin-left:0px;" {if $user_subactivity[i][j].usertypeid eq 2} href="{$siteroot}/my-account/{$user_subactivity[i][j].userid}/my_profile" {elseif $user_subactivity[i][j].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_subactivity[i][j].userid}/merchant_profile" {/if}   class="user-photo"> <img  src="{if $user_subactivity[i][j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$user_subactivity[i][j].photo}{else}{$user_subactivity[i][j].photo}{/if}{/if}" title="" alt="" width="50" height="50" /> </a> </div>
                    <div class="wall-info-rgt fl">
                      <div> <a href="javascript:void(0)" class="fl">{if $user_subactivity[i][j].usertypeid eq 2}{$user_subactivity[i][j].first_name} {$user_subactivity[i][j].last_name}{else if $user_subactivity[i][j].usertypeid eq 3}{$user_subactivity[i][j].business_name}{/if}</a> <span class="fl" style="line-height:18px;"> {$user_subactivity[i][j].timestamp|date_format:"%e %B %Y | %I:%M %p "} </span> {if $smarty.session.csUserId eq $user_subactivity[i][j].uid} <span class="fr" style="margin-right:10px;"><a href="javascript:void(0)" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" onclick="deleteComment(this,{$user_subactivity[i][j].msg_id})">x</a></span> {/if}
                        <div class="clr"></div>
                      </div>
                      <p>{$user_subactivity[i][j].msg}</p>
                      {if $user_subactivity[i][j].vault neq ''}
                      <p><img src="{$siteroot}/uploads/user/{$user_subactivity[i][j].vault}" title="" alt="" width="150" height="150" /></p>
                      {/if} </div>
                    <!--<img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;margin-left: 400px; cursor: pointer" onclick="deleteComment(this,{$user_subactivity[i][j].msg_id})" >-->
                    <div class="clr"></div>
                  </div>
                </li>
                {/if}
                {/section}
                <div id="show_thread_{$smarty.section.i.index}"></div>
              </ul>
              <div class="clr"></div>
            </div>
          </div>
          <div class="clr"></div>
        </div>
        <div class="clr"></div>
      </div>
    </li>
    {/if}
    {/if}
    {sectionelse}
    <li style="text-align:center">No Record Found.</li>
    {/section}
  </ul>
  {if $total_page gt '1'}
  <div style="text-align:right;padding-right:60px"> <strong><a href="javascript:;" {if $smarty.get.page eq ''} style="display:none;"  {else}  {if $smarty.get.page eq '1'}  style="display:none;"  {/if} {/if} onclick="sortOrder('Prev','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Prev</a>&nbsp; <a href="javascript:;"  {if $smarty.get.page eq $total_page} style="display:none;" {/if} onclick="sortOrder('Next','{$smarty.get.page}','{$smarty.get.userid}','{$smarty.get.moduleid}');">Next</a></strong> </div>
  {/if} </div>
{/if}
