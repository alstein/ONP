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


		viewReview();


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
			$("#review").addClass("active");

			//$('#review').css('background','url(../../images/live-wire-menu.png no-repeat scroll -376px -77px transparent)')
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
					$("#div_share").hide();
					$("#div_share").show();
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
					//$("#div_share").hide();
					$("#div_share").show();
					$("#show_thread").html(data);
					$("#txt_thinking").val("");
					$("#filename").val("");
	
				});
			})
		}
		$('#commentphoto').val("");
		
	}
	else if(txt_link)
		{
			if(txt_link=="Enter your link"){
				alert("Please enter link");return false;}
			if(photo==undefined)
			{
				
				cmt_url = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
				jQuery.get(cmt_url,{userid:userid,txt_link:txt_link,moduleid:'friend'},function(data)
				{
					
					$.get(cmt_url,{userid:userid,moduleid:'friend'},function(data)
					{
						
						//$('#div_share').show();
						$('#div_share').hide();
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
						//$('#div_share').show();
						$('#div_share').hide();
						$('#friend').addClass("active");
						$("#show_thread").html(data);
						$("#txt_thinking").val("");
						$("#filename").val("");
		
					});
				})
			}
		}
	
	else{  alert("Plese enter updates/events !"); }
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
	$("#show_thread").html(data);
	$("#div_share").hide();
	//$("#div_share").show();
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

