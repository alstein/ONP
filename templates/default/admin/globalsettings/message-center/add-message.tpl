<script type="text/javascript" src="{$siteroot}/js/common1.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/editnewsletter.js"></script>
<script type="text/javascript" src="{$siteroot}/ckeditor/ckeditor.js"></script>
<!-- Edit Content Panel -->
<div Id="Content">
<form name="frm" method="post" action="" id="frm" onSubmit="javascript:return checkfrm();" enctype="multipart/form-data">
<input type="hidden" id="nl_id" name="nl_id" value="{$nl_id}">
<input type="hidden" id="did" name="did" value="{$smarty.session.demorec.nl_name}">


<div id="demo"></div> 

<table width="100%"  border="0" cellspacing="0" cellpadding="5" class="Greenback">
	<tr>
		<td colspan="2"> <label for="Indicate Required Fields"><span class="red">*</span> Indicates Required Fields</lable></td>
	</tr>

{*
<!--    <tr><td  colspan='2' align="right" class=''><a href="edit_newsletter.php?action=del&nl_id={$row.nl_id}" onClick="javascript:return confirm('Are you sure to delete Newsletter ?');"><b>Delete this newsletter</b></a></td>
</tr>-->
*}


    

	<tr>
		<TD></TD>
		<TD colspan="2"><div id="users"></div></TD>
	</tr>
   <!--  <tr>
       <td align="left" >Start Date :</td>
       <td align="left">
          <input type="text" name="startdate" value="{if $row.startdate}{$row.startdate}{else}{$demoid.startdate}{/if}" id="startdate" class="textbox width40"> (Y-m-d H:m)
       </td>
    </tr>-->
    <tr>
      <td  align="left" valign="top"><span class="red">*</span><span class="frmtxt style1" >Name :</span></td>
      <td ><input name="pagename" type="text" class="frmtxt" id="pagename" size="55" value="{if $row.nl_name}{$row.nl_name}{else}{$demoid.nl_name}{/if}">
	   </td>
    </tr>
    <tr>
      <td align="left" valign="top"><span class="red">*</span> <span class="frmtxt style1" class="red">Title :</span></td>
      <td><input name="pagetitle" type="text" class="frmtxt" id="pagetitle" size="55" value="{if $row.nl_title}{$row.nl_title}{else}{$demoid.nl_title}{/if}">
	   </td>
    </tr>
	<tr>
		 <td valign="top" align="left"><span class="red">*</span>Message Content : </td>
		<td valign="top">
			{oFCKeditor->Create}
		</td>
	</tr>
	<tr>
	<td></td>
	<td><div align="left">
		<input name="Submit2" type="submit" value="{if $nl_id}Update{else}Add{/if} message">
	</div></td>
    </tr>
  </table>
</form>
<!-- Edit Content Panel -->

</div>