{strip}
<script src="{$sitejs}/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
{/strip}
{literal}
<script type="text/javascript" language="JavaScript">

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

var moduleid='{/literal}{$smarty.get.moduleid}{literal}';
if(moduleid == 'review')
{
$("#div_share").show();
}
});



	function show_comment_box(val,id)

	{

	document.getElementById("div_"+val).style.display="block";

	document.getElementById("txt_id").value=id;

	}



function viewComment(obj,val,id)

	{

		var txt_comment=$('#txt_comment').val();



		var profile=$("#profile_name").val();

		var module=document.getElementById("module").value;



		if(module=='dealsasusual'){

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}





		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';

	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_comment.php";

		jQuery.get(cmt_url,{userid:d,parentid:id,profilename:profile,moduleid:module},function(data)

		{

					

				jQuery("#show_thread_"+val).html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");





			

		});

		

		//     		jQuery(obj).css('color','#FFFFFF');

		// 		jQuery('#reviewlink').css('color','#000000');

	} 



function viewComment_deal(obj,val,id)

	{

		var txt_comment=$('#txt_comment').val();

		var profile=$("#profile_name").val();

		var module=document.getElementById("module").value;



		if(module=='dealsasusual'){

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}





		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';

	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_comment.php";

		jQuery.get(cmt_url,{userid:d,dealid:id,moduleid:module,profilename:profile},function(data)

		{

				jQuery("#show_thread_"+val).html(data);

				$('#friend').addClass("active");



		});

//     		jQuery(obj).css('color','#FFFFFF');

// 		jQuery('#reviewlink').css('color','#000000');

	} 

function viewComment_deal1(obj,val,id)

	{

		var txt_comment=$('#txt_comment').val();

		var profile=$("#profile_name").val();

		var module=document.getElementById("module").value;

		var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';

	    	cmt_url = SITEROOT+"/modules/my-account/ajax_my_comment.php";

		jQuery.get(cmt_url,{userid:d,dealid:id,moduleid:module,profilename:profile},function(data)

		{

			

			

				jQuery("#show_thread1_"+val).html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");





				

		});

		//     		jQuery(obj).css('color','#FFFFFF');

		// 		jQuery('#reviewlink').css('color','#000000');

	} 

</script>
<script type="text/javascript">



function show_button(val,val1)

{

// alert(val);

// alert(val1);

var id=$('#id').val();

var id1=$('#id1').val();

	if (id=="" || id==id1)

	{

// alert(document.getElementById("btn_close_"+val).style.display);

	document.getElementById("btn_close_"+val+val1).style.display="block";

// alert(document.getElementById("btn_close_"+val).style.display);

	}

	

}

function show_button1(val,val1)

{



document.getElementById("btn_close_"+val+val1).style.display="none";

}

function show_button12(val)

{



var id=$('#id').val();

var id1=$('#id1').val();

	if (id=="" || id==id1)

	{

 	document.getElementById("btn_close1_"+val).style.display="block";

	}

	

}

function show_button21(val)

{



 document.getElementById("btn_close1_"+val).style.display="none";

}

function deleteComment(obj,val)

{

		var module=document.getElementById("module").value;



		if(module=='dealsasusual'){

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";	

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}



		$.get(SITEROOT+"/modules/my-account/ajax_insert_comment.php",{delid:val},function(data)

		{

			var d='{/literal}{if $smarty.get.id1 eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.id1 }{/if}{literal}';

			$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)

			{

				$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");



			});

		});

}

function share_comment(obj,val,val1,id1)

{



 		var module=document.getElementById("module").value;

// 		var d=document.getElementById("txt_id").value;

// 		if(d == "")

// 		{

		var d=document.getElementById("txt_id").value;

// 		}

		

		if(module=='dealsasusual'){ //alert("1");

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}





		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)

			{

				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)

				{	//alert("2");

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");

				});

			});

		}

		else if(module=='friend' || module=='review')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)

			{

				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:id1,moduleid:module},function(data)

				{

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");

				});

			});

		}

}





function share_comment1(obj,val,val1,id1,deal_id)

{



 		var module=document.getElementById("module").value;

// 		var d=document.getElementById("txt_id").value;

// 		if(d == "")

// 		{

		var d=document.getElementById("txt_id").value;

// 		}

		

		if(module=='dealsasusual'){ //alert("1");

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}





		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module,deal_id:deal_id},function(data)

			{
                                 
				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)

				{	//alert("2");

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");



					if(module=='dealsasusual' || module=='rightnowdeal'){
                                                      
					tb_show('Share Deal', SITEROOT+'/success.php?placeValuesBeforeTB_=savedValues&TB_iframe=true&height=100&width=600&modal=false',tb_pathToImage);
                                                    
					}



				});

			});

		}

		else if(module=='friend' || module=='review')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_share_comment.php",{shareid:val,img_val:val1,userid:id1,module:module},function(data)

			{

				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:id1,moduleid:module},function(data)

				{

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");

				});

			});

		}

}





function cheers(obj,val,id1)

