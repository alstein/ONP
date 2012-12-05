{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
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

		if($("#view_success_message").val()!=""){ //alert("aa");
				tb_show('Deal', '{/literal}{$siteroot}{literal}/modules/merchant-account/show_message.php?ID=2&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=500&modal=false', tb_pathToImage);
				$("#view_success_message").val("");
			}

		viewReview();

		
		if($("#alertpopup").val()=="yes"){
			tb_show('Deal', '{/literal}{$siteroot}{literal}/modules/merchant-account/show_message.php?ID=3&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=500&modal=false', tb_pathToImage);
				
		}
    });
	function viewReview(obj)
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
	function viewFavLocalBusiness(obj)
	{

		var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
	    	cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
		
	    	jQuery.get(cmt_url,{userid:d,moduleid:'favlocalbusiness'},function(data)
		{
			jQuery("#show_thread").html(data);
			$('#div_share').hide();
		});

	}
	
	function viewFriends(obj)
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
function viewDealsAsUsual(obj)
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
	
	function viewRightNowDeal(obj)
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
	
function onfriend_page(userid)
{

	var txt_thinking=$('#txt_thinking').val();
	var txt_link=$.trim($('#txt_link').val());
	var photo=$('#commentphoto').val();
	var newfilename=$('#new_filename').val();
	
	// alert(txt_thinking);
	// alert(photo);
	// alert(newfilename);

	if((txt_thinking!='')&&(txt_thinking!='What you have been thinking?'))
	{
		if(photo==undefined)
		{
	
			cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,moduleid:'friend'},function(data)
			{
				
				$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
				{
					
					$("#show_thread").html(data);
					$("#txt_thinking").val("");
				});
			})
		}
		else
		{
	
			cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url,{userid:userid,txt_thinking:txt_thinking,photo:photo,moduleid:'friend'},function(data)
			{
	
				$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:userid,moduleid:'friend'},function(data)
				{
					$('#div_share_photo').hide();
					$("#show_thread").html(data);
					$("#txt_thinking").val("");
					$("#filename").val("");
	
				});
			})
		}
		$('#commentphoto').val("");
		//alert($('#commentphoto').val());
	}
	else if(txt_link)
		{
			if(photo==undefined)
			{
				
				cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,moduleid:'friend'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
					{
						
						$('#div_share').show();
						$('#friend').addClass("active");
						$("#show_thread").html(data);
						$("#txt_thinking").val("");
						$("#filename").val("");
					});
				})
			}
			else
			{
				cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,photo:photo,moduleid:'friend'},function(data)
				{
		
					$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:userid,moduleid:'friend'},function(data)
					{
						$('#div_share').show();
						$('#friend').addClass("active");
						$("#show_thread").html(data);
						$("#txt_thinking").val("");
						$("#filename").val("");
		
					});
				})
			}
		}
	
	else{ alert("Plese enter updates/events !"); }
}
function add_photo()
{
$('#div_share_photo').show();
}
function add_text()
{
$('#div_share_photo').hide();
}
function show_link()
{
$('#txt_thinking').hide();
$('#txt_link').show();
$('#div_share_photo').hide();
}
function clear_text()
{

var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';
$.get(SITEROOT+"/modules/merchant-account/ajax_my_review.php",{userid:d,moduleid:'friend'},function(data)
{
	$(".show_thread").html(data);
	$("#div_share").show();
	$('#friend').addClass("active");
	document.getElementById('txt_thinking').value == 'What you have been thinking?'
	$("#txt_link").val("Enter your link");
});

}

</script>
<script language="JavaScript" type="text/javascript">
function show_text()
{

	if(document.getElementById('txt_thinking').value == '')
	{
	document.getElementById('txt_thinking').value ='What you have been thinking?';
	}
}
function show_text1()
{

	if(document.getElementById('txt_thinking').value == 'What you have been thinking?')
	{
	document.getElementById('txt_thinking').value =" ";
	}
}



</script>
{/literal}

