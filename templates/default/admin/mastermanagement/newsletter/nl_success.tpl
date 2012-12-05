{include file=$header1}
{include file=$header2}
<br />
<div id="Content">
  <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="frmbrdgrn">
	 <div id="msg" align="center">{$msg}</div>
    <tr  class="txtwhitebld" >
      <td colspan='4' class='txtwhitebld'><h2>Success</h2></td>
    </tr>
	<tr>
      	<td   align="right"><a href="newsletter.php" class="frmtxt style1">Back To Newsletter</a></td>
  	</tr> 
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr class="frmtxt2">
      <td >A New newsletter {$nl_name} is added.</td>
    </tr>
         <td class="frmtxt">&nbsp;</td>
    </tr>
	<tr class="frmtxt2">
      <td >Thank You For New newsletter added.</td>
    </tr>
    <tr>
      <td class="frmtxt">&nbsp;</td>
    </tr>
  </table>
</div>

{include file=$footer} 