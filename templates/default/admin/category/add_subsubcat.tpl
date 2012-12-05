{include file=$header1}

{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script type="text/javascript">
$(document).ready(function(){
	$("#frm").validate({
		errorElement:'div',
		rules: {
			category:{
				required: true,
				minlength: 2,
				maxlength:50,
				remote: SITEROOT + "/admin/user/ajax_check_subcat.php?caatid="+$('#caatid').val()+"&subcatid="+$('#subcaatid').val(),
				accept : "[a-zA-Z]"
			}
		},
		messages: {
			category:{
				required: "Enter sub category name",
				minlength:  $.format("Enter at least {0} characters"),
				maxlength: $.format("Enter maximum {0} characters"),
				remote: "This sub-category is already in use",
				accept: "Enter only alphabatic character"
			}
		}
	});
	$('#frm').submit(function(){
            if ($('div.error').is(':visible'))
            {}
            else 
            {
               // $('#Submit').hide(); 
                //$("<div/>").replaceWith("<p></p>");
               // $('#buttonregister').append("<input type='button' name='Submit' id='Submit' value='Submit'>");
                 $('#buttonregister').replaceWith("<input type='button' name='Submit' id='Submit' value='Submit'>");
            }
        });
	
});
</script>
{/literal}
{$main_cat_id}
{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/category/category_list.php">Main Categories</a> &gt; <a href="{$siteroot}/admin/category/subcat.php?cat_id={$main_cat_id}">Sub Categories List</a> &gt; <a href="{$siteroot}/admin/category/subsubcat.php?cat_id={$smarty.get.cat_id}">  Sub Sub Categories List </a> &gt; {if $result.id eq ''}Add{else}Edit{/if} Deal  Sub Sub Category</div><br />


<div class="holdthisTop">
    <div>
        <div class="fl width50">
            <h3>{$sitetitle} {if $result.id eq ''}Add{else}Edit{/if} Deal Subcategory</h3>
        </div>
        <div class="clr">&nbsp;</div>
         {if $msg}<div align="center" id="msg">{$msg}<br/></div>{/if}

    </div><br/>

    <div id="UserListDiv" name="UserListDiv" >
      	<form name="frm" action="" id="frm"  method="post" enctype="multipart/form-data">
	<input type="hidden" value="save" name="task" id="task">
	<input type="hidden" value="{$smarty.get.cat_id}" name="caatid" id="caatid">
	<input type="hidden" value="{$result.id}" name="subcaatid" id="subcaatid">
        <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <tr>
                <td colspan="2" align="right"><a href="{$siteroot}/admin/category/subsubcat.php?cat_id={$smarty.get.cat_id}">Back</a></td>
            </tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category Name:</td>
                <td align="left" width="60%">{if $mainCatname} {$mainCatname} {else} {$result.mainCatname} {/if}</td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <tr>
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Subcategory Name:</td>
                <td align="left" width="60%"><input name="category" type="text" id="category" value="{$result.category}"  size="15" class="textbox"/></td>
            </tr>
            <tr><td colspan="2" align="right">&nbsp;</td></tr>
            <tr style="display:none;">
                <td align="right" valign="top" width="40%"><span style="color:red">*</span> Category typ:</td>
                <td align="left" width="60%">
			<input name="category_type" type="radio" id="category_type" value="product" checked="true"/>Product
			<input name="category_type" type="radio" id="category_type" value="service" {if $result.category_type eq 'service'}checked="true"{/if}/>Service
		</td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><span id="buttonregister"><input type="submit" name="Submit" id="Submit" value="Submit"></span>&nbsp; &nbsp; &nbsp;
		      <input type="button" name="Cancel" value="Cancel"  onclick="javascript: location='{$siteroot}/admin/category/subsubcat.php?cat_id={$smarty.get.cat_id}'" /></td>
            </tr>
	  </table>
      </form>
    </div>
</div>
{include file=$footer}