{include file=$header1}
<script language="JavaScript1.2">var thisFormName  = "frmAction";</script>
<script type="text/javascript" src="{$siteroot}/js/admin_check_uncheck_action.js"></script>
{include file=$header2}
<h3>Contacts Information For Contact Us</h3>
<p>&nbsp;</p>
<div align="center" id="msg">{$msg}</div>
    <div class="fr width50 ar">
          <img src="{$siteimg}/icons/add.png" align="absmiddle" /> <a href="{$siteroot}/admin/contentpages/edit_contact_information.php">Add Page</a>
    </div>
<div class="holdthisTop">
  <table width="100%"  align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
      <td>
        <form name="frmAction" id="frmAction" method="post" action="" onsubmit="">
          <table width="100%"  border="0" cellpadding="6" cellspacing="2" class="listtable">
            <tr align="center" class="headbg">
              <td width="1%" align="left"><input type="checkbox" id="checkall" /></td>
              <td width="30%" align="left">Line One <!--&nbsp;
					<a href="{$siteroot}/admindealsite/contentpages/contact_information.php?orderby=line_one asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
					<a href="{$siteroot}/admindealsite/contentpages/contact_information.php?orderby=line_one desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a>--></td>
              <td width="30%" align="left">Line Two <!--&nbsp;
					<a href="{$siteroot}/admindealsite/contentpages/contact_information.php?orderby=line_two asc"><img src="{$siteroot}/templates/default/images/up.gif" alt="ASC" width="10" height="10" title="ASC" /></a>
					<a href="{$siteroot}/admindealsite/contentpages/contact_information.php?orderby=line_two desc"><img src="{$siteroot}/templates/default/images/down.gif" alt="DESC" width="10" height="10" title="DESC"  /></a>--></td>
              <td width="10%" align="left">Action</td>
            </tr>
            {section name=i loop=$cinfo}
            <tr class="grayback" id="tr_{$smarty.section.i.iteration}">
              <td valign="top" align="left" ><input type="checkbox" name="id[]" value="{$cinfo[i].id}" /></td>
              <td valign="top" align="justify"><img src="{$siteimg}/icons/{if $cinfo[i].status  eq 'Inactive'}award_star_silver_1.png{else}award_star_silver_2.png{/if}" align="absmiddle" />{$cinfo[i].line_one}</td>
              <td valign="top" align="justify">{$cinfo[i].line_two}</td>
              <td align="left" valign="top"><img src="{$siteimg}/icons/application_edit.png" align="absmiddle" /> <a href="{$siteroot}/admin/contentpages/edit_contact_information.php?id={$cinfo[i].id}" class="admintxt"><strong>Edit</strong></a></td>
            </tr>
           {sectionelse}
            <tr>
              <td colspan="3" class="error" align="center"><strong>Sorry there is no record found. </strong> </td></tr>
          {/section}
            <tr>
              <td align="right"><img src="{$siteroot}/templates/default/images/admin/arrow_ltr.gif"  /></td>
              <td align="left" colspan="2"><select name="action" id="action">
                  <option value="">--Action--</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactivate</option>
                  <option value="delete">Delete</option></select>
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