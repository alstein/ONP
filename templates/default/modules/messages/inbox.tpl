{include file=$header_start}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.timeago.js"></script>
<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$sitejs}/lightbox.js"></script>
<script language="javascript" type="text/javascript" src="{$siteroot}/js/calendarDateInput.js"> </script>
<!--<script language="javascript" type="text/javascript" src="{$siteroot}/js/validation/validate_offer_deal.js"> </script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/edituser.js"></script>-->
{/strip}
{literal}
<script type="text/javascript">

function dele()
        {       
		var i=0,p=0;
		var chk=0;
		var del=new Array();
		var outbox=document.frmUploadVault.msgid.length;
 		for(i=0;i<outbox;i++)
		{
			
			if(document.frmUploadVault.msgid[i].checked)
			{
				var chk=1;
				del[p]=document.frmUploadVault.msgid[i].value;
				p++;
                		
       			 }
		}
		var del1=del.join(",");
		if(chk==1 || document.frmUploadVault.msgid.checked )
		{	//alert(del1);
			if(confirm("Really you like to delete this record?"))
                		{
				document.forms["frmUploadVault"].action.value="delete";
				document.forms["frmUploadVault"].del_id.value=del1;
				if(document.frmUploadVault.msgid.checked)
				document.forms["frmUploadVault"].del_id.value=document.frmUploadVault.msgid.value;
                        	document.forms["frmUploadVault"].submit();
                		return true;
                		}
                		else
                		{
                        	return false;
                		}
		}
		if(chk==0 || document.frmUploadVault.msgid.checked==false )
		{	
				alert("Please select checkbox.");
				return false;
		}
	}
	jQuery(document).ready(function()
	{
	jQuery("#checkall").click(function()
 	{
		var checked_status = this.checked;
		jQuery("input[type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	jQuery("input[type=checkbox]").click(function()
 	{
		var i=0;
		var flag=0;
 	        var checked_status = this.checked;
 	        jQuery("input[type=checkbox]").each(function()
		{
		  i++;
		  if(this.checked && i!=1)
		  {
			flag++;
		  }
		  else if(i!=1)
		  {
			flag--;
		  }
		});
		if(flag==(i-1))
		{
		  	jQuery("#checkall").attr('checked',true);
		}else{
  			jQuery("#checkall").attr('checked',false);
		}
		
		change(this);
 	});
	function change(chk)
	{
		var jQuerytr = jQuery(chk).parent().parent();
		if(jQuerytr.attr('id'))
		{
			if(jQuerytr.attr('class')=='selectedrow' && !chk.checked)
				jQuerytr.removeClass('selectedrow').addClass('grayback');
			else
				jQuerytr.removeClass('grayback').addClass('selectedrow');
		}
	}
	$("#msg").fadeOut(5000);
	var strchk=jQuery("#str").val();
	ajax_checkmessagetype(strchk);
	
});
function sendmail()
{
var str=true;
var subject=jQuery("#subject").val();
var message=jQuery("#message").val();
var to_userid=jQuery("#to_userid").val();
if(to_userid!="")
{
var to=to_userid;
}
else
{
var to=jQuery("#to").val();
}

document.getElementById("subject_error").innerHTML="";
document.getElementById("message_error").innerHTML="";

if(document.frmsendmail.subject.value=="")
{
document.getElementById("subject_error").innerHTML="Please enter subject";
str=false;
}

else if((document.frmsendmail.subject.value.length)>25)
{
document.getElementById("subject_error").innerHTML="Please enter maximum 25 character";
str=false;
}
else if((document.frmsendmail.subject.value.length)<2)
{
document.getElementById("subject_error").innerHTML="Please enter minimum 2 charater";
str=false;
}else if(document.frmsendmail.to.value==""){
	document.getElementById("to_error").innerHTML="Select user to send the message";
}else if(document.frmsendmail.message.value=="")
{
document.getElementById("message_error").innerHTML="Please enter message";
str=false;
}
else if((document.frmsendmail.message.value.length)>800)
{
document.getElementById("message_error").innerHTML="Please enter maximum 800 character";
str=false;
}
else if((document.frmsendmail.message.value.length)<5)
{
document.getElementById("message_error").innerHTML="Please enter minimum 5 charater";
str=false;
}
else
{
		jQuery.post(SITEROOT+"/modules/message/messages.php",{subject:subject,message:message,to:to},function(data)
		{
			ajax_checkmessagetype('outbox');
			return true;
			
		});
		return str;
}
}
function replytousermail(to_userid,msg_id)
{
	
	$.post(SITEROOT+'/modules/message/messages.php',{to_userid:to_userid,to:to_userid,mid:msg_id},function(data){
			jQuery("#showdiv").html(data);
			jQuery("#composechk").addClass("active");
			jQuery("#outboxchk").removeClass("active");
			jQuery("#inboxchk").removeClass("active");
			jQuery("#msgtitle").html("Reply To Message");
			
		});
}

function ajax_checkmessagetype(str)
{

	if(str=="compose")
	{
	$.post(SITEROOT+'/modules/message/messages.php',{str:str},function(data){
			jQuery("#showdiv").html(data);
		});
		
		jQuery("#composechk").addClass("active");
		jQuery("#outboxchk").removeClass("active");
		jQuery("#inboxchk").removeClass("active");
		jQuery("#msgtitle").html("Compose Message");
		
	}
	else if(str=="outbox")
	{
		$.post(SITEROOT+'/modules/message/outbox.php',{str:str},function(data){
			jQuery("#showdiv").html(data);
		});
		jQuery("#inboxchk").removeClass("active");
		jQuery("#composechk").removeClass("active");
		jQuery("#outboxchk").addClass("active");
		jQuery("#msgtitle").html("Outbox");
		
	
	}
	else
	{
	
		$.post(SITEROOT+'/modules/message/ajax_inbox.php',{str:str},function(data){
			jQuery("#showdiv").html(data);
		});
		jQuery("#inboxchk").addClass("active");
		jQuery("#outboxchk").removeClass("active");
		jQuery("#composechk").removeClass("active");
		jQuery("#inboxchk").addClass("active");
		jQuery("#msgtitle").html("Inbox");
		
	}
}

function make_unread(mun){
	$.post(SITEROOT+'/modules/message/ajax_inbox.php',{mun:mun},function(data){
		$.post(SITEROOT+'/modules/message/ajax_inbox.php',{str:'inbox'},function(data){ 
			jQuery("#showdiv").html(data);
		});
	});

}
</script>
{/literal}

{include file=$profile_header2}
<!-- main continer of the page -->

 
  <!-- header container starts here-->
  <div id="inner_header">
    <div class="ovfl-hidden">
  
      <!--<div class="help fr">
        <h2><a href="#">Help</a></h2>
      </div>-->
    </div>
  </div>
  <!-- / header container ends here-->
  <!-- main container with changing content -->
  <div id="maincont" class="ovfl-hidden">
    <div class="about-us">
      <h1>Inbox</h1>
      <div class="deal-history">
        <div class="live-wire">
          <h1>&nbsp; </h1>
          <ul class="reset">
            <li><a href="javascript:void(0);" id="inboxchk" onclick="ajax_checkmessagetype('inbox')" class="inbox active"></a></li>
            <li><a href="javascript:void(0);" id="outboxchk" onclick="ajax_checkmessagetype('outbox')" class="outbox"></a></li>
            <li><a href="javascript:void(0);" id="composechk" onclick="ajax_checkmessagetype('compose')" class="compose"></a></li>
          </ul>
          <div class="clr"></div>
        </div>
        <input type="hidden" name="str" id="str" value="{$str}">
			<div id="showdiv"></div>

      </div>
    </div>
  </div>
 {include file=$footer}



