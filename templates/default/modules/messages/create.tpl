{strip}
<link href="{$siteroot}/templates/default/css/basic.css" rel="stylesheet" type="text/css">
<link href="{$siteroot}/templates/default/css/main.css" rel="stylesheet" type="text/css">
<script src="{$sitejs}/jquery-1.4.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}
{literal}
<script language="JavaScript">
jQuery(document).ready(function() {

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
  <div style="color:red;" align="center" >{$msg}</div>
  <input type="hidden" name="userid" id="userid" value="{$user.userid}" />
  <table width="560px" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;" >
    <tr>
      <td align="right" valign="top"  class="creat_message">Subject:<span style="color:red;valign:top;"  >*</span>&nbsp;&nbsp; </td>
      <td><div class="msgsub-textbox" style="margin-left:0px;width:344px;"><input class="msgsub-inpout" name="subject" type="text" id="subject" style="width:350px;height:12px;"/></div>
        <br/>
        <span id='subject_error' style="color:#FF0000"></span></td>
    </tr>
    <div style="color: red;font-size: 12px;"  htmlfor="subject" generated="true"></div>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="top"  class="creat_message"> To:<span style="color:red;valign:top;">*</span>&nbsp;&nbsp; </td>
      <td><input type="hidden" name="to_userid" id="to_userid" value="{$smarty.post.to_userid}">
        {if $smarty.post.to_userid neq ''}
        {$name}	
        {else}
        <select name="to" id="to" class="signinput" style="width: 350px;" >
          
		
			{section name=i loop=$friendd }
					
						
          <option  value="{if $friendd[i].userid neq $smarty.session.csUserId}{$friendd[i].userid}{else}{$friendd[i].friendid}{/if}"> {if $friendd[i].userid neq $smarty.session.csUserId}{$friendd[i].first_name} {$friendd[i].last_name}{else} {$friendd[i].first_name1} {$friendd[i].last_name1}{/if} </option>
          
					
			{/section}
			{section name=j loop=$fan1}
				
          <option value="{$fan[j].userid}">{$fan1[j].business_name}</option>
          	
			{/section}
                 
        </select>
        {/if}<br>
        <span id='to_error' style="color:#FF0000"></span></td>
    </tr>
    <tr>
      <TD>&nbsp;</TD>
    </tr>
    <tr>
      <td align="right" valign="top" class="creat_message">Message:<span style="color:red;valign:top;">*</span> &nbsp;&nbsp;</td>
      <td><div class="msg-textbox" style="margin-left:0px;padding-left:3px;width:349px">
			<textarea class="msg-inpout" name="message" id="message" style="height:120px;width:349px" class="textbox fl" rows="6" cols="47"  onKeyDown="limitText(this.form.message,this.form.countdown,800);" onKeyUp="limitText(this.form.message,this.form.countdown,800);">
        </textarea>
		</div>
        <br/>
        <span style="font-size:11px;">Max. 800 charactors.</span> <span id='message_error' style="color:#FF0000"></span>
        <input readonly type="hidden" name="countdown" size="3" value="800"></td>
    </tr>
    <tr><TD colspan="2"><div style="color: red;font-size: 12px;padding-top:20px" htmlfor="message" generated="true"></div></TD></tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td  align="left">
          <input class="previe-btn" type="Submit" value="Send" name="Submit" id="Submit" />
           </td>
    </tr>
  </table>
</form>