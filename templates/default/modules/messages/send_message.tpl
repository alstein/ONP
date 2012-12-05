{literal}
<script type="text/javascript" src="{/literal}{$siteroot}{literal}/js/selectmenu.js"></script>
<script type="text/javascript">
function backtopage()
{
parent.ajax_checkmessagetype('inbox');
}

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

function check(){
	$('#frmsendmail').validate();
	if($('#frmsendmail').valid()){
			$("#buttonregister").hide();
			$("#buttonregister1").show();
			var subject=jQuery("#subject").val();
			var message=jQuery("#message").val();
			var to_userid=jQuery("#to_userid").val();
			if(to_userid!=""){
				var to=to_userid;
			}else{
				
				var to=jQuery("#to").val();
				//alert(to);	
			}

			$.post(SITEROOT+"/modules/message/messages.php",{subject:subject,message:message,to:to},function(data){
				ajax_checkmessagetype('outbox');
				return true;
			});
		//return str;
	}
}
</script>
<script language="JavaScript">
$(document).ready(function() {

	$('#frmsendmail').validate({
		    errorElement:'div',
		    rules: {
					subject:{
						required: true,
						minlength: 2,
						maxlength: 25
					},
					to:{
						required: true
					},
					message: {
						required: true,
						minlength: 5,
						maxlength: 800
						
					}
		    },
		    messages: {
					subject:{
						required: "Please enter subject",
						minlength: jQuery.format("Enter at least {0} characters."),
						maxlength: jQuery.format("Enter at most {0} characters.")
					},
					to:{
						required: "please Select To User name"
					},
					message:{
						required: "Please enter message",
						minlength: $.format("Enter at least {0} characters"),
						maxlength: $.format("Enter maximum {0} characters")
					}
		},
					success: function(label) {
						// set &nbsp; as text for IE
						label.hide();
					}
        });
});

</script>
{/literal}	

<form name="frmsendmail" id="frmsendmail" action="" method="post">
<input type="hidden" name="userid" id="userid" value="{$user.userid}" />
          <table width="600" border="0" cellspacing="0" cellpadding="0" style="margin-left:30px">
            <tr>
		<td align="right" style="vertical-align:top;width:200px">Subject:<span style="color:red">*</span>&nbsp;&nbsp; </td><td>


				<div class="msgsub-textbox" style="margin-left:7px">
					<input class="msgsub-inpout" name="subject" type="text" id="subject" style="height:12px;" value="{$subject}"/>
					
				</div>
				<div htmlfor="subject" generated="true" class="error" style="padding-left:10px"></div>
<span id='subject_error' style="color:#FF0000"></span>
</td>
            </tr>
	   <!-- <tr><td>&nbsp;</td></tr>-->
	    <tr>
		<td align="right"> To:<span style="color:red">*</span>&nbsp;&nbsp; </td><td>
			<input type="hidden" name="to_userid" id="to_userid" value="{$smarty.post.to_userid}">
		{if $smarty.post.to_userid neq ''}
			<div style="padding-left:33px;margin-top:15px;">{$name}</div>
                {else}
		






		<br>		 
		<select name="to" id="to"  style="width: 350px;margin-left:7px;" > <!--class="select"-->
			<option value="">Select Receiver</option>
			{section name=i loop=$friendd }
					
						<option value="{if $friendd[i].userid neq $smarty.session.csUserId}{$friendd[i].userid}{else}{$friendd[i].friendid}{/if}">

{if $friendd[i].userid neq $smarty.session.csUserId}{$friendd[i].first_name} {$friendd[i].last_name}{else} {$friendd[i].first_name1} {$friendd[i].last_name1}{/if}

</option>
					
			{/section}
			{section name=j loop=$fan1}
				<option value="{$fan[j].userid}">{$fan1[j].business_name}</option>	
			{/section}
                 </select>

		{/if}<br><span id='to_error' style="color:#FF0000"></span></td>
            </tr>
		<tr><TD>&nbsp;</TD></tr>
		<tr><TD colspan="2"><div htmlfor="to" generated="true" class="error" style="padding-left:69px"></div></TD></tr>
		 
	    <tr>
		<td align="right" style="vertical-align:top;"> Message:<span style="color:red">*</span>&nbsp;&nbsp;</td><td style="padding-left:0px;"> 
				
				<div class="msg-textbox" style="margin-left:7px;">
					<textarea class="msg-inpout" name="message" id="message" rows="6" cols="43" style="width:350px;" onKeyDown="limitText(this.form.message,this.form.countdown,800);" 
onKeyUp="limitText(this.form.message,this.form.countdown,800);"></textarea>
				</div><br/>

				<div style="padding-left:36px;">
				<span style="font-size:11px;">Max. 800 charactors.</span></div>
		<span id='message_error' style="color:#FF0000"></span>
<input readonly type="hidden" name="countdown" size="3" value="800">
		</td>
            </tr>
		<tr><TD>&nbsp;</TD></tr>
	    <tr><td colspan="2"><div htmlfor="message" generated="true" class="error" style="padding-left:69px;"></div></td></tr>
 	    <tr>
		<td>&nbsp;</td>
		<td  align="right">

			<div style="margin:15px 0 0 30px;" class="fl" id="buttonregister" >
							<input class="previe-btn" type="button" value="Send" name="Submit" id="Submit" onclick="check();"/>
			</div>
			
			<div style="margin:15px 0 0 30px;display:none" class="fl" id="buttonregister1" >
							<input class="previe-btn" type="button" value="Send"/>
			</div>

<!--				<div id="buttonregister"><span class="sitesub-btn-lft">
					<span class="sitesub-btn-right">
						<input class="loc_busines fl" type="button" value="Send" name="Submit" id="Submit" onclick="check();"/>
					</span>
					</span>
				</div>-->
				<!--<div id="buttonregister1" style="display:none"><span class="sitesub-btn-lft">
					<span class="sitesub-btn-right">
						<input class="loc_busines fl" type="button" value="Send"/>
					</span>
					</span>
				</div>-->

<!--			<span class="sitesub-btn-lft" style="margin-left: 10px;">
			<span class="sitesub-btn-right">
			<input  class="loc_busines fl" type="button" value="Cancel" onclick="backtopage();">
			</span>
			</span>-->

			<div style="margin:15px 0 0 30px;" class="fl" id="buttonregister1" >
							<input  class="previe-btn" type="button" value="Cancel" onclick="backtopage();">
			</div>

		</td>
            </tr>
		<tr><TD  colspan="2">&nbsp;</TD></tr>
          </table>
	</form>