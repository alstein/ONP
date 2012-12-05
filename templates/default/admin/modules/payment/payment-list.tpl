{include file=$header1}
<script type="text/javascript" src="{$siteroot}/js/validation/admin/accept-payment.js"></script>

{include file=$header2}
<div class="holdthisTop">

  <h3 class="fl width50">Accept Payment Methods</h3>
  <div class="clr"></div>
  {if $msg}<div id="msg" align="center">{$msg}</div>{/if}
    <!--<div align="right">
        <img src="{$siteimg}/icons/add.png" align="absmiddle" class="thickbox" /><a href="edit-news.php">Add News</a>
    </div>-->
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
	<form name="frmAction" id="frmAction" method="post" action="">
        <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
          <tr class="headbg">
            <td width="1%" align="center" valign="top"><input type="checkbox" id="checkall" /></td>
            <td width="20%" align="left" valign="top">Payment Method</td>
            <td width="30%" align="left" valign="top">Details</td>
            <td width="10%" align="center" valign="top">User Name</td>
            <!--<td width="10%" align="center" valign="top">End Date</td>
            <td width="10%" align="center" valign="top">User Type</td>
            <td width="10%" align="center" valign="top">Action</td>-->
          </tr>
          {section name=i loop=$payment}
          <tr class="grayback" id="tr_{$news[i].news_id}">
            <td align="center" valign="top"><input type="checkbox" name="payment_id[]" value="{$payment[i].id}" /></td>
            <td align="left" valign="top">{$payment[i].payment_method|ucfirst}</td>
            <td align="left" valign="top">{$payment[i].details|truncate:100}</td>
            <td align="center" valign="top" >{$payment[i].name}</td>
            <!--<td align="center" valign="top" ></td>
            <td align="center" valign="top" ></td>
            <td align="center" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/modules/news/edit-news.php?news_id={$news[i].news_id}" class="admintxt"><strong>Edit</strong></a></td>-->
          </tr>
	  {sectionelse}
	     <tr><td colspan="4"><strong>No Records Found.</strong></td></tr>
          {/section}
	  <tr>
              <td align="right">  <img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"/></td>
	      <td colspan="3" align="left">
		<select name="action" id="action"><option value="">--Action--</option>
                <option value="delete">Delete</option></select>
		<input type="submit" name="submit" id="submit" value="Go"/>
                <span id="acterr" class="error"></span>
	      </td>
	  </tr>
        </table>
	</form>
      </td>
      </tr>
  </table>
<!--</div>-->
</div>
{include file=$footer}