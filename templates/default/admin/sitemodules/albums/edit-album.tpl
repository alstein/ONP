{include file=$header1}
{strip}
<!--<script type="text/javascript" src="{$sitejs}/jquery.dg-magnet-combo.js"></script>-->
<!--<link rel="stylesheet" type="text/css" media="screen" href="{$siteroot}/combogrid/css/smoothness/jquery-ui-1.8.9.custom.css"/>
<link rel="stylesheet" type="text/css" media="screen" href="{$siteroot}/combogrid/css/smoothness/jquery.ui.combogrid.css"/>-->
<!--<script type="text/javascript" src="{$siteroot}/combogrid/jquery/jquery-ui-1.8.9.custom.min.js"></script>-->
<!-- <script type="text/javascript" src="http://jqueryui.com/themeroller/themeswitchertool/"></script> -->
<!--<script type="text/javascript" src="{$siteroot}/combogrid/plugin/jquery.ui.combogrid-1.6.1.js"></script>-->
{/strip}
{literal}
<script type="text/javascript">
jQuery(document).ready(function()
{
   jQuery("#msg").fadeOut(5000);
   var photo_cnt = '{/literal}{$photo_cnt}{literal}';
   for(i=0; i<photo_cnt; i++)
   {
	$("#tag_"+i).dgMagnetCombo();
   }
});

function reset_field(itr)
{
	$("#accompp_"+itr).val('');
	$("#acc_"+itr).val('');
}
function toggle(id)
{
	var checked_status = false;//this.checked;
	jQuery("input[name=trophy_case]").each(function()
	{ 
		this.checked = checked_status;
	});
	$('#'+id).attr('checked', true);
	
}
function untoggle(id)
{
	$('#'+id).attr('checked', false);
}
</script>
{/literal}
{include file=$header2}
{include file=$menu}
<div class="middel_panel">
<h1 class="type2">Edit Photos</h1>
<div class="breadcrumb"><a href="{$siteroot}/admin/home.php">Home</a>&nbsp;&raquo;&nbsp;{if $view neq 'acc'}Album{else}Accomplishment{/if}&nbsp;&raquo;&nbsp;{$album.album_title}&nbsp;&raquo;&nbsp;Edit Photos </div>
<div style="margin-left:770px"><a href="javascript:;" onclick="history.go(-1);"> <strong>Back </strong></a></div>
	<div class="holdthisTop">
	{if $msg}
	<div align="center" class="error" id="msg">{$msg}</div>
	{/if}
