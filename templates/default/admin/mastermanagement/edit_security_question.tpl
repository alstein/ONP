{include file=$header1}
{literal}
<script type="text/javascript">
$(document).ready(function(){

	jQuery("#frmQuestion").validate({
		errorElement:'div',
		rules: {
			question: {
				required: true,
		 	}
		},
		messages: {
			question: {
					required: "Please enter Secret Question",
			}
		},
});
});
</script>
{/literal}


{include file=$header2}
<div align="center" id="msg">{$msg}</div>
<div class="holdthisTop">
	<h3 class="fl width20">&nbsp;&nbsp;{if $smarty.get.id}Edit{else}Add{/if} Secret Question</h3><br/><br/>
<form name="frmQuestion" id="frmQuestion" action="" method="post">
<input type="hidden" name="id" value="{$question.id}" />
<table width="100%" border="0" cellspacing="2" cellpadding="6">
  <tr>
    <td align="right">Secret Question:&nbsp;</td>
    <td><input type="text" id="country" class="input" name="question" value="{$question.question}" size="50"/></td>
  </tr>
  <tr>
    <td align="right">Status:&nbsp;</td>
    <td><select name="status" class="combo_box">
        <option value="1" {if $question.active eq "1"}selected="selected"{/if}}>Active</option>
        <option value="0" {if $question.active eq "0"}selected="selected"{/if}>Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Save" class="button"/> <input type="button" value="Cancel" onclick="javascript: location='security_question_list.php';" class="button"/>
    </td>
  </tr>
</table>
</form>
</div>
{include file=$footer}