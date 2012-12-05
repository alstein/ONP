{include file=$header1}

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){
var caatid = $('#caatid').val();
var typ = $('#category_type').val();

	$.validator.addMethod("alphaOnly", function(value, element){
		var temp;
		temp = true;
		str = /[^a-zA-Z -]/;
		temp = !str.test(value);
		return temp;
	}, "Enter only alphabatic character.");

	$("#frm").validate({
		errorElement:'div',
		rules: {
			category:{
				required: true,
				minlength: 2,
				maxlength:50,
			        remote: SITEROOT + "/admin/user/ajax_check_cat.php?typ="+typ+"&caatid="+caatid,
				alphaOnly : true
			}
		},
		messages: {
			category:{
				required: "Enter category name",
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters"),
	        	remote: "This category is already in use"
			}
		}
	});
document.forms['frm'].submit
});
</script>
{/literal}

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/category/category_list.php"> Deal Category</a>
&gt;{if $smarty.get.cid} Edit Deal Category{else} Add Deal Category{/if} 
</div><br/>


<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} {if $smarty.get.cid}Edit{else}Add{/if} Deal Category</h3>
        </div>
        <div class="clr">&nbsp;</div>
         {if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

    <div id="UserListDiv" name="UserListDiv" >
      	<form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data">
	<input type="hidden" value="{$smarty.get.cid}" name="caatid" id="caatid">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/category/category_list.php">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category Name:</td>
                <td align="left" width="60%"><input name="category" type="text" id="category" value="{$result.category}"  size="15" class="textbox"/></td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <!--<tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category Type:</td>
                <td align="left" width="60%">
                    <input name="category_type" type="radio" id="category_type" value="product" checked="true"/>Product
                    <input name="category_type" type="radio" id="category_type" value="service" {if $result.category_type eq 'service'}checked="true"{/if}/>Service
                </td>
            </tr>-->
{*
<!--             <tr>
                <td align="right" valign="top" width="40%"><span style="color:red"></span>Issue Coupon Manualy:</td>
                <td align="left" width="60%"><input name="issmanu" type="radio" id="issmanu" {if $result.coupon_manualy eq 'on'} checked="true" {/if}/></td>
            </tr>-->
*}

            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <tr>
                <td></td>
                <td align="left"><input type="submit" name="submit" value="{if $smarty.get.cid}Update{else}Add{/if}" /></td>
            </tr>
	  </table>
      </form>
    </div>
</div>
{include file=$footer}
