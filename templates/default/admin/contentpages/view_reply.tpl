{include file=$header1}
<script type="text/javascript">
{literal}
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
			$("#acterr").text("Please Select Action.").show().fadeOut(3000);
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
			$("#acterr").text("Please Select Checkbox.").show().fadeOut(3000);
			return false;
		}
		if(confirm('Are you sure to perform "'+$("#action").attr('value')+'" action'))
			return true;
		else
			return false;
    });
	$("#msg").fadeOut(5000);
});
{/literal}
</script>
{include file=$header2}
<div class="breadcrumb">
  <a href="{$siteroot}/{$AdminFolderName}/index.php">Home</a> &gt; <a href="{$siteroot}/admin/contentpages/contact_us.php">Contact Us</a> &gt; View Reply
</div>
<div>&nbsp;</div>
	<h3 class="fl width50">View Reply</h3>
<div class="holdthisTop">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
	<td>
	<table width="100%" cellspacing="5" cellpadding="2">
		<div align="center" id="msg">{$msg}</div>
		<tr>
			<td width="20%" align="right" valign="top"><strong>From : </strong></td>
			<td align="left" valign="top">{$reply.fullName}</td>
		</tr>	
		<tr>
			<td width="20%" align="right" valign="top"><strong>Email : </strong></td>
			<td align="left" valign="top">{$reply.emailId}</td>
		</tr>	
	    	<tr>
			<td width="20%" align="right" valign="top"><strong>Message : </strong></td>
			<td align="left" valign="top">{$reply.message}</td>
		</tr>
		<tr>
			<TD>&nbsp;</TD>
		</tr>
		<tr>
			<TD></TD>
			<td><a href="contact_reply.php?cid={$reply.cid}"><strong>Reply To This Message</strong></a></td>
		</tr>
		<tr>
			<TD>&nbsp;</TD>
		</tr>
		<tr>
			<td width="20%" align="right"><strong>Replies :</strong></td>
		 <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
            <tr align="center" class="headbg">
              <td width="20%" align="left">Subject</td>
              <td width="50%" align="left">Message</td>
              <td width="15%" align="left">Posted Date</td>
            </tr>
            {section name=i loop=$rep_array}
            <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
              <td valign="top" align="left">{$rep_array[i].subject}</td>
              <td valign="top" align="justify">{$rep_array[i].reply}</td>
              <td valign="top" align="justify"><strong>[{$rep_array[i].posted_date|date_format:"%d-%m-%Y"}]</strong></td>
            </tr><!--date_format:$smarty_date_format -->
          {sectionelse}
           <tr>
              <td colspan="3" class="error" align="center"><strong>Sorry there is no reply found.</strong></td>
           </tr>
          {/section}

          </table>
	</table>
	</td>
 </tr>
  </table>
</div>
{include file=$footer}