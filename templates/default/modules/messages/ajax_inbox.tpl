{strip}
<link rel="stylesheet" href="{$siteroot}/templates/default/css/form.css" media="screen">

{/strip}
{literal}
<script type="text/javascript">
function backtopage()
{
parent.ajax_checkmessagetype('inbox');
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
<form name="frmUploadVault" id="frmUploadVault" enctype="multipart/form-data" method="POST" action="" >
        
<div class="inbox-tbl">
          <table width="960" border="0" cellpadding="0" cellspacing="0">
			{if $message!=''}  
            <tr>
              <th width="153" valign="top" height="35">&nbsp; </th>
              <th width="200" valign="top" height="35"> From </th>
              <th width="238" valign="top" height="35"> Subject </th>
              <th width="153" valign="top" height="35"> Posted Date </th>
            </tr>
			{/if}
		{section name=i loop=$message}
            <tr id="tr_{$message[i].MID}" >
              <td width="153" align="center"  height="30"><div style="width:12px; margin:0 auto">
                  <input name="msgid[]" value="{$message[i].MID}" id="msgid"  type="checkbox"> <!--class="styled"-->
                </div></td>
              <td width="200" align="center"> {$message[i].first_name|ucfirst} {$message[i].last_name|ucfirst}</td>
			{if $message[i].msg_read  eq '1'}
				<td width="238" align="center" onclick="make_unread({$message[i].MID})"><a href="javascript:void(0)"  onclick="javascript:tb_show('View Message', '{$siteroot}/modules/message/view_message.php?status=inbox&msg_id={$message[i].MID}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=600&modal=false', tb_pathToImage);"  class="thickbox">{$message[i].subject|ucfirst|truncate:15}</a></td>
			{else}
				<td width="238" align="center" onclick="make_unread({$message[i].MID})"><a href="javascript:void(0)"  onclick="javascript:tb_show('View Message', '{$siteroot}/modules/message/view_message.php?status=inbox&msg_id={$message[i].MID}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=200&width=600&modal=false', tb_pathToImage);"  class="thickbox">{if $message[i].flag eq '0'}<b>{$message[i].subject|ucfirst|truncate:15}</b>{else}{$message[i].subject|ucfirst|truncate:15}{/if}</a></td>
			{/if}
              <td width="153" align="center" onclick="make_unread({$message[i].MID})">{$message[i].cdate|date_format}</td>
            </tr>
		{sectionelse}
  	    <tr>
		<td align="center" colspan="5" class="error">Inbox Is Empty</td>
            </tr>
     	{/section}  
          </table>
         {if $message!=''}   
          <div class="inbox-btm">
          <div class="fl">
          <img src="{$siteroot}/templates/default/images/tbl-arrow.gif" width="17" height="15" alt="" title=""  />
          </div>
          
          <div class="fl" style="margin:0 10px 0 10px">
          <input type="submit"  value="Delete"  name="Delete"  class="previe-btn" style="width:92px" />
          </div>
          
          <div class="fl">
          <input type="button" value="Cancel " name="cancel" onclick="backtopage();"  class="previe-btn" style="width:92px" />
          </div>

			<div class="fr">{if $showpgnation eq "yes" }{$pgnation}{/if}</div>
          
         {/if}
           <div class="clr"></div>
          </div>
           <div class="clr"></div>
        </div>
</form>