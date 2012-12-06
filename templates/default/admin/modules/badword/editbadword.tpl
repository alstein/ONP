{include file=$header1}
{include file=$header2} 
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}
<script language="javascript">
{literal}
	
	$(document).ready(function(){
	$("#frmbanner").validate({
	errorElement:'div',
	rules:{
		bad_word:{
			required:true,
			minlength: 2,
			maxlength: 50
			}
		},
	messages:{
		bad_word:{
			required:"Please enter the word.",
			minlength: jQuery.format("Enter at least {0} characters"),
			maxlength: jQuery.format("Enter at most {0} characters")
			}
		
		}
	});
});
			
	
{/literal}
</script>
<div class="breadcrumb" align="left" style="float:left;"><a href="{$siteroot}/admin/index.php">Home</a>  &gt; <a href="{$siteroot}/admin/modules/badword/badword-list.php">Badword List</a>  &gt; Edit Word </div><br><br>
<h3>Edit Word</h3><br>

<div class="holdthisTop">
<div align="right"><b><a href="badword-list.php">Back</a></b></div>
<div align="center"><font color=red>{$msg}</font></div>
<form name="frmbanner" id="frmbanner" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="{$user.id}" />
  
       
          <table class="conttableDkBg conttable" align="center" width="100%"  border="0" cellpadding="6" cellspacing="2">
		<!--<tr>		
   			 <td align="left"><h2>Edit Word</h2>
	    		 <td align="right"><b><a href="badword-list.php">Back</a></b></td>
	      </tr>-->
               <tr>
            	      <td  align="right" valign="top"><font color="red">*</font> Bad Word:</td>
             	      <td align="left"><input type="text" name="bad_word" id="bad_word" value="{$user.bad_word}" class="input" /></td>
              </tr>
           
		<!--<tr>
            	      <td  align="right" valign="top"> Replacement:</td>
             	      <td align="left"><input type="text" name="rep_word" id="rep_word" value="{$user.rep_word}" class="input" /></td>
              </tr>-->
	
            <tr>
              <td align="right" valign="top">
              </td>
              <td>
               <input type="submit" name="Submit" value="submit" class="button1" /><div class="buttonEnding1"></div>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button" name="Cancel" value="Cancel" class="button1" onclick="javascript: history.back();" /><div class="buttonEnding1"></div>
	      </td>
            </tr>
          </table>
        </form>
</div>



{include file=$footer}