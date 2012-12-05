{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
      $("#frmRegister").validate({
	    errorElement:'div',
	    rules: {
		  level:{
			  required: true
		  },
		  m_id:{
			  required: true
		  }
	    },
	    messages: {
		  level:{
			  required: "level name should not be blank"
		  },
		  m_id:{
			  required: "Please select at least one checkbox"
		  }
	  }
          });
      });

function selectLevel(lvl)
{
    if(lvl!="")
    {
	    window.document.frmRegister.action=SITEROOT+"/admin/user/modules.php?level="+lvl;
	    window.document.frmRegister.submit();
    }
}

</script>
{/literal}

{include file=$header2}

<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; <a href="{$siteroot}/admin/user/manage_admin.php">Admin User</a>
&gt;<a href="{$siteroot}/admin/user/modules.php">Manage Levels And Modules</a>&gt;Add New  Level</div>


<div class="holdthisTop">
<h3>Add New Access Level</h3>
<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back</A></TD></TR></table>

  <form name="frmRegister" id="frmRegister" method="post" action="">
    <table width="100%" border="0" cellspacing="2" cellpadding="6">
<!--        <tr class="fl">
          <td align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="javascript: void(0);" onclick="$('#old_l').hide();$('#add_l').show();">Add New Level</a></td>
        </tr>-->
	{if $msg}<tr><TD colspan="2"><div align="center" id="msg">{$msg}</div></TD></tr>{/if}
        <tr><TD>&nbsp;</TD></tr>
        <tr  align="right" valign="top">
	    <td align="right" valign="top"><span style="color:red">*</span> Level: </td>
	    <td align="left" width="60%"><input type="text" name="level" id="level"/>
        </tr>
	<tr>
	  <td align="right" valign="top"><span style="color:red">*</span> Access Level: </td>
          <td>
	      {section name=i loop=$modules}
		{if $modules[i]}
		  <table>
		      <tr><td><strong>{$modules[i].module_name}</strong></td></tr>
		      {section name=j loop=$modules[i].sub_m}
		      <tr><td>&nbsp;<input type="checkbox" name="m_id[]" id="m_id" value="{$modules[i].sub_m[j].id}">{$modules[i].sub_m[j].module_name}</td></tr>
		      {/section}
		  </table>
		{/if}
	      {/section}
          <td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	    <td align="left"><label>
	      <input type="submit" name="Submit" id="Submit" value="Save" class="" />&nbsp;&nbsp;&nbsp;
	      <input type="button" name="cancel" id="cancel" value="Cancel" onclick="javascript: location='{$siteroot}/admin/user/manage_admin.php'" class="" /> </label></td>
	</tr>
    </table>
  </form>
</div>
{include file=$footer} 