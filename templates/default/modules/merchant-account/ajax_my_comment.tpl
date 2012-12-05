{strip}
<script type="text/javascript" src="{$sitejs}/validation/validate_comment.js"></script>
{/strip}
{literal}
<script type="text/javascript" language="JavaScript">
function deleteComment_box(id,module)
{

	var cmt_url1 = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url1,{userid:id,moduleid:module},function(data){
					$("#show_thread").html(data);
				});
}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if(charCode==13)
	{
		
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
function isNumberKey12(evt)
{

    var charCode = (evt.which) ? evt.which : evt.keyCode
    if(charCode==13)
	{
		
		var review_id = '{/literal}{$smarty.get.review_id}{literal}';
		insertComment_review(this,review_id);
		return true;
	}
	else
	{
		 return true;
	}
//     if (charCode > 31 && (charCode < 48 || charCode > 57))
//     return false;

   
}
function insertComment(obj,id)
	{

		var val=$.trim(document.getElementById("txt_thinking1").value);
		if(val && val!="Add Comment")
		{

			var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
			var dmid='{/literal}{$smarty.get.dmid}{literal}';

			cmt_url = SITEROOT+"/modules/merchant-account/ajax_insert_comment.php";
			jQuery.get(cmt_url,{userid:d,parentid:id,thinking:val},function(data){
			//page reload
			cmt_url2 = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url2,{userid:d,moduleid:dmid},function(data)
			{
				jQuery("#show_thread").html(data);
				$('#div_share').hide();
			});
			//window.location.reload();
			});
		}else {alert("Please enter the comment !")}

	} 
function insertComment_review(obj,id)
	{

		var val=$.trim(document.getElementById("txt_thinking1").value);
		if(val && val!="Add Comment")
		{

			var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
			var dmid='{/literal}{$smarty.get.dmid}{literal}';

			cmt_url = SITEROOT+"/modules/merchant-account/ajax_insert_comment.php";
			jQuery.get(cmt_url,{userid:d,review_id:id,thinking:val},function(data){
			//page reload
			cmt_url2 = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url2,{userid:d,moduleid:dmid},function(data)
			{
				jQuery("#show_thread").html(data);
				$('#div_share').hide();
			});
			//window.location.reload();
			});
		}else {alert("Please enter the comment !")}

	} 
function insertComment_deal(obj,id)
	{
		var val=$.trim(document.getElementById("txt_thinking1").value);

		if(val !="" && val!="Add Comment")
		{
			var d='{/literal}{if $smarty.get.userid eq ''}{ $smarty.session.csUserId }{else}{ $smarty.get.userid }{/if}{literal}';
			var dmid='{/literal}{$smarty.get.dmid}{literal}';


			cmt_url = SITEROOT+"/modules/merchant-account/ajax_insert_comment.php";
			jQuery.get(cmt_url,{userid:d,dealid:id,thinking:val},function(data){
			//page reload

			cmt_url2 = SITEROOT+"/modules/merchant-account/ajax_my_review.php";
			jQuery.get(cmt_url2,{userid:d,moduleid:dmid},function(data)
			{
				jQuery("#show_thread").html(data);
				$('#div_share').hide();
			});
			
			//window.location.reload();
			});
		}else {alert("Please enter the comment !")}
	}</script>
{/literal}

<!--<form name="frm_comment" id="frm_comment" method="POST">-->
	<!--<div class="whats-in-mind" style="height:28px;maggin-top:5px;"  >
		<input type="text" name="txt_thinking1" id="txt_thinking1"  class="whats-in-mind-textbox" style="width:375px;padding-top:3px;margin: 0 auto 0px;"/>
		<div class="fr">
		<span class="share-btn-lft"><span class="share-btn-rgt">

			<input class="share-btn " type="button" name="submit_share" id="submit_share" value="Post" onclick="{if $smarty.get.parentid neq ''}insertComment(this,{$smarty.get.parentid}){elseif $smarty.get.dealid neq ''} insertComment_deal(this,{$smarty.get.dealid}){elseif  $smarty.get.review_id neq ''} insertComment_review(this,{$smarty.get.review_id}){/if};">

 </span></span>
		<span class="share-btn-lft" style="margin-left:5px;margin-right:5px;"><span class="share-btn-rgt" >
			<input class="share-btn " type="button" name="submit_share" id="submit_share" value="Cancel" onclick="deleteComment_box('{ $smarty.get.userid}','{$smarty.get.dmid}')" > </span></span>
		</div>
<div class="error" htmlfor="txt_thinking" generated="true"></div>
		<div class="clr"></div>
	</div>-->
<!--</form>-->


 						<li>
                            <div class="frd-comm">
								<input type="text" name="txt_thinking1" id="txt_thinking1"  class="whats-in-mind-textbox"  value="Add Comment" onfocus="if(this.value=='Add Comment')this.value=''" onblur="if(this.value=='')this.value='Add Comment'"/>

                            </div>
                        </li>

                          <li>

 							<div class="fr" style="margin-right:10px">
							 <input class="post-btn" type="button" name="submit_share" id="submit_share" value="Cancel" onclick="deleteComment_box('{ $smarty.get.userid}','{$smarty.get.dmid}')" >
                            </div>


                            <div class="fr" style="margin-right:10px">
							   <input class="post-btn" type="button" name="submit_share"  style="width:52px" id="submit_share" value="Post" onclick="{if $smarty.get.parentid neq ''}insertComment(this,{$smarty.get.parentid}){elseif $smarty.get.dealid neq ''} insertComment_deal(this,{$smarty.get.dealid}){elseif  $smarty.get.review_id neq ''} insertComment_review(this,{$smarty.get.review_id}){/if};">
                            </div>


							<div class="error" htmlfor="txt_thinking" generated="true"></div>
                          </li>