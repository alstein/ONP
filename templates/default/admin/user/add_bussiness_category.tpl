{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.pack.js"></script>

<script type="text/javascript">
{literal}
$(document).ready(function() {
jQuery.validator.addMethod("specialchars", function(value, element) {
      var str1 = /\s/;
      var str2 = /([A-Za-z0-9_]+)/;
      if(str1.test(value))
         return false;
      if(!(str2.test(value)))
         return false;
      return true;

        }, "Special characters and space not allowed");
   
	// validate form on keyup and submit	
	var validator = $("#frmUserProfile").validate({
		errorElement:'div',
		rules: {
        	category:{
				required: true,	
            specialchars:true
			 },
         title: {
                    required:true,
                    minlength:2,
                    maxlength:66,
                    specialchars:true
                 },
         description: {
                    required:true,
                    minlength:2,
                    maxlength:160
                 },
         keyword: {
                    required:true,
                    minlength:2,
                    maxlength:10
                 },
         abstract: {
                    required:true,
                    minlength:2,
                    maxlength:66
                 },
         subject: {
                    required:true,
                    minlength:2,
                    maxlength:66
                  }
		},
		
		messages: {
			category:{
				required: "Enter Bussiness Category",
            specialchars:"Special characters and space not allowed"
			},
         title:{
             required: "Enter SEO Title",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes")
         },
         description:{
             required: "Enter SEO Discription",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes")
         },
         keyword:{
             required: "Enter SEO Keyword",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes")
         },
         abstract:{
             required: "Enter SEO Abstract",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes")
         },
         subject:{
             required: "Enter SEO Subject",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes")

                }
			
		},

		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.hide();
		}
	});	
});
{/literal}
</script>
{include file=$header2}
<h3></h3>
<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back</A></TD></TR></table>
<div class="holdthisTop">
  <div align="center" id="msg">{$msg}</div>
<h3 class="fl width50"> {if $smarty.get.categoryid}Edit {else}Add {/if}Bussiness Category</h3>
  <div class="fl width60">
    <form name="frmUserProfile" id="frmUserProfile" action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="categoryid" id="categoryid" value="{$smarty.get.categoryid}" />
      <table cellspacing="6" cellpadding="2" width="100%" border="0">
	<tr align="center"><td align="right" valign="top" colspan="2">&nbsp;</td></tr>
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> Bussiness Category: </td>
		<td align="left" valign="top"><input type="text" maxlength="15" size="26" value="{$category.category}" name="category" id="category" class="textbox"/>
		</td>
	</tr>
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> SEO Title: </td>
		<td align="left" valign="top"><textarea name="title" id="title" rows="3" class="textbox" cols="30">{$category.seotitle}</textarea>
		</td>
	</tr>
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> SEO Discription: </td>
		<td align="left" valign="top"><textarea name="description" id="description" rows="3" class="textbox" cols="30">{$category.description}</textarea>
		</td>
	</tr>
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> SEO Keyword: </td>
		<td align="left" valign="top"><textarea name="keyword" id="keyword" rows="3" class="textbox" cols="30">{$category.seokeyword}</textarea>
		</td>
	</tr>
	
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> SEO Abstract: </td>
		<td align="left" valign="top"><textarea name="abstract" id="abstract" rows="3" class="textbox" cols="30">{$category.seoabstract}</textarea>
		</td>
	</tr>
	<tr align="center">
		<td align="right" valign="top"><span style="color:red;">*</span> SEO Subject: </td>
		<td align="left" valign="top"><textarea name="subject" id="subject" rows="3" class="textbox" cols="30">{$category.seosubject}</textarea>
		</td>
	</tr>
	<!--<tr align="center">
		<td align="right" valign="top">Status: </td>
		<td align="left" valign="top"><input type="radio" name="status" value="Active" {if $smarty.get.categoryid}{if $category.status eq 'Active'}checked="checked"{/if}{else}checked="checked" {/if} />
		Active &nbsp;&nbsp;
		<input type="radio" name="status" value='Inactive'{if $smarty.get.categoryid}{if $category.status eq 'Inactive'}checked="checked"{/if}{/if} />
		Inactive </td>
	</tr>	-->
	
	<tr>
		<td></td>
		<td><input type="submit" name='submit' value="{if $smarty.get.categoryid}Save{else}Save{/if}" /> &nbsp; &nbsp; <input type="button" value="Cancel" onclick="javascript: location='bussiness_category.php'"  />
		</td>
	</tr>
	</table>
    </form>
  </div>
  </td>
  <div class="clr"></div>
</div>
 {include file=$footer} 