<!-- Header starts -->
{include file=$profile_header2}
<!-- Header ends -->
<!-- main continer of the page -->
<div id="wrapper">
  <!-- Maincontent starts -->




  <div id="maincont" >

    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="profile-tbl">

		<!--<tr><td style="width:208px"></td></tr>-->

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
                 <li  ><a  href="javascript:void(0);"   onclick="javascript:viewReview(this);" id="review" class="review-deal"></a></li>
                <li><a href="javascript:void(0);"  onclick="javascript:viewFriends(this);" id="friend" class="update-deal"></a></li>
               <!--<li><a href="javascript:void(0);"  onclick="javascript:viewRightNowDeal(this);" id="rightnowdeal" class="hurryup-deal-new"></a></li>
               <li><a  href="javascript:void(0);"  onclick="javascript:viewDealsAsUsual(this);" id="dealasusual" class="fav-deal-new"></a></li>-->
                <li><a href="javascript:void(0);"  onclick="javascript:viewRightNowDeal(this);" id="rightnowdeal" class="hurryup-deal-new"></a></li>
              </ul>
              <div class="clr"></div>
			<div>



    <input type="hidden" name="txt_id" id="txt_id" value="{if $smarty.get.id1 eq ''}{$smarty.session.csUserId}{else}{$smarty.get.id1}{/if}">
      {if $smarty.session.csUserId neq '' && $smarty.get.id1 eq''}
      <input type="hidden" name="txt_friend" id="txt_friend" value="{$smarty.get.friendid}">
      <form method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
        <div class="whats-in-mind" id="div_share" style="display:none;padding:33px 14px;width:537px;">
          <input  class="whats-in-mind-textbox"  type="text" name="txt_thinking" id="txt_thinking" value="What you have been thinking?"  onBlur="if(this.value=='')this.value='What you have been thinking?'" style=" background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DDDDDD;
    margin: 10px auto;
    padding: 7px 10px;
    width: 370px;"   onClick="if(this.value=='What you have been thinking?')this.value=''"/> 
		
		 <input type="text" name="txt_link" id="txt_link"  class="whats-in-mind-textbox" value="Enter your link"  onClick="if(this.value=='Enter your link')this.value=''"  onBlur="if(this.value=='')this.value='Enter your link'"  style=" background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DDDDDD;
    margin: 10px auto;
    padding: 7px 10px;
    width: 330px;display:none;"/>

		<div class="fr" style="padding-top:16px;width:145px;">
            <input class="post-btn fr" type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:clear_text();">
			<input class="post-btn fr" type="button" name="share" id="share" value="Post" onClick="javascript:onfriend_page({$smarty.session.csUserId});" style="margin-right:12px;">
		</div>
		

           <div  id="div_share_photo" style="display:none;">
            <div id="right_col">
              <div id="upload_area" style="width:246px;"> </div>
            </div>
            <div class="clear"> </div>
            <input type="hidden" name="maxSize" value="9999999999" />
            <input type="hidden" name="maxW" value="200" />
            <input type="hidden" name="fullPath" value="{$siteroot}/uploads/user/temp/" />
            <input type="hidden" name="relPath" value="../../uploads/user/temp/" />
            <input type="hidden" name="colorR" value="255" />
            <input type="hidden" name="colorG" value="255" />
            <input type="hidden" name="colorB" value="255" />
            <input type="hidden" name="maxH" value="300" />
            <input type="hidden" name="filename" value="filename" />
            <p>
              <input type="file" name="filename" id="filename" class="signinput" value="" onChange="ajaxUpload(this.form,'{$siteroot}/php_ajax_image_upload/scripts/ajaxupload.php?filename=name&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath={$siteroot}/uploads/temp/&amp;relPath={$siteroot}/uploads/temp/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" />
            </p>
          </div>
          <div > <a href="javascript:void(0);" onClick="javascript:add_text();"  class="write">&nbsp;</a> <a href="javascript:void(0);" onClick="javascript:add_photo();" class="photos">&nbsp;</a> <a href="javascript:void(0);" class="links" onClick="javascript:show_link();"  class="links">&nbsp;</a> </div>
        </div>
         <div class="clr"></div>
      </form>
      {elseif $smarty.get.id1 neq '' && $count_friend neq '0'}
      <input type="hidden" name="txt_friend" id="txt_friend" value="{$smarty.get.friendid}">
      <form method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
        <div class="whats-in-mind" id="div_share" style="display:none;padding:33px 14px;">
          <input type="text" name="txt_thinking" id="txt_thinking" value="What you have been thinking?"  style="width:380px;"   onBlur="if(this.value=='')this.value='What you have been thinking?'" onClick="if(this.value=='What you have been thinking?')this.value=''" class="whats-in-mind-textbox"   />   
	<input type="text" name="txt_link" id="txt_link"  style=" background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #DDDDDD;
    margin: 10px auto;
    padding: 7px 10px;
    width: 370px;display:none;" class="whats-in-mind-textbox" value="Enter your link"  onBlur="if(this.value=='')this.value='Enter your link'" onClick="if(this.value=='Enter your link')this.value=''" onfocus="if(this.value=='Enter your link')this.value=''"/>
	
	<div class="fr"> <span class="share-btn-lft"><span class="share-btn-rgt">
          <input class="share-btn " type="button" name="share" id="share" value="Post" onClick="javascript:onfriend_page({$smarty.session.csUserId});">
          </span></span>
		<span class="share-btn-lft" style="margin-left:5px"><span class="share-btn-rgt">
          <input class="share-btn " type="button" name="cancel" id="cancel" value="Cancel" onClick="javascript:clear_text();">
          </span></span>		
	
	</div>
          <div  id="div_share_photo" style="display:none;">
            <div id="right_col">
              <div id="upload_area"  style="width:246px;"></div>
            </div>
            <div class="clear"> </div>
            <input type="hidden" name="maxSize" value="9999999999" />
            <input type="hidden" name="maxW" value="200" />
            <input type="hidden" name="fullPath" value="{$siteroot}/uploads/user/temp/" />
            <input type="hidden" name="relPath" value="../../uploads/user/temp/" />
            <input type="hidden" name="colorR" value="255" />
            <input type="hidden" name="colorG" value="255" />
            <input type="hidden" name="colorB" value="255" />
            <input type="hidden" name="maxH" value="300" />
            <input type="hidden" name="filename" value="filename" />
            <p>
              <input type="file" name="filename" id="filename" class="signinput" value="" onChange="ajaxUpload(this.form,'{$siteroot}/php_ajax_image_upload/scripts/ajaxupload.php?filename=name&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath={$siteroot}/uploads/temp/&amp;relPath={$siteroot}/uploads/temp/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" />
            </p>
          </div>
          <div class="ovfl-hidden fl"> <a href="javascript:void(0);" onClick="javascript:add_text();"  class="write">&nbsp;</a> <a href="javascript:void(0);" onClick="javascript:add_photo();" class="photos">&nbsp;</a>  <a href="javascript:void(0);" class="links" onClick="javascript:show_link();"  class="links">&nbsp;</a> </div>
        </div>
        <div class="clr"></div>
      </form>
      {/if}


			</div>
            </div>
			
            <div class="main-comment-wall">
              <ul class="reset">
               <div id="show_thread"></div>
             
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