{

//alert(id1);

//alert(val);



 		var module=document.getElementById("module").value;



		var d=document.getElementById("txt_id").value;	

		//alert(d);



		if(module=='dealsasusual'){

			var amod="dealasusual";

			var amod1="rightnowdeal";

			var amod2="favbusiness";

			var amod3="friend";

		}

		else if(module=='rightnowdeal') {

			var amod="rightnowdeal";

			var amod1="dealasusual";

			var amod2="favbusiness";

			var amod3="friend";



		}else if(module=='favlocalbusiness') {

			var amod="favbusiness";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="friend";

		}else if(module=='friend'){ 

			var amod="friend";

			var amod1="dealasusual";

			var amod2="rightnowdeal";

			var amod3="favbusiness";

		}



		if(module=='dealsasusual' || module=='rightnowdeal' || module=='favlocalbusiness')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_cheers.php",{shareid:val,userid:id1,module:module},function(data)

			{	

				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)

				{

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");



				});

			});

		}

		else if(module=='friend' || module=='review')

		{

			$.get(SITEROOT+"/modules/my-account/ajax_cheers.php",{shareid:val,userid:id1,module:module},function(data)

			{	

				$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data)

				{

					$(".profile-middel").html(data);

					$('#'+amod).addClass("active");

					$('#'+amod1).removeClass("active");

					$('#'+amod2).removeClass("active");

					$('#'+amod3).removeClass("active");



				});

			});

		}

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



	jQuery.post(SITEROOT+"/modules/my-account/ajax_my_review.php?page="+pack+"&userid="+userid+"&moduleid="+moduleid, function(data)

	{

		$(".profile-middel").html(data);

	});

}

function clear_text(val,id)

{

var id1=val;

var module=id;



if(module=='friend')

{ 

	var amod="friend";

	var amod1="dealasusual";

	var amod2="rightnowdeal";

	var amod3="favbusiness";

}

$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:id1,moduleid:module},function(data)

{

	$(".profile-middel").html(data);

	$('#'+amod).addClass("active");

	$('#'+amod1).removeClass("active");

	$('#'+amod2).removeClass("active");

	$('#'+amod3).removeClass("active");

	$("#div_share").show();

	

});



}

</script>
{/literal}

{if $smarty.get.moduleid neq 'review'}
<div class="live-wire">
  <h1>Live Wire</h1>
  <ul class="reset">
	   <li><a href="javascript:void(0);"  onclick="javascript:viewRightNowDeal(this);" id="rightnowdeal" class="hurryup-deal-new"></a></li>
    <li><a href="javascript:void(0);"  onclick="javascript:viewDealsAsUsual(this);" id="dealasusual"   class="fav-deal-new"></a></li>
 
    <li><a href="javascript:void(0);"  onclick="javascript:viewFriends(this);" id="friend"  class="friends-deal"></a></li>
    <li><a href="javascript:void(0);"  onclick="javascript:viewFavLocalBusiness(this);" id="favbusiness"  class="local-deal"></a></li>
  </ul>
  <div class="clr"></div>
</div>
{/if}
<input type="hidden" name="txt_id" id="txt_id" value="{if $smarty.get.userid eq ''}{$smarty.session.csUserId}{else}{$smarty.get.userid}{/if}">
<input type="hidden" name="profile_name" id="profile_name" value="my_profile_home">
<input type="hidden" name="id" id="id" value="{$smarty.get.userid}">
<input type="hidden" name="id1" id="id1" value="{$smarty.session.csUserId}">
{if $smarty.get.friendid neq ''}
<input type="hidden" name="txt_friend" id="txt_friend" value="{$smarty.get.friendid}">
{/if}


{if $currentpage eq 'yes' || $smarty.get.moduleid eq 'review'}

  {if  $smarty.get.userid eq $smarty.session.csUserId  || ($smarty.session.csUserTypeId eq '2' && ($profile_feed_setting eq 'public' || $friend_acc.count_friend_acc gt 0)) || ($smarty.session.csUserTypeId eq '3' && ($merchant_setting eq 'public' && $fan_acc.count_fan_acc gt 0))}

    {if $smarty.session.csUserId neq ''}
        
        {if $smarty.get.friendid neq ''}
  <input type="hidden" name="txt_friend" id="txt_friend" value="{$smarty.get.friendid}">
{/if}
<form method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
  <div class="post-comment" id="div_share" style="display:none;">
    <div class="post-txtbox ">
      <input type="text" name="txt_thinking" id="txt_thinking" value="What you have been thinking?"  onBlur="if(this.value=='')this.value='What you have been thinking?'" style="{if $currentpage eq 'yes' || $smarty.get.moduleid eq 'review'} width:349px; {else} width:380px;{/if}"   onClick="if(this.value=='What you have been thinking?')this.value=''" />
      <input type="text" name="txt_link" id="txt_link" value=""  style="width:349px;height:12px;display:none" class="whats-in-mind-textbox" value="Enter your link"  onBlur="if(this.value=='')this.value='Enter your link'" style="{if $currentpage eq 'yes' || $smarty.get.moduleid eq 'review'} width:349px; {else} width:380px;{/if}"  />
    </div>
    <div  id="div_share_photo" style="display:none;margin-left:10px;">
      <div id="right_col">
        <div id="upload_area" style="width:246px;">
          <!--Images Will Be uploaded here for the demo.<br />
                    
                                <br />
                    
                                You can direct them to do any thing you want!<br>
                    
                                No Image uploaded.-->
        </div>
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
        <input type="file" name="filename" id="filename" class="signinput" style="margin-left:8px;" value="" onChange="ajaxUpload(this.form,'{$siteroot}/php_ajax_image_upload/scripts/ajaxupload.php?filename=name&amp;maxSize=9999999999&amp;maxW=200&amp;fullPath={$siteroot}/uploads/temp/&amp;relPath={$siteroot}/uploads/temp/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'images/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" />
      </p>
    </div>
    <div class="fl"> {if $smarty.get.userid eq $smarty.session.csUserId}<a href="javascript:void(0);" onClick="javascript:add_photo();" class="fl pstlink1">&nbsp;</a>{/if} <a href="javascript:void(0);" class="fl pstlink2" onClick="javascript:add_link();"  class="links">&nbsp;</a> </div>
    <div class="fr" style="margin-right:10px">
      <input type="button" name="share" id="share" value="Post" onClick="javascript:onfriend_page({$smarty.get.userid});" class="post-btn" value="Post" style="width:52px"/>
    </div>
    <div class="clr"></div>
  </div>
  <div class="clr"></div>
