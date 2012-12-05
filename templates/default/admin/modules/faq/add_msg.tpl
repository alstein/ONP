
<!--<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/add_msg.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/common1.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/editnewsletter.js"></script>
<script type="text/javascript" src="{$siteroot}/ckeditor/ckeditor.js"></script>

<div class="holdthisTop">
    <div>
        <div class="fl">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} Error Message</h3>
        </div>
        <div class="clr">&nbsp;</div>
        {if $msg}<br/><div align="center" id="msg">{$msg}<br/></div>{/if}
    </div>
    <br/>
    <div id="UserListDiv" name="UserListDiv" >
      <form name="frmRegistration" id="frmRegistration" method="post" action="" enctype="multipart/form-data">
	  <table width="100%" border="0" cellspacing="2" cellpadding="1">
	      <tr>
		  <td align="right" valign="center" width="40%"><span style="color:red">*</span> Message Type: </td>
		  <td align="left" width="60%">
		    <select name="msgtype" id="msgtype"> 
		      <option value="success" {if $row.msgtype eq 'success'} selected="selected" {/if}>Success</option>
		      <option value="error" {if $row.msgtype eq 'error'} selected="selected" {/if}>Error</option>
		    </select>
		  </td>
	      </tr>
	      <tr><td colspan="2">&nbsp;</td></tr>
	      <tr>
		  <td align="right" valign="top" width="40%"><span style="color:red">*</span>Message: </td>
		  <td align="left" width="60%">
		      <textarea name="catdec" id="catdec" class="textbox" rows="4" cols="40">{$row.msgtext}</textarea>
		  </td>
	      </tr>
	      <tr><td colspan="2" align="right">&nbsp;</td> </tr>
	      <tr>
		  <td></td>
		  <td><input type="submit" name="submit" value="Save" /></td>
	      </tr>
	  </table>
      </form>
    </div>
</div>
<!--{include file=$footer}-->