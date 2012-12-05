{include file=$header1}

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){

   	$.validator.addMethod("alphaOnly", function(value, element){
                var temp;
                temp = true;
                str = /[^a-zA-Z -]/;
                temp = !str.test(value);
                return temp;
         }, "Only a to z, A to Z and - is allowed.");

	$("#frm").validate({
		errorElement:'div',
		rules: {
			dealtype:{
				required: true,
				minlength: 2,
				maxlength:50,
 			        remote: {url:SITEROOT + "/admin/deal/ajax_check_dltypename.php?dltype_id="+$('#dt_id').val(),type:"post"},
				alphaOnly:true//,
// 				accept : "[a-zA-Z]"
			}
		},
		messages: {
			dealtype:{
				required: "Please enter deal type",
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters"),
 	        	        remote: "This deal type is already in use"//,
// 				accept: "Enter only alphabatic character"
			}
		}
	});
});


// function prvtTwcSbtFrm()
// {
// 	if($('#frm').valid())
// 	{
// 		$('#submit').hide();
// 	}
// }

</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/deal/deal_type_list.php"> Manage Deal Type</a>
&gt;{if $smarty.get.dt_id} Edit Deal Type{else} Add Deal Type{/if} 
</div><br/>


<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} {if $smarty.get.dt_id}Edit{else}Add{/if} Deal Type</h3>
        </div>
        <div class="clr">&nbsp;</div>
         {if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

    <div id="UserListDiv" name="UserListDiv" >
      	<form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data" >
	<input type="hidden" value="{$smarty.get.dt_id}" name="dt_id" id="dt_id">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/deal/deal_type_list.php">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Deal Type:</td>
                <td align="left" width="60%"><input name="dealtype" type="text" id="dealtype" value="{$result.dealtype}"  size="15"  class="textbox"/></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span>Price Option:</td>
                <td align="left" width="60%">
                    <input type="radio" name="normal" id="normal" value="normal" checked="true">Normal&nbsp;&nbsp;
                    <input type="radio" name="normal" id="normal" value="groupbuy" {if $result.price_option eq "groupbuy"} checked="true"{/if} >Group Buy
                </td>
            </tr>
            <!--<tr><td colspan="2" align="right">&nbsp;</td></tr>-->
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <tr>
                <td></td>
                <td align="left"><input type="submit" id="submit" name="submit" value="{if $smarty.get.dt_id}Update{else}Add{/if}" /></td>
            </tr>
	  </table>
      </form>
    </div>
</div>
{include file=$footer}