</form>
{elseif $smarty.get.userid neq '' && $count_friend neq '0'}
            .
<input type="hidden" name="txt_friend" id="txt_friend" value="{$smarty.get.friendid}">
<form method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
  <div class="post-comment" id="div_share" style="display:none;">
    <div class="post-txtbox">
      <input type="text" name="txt_thinking" id="txt_thinking" value="What you have been thinking?"  onBlur="if(this.value=='')this.value='What you have been thinking?'" onClick="if(this.value=='What you have been thinking?')this.value=''" style="{if $currentpage eq 'yes' || $smarty.get.moduleid eq 'review'} width:349px;height:12px; {else}width:380px;{/if}"  />
      <input type="text" name="txt_link" id="txt_link" value=""  style="width:349px;height:12px;display:none"   value="Enter your link"  onBlur="if(this.value=='')this.value='Enter your link'" style="{if $currentpage eq 'yes' || $smarty.get.moduleid eq 'review'} width:349px; {else} width:380px;{/if}"  />
    </div>
    <div  id="div_share_photo" style="display:none;">
      <div id="right_col">
        <div id="upload_area"  style="width:246px;margin-left:10px;"> </div>
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
    <div class="fl"> {if $smarty.get.userid eq $smarty.session.csUserId}<a href="javascript:void(0);" onClick="javascript:add_photo();" class="fl pstlink1">&nbsp;</a>{/if} <a href="javascript:void(0);" class="fl pstlink2" onClick="javascript:add_link();"  class="links">&nbsp;</a> </div>
    <div class="fr" style="margin-right:10px">
      <input type="button" name="share" id="share" value="Post" onClick="javascript:onfriend_page({$smarty.get.userid});" class="post-btn" value="Post" style="width:52px"/>
    </div>
    <div class="clr"></div>
  </div>
  <div class="clr"></div>
</form>
{/if}

{/if}
{/if}


