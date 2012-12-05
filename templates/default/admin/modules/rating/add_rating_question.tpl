{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/jquery.validate.min.js"></script>

{literal}
<script language="JavaScript">
$(document).ready(function()
{
    $("#home_form").validate({
		errorElement:'div',
		rules: {
				rating_quetion:
				{
					required: true,
					minlength:6,
					maxlength:150
				}
			},
		messages:
			{
				rating_quetion:
				{
					required: "Please enter rating question",
					minlength: $.format("Enter minimum {0} characters"),
					maxlength:$.format("Enter maximum {0} characters")
				}
			}
                });
});
</script>
{/literal}
{literal}
<script language="JavaScript">
	$(document).ready(function()
{
   

$('#home_form').submit(function(){
                    if ($('div.error').is(':visible'))
            {
            } 
            else 
            { 
                $('#Save').hide(); 
                $('#buttonregister').append("<input type='button' name='Save' id='Save' value='Save' />"); 
            }
        });
});
</script>
{/literal}
{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt;<a href="{$siteroot}/admin/modules/rating/rating_question_list.php"> Manage Rating Question</a> &gt;
{if $smarty.get.edit_id} Edit Manage Rating Question{else} Add Manage Rating Question{/if}</div><br/>

<div class="holdthisTop">
	<div>
	  <div class="fl width50">
		  <h3>{$sitetitle}   Manage Rating Question</h3>
	  </div>
          <div class="clr">&nbsp;</div>
     	  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}
	</div>

      <div class="clr">&nbsp; </div>
    <div id="UserListDiv" name="UserListDiv">
  
    <form name="home_form" action="" id="home_form" method="post" enctype="multipart/form-data">
       <input type="hidden" value="{$smarty.get.edit_id}" name="id_name" id="id_name" />
      <table width="100%" border="0" cellspacing="2" cellpadding="6" class="conttableDkBg conttable">
        <tr> 
           <td width="20%" align="right" valign="top" ><span style="color:red;">*</span>Rating Question :</td> 
           <td align="left" width="40%"><input type="text" name="rating_quetion" id="rating_quetion" value="{$rating_question}"   style="width:268px;" maxlength="255"/>
           </td> 
        </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="left">
      <div style="width:150px"> 
        
         {if $id neq ""}
                 <input type="submit" name="Update" id="Update" value="Update" class="but_new fl" />
                 {else}
                   <div id="buttonregister"><input type="submit" name="Save" id="Save" value="Save" class="but_new fl"/></div>
                  {/if}
                 <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="javascript: location='rating_question_list.php'" 
                 class="but_new fl"/>
         
      </div>
      </td>
    </tr>
  </table>
  </form> 
</div>
</div>
{include file=$footer}
