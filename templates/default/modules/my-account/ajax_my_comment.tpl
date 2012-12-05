
{strip}
<script src="{$sitejs}/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>


{/strip}
{literal}
<script type="text/javascript" language="JavaScript">

function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if(charCode==13)
	{
		//alert("in keypress");
		var parentid = '{/literal}{$smarty.get.parentid}{literal}';
		insertComment(this,parentid);
		return true;
	}
	else
	{
		 return true;
	}
//     if (charCode > 31 && (charCode < 48 || charCode > 57))
//     return false;

   
}
function isNumberKey1(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if(charCode==13)
	{
		//alert("in keypress");
		var dealid = '{/literal}{$smarty.get.dealid}{literal}';
		insertComment_deal(this,dealid);
		return true;
	}
	else
	{
		 return true;
	}
//     if (charCode > 31 && (charCode < 48 || charCode > 57))
//     return false;

   
}
function deleteComment_box(id,module)
{
	var cmt_url1 = SITEROOT+"/modules/my-account/ajax_my_review.php";
			jQuery.get(cmt_url1,{userid:id,moduleid:module},function(data){
					$(".profile-middel").html(data);
				});
}
function insertComment(obj,id)
	{
	
		var module=document.getElementById("module").value;

		if(module=='dealsasusual'){
			var amod="dealsasusual";
			var amod1="rightnowdeal";
			var amod2="favbusiness";
			var amod3="friend";
		}
		else if(module=='rightnowdeal') {
			var amod="rightnowdeal";
			var amod1="dealsasusual";
			var amod2="favbusiness";
			var amod3="friend";

		}else if(module=='favlocalbusiness') {
			var amod="favlocalbusiness";
			var amod1="dealsasusual";
			var amod2="rightnowdeal";
			var amod3="friend";
		}else if(module=='friend'){ 
			var amod="friend";
			var amod1="dealsasusual";
			var amod2="rightnowdeal";
			var amod3="favbusiness";
		}

		var val=$.trim(document.getElementById("txt_thinking1").value);

		if(val)
		{
			var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
			var cmt_url = SITEROOT+"/modules/my-account/ajax_insert_comment.php";
			jQuery.get(cmt_url,{userid:d,parentid:id,thinking:val},function(data){
			var cmt_url1 = SITEROOT+"/modules/my-account/ajax_my_review.php";
			jQuery.get(cmt_url1,{userid:d,moduleid:module},function(data){
					$(".profile-middel").html(data);
					$('#'+amod).addClass("active");
					$('#'+amod1).removeClass("active");
					$('#'+amod2).removeClass("active");
					$('#'+amod3).removeClass("active");

				});
			});
		}else{ alert("Please enter comments !");  }

	} 
function insertComment_deal(obj,id,moduleid)
	{

alert(id);
		var module=document.getElementById("module").value;

		if(module=='dealsasusual'){
			var amod="dealsasusual";
			var amod1="rightnowdeal";
			var amod2="favbusiness";
			var amod3="friend";
		}
		else if(module=='rightnowdeal') {
			var amod="rightnowdeal";
			var amod1="dealsasusual";
			var amod2="favbusiness";
			var amod3="friend";

		}else if(module=='favlocalbusiness') {
			var amod="favlocalbusiness";
			var amod1="dealsasusual";
			var amod2="rightnowdeal";
			var amod3="friend";
		}else if(module=='friend'){ 
			var amod="friend";
			var amod1="dealsasusual";
			var amod2="rightnowdeal";
			var amod3="favbusiness";
		}

		var val=$.trim(document.frm_comment.txt_thinking.value);

		if(val)
		{
				
				if(document.frm_comment.txt_thinking.value !="")
				{
					var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
				
					cmt_url = SITEROOT+"/modules/my-account/ajax_insert_comment.php";
					jQuery.get(cmt_url,{userid:d,dealid:id,thinking:val},function(data){
						$.get(SITEROOT+"/modules/my-account/ajax_my_review.php",{userid:d,moduleid:module},function(data){
							$(".profile-middel").html(data);
							$('#'+amod).addClass("active");
							$('#'+amod1).removeClass("active");
							$('#'+amod2).removeClass("active");
							$('#'+amod3).removeClass("active");

						});
					});
				}
		}else{ alert("Please enter comments !");  }


	} 
</script>
{/literal}

<form name="frm_comment" id="frm_comment" method="POST">
 <input type="hidden" name="txt_module" id="txt_module" value="{$smarty.get.moduleid}">
 <input type="hidden" name="txt_parent" id="txt_parent" value="{$smarty.get.parentid}">
<div class="whats-in-mind" id="comment_div" name="comment_div" {if $smarty.get.profilename eq 'my_profile'} style="height:28px;maggin-top:5px;" {elseif $smarty.get.profilename eq 'my_profile_home'} style="height:28px;maggin-top:5px;" {/if}  >
 <li>
	<div class="frd-comm">
	<input type="text"  name="txt_thinking1" id="txt_thinking1"   style={if $currentpage eq 'no'}width:345px; {else}width:370px;{/if}padding-top:3px;margin: 0 auto 0px;height:7px;"  />
	</div>
</li>
<li>
	<div class="fr" style="margin-right:10px">
	<input type="button" name="submit_share" id="submit_share"  {if $smarty.get.parentid neq ''} onclick="insertComment(this,'{$smarty.get.parentid}');" {elseif $smarty.get.dealid neq ''} onclick="insertComment_deal(this,'{$smarty.get.dealid}');" {/if}  class="post-btn" value="Post" style="width:52px"/>
	</div>
</li>
</div>
</form>