{if $smarty.get.moduleid eq 'friend' || $smarty.get.moduleid eq 'favlocalbusiness'}
<input type="hidden" name="module" id="module" value="{$smarty.get.moduleid}">
<div class="main-comment-wall">
  <ul class="reset wall-comm-list">
    {section name=i  loop=$user_activity }
    
    {if $user_activity[i].msg neq ''}
    {if $user_activity[i].uid eq $user_activity[i].fid and $user_activity[i].wall eq '1' and $user_activity[i].vault eq '' and $smarty.get.moduleid eq 'friend' and $user_activity[i].uid neq $smarty.session.csUserId}
    
    {else}
  <li onmouseover="javascript:show_button12({$smarty.section.i.index});" onmouseout="javascript:show_button21({$smarty.section.i.index});" >
    <div class="user-wall">
      <div class="user-wall-lft fl">
        <div class="user-frd-photo fl"> <img  src="{if $user_activity[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.userid neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}" width="50" height="50" alt="" title=""  /> </div>
      </div>
      <div class="user-wall-rgt fr">
        <div class="post-bg">
          <div class="post-bg-top"> <a {if $user_activity[i].usertypeid eq 2}  href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" {elseif $user_activity[i].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile"  {/if}  class="fl live-wire-user-names">{if $user_activity[i].usertypeid eq 2}{$user_activity[i].first_name|ucfirst} {$user_activity[i].last_name|ucfirst}{else}{$user_activity[i].business_name|ucfirst} {/if}</a>
            <p class="fl" style="line-height:34px;">{$user_activity[i].timestamp|date_format:"%e %B %Y | %I:%M %p "} </p>
          </div>
          <div>
          <div class="post-bg-mid fl">
            <div style="height:10px; width:10px; display:block" class="fr"><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close1_{$smarty.section.i.index}" id="btn_close1_{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px;" onclick="deleteComment(this,{ $user_activity[i].msg_id})"></div>
            <p class="fl" style="margin-right:6px"> {if $user_activity[i].uid neq $user_activity[i].fid}
              
              
              {if $user_activity[i].vault_t eq 'status' && $user_activity[i].wall eq '1'}
              
              {if $user_activity[i].fid neq $smarty.session.csUserId}
              
              { if $user_activity[i].usertypeid eq 2 } <a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="live-wire-user-names">{$user_activity[i].first_name|ucfirst} { $user_activity[i].last_name|ucfirst }</a> { elseif $user_activity[i].usertypeid eq 3 } <a href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile" class="live-wire-user-names">{ $user_activity[i].business_name|ucfirst }</a> {/if} Posted On 
              
              { if $user_activity[i].utypeid eq 2 } <a href="{$siteroot}/my-account/{$user_activity[i].uuserid}/my_profile" class="live-wire-user-names"> { $user_activity[i].fname|ucfirst } {$user_activity[i].lname|ucfirst}'s </a> {elseif $user_activity[i].utypeid eq 3} <a href="{$siteroot}/merchant-account/{$user_activity[i].uuserid}/merchant_profile" class="live-wire-user-names">{ $user_activity[i].bname|ucfirst }'s</a> { /if} LiveWire
              <!--|{$user_activity[i].timestamp}-->
              {/if}
              
              {/if}
              
              {/if}
              
              
              {if $user_activity[i].vault_t eq 'link'} <a href="{$user_activity[i].msg}" target="_blank" >{$user_activity[i].msg}</a>{else}{$user_activity[i].msg}{/if}

             <!-- {if $user_activity[i].vault_t eq 'album'}
				<br>
				<img src="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" >
			{/if}
              -->
              
              {if $user_activity[i].vault neq '' && $user_activity[i].vault neq 0}
              </p>
              
              <div class="clr"></div>
            <p style="padding-top:10px;"> {if $user_activity[i].vault_t eq 'deal' || $user_activity[i].vault_t eq 'buy_deal'} <a href="{$siteroot}/uploads/deal/{$user_activity[i].vault}" rel="lightbox"><img src="{$siteroot}/uploads/deal/{$user_activity[i].vault}"  title="" alt="" width="150" height="150" /></a> 
			{elseif $user_activity[i].vault_t eq 'profile_img'}
					 <a href="{$siteroot}/uploads/user/{$user_activity[i].vault}" target="_blank" rel="lightbox"><img src="{$siteroot}/uploads/user/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /></a> 
			{elseif $user_activity[i].vault_t eq 'album'}
				<a href="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" rel="lightbox"><img src="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /></a>
			{else}
            <div  class="single"> <a href="{$siteroot}/uploads/album/photo/400X300/{$user_activity[i].vault}" rel="lightbox"><img src="{$siteroot}/uploads/user/{$user_activity[i].vault}"   title="" alt="" width="150" height="150" /></a></div>
            {/if}
            </p>
            {/if} 
            
            <div class="clr"></div>
            </div>
            
            
            <div class="clr"></div>
            </div>
          <div class="post-bg-btm">
            <div class="user-com"> <a id="link_comment" href="javascript:void(0);" onclick="viewComment(this,{$smarty.section.i.index},{$user_activity[i].msg_id});"  class="fl commenttxt">Comment</a><span class="fl">.</span> <a href="javascript:void(0);" {if $user_activity[i].vault eq '' } onclick=share_comment(this,{$user_activity[i].msg_id},'no_image','{$user_activity[i].uid}'){else} onclick=share_comment(this,{$user_activity[i].msg_id},'{$user_activity[i].vault}','{$user_activity[i].uid}') {/if}  class="fl commenttxt">Share</a><span class="fl">.</span>
              <!-- <a  href="javascript:void(0);" onclick="cheers(this,{$user_activity[i].msg_id},'{$smarty.session.csUserId}')" class="fl">Cheer ({$user_activity[i].count_cheer})</a> -->
              {if $user_activity[i].count_cheer1 gt 0}
              <div class="fl " style="width:80px"><a href="javascript:void(0);"  class="commenttxt fl">Cheered</a>
                <p style="line-height:26px;" class="fl">({$user_activity[i].count_cheer})</p>
                </div>
              {section name=c loop=$cheer[i]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer[i][0].usertypeid eq 2}<a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile"> {$cheer[i][0].fullname}</a>{else if $cheer[i][0].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a>{/if}
              
              {if $cheer[i][1].fullname neq '' || $cheer[i][1].business_name neq ''}and{/if} 
              
              {if $cheer[i][1].usertypeid eq 2}<a  style=" margin-left: 5px;" href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].fullname}</a> {elseif $cheer[i][1].usertypeid eq 3}<a style=" margin-left: 5px;" href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a>{/if}
              
              {if $user_activity[i].count_cheer gt 2}and<a style=" margin-left: 5px;" href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);">others </a>{/if} cheered this 
              
              {/if}
              
              {/section}
              
              {else} <a href="javascript:void(0);" onclick="cheers(this,{$user_activity[i].msg_id},'{$smarty.session.csUserId}')" class="cheer fl">Cheer</a>
              <p  style="line-height:26px;" class="fl">({$user_activity[i].count_cheer})</p>
              {section name=c loop=$cheer[i]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer[i][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][0].fullname}</a>{else if $cheer[i][0].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a>{/if}
              
              {if $cheer[i][1].fullname neq '' || $cheer[i][1].business_name neq ''}and{/if} 
              
              {if $cheer[i][1].usertypeid eq 2}<a style=" margin-left: 5px;" href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].fullname}</a>{elseif $cheer[i][1].usertypeid eq 3}<a style=" margin-left: 5px;" href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a>{/if}
              
              
              
              {if $user_activity[i].count_cheer gt 2}and <a style=" margin-left: 5px;" href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=400&modal=false', tb_pathToImage);">others </a>{/if}
              <!--cheered this -->
              {/if}
              
              {/section}
              
              {/if}
              <!-- <p>cheered this</p>-->
              <div class="clr"></div>
            </div>
            <!--<pre>{$sub[i]|print_r}-->
            <div>
              <ul class="reset">
                {section name=j  loop=$sub[i]}
                { if $sub[i][j].parent_id eq $user_activity[i].msg_id }
                <li {if $smarty.get.moduleid eq 'review'} class="shared reset" {elseif $smarty.section.j.last eq '1'} class="shared reset" {else} class="sub" {/if } onmouseover="javascript:show_button({$smarty.section.j.index},{$smarty.section.i.index});" onmouseout="javascript:show_button1({$smarty.section.j.index},{$smarty.section.i.index});">
                <div class="main-wall">
                  
                  <div class="fl">
                  <div class="wall-img-lft fl"> <img src="{if $sub[i][j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.userid neq ''}{$sub[i][j].photo}{else}{$sub[i][j].photo}{/if}{/if}"  width="50" height="50" alt="" title=""  /> </div>
                  <div class="wall-info-rgt fl">
                    <div> <a {if $user_activity[i].usertypeid eq 2}  href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" {elseif $user_activity[i].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile"  {/if}   target="_blank" class="fl">{if $sub[i][j].usertypeid eq 2}{$sub[i][j].first_name} {$sub[i][j].last_name}{else if $sub[i][j].usertypeid eq 3}{$sub[i][j].business_name}{/if}</a> <span class="fl">{$sub[i][j].timestamp|date_format:"%e %B %Y | %I:%M %p "} </span>
                      <div class="clr"></div>
                    </div>
                    <p>{$sub[i][j].msg}</p>
                    {if $sub[i][j].vault neq ''}
                    <p><img src="{$siteroot}/uploads/user/{$sub[i][j].vault}" title="" alt="" height="160" width="160" /></p>
                    {/if} </div>
                  <div class="clr"></div>
                  
                  </div>
                  
                  <div style="height:10px; width:10px" class="fr"><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px; " onclick="deleteComment(this,{ $sub[i][j].msg_id})"  ></div>
                  
                  <div class="clr"></div>
                </div>
                </li>
                {/if}
                {/section}
                <div id="show_thread_{$smarty.section.i.index}" class="profile-middel"></div>
              </ul>
              <div class="clr"></div>
            </div>
            <div class="clr"></div>
          </div>
        </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
    </li>
    {/if}
    {/if}         
    {sectionelse}
    <div class="error" align="center" >No Record Found.</div>
    {/section}
  </ul>
  <div class="clr"></div>
