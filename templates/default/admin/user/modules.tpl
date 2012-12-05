{include file=$header1}
{strip}
<script type="text/javascript" src="{$sitejs}/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$sitejs}/jquery.validate.pack.js"></script>
{/strip}

{literal}
<script language="JavaScript" type="text/javascript">

$(document).ready(function(){
      $("#frmRegister").validate({
	    errorElement:'div',
	    rules:{
	       level:{
	               required:true
	            }
	         },
	    messages:{
                level:{
                        required:"level name should not be blank"
                      }
                   }
      });
      $("#msg").fadeOut(5000);
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
&gt;Manage Levels And Modules</div>
<br />


<div class="holdthisTop">
<h3>Manage Levels And Modules</h3>
<!--<table width="100%" border="0" ><TR><TD align="right"><A href="javascript:history.go(-1);">Back</A></TD></TR></table>-->
  <form name="frmRegister" id="frmRegister" method="post" action="">
    <table width="100%" border="0" cellspacing="2" cellpadding="6">
        <tr class="fl">
          <td align="right"><img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="modules.php?act=add">Add New Level</a></td>
        </tr>
	{if $msg}<tr><TD colspan="2"><div align="center" id="msg">{$msg}</div></TD></tr>{/if}
        <tr><TD>&nbsp;</TD></tr>

	<tr id="old_l" align="right" valign="top">
	    <td align="right" valign="top"><span style="color:red">*</span> Level: </td>
	    <td align="left" width="60%">
	      <select name="level" id="level" style="width:150px;" onchange="javascript: selectLevel(this.value)">
		  <option value="all">Select</option>  
		  {section name=i loop=$level}<option value="{$level[i].levelid}" {if $level[i].levelid eq $smarty.get.level} selected="selected"{/if}>{$level[i].name|ucfirst}</option>{/section}
	      </select>
	    </td>
	</tr>
	<tr>
	  <td align="right" valign="top"><span style="color:red">*</span> Access Level: </td>
          <td>
	      {section name=i loop=$modules}
		{if $modules[i]}
		  <table>
		      <tr><td><strong>{$modules[i].module_name}</strong></td></tr>
		      {section name=j loop=$modules[i].sub_m}
		      <tr><td>&nbsp;<input type="checkbox" name="m_id[]"  id="m_id" value="{$modules[i].sub_m[j].id}" 
                      {if in_array($modules[i].sub_m[j].id,$level1)==true} 
                           checked="true"{/if}  >{$modules[i].sub_m[j].module_name}</td></tr>
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