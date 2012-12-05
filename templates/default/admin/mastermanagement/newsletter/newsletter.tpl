{include file=$header1}
{strip}
<script language="javascript" src = "{$siteroot}/js/validation/newsletter.js"></script>
<script language="javascript" src = "{$siteroot}/js/common.js"></script>
{/strip}
{include file=$header2}
<h2 class="txt13 padingTop">Manage Newsletter</h2>
<div class="clr"></div>
<div>&nbsp;</div>
<div id="Content" >
  <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="" class="listtable" >
<div align="center" id="msg">{$msg}</div>
    <tr> </tr>
    <tr>
      <td  align="left" >&nbsp;</td>
      <td align="right"><a href="edit_newsletter.php"  title="Add Newsletter"> <b>Add NewsLetter</b></a></td>
    </tr>
    <tr>
      <td colspan="2"><table align="right">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table></td>
    </tr>
  <td colspan="2"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" class="Greenback">
    { if $mode eq "selectpg"}
    <tr class="trbgprj02">
      <td colspan="2" class="redtxt" align="left">Please select a <strong>newsletter</strong> to edit</td>
    </tr>
    { else}
    <tr>
      <td colspan="2" class="redtxt" align="left">Please select a <strong>newsletter</strong> to edit</td>
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
    <tr>
      <td colspan="2" align="center">{$msg}</td>
    </tr>
    <tr>
      <td>
	  <form name="frm" method="post" action="edit_newsletter.php" onsubmit="javascript: return valid_page();">
        <div align="center">
          <select name="nl_id" class="frmtxt" id="nl_id">
            <option value="0">Select Newsletter To Edit</option>
            {section name=sec1 loop=$row}
	            <option value="{$row[sec1].nl_id}">{$row[sec1].nl_name}</option>
            {/section}
	 </select>
          <input name="Submit" type="submit" class="button1" value="Edit Newsletter"/>
        </div>
      </form></td>
      <td width="30%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="adminhedtxt" align="left"><b>Instruction</b></td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Please Select a <strong>newsletter</strong> to edit from the drop down presented above.</td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Once selected please click on Edit page. This will open up a WYSIWYG Editor which will let you edit the newsletter contents. </td>
    </tr>
    <tr>
      <td colspan="2" class="admintxt" align="left">Once you are done click on Save.</td>
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