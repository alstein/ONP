{literal}
<script type="text/javascript">
function backtopage()
{
parent.ajax_checkmessagetype('outbox');
}
</script>

{/literal}	

<input type="hidden" name="chklink" id="chklink" value={$chklink}>	
<form  name="frmUploadVault" id="frmUploadVault"  enctype="multipart/form-data" method="post" action="" >

<div class="inbox-tbl">
          <table width="960" border="0" cellpadding="0" cellspacing="0">
		{if $outbox!=''}  
            <tr>
              <th width="153" valign="top" height="35">&nbsp; </th>
              <th width="200" valign="top" height="35"> From </th>
              <th width="238" valign="top" height="35"> Subject </th>
              <th width="153" valign="top" height="35"> Posted Date </th>
            </tr>
		{/if}
		{section name=i loop=$outbox}
            <tr id="tr_{$outbox[i].MID}" >
              <td width="153" align="center"  height="30"><div style="width:12px; margin:0 auto">
                  <input  name="msgid[]" value="{$outbox[i].MID}" id="msgid" type="checkbox">  <!--class="styled"-->
                </div></td>
              <td width="200" align="center">{$outbox[i].first_name|ucfirst} {$outbox[i].last_name|ucfirst}</td>
             {if $outbox[i].msg_read  eq '1'}
			<td width="238" align="center"><a href="javascript:void(0);" onclick="javascript:tb_show('View Message', '{$siteroot}/modules/message/view_message.php?status=outbox&msg_id={$outbox[i].MID}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=150&width=600&modal=false', tb_pathToImage);"  class="thickbox">{$outbox[i].subject|ucfirst|truncate:15}</a></td>
		{else}
				<td width="238" align="center"><a href="javascript:void(0);" onclick="javascript:tb_show('View Message', '{$siteroot}/modules/message/view_message.php?status=outbox&msg_id={$outbox[i].MID}&placeValuesBeforeTB_=savedValues&TB_iframe=true&height=150&width=600&modal=false', tb_pathToImage);"  class="thickbox">{$outbox[i].subject|ucfirst|truncate:15}</a></td>
		{/if}
              <td width="153" align="center"> {$outbox[i].cdate|date_format} </td>
            </tr>
		{sectionelse}
  	    <tr>
		<td align="center" colspan="5" class="error">Outbox Is Empty</td>
            </tr>
     	{/section}  
          </table>
          
          <div class="inbox-btm">
          <div class="fl">
          <img src="{$siteroot}/templates/default/images/tbl-arrow.gif" width="17" height="15" alt="" title=""  />
          </div>
          
          <div class="fl" style="margin:0 10px 0 10px">
          <input type="submit"  value="Delete"  name="Delete_outbox"  class="previe-btn" style="width:92px" value="Delete"/>
          </div>
          
          <div class="fl">
          <input type="button" name="cancel" onclick="backtopage();"  class="previe-btn" style="width:92px" value="Cancel"/>
          </div>
           <div class="clr"></div>
          </div>
         
          
           <div class="clr"></div>
        </div>


	</form>