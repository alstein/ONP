
{literal}
<script language="javascript">
function check()
{
 if(document.frmtxt.credit.value=="")
  {
   document.getElementById('msg').innerHTML="Please enter credit";
    document.frmtxt.credit.focus();
	return false;
   }
 if(isNaN(document.frmtxt.credit.value))
  {
   document.getElementById('msg').innerHTML="Please enter only digits";
    document.frmtxt.credit.focus();
	return false;
   }
 if(document.frmtxt.credit.value > {/literal}{$dtcredits.credit}{literal})
 {
 
  document.getElementById('msg').innerHTML="Please enter correct credit";
    document.frmtxt.credit.focus();
	return false;
 }		
}

</script>	
{/literal}	
<form name="frmtxt" id="frmtxt" action="" method=post onsubmit= "return check();">
<table>
 <TR><TD>Pay Credit</TD><td><input type=text name=credit id=credit></td></TR>
 <tr><td>&nbsp;</td><td><font color=red size=1><div id=msg></div></font></td></tr>
 <tr><TD align=right><input type=submit name=submit id=submit value=Pay ></td><td align=left><input type="button"  value="Back" class="button1" onclick="javascript:history.go();" /></td></tr>
</table>
</form>