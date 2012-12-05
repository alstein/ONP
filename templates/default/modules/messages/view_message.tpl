{literal}
<script type="text/javascript">

function replytomail(to_userid,msg_id)
{
closebox();
parent.replytousermail(to_userid,msg_id);
}
function closebox()
{
javascript: window.parent.tb_remove();
}
</script>
<style type="text/css">
</style>

{/literal}	
<link href="{$siteroot}/templates/default/css/lightbox.css" rel="stylesheet" type="text/css">
<table cellspacing="5" cellpadding="5" width="100%" border="0" align="center" style="font-family:Arial">
	 <tr>
        <td align="left" valign="top" width="15%" class="profile-name" ><input type="hidden" name="userid" id="userid" value="{$user.userid}" />
        <span style="color:red">*</span>{if $smarty.get.status eq 'inbox'}From {else}To{/if}:</td>
        <td align="left" width="85%" style="font-size:11px; color:#2b587a">{$messages.first_name} {$messages.last_name}</td>
	 <tr>
        <td align="left" valign="top" width="15%" class="profile-name" ><input type="hidden" name="userid" id="userid" value="{$user.userid}" />
        <span style="color:red">*</span> Subject:</td>
        <td align="left" width="85%" style="font-size:11px; color:#2b587a">{$messages.subject} </td>
      </tr>
          <tr>
              <td align="left" valign="top" width="15%" class="profile-name" ><span style="color:red">*</span> Message: </td>
              <td align="left" width="85%" style="font-size:11px; color:#2b587a">{$messages.message}</td>
            </tr>
      <tr>
        <td></td>
        <td>
		{if $smarty.get.status neq 'outbox'}
		
<br /><br />
			<input type="button" name="Replay" id="Replay" value="Reply"  class="previe-btn"  onclick="replytomail('{$messages.FROM_ID}','{$smarty.get.msg_id}');">



	<!--<div style="margin:15px 0 0 30px;" class="fl" id="buttonregister1" >-->
		<input type="button" name="cancel" id="cancel" value="Cancel"  class="previe-btn"  onclick="closebox();">
	<!--</div>-->
	
	<!--<span class="share-btn-lft" style="margin-left:5px;" ><span class="share-btn-rgt" ><input type="button" style="font-size: 12px;width:52px;color:#fff;  padding-top: 5px;" name="Replay" id="Replay" value="Reply"  class="share-btn ovfl-hidden"  onclick="replytomail('{$messages.FROM_ID}','{$smarty.get.msg_id}');"></span></span>
<span class="share-btn-lft" style="margin-left:5px;" ><span class="share-btn-rgt" ><input type="button" style="font-size: 12px;width:90px;color:#fff;  padding-top: 5px;" name="cancel" id="cancel" value="Cancel"  class="share-btn ovfl-hidden"  " onclick="closebox();"></span></span>-->


		<!--<input type="button" class="loc_busines fl" value="Reply" name="Replay" onclick="replytomail('{$messages.FROM_ID}');" style="width:90px;" />-->
		


		 <!--<span class="sitesub-btn-lft" style="margin-left:10px;"><span class="sitesub-btn-right">
		   <input class="loc_busines fl" type="button"  value="Cancel " name="cancel" onclick="closebox();" style="width:90px;" />-->
		 <!-- </span></span>-->
		{/if}
		
        </td>
      </tr>
    </table>