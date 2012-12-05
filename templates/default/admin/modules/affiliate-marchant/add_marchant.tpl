{include file=$header1}

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){
var mid = $('#mid').val();
$.validator.addMethod("numGreatZero", function(value, element)
	{
			var temp;
			temp = true;
			temp = !(value<=0);
			return temp;
         }, "Please enter valid merchant id");	
	
	$("#frm").validate({
		errorElement:'div',
		rules: {
			marchant_id:{
				required: true,
				number: true,
				remote: {url:SITEROOT + "/admin/modules/affiliate-marchant/ajax_check_marchant.php?mid="+mid, type:"post", async: true },
				maxlength: 50,
				numGreatZero:true
				
			},
			marchant_name:{
				required: true,
				maxlength: 50,
				remote: {url:SITEROOT + "/admin/modules/affiliate-marchant/ajax_check_marchant.php?mid="+mid, type:"post", async: true },
				//remote: {url:SITEROOT + "/admin/modules/affiliate-marchant/ajax_check_marchant.php?mid="+mid, type:"post", async: false },
				accept : "[a-zA-Z]"
			}
		},
		messages: {
			marchant_id:{
				required: "Please enter merchant id",
				maxlength: $.format("Enter maximum {0} characters"),
				remote: "This merchant id is already in use",
				number: "Enter only numeric value"
			},
			marchant_name:{
				required: "Please enter merchant name",
				maxlength: $.format("Enter maximum {0} characters"),
				accept: "Enter only alphabetical characters",
				remote: "This merchant name is already in use"
			}
		}
	});
document.forms['frm'].submit
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/affiliate-marchant/marchant_list.php"> Affiliate Merchant</a>
&gt;{if $smarty.get.mid} Edit Merchant Details{else} Add Merchant Details{/if}
</div><br/>


<div class="holdthisTop">
	<div>
		<div class="fl width50">
			<h3>{$sitetitle} {if $smarty.get.mid}Edit{else}Add{/if} Merchant Details</h3>
		</div>
		<div class="clr">&nbsp;</div>
		{if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}
    </div><br/>

	<div id="UserListDiv" name="UserListDiv" >
		<form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="{$smarty.get.mid}" name="mid" id="mid">
			<table width="100%" border="0" cellspacing="2" cellpadding="1">
				<tr>
					<td colspan="2" align="right"><a href="{$siteroot}/admin/modules/affiliate-marchant/marchant_list.php">Back</a></td>
				</tr>
				<tr>
					<td align="right" valign="top" width="40%"><span style="color:red">*</span> Merchant Id:</td>
					<td align="left" width="60%"><input name="marchant_id" type="text" id="marchant_id" value="{$result.marchant_id}"  size="15" class="textbox"/></td>
				</tr>
				<tr><td colspan="2" align="right">&nbsp;</td></tr>
				<tr>
					<td align="right" valign="top" width="40%"><span style="color:red">*</span> Merchant Name:</td>
					<td align="left" width="60%"><input name="marchant_name" type="text" id="marchant_name" value="{$result.marchant_name}"  size="15" class="textbox"/></td>
				</tr>
				<tr><td colspan="2" align="right">&nbsp;</td></tr>
				<tr>
					<td></td>
					<td align="left"><input type="submit" name="submit" value="{if $smarty.get.mid}Update{else}Add{/if}" /></td>
				</tr>
			</table>
		</form>
	</div>
</div>
{include file=$footer}
