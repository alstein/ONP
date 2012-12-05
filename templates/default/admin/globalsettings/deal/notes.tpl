
<link href="{$siteroot}/templates/default/css/main.css" rel="stylesheet" type="text/css" />
{literal} 
<script type="text/javascript" language="JavaScript">
function validation()
{
   var getemail=document.getElementById("notes").value;
   if(getemail=="")
  { 
                alert("Please enter note");
                document.getElementById("notes").focus();
                return false;
  }
}

</script>
{/literal}

  <div id="maincont">

    <div class="searchresultsec">
     <h2 class="allCaps searchtitle"></h2>
        <div class="ovfl-hidden" style="margin-top:50px">
       
 <form name="howitworks" id="howitworks" method="POST" action="">
 <input type="hidden" name="hiddendealid" id="hiddendealid" value="{$dealid}">
          <table align="center">
{if $msg!=""}
<tr><td colspan="2"><strong style="color:#87B400">{$msg}</strong></td></tr>
 {else}
<tr height="10px"><td></td></tr>
<tr><td valign="top"><span style="color:red">*</span><strong>Notes:</strong>&nbsp;&nbsp;</td>
            <td><textarea rows="8" cols="30" name="notes" id="notes">{$record.notes}</textarea></td>
<td colspan="" align=""></td><td></td>
</tr>
     <tr></tr>
 <tr><td></td><td><div class="buttongreen" style="margin-left:10px"> <input class="inputbtn" type="submit" name="save" id="save" value="Submit" onclick="return validation()"></div></td></tr>
{/if}
</table>
</form>

          


        	
    </div>
  </div>
</div>
<!-- Maincontent ends -->
<!-- Footer starts -->