<table width="100%" border="0" align="center" cellspacing="2" cellpadding="6" class="datagrid">
<tr>
<td>
            <table width="100%" cellpadding="3" cellspacing="2"  border="0">
            <form name="frmPhoto" id="frmPhoto" method="POST" target="" action="">
            {section name=i loop=$record}
                 <tr>
		  <td width="25%" valign="top" rowspan="4">
		     <input type="hidden" name="photoid[{$smarty.section.i.index}]" value="{$record[i].photoid}">
	             <input type="hidden" name="image[{$record[i].photoid}]" value="{$record[i].image}">
			<img src="{$siteroot}/uploads/post_accomplish/thumbnail/{$record[i].image}" height="145" width="145" alt="Image">
			<br><br>
			{if $view neq 'acc'}<input type="radio" name="album_cover[]" id="album_cover_{$smarty.section.i.iteration}" value="{$record[i].photoid}" {if $record[i].album_cover eq '1'} checked="true" {/if}>&nbsp;Album Cover Photo
			{else}<input type="radio" name="accomplishment_cover[]" id="accomp_cover_{$smarty.section.i.iteration}" value="{$record[i].photoid}" {if $acc_cover eq $record[i].photoid} checked="true" {/if}>&nbsp;Accomplishment Cover Photo
			{/if}
			{if $view eq 'acc'}
			<br><input type="checkbox" name="trophy_case" id="trophy_case_{$smarty.section.i.index}" value="{$record[i].photoid}" onclick="if(!this.checked) untoggle('trophy_case_{$smarty.section.i.index}'); else toggle('trophy_case_{$smarty.section.i.index}');" {if $tr_case eq $record[i].photoid} checked="true" {/if}>&nbsp;Trophy Case Photo{/if}
			<br><input type="checkbox" name="delete[]" id="delete_{$smarty.section.i.index}" value="{$record[i].photoid}">&nbsp;Delete Photo
			<br><br>Move to another album<br>
				<select name="other_album[]" id="other_album" class="select3">
				<option value=""> --Select Album --</option>
				{section name=j loop=$other_album}
				<option value="{$other_album[j].album_id}">{$other_album[j].album_title|ucfirst}</option>
				{/section}
				</select>
		  </td>
		  <td width="17%" valign="top">Description:</td><td valign="top"><textarea name="description[]" id="description_{$smarty.section.i.index}" style="height:60px;width:290px;">{$record[i].description}</textarea></td>
		</tr>
		<tr>
		  <td valign="top">Tag others in Photo:</td>
		  <td valign="top"><select name="tag_{$smarty.section.i.index}[]" id="tag_{$smarty.section.i.index}" class="" multiple="true" style="width:290px; height:87px;">
                   {section name=k loop=$friends}
                   <option value="{$friends[k].userid}" {section name=j loop=$record[i].tag} {if $record[i].tag[j] eq $friends[k].userid} selected="selected" {/if} {/section}>{if $friends[k].role_id eq '3'}
                	  {if $friends[k].share_name eq '1'}{$friends[k].first_name|ucfirst} {$friends[k].last_name|ucfirst}
                	  {else}{$friends[k].login_name|ucfirst}{/if}
                   {else}{$friends[k].first_name|ucfirst} {$friends[k].last_name|ucfirst}
                   {/if}</option>
                   {sectionelse}
                   <option> No Friends </option>
                   {/section}
                   </select>
                   </td>
		</tr>
		<tr>{if $record[i].accomp neq ''}
		  <td valign="top">Accomplishment</td>
		  <td>{$record[i].acc_detail.award_title}&nbsp;|&nbsp;{$record[i].acc_detail.title}&nbsp;|&nbsp;{$record[i].acc_detail.edate}&nbsp;|&nbsp;{$record[i].acc_detail.login_name}</td>
		  {/if}
		</tr>
		<tr>
		  <td valign="top">Assign to Accomplishment:</td>
		  <td valign="top">
			<input type="text" name="accompp_{$smarty.section.i.index}" id="accompp_{$smarty.section.i.index}" size="30" value="{$record[i].acc_detail.award_title}"/>
			<span class="ui-state-default ui-corner-all accomp_2 cg-resetButton">
				<span class="ui-icon ui-icon-circle-close" onclick="reset_field('{$smarty.section.i.index}');"></span>
			</span>
			<input type="hidden" name="acc_{$smarty.section.i.index}" id="acc_{$smarty.section.i.index}" value="{$record[i].acc_detail.acc_id}"/>
                   </td>
		</tr>
		<tr>
		  <TD colspan="3" style="border-bottom-color : #c6c6c6; border-bottom-style : solid; border-bottom-width : 1px;"></TD>
		</tr>

	   {/section}
		<tr>
			<td>&nbsp;</td>
			<td align="left" colspan="2">
			<div class="buttons">{if $record}<input type="submit" name="submit" value="Save" class="button1"/> {/if}</div>
			<div class="buttons">
			<input type="button" name="Cancel" id="Cancel" value="Cancel" class="button1" onclick="Javascipt: history.go(-1);"/>
			</div></td>
		</tr>
		</form>
	   </table>
</td>
</tr>
</table>
</div>
</div>
</div>
<!--main content ends -->

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
   {section name=i loop=$record}
		{literal}
		<script type="text/javascript">
		var userid = {/literal}{$smarty.get.userid}{literal};
		var roleid = {/literal}{$smarty.get.roleid}{literal};
		$( "#accompp_"+{/literal}{$smarty.section.i.index}{literal} ).combogrid({
			url: SITEROOT+'/modules/admindata.php?userid='+userid+'&roleid='+roleid,
			debug:true,
			colModel: [{'columnName':'acc_id','width':'0','label':''},{'columnName':'award_title','width':'25','label':'Accomplishment'}, {'columnName':'title','width':'25','label':'Event'}, {'columnName':'end_date','width':'20','label':'Date'}, {'columnName':'login_name','width':'25','label':'Username'}],
			select: function( event, ui ) {
				$( "#accompp_"+{/literal}{$smarty.section.i.index}{literal} ).val( ui.item.award_title );
				$( "#acc_"+{/literal}{$smarty.section.i.index}{literal} ).val( ui.item.acc_id );
				return false;
			}
		});
		</script>
		{/literal}
   {/section}
{include file=$footer}