</div>
{elseif $smarty.get.moduleid eq 'dealsasusual' || $smarty.get.moduleid eq 'rightnowdeal'}
<input type="hidden" name="module" id="module" value="{$smarty.get.moduleid}">
<div class="offer-deal-mer">
  <ul class="reset mer-deal-list">
    {if $cnt_implode1 gt 0}
    
    {section name=k  loop=$deal }
    
    
    
    {if $deal[k].deal_unique_id neq ''}
    <li>
      <div class="mer-offer-deal">
        <div class="mer-offer-deal-lft fl"> <img src="{if $deal[k].deal_image eq '' }{$siteroot}/templates/default/images/no_image.jpg{else}{$siteroot}/uploads/deal/thumbnail/{$deal[k].deal_image}{/if}" width="80" height="80" alt="" title="" /> </div>
        <div class="mer-offer-deal-rgt fr">
          <div>
            <div class="fl">
              <h1 class="fl mer-title"><a style="float:left;margin-right:8px; width:170px" href="{$siteroot}/merchant-account/{$deal[k].userid}/merchant_profile" >{$deal[k].business_name|ucfirst}</a></h1>
			 <a href="{$siteroot}/merchant-account/{$deal[k].id}/view_search_merchant_cat"><p class="fl mer-txt" style="color:#F9532C">&nbsp;{$deal[k].category|substr:0:24|html_entity_decode|ucfirst}</p></a> <br>
             
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
                <button class="ratebtn" > <span class="ratebtn-lft"><span class="ratebtn-rgt">{$deal[k].discount_in_per}% OFF</span></span> </button>
              </div>
              <p class="fl">on <b><a {if $smarty.get.userid eq $smarty.session.csUserId } href="{$siteroot}/buy/{$deal[k].deal_unique_id}/" target="_blank" {else} href="javascript:void(0);"{/if} style="color:#044EA2">{$deal[k].deal_title|html_entity_decode}</a></b></p>
              <div class="clr"></div>
              <!-- <p>{$deal[k].offer_details|html_entity_decode|ucfirst}</p>-->
            </div>
          </div>
          <div class="date-txt">
            <p>{$deal[k].posted_date|date_format:"%e %B %Y | %I:%M %p "}</p>
            <div class="grey-btm-box"> <a href="javascript:void(0);"  onclick="share_comment1(this,'{$deal[k].deal_title}','{$deal[k].deal_image}','{$deal[k].merchant_id}','{$deal[k].deal_unique_id}')" class="fl">Share</a><span class="fl">.</span> {if  $deal[k].count_cheer1 gt 0} <a href="javascript:void(0);"  class="fl">Cheered</a>
              <p style="line-height:23px;" class="fl" >({$deal[k].count_cheer})</p>
              {section name=c loop=$cheer1[k]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer1[k][0].usertypeid eq 2}<a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer1[k][0].fullname}</a>{else if $cheer1[k][0].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer1[k][0].userid}/merchant_profile">{$cheer1[k][0].business_name}</a> {/if}
              
              {if $cheer1[k][1].fullname neq '' || $cheer1[k][1].business_name neq ''}and{/if}{if $cheer1[k][1].usertypeid eq 2}<a style=" margin-left: 5px;" href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer1[k][1].fullname}</a>{elseif $cheer1[k][1].usertypeid eq 3}<a style=" margin-left: 5px;" href="{$siteroot}/merchant-account/{$cheer1[k][0].userid}/merchant_profile">{$cheer1[k][1].business_name}</a> {/if} {if $deal[k].count_cheer gt 2}and<a style=" margin-left: 5px;" href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?dealid={$deal[k].deal_unique_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);"> others</a>{/if} cheered this 
              
              {/if}
              
              {/section}
              
              {else} <a href="javascript:void(0);" onclick="cheers(this,'{$deal[k].deal_unique_id}','{$smarty.session.csUserId}')" class="fl">Cheer</a>
              <p class="fl" style="line-height:23px;">({$deal[k].count_cheer})</p>
              {section name=c loop=$cheer1[k]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer1[k][0].usertypeid eq 2}<a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile">{$cheer1[k][0].fullname}</a>{else if $cheer1[k][0].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer1[k][0].userid}/merchant_profile">{$cheer1[k][0].business_name}</a> {/if}
              {if $cheer1[k][1].fullname neq '' || $cheer1[k][1].business_name neq ''}and{/if} 
              
              {if $cheer1[k][1].usertypeid eq 2}<a   href="{$siteroot}/my-account/{$cheer1[k][0].userid}/my_profile" style=" margin-left: 5px;">{$cheer1[k][1].fullname}</a>{elseif $cheer1[k][1].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer1[k][0].userid}/merchant_profile" style=" margin-left: 5px;">{$cheer1[k][1].business_name}</a> {/if}
              {if $deal[k].count_cheer gt 2}and<a style=" margin-left: 5px;" href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?dealid={$deal[k].deal_unique_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);" style=" margin-left: 5px;"> others</a>{/if} cheered this 
              
              {/if}
              
              {/section}
              
              {/if}
              <div class=" clr"></div>
            </div>
          </div>
        </div>
        <div class="clr"></div>
      </div>
    </li>
    {/if}
    {sectionelse}
    <div class="error" align="center" >No Record Found.</div>
    {/section}
    
    {else}
    <div class="error" align="center" >No Record Found.</div>
    {/if}
    <div id="show_thread_{$smarty.section.k.index}"></div>
  </ul>
