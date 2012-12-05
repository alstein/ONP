{include file=$header1}

{strip}
<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
<script language="javascript" src="{$siteroot}/js/news_letter.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/sendnewsletter.js"></script>
{/strip}

{include file=$header2}

<h3>Send Message</h3>
<div id="Content"> 
	  {if $msg}<div align="center" class="red" id="msg">{$msg}<br/><br/></div>{/if}
    <form name="frm_send_news" id="frm_send_news" action = "" method="POST">
      <table width="100%" height="129"  border="0" align="center" cellpadding="2" cellspacing="1" class="brdall" >

	  <tr>
              <td>
                <table width="100%"  border="0" cellpadding="0" cellspacing="1" class="Greenback" >
		 <tr>
		    <td  height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;Message : </td>
		    <td  height="25" align="left" class="fade_back_1">
		    <select name="newsletter" id="newsletter" onChange="selectpagecontent();" style="width:200px;">
		    <option value="">-Select-</option>
		    {section name=sec1 loop=$title}
		    <option value="{$title[sec1].nl_id}" {if $nlid eq $title[sec1].nl_id} selected="selected"{/if}>{$title[sec1].nl_title}</option>
		    {/section}
		    </select></td>
  		 </tr>
		<Tr><td colspan="2">&nbsp;</td></Tr>
		
		<tr id="to1">
		  <td width="20%" height="25" align="right" valign="top" class="fade_back"><span style="color:red">*</span>&nbsp;To : &nbsp;</td>
		  <td height="71%" class="fade_back_1" valign="middle"><textarea name="to" class="text_area5" rows="3" cols="60" id="to"></textarea></td>
		</tr>
		<tr>
		  <td width="20%" height="25" align="left" class="fade_back">&nbsp;</td>
		  <td height="71%" class="fade_back_1" align="left">
		      <table>
			<tr>
			  <td>
			      <div id="sub" style="display:block"><a href="JavaScript:void(0);" class="left_menu" onClick="return openpopup1('add_to_sub','');"><u>All Users List</u></a></div>
			  </td>
			  <td>
			      <input type="radio"  name="all" id="all" value="all" onclick="return show();" >
			      <strong>All Seller</strong>
			    </td>
			  <td> <input  type="radio" name="all" id="allbuyer" value="allbuyer" onclick="return show();" ><strong>All Buyer</strong></td>
			</tr>
		      </table>
		    </td>
		 </tr> 
		 <tr>
		    <td width="20%" height="25" align="right" class="fade_back"><span style="color:red">*</span>&nbsp;Subject : &nbsp;</td>
		    <td width="100%" height="25"  align="left" class="fade_back_1"><input name="subject" type="text" id="subject" value="" class="text_box4" size="60">&nbsp;</td>
		</tr> 
          <Tr><td colspan="2">&nbsp;</td></Tr>
           <tr>
                <td valign="top" align="right"><span style="color:red">*</span>&nbsp;Message Content : &nbsp;</td>
                <td valign="top">
                  {oFCKeditor->Create}
                </td>
           </tr>
            <Tr><td colspan="2">&nbsp;</td></Tr>

		<tr>
                        <td width="20%" height="25" align="center" class="fade_back">&nbsp;</td>
			<td height="71%"  align="left" class="fade_back_1">&nbsp;
			<input type="submit" name="submit" value="Send Message"></td>
		</tr>
	 </table>
	    </td>
	  </tr>
      </table>
    </form>
</div>
{include file=$footer} 