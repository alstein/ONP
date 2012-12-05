{include file=$header1}
<!--<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>-->
<script type="text/javascript" src="{$siteroot}/js/ajax.js"></script>
<script type="text/javascript" src="{$siteroot}/js/ajax_user_search.js"></script>
<script type="text/javascript" src="{$siteroot}/js/validation/admin/userlist.js"></script>

{include file=$header2}
<div class="breadcrumb"><a href="{$siteroot}/admin/index.php">Home</a> &gt; Contact Us</div>
<br />

<div class="holdthisTop">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td><center>
          {$msg}
        </center>
        <h3>Contact Us</h3>
        <form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
          <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
            <tr align="center" class="headbg">
              <td width="1%" align="left"><input type="checkbox" id="checkall" /></td>
              <td width="20%" align="left">Full Name &nbsp;<!--
					<a href="{$siteroot}/admindealsite/contentpages/contact_us.php?orderby=fullName asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
					<a href="{$siteroot}/admindealsite/contentpages/contact_us.php?orderby=fullName desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a><--></td>
              <td align="left">Message &nbsp;
					<!--<a href="{$siteroot}/admindealsite/contentpages/contact_us.php?orderby=message asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
					<a href="{$siteroot}/admindealsite/contentpages/contact_us.php?orderby=message desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a><--></td>
            </tr>
            {section name=i loop=$contactus}
            <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
              <td valign="top" align="left" ><input type="checkbox" name="cid[]" value="{$contactus[i].cid}" id="userid"/></td>
              <td valign="top" align="left"><a href="view_reply.php?id={$contactus[i].cid}">{$contactus[i].fullName|ucfirst}<br />
                {$contactus[i].emailId}</a></td>
              <td valign="top" align="justify"><strong>[{$contactus[i].postedDate|date_format:$smarty_date_format}]</strong><br />
                {*$contactus[i].message|truncate:150*}{$contactus[i].message}</td>
            </tr>
            {/section}
            <tr>
              <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
		<td align="left" colspan="2">
		<select name="action" id="action">
                  <option value="">--Action--</option>
                  <option value="delete">Delete</option>
                </select>
                <input type="submit" name="submit" id="submit" value="Go" />
                <span id="acterr" class="error"></span><div class="ar fr width50">
               {$pgnation}
            </div>
            <div class="clr"></div> </td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
{include file=$footer}