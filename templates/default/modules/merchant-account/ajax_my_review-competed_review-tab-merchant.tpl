
{literal}
<script type="text/javascript" language="JavaScript">
	function show_comment_box(val,id)
	{
	document.getElementById("div_"+val).style.display="block";
	document.getElementById("txt_id").value=id;
	}

function viewComment_review(obj,val,id)
	{
// 		var txt_comment=$('#txt_comment').val();
		var profile=$("#profile_name").val();
		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
		var dmid='{/literal}{$smarty.get.moduleid}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_comment.php";


		jQuery.get(cmt_url,{userid:d,review_id:id,dmid:dmid},function(data)
		{
			
				jQuery("#show_thread_"+val).html(data);
				
		});
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
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
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
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
//     		jQuery(obj).css('color','#FFFFFF');
// 		jQuery('#reviewlink').css('color','#000000');
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

			//alert(val);
			var id=$('#id').val();
			var id1=$('#id1').val();
				if (id=="" || id==id1)
				{
				document.getElementById("mbtn_close_"+val).style.display="block";
				}
			}
				function show_buttonm1(val)
				{
				//alert(val);
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
// alert(id1);
// alert(val);
// alert(val1);
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
// alert(id1);
// alert(val);
// alert(val1);
 		var module=document.getElementById("module").value;
// 		var d=document.getElementById("txt_id").value;
// 		if(d == "")
// 		{
		var d=document.getElementById("txt_id").value;
// 		}
		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')
		{
			$.get(SITEROOT+"/modules/merchant-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module,deal_id:deal_id},function(data)
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

function cheers(obj,val,id1)
{
// alert(id1);
// alert(val);

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
			<span id="span1" class="share-btn-lft01">
				<span id="span2" class="share-btn-rgt01">
		 				<input class="share-btn ovfl-hidden"  name="write_review" id="write_review" type="button" onClick="javascript:add_review()"  value="Write a Review "/>
				</span>
			</span> 
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

						<div class="user-frd-photo fl">  
								<a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="user-photo"><img src="{if $user_activity[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}" title="" alt="" width="47" height="46" /></a> 
						</div>

                    </div>
                    <div class="user-wall-rgt fr">

					<div class="post-bg">
                        <div class="post-bg-top"> 
								<a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="fl">{$user_activity[i].first_name} {$user_activity[i].last_name}</a>
                          <p class="fl">{$user_activity[i].rating_date|date_format:"%e %B %Y at "} {$user_activity[i].rating_date|date_format:$config.date}</p>
                        </div>
                        <div class="post-bg-mid">
                          <div style="margin-bottom:10px">
                            <p class="fl ratingtxt"> Rating:</p>
                            <div class="fl"> 

								<span class="star_1 fl"><img  {if $user_activity[i].average_rating  > 0 && $user_activity[i].average_rating  <= 0.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 0.5 } src="{$siteroot}/templates/default/images/star-on.png" {else}  src="{$siteroot}/templates/default/images/star-off.png" {/if}/></span>
								<span class="star_2 fl"><img alt="" {if $user_activity[i].average_rating  > 1 && $user_activity[i].average_rating  <= 1.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 1.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
								<span class="star_3 fl"><img  alt=""  {if $user_activity[i].average_rating  > 2 && $user_activity[i].average_rating  <= 2.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 2.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if} /></span>
								<span class="star_4 fl"><img  alt="" {if $user_activity[i].average_rating  > 3 && $user_activity[i].average_rating  <= 3.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 3.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>
								<span class="star_5 fl"><img alt="" {if $user_activity[i].average_rating  > 4 && $user_activity[i].average_rating  <= 4.5} src="{$siteroot}/templates/default/images/star-half.png"{/if} {if $user_activity[i].average_rating  > 4.5}src="{$siteroot}/templates/default/images/star-on.png"{else} src="{$siteroot}/templates/default/images/star-off.png"{/if}/></span>

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
                        <div class="user-com"> 

							<a id="link_comment" href="javascript:void(0);" class="fl commenttxt" onclick="viewComment_review(this,{$smarty.section.i.index},{$user_activity[i].rating_id});" >Comments({$user_activity[i].count_sub})</a>

                          <div class=" clr"></div>
                        </div>
                        <ul class="reset">

	{section name=j  loop=$reviewsubcomment[i] }
		{if $reviewsubcomment[i][j].review_id eq $user_activity[i].rating_id}
                          <li onmouseover="javascript:show_button({$smarty.section.j.index},{$smarty.section.i.index});" onmouseout="javascript:show_button1({$smarty.section.j.index},{$smarty.section.i.index});" >
                            <div class="main-wall">
                              <div class="wall-img-lft fl"> 

								<a  {if $reviewsubcomment[i][j].usertypeid eq 2} href="{$siteroot}/my-account/{$reviewsubcomment[i][j].userid}/my_profile" {elseif $reviewsubcomment[i][j].usertypeid eq 3} href="{$siteroot}/merchant-account/{$reviewsubcomment[i][j].userid}/merchant_profile" {/if} class="fl">
										<img  src="{if $reviewsubcomment[i][j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.id1 neq ''}{$reviewsubcomment[i][j].photo }{else}{$reviewsubcomment[i][j].photo }{/if}{/if}" title="" alt="" width="47" height="46" />
								</a>

							 </div>
                              <div class="wall-info-rgt fl">
                               
									<a href="#" class="fl">{if $reviewsubcomment[i][j].usertypeid eq 2}{$reviewsubcomment[i][j].first_name} {$reviewsubcomment[i][j].last_name}{else if $reviewsubcomment[i][j].usertypeid eq 3}{$reviewsubcomment[i][j].business_name}{/if}
									</a> 

									<span class="fl"> {$reviewsubcomment[i][j].timestamp} </span>

								{if $smarty.session.csUserId eq $reviewsubcomment[i][j].uid}
									<span class="fr"> 
										<a href="javascript:void(0)" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;cursor: pointer" onclick="deleteComment(this,{$reviewsubcomment[i][j].msg_id})">x
										</a>
									</span>
								{/if}

									<!--<span class="fr" style="margin-top:6px;"> <img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;cursor: pointer" onclick="deleteComment(this,{$reviewsubcomment[i][j].msg_id})" ></span>-->
										

                                  <div class="clr"></div>
                                
                                <p>{$reviewsubcomment[i][j].msg}</p>

								{if $reviewsubcomment[i][j].vault neq ''}
									<p><img src="{$siteroot}/uploads/user/{$reviewsubcomment[i][j].vault}" title="" alt="" width="150" height="150" /></p>
								{/if}

                              </div>
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
		<li><div class="error" align="center">No Record Found.</div></li>
{/section}
{/if}
</ul>
</div>
</div>