</div>
{elseif $smarty.get.moduleid eq 'review'}
<input type="hidden" name="module" id="module" value="{$smarty.get.moduleid}">
<div class="main-comment-wall">
  <ul class="reset wall-comm-list">
    {if  $smarty.get.userid eq $smarty.session.csUserId  || ($smarty.session.csUserTypeId eq '2' && ($profile_feed_setting eq 'public' || $friend_acc.count_friend_acc gt 0)) || ($smarty.session.csUserTypeId eq '3' && ($merchant_setting eq 'public' && $fan_acc.count_fan_acc gt 0))}
    
    {section name=i  loop=$user_activity }
    { if $user_activity[i].userid neq '' }
    <li  {if $user_activity[i].count_sub gt 0 } class="sub" {else} class="shared reset" {/if}  onmouseover="javascript:show_button12('{$smarty.section.i.index}');" onmouseout="javascript:show_button21('{$smarty.section.i.index}');">
    <div class="user-wall">
      <div class="user-wall-lft fl">
        <div class="user-frd-photo fl"> <img  src="{if $user_activity[i].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/50X50/{if $smarty.get.userid neq ''}{$user_activity[i].photo}{else}{$user_activity[i].photo}{/if}{/if}"  alt="" title=""  /> </div>
      </div>
      <div class="user-wall-rgt fr">
        <div class="post-bg">
          <div class="post-bg-top"> <a href="javascript:void(0);" class="fl live-wire-user-names">{$user_activity[i].first_name} {$user_activity[i].last_name}</a> <p class="fl" style="line-height:34px;">{$user_activity[i].timestamp}  </p> </div>
          <div class="post-bg-mid">
            <div style="height:10px; width:10px" class="fr"><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close1_{$smarty.section.i.index}" id="btn_close1_{$smarty.section.i.index}"  style="display:none;background-color:Transparent;border:0px; " onclick="deleteComment(this,{ $user_activity[i].msg_id})"  ></div>
            <p class="fl"> {if $user_activity[i].vault_t  eq 'status'  && $user_activity[i].wall eq '1'}
              
              {if $smarty.get.userid eq $smarty.session.csUserId}
              {if $user_activity[i].fid neq $smarty.session.csUserId}
              
              {if $user_activity[i].usertypeid eq 2} <a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="live-wire-user-names"> {$user_activity[i].first_name|ucfirst} {$user_activity[i].last_name|ucfirst}</a> {elseif $user_activity[i].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile"> {$user_activity[i].business_name|ucfirst}</a> {/if} Posted On 
              
              {if $user_activity[i].utypeid eq 2} <a href="{$siteroot}/my-account/{$user_activity[i].uuserid}/my_profile" class="live-wire-user-names"> {$user_activity[i].fname|ucfirst} {$user_activity[i].lname|ucfirst}'s</a> {elseif $user_activity[i].utypeid eq 3} <a href="{$siteroot}/merchant-account/{$user_activity[i].uuserid}/merchant_profile" class="live-wire-user-names"> {$user_activity[i].bname|ucfirst}'s</a> {/if} LiveWire <br>
              {/if}
              {else}
              {if $user_activity[i].fid eq $smarty.session.csUserId}
              
              {if $user_activity[i].usertypeid eq 2} <a href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" class="live-wire-user-names"> {$user_activity[i].first_name|ucfirst} {$user_activity[i].last_name|ucfirst}</a> {elseif $user_activity[i].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile" class="live-wire-user-names"> {$user_activity[i].business_name|ucfirst}</a> {/if} Posted On 
              
              {if $user_activity[i].utypeid eq 2} <a href="{$siteroot}/my-account/{$user_activity[i].uuserid}/my_profile" class="live-wire-user-names"> {$user_activity[i].fname|ucfirst} {$user_activity[i].lname|ucfirst}'s</a> {elseif $user_activity[i].utypeid eq 3} <a href="{$siteroot}/merchant-account/{$user_activity[i].uuserid}/merchant_profile" class="live-wire-user-names"> {$user_activity[i].bname|ucfirst}'s</a> {/if} LiveWire <br>
              {/if}
              {/if}
              {/if}
              
              {if $user_activity[i].vault_t eq 'link'} <a href="{$user_activity[i].msg}" target="_blank" >{$user_activity[i].msg}</a>{else}{$user_activity[i].msg}{/if}</p>

			<!-- {if $user_activity[i].vault_t eq 'album'}
				<br>
				<br>
				<img class="fl"  src="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" >
			{/if}-->
              
            {if $user_activity[i].vault neq '' && $user_activity[i].vault neq 0}
            
            <div class="clr"></div>
            <p style="padding-top:10px;"> {if $user_activity[i].vault_t eq 'deal' || $user_activity[i].vault_t eq 'buy_deal'} <a target="_blank" href="{$siteroot}/uploads/album/photo/400X300/{$user_activity[i].vault}" rel="lightbox"><img src="{$siteroot}/uploads/deal/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /></a>  {elseif $user_activity[i].vault_t eq 'album'}<a href="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" target="_blank" rel="lightbox"><img src="{$siteroot}/uploads/album/photo/thumbnail/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /></a>
			{elseif $user_activity[i].vault_t eq 'profile_img'}
					 <a href="{$siteroot}/uploads/user/{$user_activity[i].vault}" target="_blank" rel="lightbox"><img src="{$siteroot}/uploads/user/thumbnail/{$user_activity[i].vault}" title="" alt="" /></a> 
			{else}
			 <a href="{$siteroot}/uploads/album/photo/400X300/{$user_activity[i].vault}" target="_blank" rel="lightbox"><img src="{$siteroot}/uploads/user/{$user_activity[i].vault}" title="" alt="" width="150" height="150" /></a> {/if} </p>
            {/if} 
            
            <div class="clr"></div>
            </div>
          <div class="post-bg-btm"> {if $smarty.get.userid eq $smarty.session.csUserId || $count_friend_ornot gt 0 || $count_fan_or_not gt 0}
            <div class="user-com"> 
            <a id="link_comment" href="javascript:void(0);" onclick="viewComment(this,{$smarty.section.i.index},{$user_activity[i].msg_id});"  class="fl commenttxt">Comment</a>
            <span class="fl">.</span> <a href="javascript:void(0);"  href="javascript:void(0);" {if $user_activity[i].vault eq '' } onclick=share_comment(this,{$user_activity[i].msg_id},'no_image','{$smarty.get.userid}'){else} onclick=share_comment(this,{$user_activity[i].msg_id},'{$user_activity[i].vault}','{$smarty.get.userid}') {/if}  class="fl commenttxt">Share</a>
            <span class="fl">.</span>
              <!-- <a  href="javascript:void(0);" onclick="cheers(this,{$user_activity[i].msg_id},'{$smarty.session.csUserId}')" class="fl">Cheer ({$user_activity[i].count_cheer})</a> -->
              {if $user_activity[i].count_cheer1 gt 0}
              <div class="fl" style="width:80px"><a href="javascript:void(0);"  class="commenttxt fl">Cheered</a>
                <p  style="line-height:26px;" class="fl">({$user_activity[i].count_cheer})</p>
              </div>
              {section name=c loop=$cheer[i]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer[i][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][0].fullname}</a> {else if $cheer[i][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a> {/if}
              
              {if $cheer[i][1].fullname neq '' || $cheer[i][1].business_name neq ''}and{/if} 
              
              {if $cheer[i][1].usertypeid eq 2}<a style=" margin-left: 5px;"  class="fl" href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].fullname}</a> {elseif $cheer[i][1].usertypeid eq 3}<a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a> {/if}
              {if $user_activity[i].count_cheer gt 2}and<a style=" margin-left: 5px;" href="javascript:void(0);" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);">others </a>{/if} cheered this 
              
              {/if}
              
              {/section}
              
              {else}<a href="javascript:void(0);" onclick="cheers(this,{$user_activity[i].msg_id},'{$smarty.session.csUserId}')" class="cheer fl">Cheer</a>
              <p style="line-height:26px;" class="fl">({$user_activity[i].count_cheer})</p>
              {section name=c loop=$cheer[i]}
              
              {if $smarty.section.c.iteration lt 2}
              
              
              
              {if $cheer[i][0].usertypeid eq 2} <a   href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][0].fullname}</a> {else if $cheer[i][0].usertypeid eq 3} <a href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][0].business_name}</a> {/if}
              
              {if $cheer[i][1].fullname neq '' || $cheer[i][1].business_name neq ''}and{/if} 
              
              {if $cheer[i][1].usertypeid eq 2}<a style=" margin-left: 5px;"  href="{$siteroot}/my-account/{$cheer[i][0].userid}/my_profile">{$cheer[i][1].fullname}</a> {elseif $cheer[i][1].usertypeid eq 3}<a style=" margin-left: 5px;" href="{$siteroot}/merchant-account/{$cheer[i][0].userid}/merchant_profile">{$cheer[i][1].business_name}</a> {/if}
              
              {if $user_activity[i].count_cheer gt 2}and<a href="javascript:void(0);" style=" margin-left: 5px;" onClick="javascript:tb_show('Cheers For This', '{$siteroot}/modules/my-account/show_cheer_user.php?activityid={$user_activity[i].msg_id}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=300&width=300&modal=false&scrollbars=no', tb_pathToImage);">others </a>{/if} cheered this 
              
              {/if}
              
              {/section}
              
              {/if}
              <!-- <p>cheered this</p>-->
              <div class="clr"></div>
            </div>
            {/if}
            <div >
              <ul class="reset">
                {section name=j  loop=$sub[i]}
                
                { if $sub[i][j].parent_id eq $user_activity[i].msg_id }
                <li onmouseover="javascript:show_button({$smarty.section.j.index},{$smarty.section.i.index});" onmouseout="javascript:show_button1({$smarty.section.j.index},{$smarty.section.i.index});">
                  <div class="main-wall" style="padding-right:15px">
                    
                    <div class="fl">
                    <div class="wall-img-lft fl"> <img src="{if $sub[i][j].photo eq '' }{$siteroot}/templates/default/images/profile_pic.png{else}{$siteroot}/uploads/user/{if $smarty.get.userid neq ''}{$sub[i][j].photo}{else}{$sub[i][j].photo}{/if}{/if}"  width="50" height="50" alt="" title=""  /> </div>
                    <div class="wall-info-rgt fl">
                      <div> <a {if $user_activity[i].usertypeid eq 2}  href="{$siteroot}/my-account/{$user_activity[i].userid}/my_profile" {elseif $user_activity[i].usertypeid eq 3} href="{$siteroot}/merchant-account/{$user_activity[i].userid}/merchant_profile"  {/if}>{$sub[i][j].first_name} {$sub[i][j].last_name}</a><span >{$sub[i][j].timestamp} </span>
                        <div class="clr"></div>
                      </div>
                      <p>{$sub[i][j].msg}</p>
                      {if $sub[i][j].vault neq ''}
                      <p><img src="{$siteroot}/uploads/user/{$sub[i][j].vault}" title="" alt="" height="160" width="160" /></p>
                      {/if} </div>
                    <div class="clr"></div>
                    
                    </div>
                    <div style="height:10px; width:10px" class="fr"><img src="{$siteroot}/templates/default/images/btn_close.png" name="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" id="btn_close_{$smarty.section.j.index}{$smarty.section.i.index}" style="display:none;background-color:Transparent;border:0px;" onclick="deleteComment(this,{ $sub[i][j].msg_id})"    ></div>
                     <div class="clr"></div>
                  </div>
                </li>
                {/if}
                {/section}
                <div id="show_thread_{$smarty.section.i.index}" class="profile-middel"></div>
              </ul>
              <div class="clr"></div>
            </div>
            <div class="clr"></div>
          </div>
        </div>
        <div class="clr"></div>
      </div>
      <div class="clr"></div>
    </div>
    <div class="clr"></div>
    </li>
    {/if}             
    {sectionelse}
    <div class="error" align="center" >No Record Found.</div>
    {/section}
    
    {else}
    <div class="error" align="center" style="margin-top:80px;height:400px;">User has restricted this area as private</div>
    {/if}
  </ul>
  <div class="clr"></div>
</div>
{/if}