{include file=$header1}

{literal}
<script language="javascript">
$(document).ready(function(){
   jQuery.validator.addMethod("lettersonly",
   function(value, element)
   {
      return this.optional(element) || /^[a-z\s]+$/i.test(value);
   }, "Please enter character only");

	$.validator.addMethod("valid_editor", function(value, element) { 
		var editorcontent = CKEDITOR.instances[element.name].getData().replace(/<[^>]*>/gi, '');
		if (editorcontent.length)
		{
			return true;
		}else
		{
			return false;
		}
	}, "Please enter description");

	jQuery("#frmPage").validate({
		errorElement:'div',
		rules: {
			title: {
				required: true,
				maxlength:50
			},
			description: {
				valid_editor: true
			}
		},

		messages: {
			title: {
				required: "Please enter title.",
               			maxlength: $.format("Enter maximum {0} characters")
			},
			description: {
				valid_editor: "Please enter description."
			}
		},
 		success: function(label) {
 		// set &nbsp; as text for IE
 		label.hide();
 		}
		});
});
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/contentpages/page_list.php"> Content pages</a>
 &gt;{if $page.pageid eq ""} Add Content Page{else} Edit Content Page{/if}</div>
<br />


  <table width="82%"  align="center">
    <tr>
      <td>
        <h3>{if $page.title}Edit{else}Add{/if} Content Page</h3><br/>
        <form name="frmPage" id="frmPage" method="post" action="" enctype="multipart/form-data">
          <input type="hidden" name="pageid" value="{$page.pageid}" />
          <table width="100%"  border="0" cellpadding="6" cellspacing="2">
          {*<!--  <tr>
              <td width="15%" align="right" valign="top"><span style="color:red">*</span> Page Category: </td>
              <td align="left">
                  <select name="page_cat" id="page_cat">
                      <option value="">  Select </option>
                      {section name=i loop=$page_cat}
                      <option value="{$page_cat[i].id}" {if $page.page_cat eq $page_cat[i].id} selected="selected"{/if}>{$page_cat[i].title}</option>
                      {/section}
                  </select>
              </td>
            </tr>-->*}

            <tr>
              <td width="15%" align="right" valign="top"><span style="color:red">*</span> Title: </td>
              <td align="left"><input type="text" name="title" id="title" size="60" maxlength="100" value="{$page.title}"  align="left" /></td>
            </tr>

            <tr>
              <td valign="top" align="right"><span style="color:red">*</span> Description: </td>
              <td valign="top">
                {*oFCKeditor->Create*} {$oFCKeditorDesc}
                </td>
            </tr>
            

            <tr>
              <td align="right" valign="top"></td>
              <td><input type="submit" name="Submit" value="Save"  /> &nbsp; &nbsp; &nbsp;
                <input type="button" name="Cancel" value="Cancel" onclick="javascript: location='page_list.php';" /></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>

{include file=$footer}