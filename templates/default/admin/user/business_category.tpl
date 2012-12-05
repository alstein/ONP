{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript">
{literal}


$(document).ready(function() {
jQuery.validator.addMethod("specialchars", function(value, element) 
                  {
                  var str2= "/^[0-9a-zA-Z]+$/";
//                 var str2 = /([A-Za-z0-9]+)/;
                if(!(str2.test(value)))
                        return false;
                  }, "Special character not allowed");
   
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
                    maxlength:160,
                      specialchars:true
                 },
         keyword: {
                    required:true,
                    minlength:2,
                    maxlength:10,
                      specialchars:true
                 },
         abstract: {
                    required:true,
                    minlength:2,
                    maxlength:66,
                      specialchars:true
                 },
         subject: {
                    required:true,
                    minlength:2,
                    maxlength:66,
                      specialchars:true
                 }
      },
      
      messages: {
         category:{
            required: "Enter Bussiness Category",
            specialchars:"Special character not allowed"
         },
         title:{
             required: "Enter SEO Title",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes"),
             specialchars:"Special character not allowed"
         },
         description:{
             required: "Enter SEO Discription",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes"),
             specialchars:"Special character not allowed"
         },
         keyword:{
             required: "Enter SEO Keyword",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes"),
            specialchars:"Special character not allowed"
         },
         abstract:{
             required: "Enter SEO Abstract",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes"),
             specialchars:"Special character not allowed"
         },
         subject:{
             required: "Enter SEO Subject",
                     minlength:jQuery.format("Enter atleast {0} charactes"),
                     maxlength:jQuery.format("Enter atmost {0} charactes"),
             specialchars:"Special character not allowed"

                }
         
      },
      success: function(label) {
         // set &nbsp; as text for IE
         label.hide();
      }
   });   
});

$(document).ready(function()
{
	$("#checkall").click(function()
 	{
		var checked_status = this.checked;
		$("input[@type=checkbox]").each(function()
		{
			this.checked = checked_status;
			change(this);	
		});
 	});
	$("input[@type=checkbox]").click(function()
 	{
		change(this);
 	});
	function change(chk)
	{
		var $tr = $(chk).parent().parent();
		if($tr.attr('id'))
		{
			if($tr.attr('class')=='selectedrow' && !chk.checked)
				$tr.removeClass('selectedrow').addClass('grayback');
			else
				$tr.removeClass('grayback').addClass('selectedrow');
		}
	}
	var flag = false;
	$("#frmAction").submit(function(){
		
		if($("#action").attr('value')=='')
		{
			$("#acterr").text("Select action").show().fadeOut(3000);
			return false;
		}
		$("input[@type=checkbox]").each(function()
		{
			var $tr = $(this).parent().parent();
			if($tr.attr('id'))
				if(this.checked == true)
					flag = true;
		});
		
		if (flag == false) {
			$("#acterr").text("Select record").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});

function activeSuspend(bid,valu)
{		
		if(confirm('Are you sure to perform "'+valu+'" action'))
		{
			location.href=SITEROOT+"admin/user/bussiness_category.php?business_id="+bid+"&approve="+valu+"&act=approve";	
			return true;
		}
		else
		{
			return false;
		}
		
		return false;
}
{/literal}
</script>
{include file=$header2}
<div class="fl width50 "><img src="{$siteimg}/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/user/add_bussiness_category.php" rel ="contentarea">Add Bussiness Category</a></div><br>
<br><h3 class="fl width50">Bussiness Category List</h3>
<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back</A></TD></TR></table>
<div class="holdthisTop">
	
	<div class="clr"></div>
	<div id="msg" align="center">{$msg}</div>
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
        <form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="5%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
            <td width="25%" align="left" valign="top">Bussiness Category</td>
           <td width="40%" align="left" valign="top">Discription</td>
				<td align="left" width="10%">Status(Active/Suspended)</td>
            <td width="20%" align="center" valign="top">Action</td>
          </tr>
          {section name=i loop=$type}
          <tr class="grayback" id="tr_{$type[i].categoryid}">
            <td align="center" valign="top"><input type="checkbox" name="categoryid[]" value="{$type[i].categoryid}" /></td>
            <td align="left" valign="top">
      <img src="{$siteimg}/icons/{if $type[i].status eq
         'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />

            {$type[i].category}</td>
            <td align="left" valign="top" >{$type[i].description|substr:0:20}</td>
				<td align="left" valign="top" >{if $type[i].status eq 'Active'} Active {else} Suspended {/if}</td>
		<td align="left" valign="top">
			<img src="{$siteimg}/icons/application_edit.png" align="absmiddle" />
				<a href="{$siteroot}/admin/user/add_bussiness_category.php?categoryid={$type[i].categoryid}" class="admintxt">
					<strong>Edit&nbsp;&nbsp;&nbsp;</strong>
				</a>
			<img src="{$siteroot}/templates/default/images/icons/application_view_gallery.png" align="absmiddle" />
						{if $type[i].status=='Active' }
							<a href="javascript:void(0);" onclick="javascript: activeSuspend({$type[i].categoryid},'Suspend');">
								<strong>Suspend</strong>
								<input type="hidden" id="action2" value="Inactive" />
							</a>
						{else}
							<a href="javascript:void(0);" onclick="javascript: activeSuspend({$type[i].categoryid},'Active');">
								<strong>Active</strong>
								<input type="hidden" id="action2" value="Active" />
							</a>
						{/if}
		</td>
          </tr>
		  {sectionelse}
		  <tr><td colspan="4"><strong>No Pages Found.</strong></td></tr>
          {/section}
		  <tr><td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td><td colspan="3" align="left">
            <select name="action" id="action">
				<option value="">Action</option>
				<option value="Delete">Delete</option>
  				<option value="Active">Active</option>
				<option value="Suspend">Suspend</option>
				</select>
        <input type="submit" name="submit" id="submit" value="Go" /><span id="acterr" class="error"></span></td></tr>
        </table>
        </form>
        </td>
    </tr>
  </table>
</div>
{include file=$footer}