{include file=$header1}
{include file=$header2}
<!--<script type="text/javascript" src="{$siteroot}/js/validation/admin/faqcategorylist.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>-->
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; System Emails</div>
<br />
{literal}
<script language="javascript">
	$(document).ready(function() {
	jQuery("#frm").validate({
	errorElement:'div',
	rules: {
	email_id: {
	required: true
	}
	},
	messages: {
	email_id: {
	required: "Please select system email."
	}
	}
	});
	$('#msg').fadeOut(5000);
	});
</script>
{/literal}
{literal}
<!--<script language="javascript">
	function valid_page()
	{
		if(document.getElementById('nl_id').value == '')
		{
			alert("Please select email");
			return false;
		}
		else
		{
			location.href = SITEROOT+'/admin/globalsettings/edit_email.php?email_id='+document.getElementById('nl_id').value;
			return false;
		}
	}
</script>-->
{/literal}

<h2 class="txt13 padingTop">System Emails</h2>
<div class=""></div>
<div>&nbsp;</div>

  {if $msg}<div align="center" id="msg">{$msg}</div>{/if}

<div align="center" id="msg"></div>

<div id="Content" >
<!--<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);"></A></TD></TR></table>-->
  <table width="82%" align="center" cellpadding="0" cellspacing="" class="listtable"  >
    <tr> </tr>
    <tr>
      <td  align="left" >&nbsp;</td>
      <td align="right"><!--<a href="edit_email.php" title="Add Email"><b>Add Email</b></a>--></td>
    </tr>
    <tr>
      <td colspan="2"><table align="right">
          <tbody>
            <tr>
              <td><!-- <a href="add_blog.php?editid=<?=$row1['blogid'];?>" title="Edit Blog"> <img src="<?php echo SITEROOT; ?>/templates/<?php echo TEMPLATEDIR; ?>/images/admin/Edit16.png" class="admintxt" align="left" hspace="4"> <b>Edit</b></a>  --></td>
            </tr>
          </tbody>
      </table></td>
    </tr>
  <td colspan="2"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" class="Greenback">
    { if $mode eq "selectpg"}
    <tr class="trbgprj02">
      <td colspan="2" class="redtxt" align="left">Please select a email to edit</td>
    </tr>
    { else}
    <tr>
      <td colspan="2" class="redtxt" align="left">Please select a system email to edit</td>
    </tr>
    {/if}

    { if $message neq ""}
    <tr>
            <td colspan="2"><div align="center" class="errfailuremsg">{$message}</div></td>
    </tr>
    <tr>
	    <td colspan="2">&nbsp;</td>
    </tr>
    {/if}
<!--    <tr>
      <td colspan="2" align="center">{$msg}</td>
    </tr>-->
    <tr>
      <td>
        <form name="frm" id="frm" method="post" action="{$siteroot}/admin/globalsettings/edit_email.php">
        <div align="center">
          <select name="email_id" class="frmtxt" id="email_id">
            <option value="">Select System Email To Edit</option>
            {section name=sec1 loop=$emails}
	            <option value="{$emails[sec1].emailid}">{$emails[sec1].subject}</option>
            {/section}
	 </select>
          <input name="edit" type="submit" class="" value="Edit Email"/>
        </div>
        <div class="error" htmlfor="email_id" generated="true" align="center"></div>
        </form>
      </td>
      <td width="30%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="adminhedtxt" align="left"><b>Instruction</b></td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Please select a system email to edit from the drop down presented above.</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Once selected please click on <strong>Edit Email</strong>. This will open up a <strong> WYSIWYG Editor</strong> which will let you edit the system email contents. </td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Once you are done click on <strong>save</strong>.</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt">&nbsp;</td>
    </tr>
  </table></td>
  </tr>
  </table>
</div>
{include file=$footer} 