<!-- main continer of the page -->
<div id="wrapper">
  <!-- Header starts -->
    {include file=$profile_header2}
  <!-- Header ends -->
  <!-- Maincontent starts -->
  <div id="maincont" >
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">
      <tr>
        <!-- Profile Left Section Start -->
             {include file=$merchant_home_left}
        <!-- Profile Left Section End -->
        <!-- Profile Middle Section Start -->
        <td width="560" valign="top"><!-- Profile Comment Section Start -->
          <div class="maincont-inner-mid fl">
            <div class="live-wire">
              <h1>Live Wire</h1>
              <ul class="reset">
                 <li><a href="#" class="review-deal active"></a></li>
                <li><a href="#" class="update-deal"></a></li>
               <li><a href="#" class="hurryup-deal"></a></li>
               <li><a href="#" class="fav-deal"></a></li>
              </ul>
              <div class="clr"></div>
            </div>
            <div class="main-comment-wall">
              <ul class="reset">
                <li>
                  <div class="user-wall">
                    <div class="user-wall-lft fl">
                      <div class="user-frd-photo fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                    </div>
                    <div class="user-wall-rgt fr">
                      <div class="post-bg">
                        <div class="post-bg-top"> <a href="#" class="fl">Latha Priya </a>
                          <p class="fl">said on 6 September 2012  |   2.22pm </p>
                        </div>
                        <div class="post-bg-mid">
                          <div style="margin-bottom:10px">
                            <p class="fl ratingtxt"> Rating:</p>
                            <div class="fl"> <a href="#" class="star-icon fl active"></a> <a href="#" class="star-icon fl active"></a> <a href="#" class="star-icon fl"></a> <a href="#" class="star-icon fl"></a> <a href="#" class="star-icon fl"></a>
                              <div class="clr"></div>
                            </div>
                            <div class="clr"> </div>
                          </div>
                          <div class="user-blog">
                            <p class="userblue-txt">Keyword/ Summary:</p>
                            <p class="usertxtcom">Morbi et est aliquet mi sagittis dictum. Quisque vehicula bibendum fringilla.</p>
                          </div>
                          <div>
                            <p class="userblue-txt">Review:</p>
                            <p class="usertxtcom">Morbi et est aliquet mi sagittis dictum. Quisque vehicula bibendum fringilla.</p>
                          </div>
                        </div>
                      </div>
                      <div class="post-bg-btm">
                        <div class="user-com"> <a href="#" class="fl commenttxt">Comment</a>
                          <div class=" clr"></div>
                        </div>
                        <ul class="reset">
                          <li>
                            <div class="main-wall">
                              <div class="wall-img-lft fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                              <div class="wall-info-rgt fl">
                                <div> <a href="#" class="fl">Tiffany Teng</a> <span class="fl">10 September 2012</span>
                                  <div class="clr"></div>
                                </div>
                                <p>Good offerings... Good offerings... Good offerings...Good offerings... Good offerings... Good offerings...Good offerings... Good Good offerings... Good offerings...</p>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li>
                            <div class="main-wall">
                              <div class="wall-img-lft fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                              <div class="wall-info-rgt fl">
                                <div> <a href="#" class="fl">Ai Ching</a> <span class="fl">10 September 2012</span>
                                  <div class="clr"></div>
                                </div>
                                <p>Thanks for sharing.</p>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li>
                            <div class="frd-comm">
                              <input name="name" type="text"  value="Add Comment"/>
                            </div>
                          </li>
                          <li>
                            <div class="fr" style="margin-right:10px">
                              <input name="name" type="text"  class="post-btn" value="Post" style="width:52px"/>
                            </div>
							
	
                          </li>
                        </ul>
                        <div class="clr"></div>
                      </div>
                    </div>
                    <div class="clr"></div>
                  </div>
                </li>
                <li >
                  <div class="user-wall" style="border:none">
                    <div class="user-wall-lft fl">
                      <div class="user-frd-photo fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                    </div>
                    <div class="user-wall-rgt fr">
                      <div class="post-bg">
                        <div class="post-bg-top"> <a href="#" class="fl">Tiffany</a>
                          <p class="fl">update on 6 September 2012  |   2.22pm </p>
                        </div>
                        <div class="post-bg-mid">
                          <div style="margin-bottom:10px">
                            <p class="fl ratingtxt"> Rating:</p>
                            <div class="fl"> <a href="#" class="star-icon fl active"></a> <a href="#" class="star-icon fl active"></a> <a href="#" class="star-icon fl"></a> <a href="#" class="star-icon fl"></a> <a href="#" class="star-icon fl"></a>
                              <div class="clr"></div>
                            </div>
                            <div class="clr"> </div>
                          </div>
                          <div class="user-blog">
                            <p class="userblue-txt">Keyword/ Summary:</p>
                            <p class="usertxtcom">Morbi et est aliquet mi sagittis dictum. Quisque vehicula bibendum fringilla. Morbi et est aliquet mi 
                              sagittis dictum. Quisque vehicula bibendum fringilla.</p>
                          </div>
                          <div>
                            <p class="userblue-txt">Review:</p>
                            <p class="usertxtcom">Morbi et est aliquet mi sagittis dictum. Quisque vehicula bibendum fringilla Quisque vehicula 
                              bibendum fringilla. Quisque vehicula bibendum fringilla. Quisque vehicula bibendum fringilla. Quis
                              que vehicula bibendum fringilla.</p>
                          </div>
                        </div>
                      </div>
                      <div class="post-bg-btm">
                        <div class="user-com"> <a href="#" class="fl commenttxt">Comment</a>
                          <div class=" clr"></div>
                        </div>
                        <ul class="reset">
                          <li>
                            <div class="main-wall">
                              <div class="wall-img-lft fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                              <div class="wall-info-rgt fl">
                                <div> <a href="#" class="fl">Tiffany Teng</a> <span class="fl">10 September 2012</span>
                                  <div class="clr"></div>
                                </div>
                                <p>Good offerings... Good offerings... Good offerings...Good offerings... Good offerings... Good offerings...Good offerings... Good Good offerings... Good offerings...</p>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li>
                            <div class="main-wall">
                              <div class="wall-img-lft fl"> <img src="images/user-img.png" width="50" height="50" alt="" title=""  /> </div>
                              <div class="wall-info-rgt fl">
                                <div> <a href="#" class="fl">Ai Ching</a> <span class="fl">10 September 2012</span>
                                  <div class="clr"></div>
                                </div>
                                <p>Thanks for sharing.</p>
                              </div>
                              <div class="clr"></div>
                            </div>
                          </li>
                          <li>
                            <div class="frd-comm">
                              <input name="name" type="text"  value="Add Comment"/>
                            </div>
                          </li>
                          <li>
                            <div class="fr" style="margin-right:10px">
                              <input name="name" type="text"  class="post-btn" value="Post" style="width:52px"/>
                            </div>
                          </li>
                        </ul>
                        <div class="clr"></div>
                      </div>
                    </div>
                    <div class="clr"></div>
                  </div>
                </li>
              </ul>
              <div class="clr"></div>
            </div>
            <div class="clr" style="height:50px"></div>
          </div>
          <!-- Profile Comment Section End --></td>
        <!-- Profile Middle Section End -->
        <!-- Profile Right Section Start -->
           {include file=$merchant_home_right}
        <!-- Profile Right Section End -->
      </tr>
    </table>
  </div>
  <!-- Maincontent ends -->
</div>
<!-- Footer starts -->

   {include file=$footer}